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
    public $backoff = [60, 120, 300, 600, 1200];

    protected $pincodeId;
    protected $specificWeightId;
    protected $batchSize = 5;
    protected $rateLimitPerMinute = 25;

    public function __construct($pincodeId, $specificWeightId = null)
    {
        $this->pincodeId = $pincodeId;
        $this->specificWeightId = $specificWeightId;
    }

    public function handle(ShiprocketService $ship)
    {
        $pincode = Pincode::find($this->pincodeId);
        if (!$pincode) {
            Log::warning('Pincode not found', ['pincode_id' => $this->pincodeId]);
            return;
        }
        $rateLimitKey = 'shiprocket_rate_limit_' . date('Y-m-d-H-i');
        $newRate = Cache::get($rateLimitKey, 0) + 1;
        Cache::put($rateLimitKey, $newRate, 60);
        
        if ($newRate > $this->rateLimitPerMinute) {
            $current = Cache::get($rateLimitKey, 0);
            Cache::put($rateLimitKey, $current - 1, 60);
            
            Log::warning('Rate limit exceeded, retrying later', [
                'pincode' => $pincode->pincode,
                'current_rate' => $newRate - 1,
                'limit' => $this->rateLimitPerMinute,
                'retry_after' => 60
            ]);
            
            $this->release(60);
            return;
        }

        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        
        if ($this->specificWeightId) {
            $weightCategory = WeightCategory::find($this->specificWeightId);
            if (!$weightCategory) {
                Log::warning('Weight category not found', ['weight_id' => $this->specificWeightId]);
                return;
            }
            $weightsToProcess = collect([$weightCategory]);
            
            Log::info('Processing specific weight', [
                'pincode' => $pincode->pincode,
                'weight' => $weightCategory->primary_weight . ' kg',
                'weight_id' => $weightCategory->id,
                'api_calls_used' => $newRate
            ]);
        } else {
            $weights = WeightCategory::all();
            $processedWeights = PincodeShippingRate::where('pincode_id', $pincode->id)
                ->whereNotNull('shipping_rate')
                ->pluck('weight_category_id')
                ->toArray();

            $weightsToProcess = $weights->filter(function ($weight) use ($processedWeights) {
                return !in_array($weight->id, $processedWeights);
            });

            if ($weightsToProcess->isEmpty()) {
                Log::info('All weights already processed', ['pincode' => $pincode->pincode]);
                return;
            }

            Log::info('Processing all weights', [
                'pincode' => $pincode->pincode,
                'total' => $weightsToProcess->count(),
                'processed' => count($processedWeights),
                'api_calls_used' => $newRate
            ]);
        }

        foreach ($weightsToProcess as $weightCategory) {
            $currentRate = Cache::get($rateLimitKey, 0);
            
            if ($currentRate >= $this->rateLimitPerMinute) {
                Log::warning('Rate limit reached during processing', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weightCategory->primary_weight,
                    'current_rate' => $currentRate
                ]);
                $this->release(60);
                return;
            }

            try {
                $newRate = Cache::get($rateLimitKey, 0) + 1;
                Cache::put($rateLimitKey, $newRate, 60);
                
                $response = $ship->getServiceability(
                    $fromPin,
                    $pincode->pincode,
                    $weightCategory->primary_weight,
                    0
                );
                
                $companies = $response['raw']['data']['available_courier_companies'] ?? [];
                $filtered = collect($companies)
                    ->filter(function ($item) use ($weightCategory) {
                        $minWeight = $item['min_weight'] ?? 0;
                        $maxWeight = $item['max_weight'] ?? PHP_FLOAT_MAX;
                        return $weightCategory->primary_weight >= $minWeight &&
                            $weightCategory->primary_weight <= $maxWeight;
                    })
                    ->sortBy('rate')
                    ->values();
                    
                PincodeShippingRate::updateOrCreate(
                    [
                        'pincode_id' => $pincode->id,
                        'weight_category_id' => $weightCategory->id,
                    ],
                    [
                        'shipping_rate' => $filtered->isNotEmpty() ? $filtered->first()['rate'] : null,
                    ]
                );

                Log::info('Weight processed', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weightCategory->primary_weight,
                    'rate' => $filtered->first()['rate'] ?? null,
                    'api_calls_used' => $newRate
                ]);

                $currentRate = Cache::get($rateLimitKey, 0);
                if ($currentRate > $this->rateLimitPerMinute - 10) {
                    sleep(5);
                } elseif ($currentRate > $this->rateLimitPerMinute - 5) {
                    sleep(3);
                } else {
                    sleep(2);
                }

            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();                
                if (str_contains(strtolower($errorMessage), 'rate limit') ||
                    str_contains(strtolower($errorMessage), '429')) {
                    Log::warning('Rate limit error', [
                        'pincode' => $pincode->pincode,
                        'weight' => $weightCategory->primary_weight,
                        'message' => $errorMessage
                    ]);
                    $current = Cache::get($rateLimitKey, 0);
                    if ($current > 0) {
                        Cache::put($rateLimitKey, $current - 1, 60);
                    }
                    
                    $this->release(120);
                    return;
                }

                Log::error('Shiprocket API Error', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weightCategory->primary_weight,
                    'message' => $errorMessage,
                ]);

                sleep(2);
                continue;
            }
        }

        Log::info('All weights processed successfully', [
            'pincode' => $pincode->pincode,
            'total_weights' => $weightsToProcess->count()
        ]);
    }
}