<?php

namespace App\Jobs;

use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Services\ShiprocketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UpdateShipmentRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public $timeout = 900;
    public $backoff = [30, 60, 120, 300, 600];

    protected $pincodeId;
    protected $batchSize = 10;
    protected $rateLimitPerMinute = 30;

    public function __construct($pincodeId)
    {
        $this->pincodeId = $pincodeId;
    }

    public function handle(ShiprocketService $ship)
    {
        $pincode = Pincode::find($this->pincodeId);

        if (!$pincode) {
            Log::warning('Pincode not found', ['pincode_id' => $this->pincodeId]);
            return;
        }

        // Check if we're rate limited
        $rateLimitKey = 'shiprocket_rate_limit_' . date('Y-m-d-H-i');
        $currentRate = Cache::get($rateLimitKey, 0);

        if ($currentRate >= $this->rateLimitPerMinute) {
            Log::warning('Rate limit reached, retrying later', [
                'pincode' => $pincode->pincode,
                'current_rate' => $currentRate,
                'limit' => $this->rateLimitPerMinute
            ]);
            self::dispatch($this->pincodeId)->delay(now()->addMinutes(1));
            return;
        }

        $weights = WeightCategory::all();
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');

        // Check which weights are already processed for this pincode
        $processedWeights = PincodeShippingRate::where('pincode_id', $pincode->id)
            ->whereNotNull('shipping_rate')
            ->pluck('weight_category_id')
            ->toArray();

        // Only process unprocessed weights
        $weightsToProcess = $weights->filter(function ($weight) use ($processedWeights) {
            return !in_array($weight->id, $processedWeights);
        });

        if ($weightsToProcess->isEmpty()) {
            Log::info('All weights already processed', ['pincode' => $pincode->pincode]);
            return;
        }

        Log::info('Processing weights', [
            'pincode' => $pincode->pincode,
            'total' => $weightsToProcess->count(),
            'processed' => count($processedWeights)
        ]);

        // Process in smaller batches to manage rate limits
        $batches = $weightsToProcess->chunk($this->batchSize);

        foreach ($batches as $batchIndex => $batch) {
            // Check rate limit before each batch
            $currentRate = Cache::get($rateLimitKey, 0);
            if ($currentRate >= $this->rateLimitPerMinute) {
                Log::warning('Rate limit during processing, pausing', [
                    'pincode' => $pincode->pincode,
                    'batch' => $batchIndex + 1,
                    'current_rate' => $currentRate
                ]);

                sleep(30);
                $currentRate = Cache::get($rateLimitKey, 0);

                if ($currentRate >= $this->rateLimitPerMinute) {
                    self::dispatch($this->pincodeId)->delay(now()->addMinutes(2));
                    return;
                }
            }

            Log::info('Processing batch', [
                'pincode' => $pincode->pincode,
                'batch' => $batchIndex + 1,
                'total_batches' => $batches->count(),
                'weights_in_batch' => $batch->count()
            ]);

            foreach ($batch as $weightCategory) {
                try {
                    // Increment rate limit counter with expiration
                    $newRate = Cache::get($rateLimitKey, 0) + 1;
                    Cache::put($rateLimitKey, $newRate, 60);

                    $response = $ship->getServiceability(
                        $fromPin,
                        $pincode->pincode,
                        $weightCategory->primary_weight,
                        0
                    );

                    $companies = $response['raw']['data']['available_courier_companies'] ?? [];

                    // Filter couriers that can handle this weight
                    $filtered = collect($companies)
                        ->filter(function ($item) use ($weightCategory) {
                            $minWeight = $item['min_weight'] ?? 0;
                            $maxWeight = $item['max_weight'] ?? PHP_FLOAT_MAX;

                            return $weightCategory->primary_weight >= $minWeight &&
                                $weightCategory->primary_weight <= $maxWeight;
                        })
                        ->sortBy('rate')
                        ->values();

                    // ✅ Only update shipping_rate (existing column)
                    PincodeShippingRate::updateOrCreate(
                        [
                            'pincode_id' => $pincode->id,
                            'weight_category_id' => $weightCategory->id,
                        ],
                        [
                            'shipping_rate' => $filtered->isNotEmpty() ? $filtered->first()['rate'] : null,
                        ]
                    );

                    Log::info('Weight processed successfully', [
                        'pincode' => $pincode->pincode,
                        'weight' => $weightCategory->primary_weight,
                        'rate' => $filtered->first()['rate'] ?? null,
                        'rate_count' => $newRate
                    ]);

                    // Dynamic sleep based on rate limit
                    $currentRate = Cache::get($rateLimitKey, 0);
                    if ($currentRate > $this->rateLimitPerMinute - 5) {
                        sleep(3);
                    } else {
                        sleep(1);
                    }

                } catch (\Exception $e) {
                    $errorMessage = $e->getMessage();
                    
                    if (str_contains(strtolower($errorMessage), 'rate limit') ||
                        str_contains(strtolower($errorMessage), '429')) {
                        Log::warning('Rate limit error, will retry later', [
                            'pincode' => $pincode->pincode,
                            'weight' => $weightCategory->primary_weight,
                            'message' => $errorMessage
                        ]);

                        self::dispatch($this->pincodeId)->delay(now()->addMinutes(5));
                        return;
                    }

                    Log::error('Shiprocket API Error', [
                        'pincode' => $pincode->pincode,
                        'pincode_id' => $pincode->id,
                        'weight' => $weightCategory->primary_weight,
                        'weight_category_id' => $weightCategory->id,
                        'message' => $errorMessage,
                    ]);

                    // ❌ REMOVED: Don't store error in database (columns don't exist)
                    // Just log and continue

                    sleep(2);
                    continue;
                }
            }

            // Cooldown between batches
            if ($batchIndex < $batches->count() - 1) {
                $currentRate = Cache::get($rateLimitKey, 0);
                if ($currentRate > $this->rateLimitPerMinute - 5) {
                    Log::info('Batch completed, cooling down', [
                        'pincode' => $pincode->pincode,
                        'current_rate' => $currentRate,
                        'cooldown' => 30
                    ]);
                    sleep(30);
                } else {
                    sleep(5);
                }
            }
        }

        Log::info('All weights processed successfully', [
            'pincode' => $pincode->pincode,
            'total_weights' => $weights->count()
        ]);
    }
}