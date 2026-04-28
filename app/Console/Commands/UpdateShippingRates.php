<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateShippingRates extends Command
{
    protected $signature = 'shiprocket:update-rates';
    protected $description = 'Update shipping rates from Shiprocket';

    public function handle()
    {
        $this->info('Command started');

        $weights = [
            'weight_450gm' => 0.45,
            'weight_750gm' => 0.75,
            'weight_1350gm' => 1.35,
            'weight_3400gm' => 3.4,
            'weight_7500gm' => 7.5,
            'weight_14kg' => 14,
            'weight_25kg' => 25,
        ];

        $ship = app(\App\Services\ShiprocketService::class);
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');

        DB::table('pincode_data')
            ->chunkById(50, function ($rows) use ($weights, $ship, $fromPin) {
                foreach ($rows as $row) {
                    $this->info("Processing: " . $row->pincode);
                    $update = [];
                    foreach ($weights as $column => $weight) {
                        $this->info("  Weight: $weight");
                        $response = $ship->getServiceability(
                            $fromPin,
                            $row->pincode,
                            $weight,
                            0
                        );
                        //Log::info('Serviceability response for ' . $row->pincode . ', weight ' . $weight . ': ' . json_encode($response, JSON_PRETTY_PRINT));
                        $companies = $response['raw']['data']['available_courier_companies'] ?? [];
                        if (empty($companies)) {
                            $this->warn("  No courier available");
                            continue;
                        }
                        /* Filter by min_weight */
                        $filtered = collect($companies)
                            ->filter(function ($item) use ($weight) {
                                return $weight >= ($item['min_weight'] ?? 0);
                            })
                            ->sortBy('rate')
                            ->values();
                        if ($filtered->isEmpty()) {
                            $this->warn("  No valid courier after weight filter");
                            continue;
                        }
                        $rate = $filtered->first()['rate'] ?? null;
                        if ($rate) {
                            $update[$column] = $rate;
                            $this->info("  Rate found: ₹" . $rate);
                        }
                        /* API safety delay */
                        usleep(500000); /* 0.5 sec */
                    }
                    if (!empty($update)) {
                        DB::table('pincode_data')
                            ->where('id', $row->id)
                            ->update($update);
                        $this->info("Updated: " . $row->pincode);
                        // Log::info("Updated rates", [
                        //     'pincode' => $row->pincode,
                        //     'data' => $update
                        // ]);
                    } else {
                        $this->warn("No rates updated for: " . $row->pincode);
                    }
                }
            });
        $this->info('All rates updated successfully!');
    }
}