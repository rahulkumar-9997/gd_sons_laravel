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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateShipmentRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 100;
    public $timeout = 120;

    public function retryUntil()
    {
        return now()->addDay();
    }

    protected $pincodeId;
    protected $weightId;

    public function __construct($pincodeId, $weightId)
    {
        $this->pincodeId = $pincodeId;
        $this->weightId = $weightId;
    }

    public function handle(ShiprocketService $ship)
    {
        $pincode = Pincode::find($this->pincodeId);

        if (!$pincode) {
            return;
        }
        $weight = WeightCategory::find($this->weightId);
        if (!$weight) {
            return;
        }
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        try {
            $rateKey = 'shiprocket_api_' . now()->format('Y-m-d-H-i');
            $count = Cache::increment($rateKey);
            if ($count == 1) {
                Cache::put($rateKey, 1, 60);
            }
            if ($count > 25) {
                Log::warning('Rate limit reached. Releasing job.', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weight->primary_weight,
                ]);
                $this->release(60);
                return;
            }
            $response = $ship->getServiceability(
                $fromPin,
                $pincode->pincode,
                $weight->primary_weight,
                0
            );
            $companies = $response['raw']['data']['available_courier_companies'] ?? [];
            $filtered = collect($companies)
                ->filter(function ($item) use ($weight) {
                    $minWeight = $item['min_weight'] ?? 0;
                    $maxWeight = $item['max_weight'] ?? PHP_FLOAT_MAX;
                    return $weight->primary_weight >= $minWeight
                        && $weight->primary_weight <= $maxWeight;

                })
                ->sortBy('rate')
                ->values();
            $rate = $filtered->first()['rate'] ?? null;
            if ($rate === null) {
                Log::warning('No shipping rate found', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weight->primary_weight,
                ]);
                return;
            }
            PincodeShippingRate::updateOrCreate(
                [
                    'pincode_id' => $pincode->id,
                    'weight_category_id' => $weight->id,
                ],
                [
                    'shipping_rate' => $rate,
                ]
            );

            Log::info('Updated', [
                'pincode' => $pincode->pincode,
                'weight' => $weight->primary_weight,
                'rate' => $filtered->first()['rate'] ?? null
            ]);
        } catch (\Exception $e) {
            Log::error('Shiprocket Error', [
                'pincode' => $pincode->pincode,
                'weight' => $weight->primary_weight,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}