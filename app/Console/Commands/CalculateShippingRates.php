<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Services\ShiprocketService;

class CalculateShippingRates extends Command
{
    protected $signature = 'shiprocket:update-rates';
    protected $description = 'Update shipping rates from Shiprocket';

    public function handle()
    {
        $this->info('Command started');
        $ship = app(ShiprocketService::class);
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        $weights = WeightCategory::all();
        Pincode::chunkById(50, function ($pincodes) use ($weights, $ship, $fromPin) {
            foreach ($pincodes as $pincode) {
                $this->info("Processing Pincode: {$pincode->pincode}");
                foreach ($weights as $weightCategory) {
                    $weight = $weightCategory->primary_weight;
                    $this->info("Weight: {$weight} KG");
                    try {
                        $response = $ship->getServiceability(
                            $fromPin,
                            $pincode->pincode,
                            $weight,
                            0 // prepaid
                        );

                        $companies = $response['raw']['data']['available_courier_companies'] ?? [];

                        if (empty($companies)) {
                            $this->warn("No courier available");
                            continue;
                        }
                        $filtered = collect($companies)
                            ->filter(function ($item) use ($weight) {
                                return $weight >= ($item['min_weight'] ?? 0);
                            })
                            ->sortBy('rate')
                            ->values();
                        if ($filtered->isEmpty()) {
                            $this->warn("No valid courier after filtering");
                            continue;
                        }
                        $rate = $filtered->first()['rate'] ?? null;
                        if ($rate) {
                            PincodeShippingRate::updateOrCreate(
                                [
                                    'pincode_id' => $pincode->id,
                                    'weight_category_id' => $weightCategory->id,
                                ],
                                [
                                    'shipping_rate' => $rate,
                                ]
                            );

                            $this->info(
                                "Updated {$pincode->pincode} - {$weight}kg => ₹{$rate}"
                            );
                        }
                        // API delay
                        usleep(500000);

                    } catch (\Exception $e) {
                        Log::error('Shiprocket Error', [
                            'pincode' => $pincode->pincode,
                            'weight' => $weight,
                            'message' => $e->getMessage(),
                        ]);
                        $this->error($e->getMessage());
                    }
                }
            }
        });

        $this->info('All rates updated successfully!');
    }
}