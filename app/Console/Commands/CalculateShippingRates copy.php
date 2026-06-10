<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        $this->info('Shiprocket rate update started');

        $ship = app(ShiprocketService::class);
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');

        $weights = WeightCategory::all();
        $totalWeights = $weights->count();

        // Only pending pincodes
        $pincodes = Pincode::whereNotIn(
            'id',
            PincodeShippingRate::select('pincode_id')
                ->groupBy('pincode_id')
                ->havingRaw('COUNT(DISTINCT weight_category_id) >= ?', [$totalWeights])
        )
        ->orderBy('id')
        ->limit(10) 
        ->get();
        if ($pincodes->isEmpty()) {
            $this->info('No pending pincodes found');
            return;
        }
        foreach ($pincodes as $pincode) {
            $this->info("Processing: {$pincode->pincode}");
            foreach ($weights as $weightCategory) {
                try {
                    $response = $ship->getServiceability(
                        $fromPin,
                        $pincode->pincode,
                        $weightCategory->primary_weight,
                        0
                    );
                    $companies = $response['raw']['data']['available_courier_companies'] ?? [];
                    if (!empty($companies)) {
                        $filtered = collect($companies)
                            ->filter(fn ($item) =>
                                $weightCategory->primary_weight >= ($item['min_weight'] ?? 0)
                            )
                            ->sortBy('rate')
                            ->values();
                        if ($filtered->isNotEmpty()) {
                            PincodeShippingRate::updateOrCreate(
                                [
                                    'pincode_id' => $pincode->id,
                                    'weight_category_id' => $weightCategory->id,
                                ],
                                [
                                    'shipping_rate' => $filtered->first()['rate']
                                ]
                            );
                            $this->info("Updated {$pincode->pincode} - {$weightCategory->primary_weight}kg");
                        }
                    }
                    sleep(3);
                } catch (\Exception $e) {
                    Log::error('Shiprocket API Error', [
                        'pincode' => $pincode->pincode,
                        'weight' => $weightCategory->primary_weight,
                        'message' => $e->getMessage(),
                    ]);
                    $this->warn("Failed: {$pincode->pincode}");
                    sleep(10);
                    continue; 
                }
            }
        }

        $this->info('Batch completed successfully');
    }
}