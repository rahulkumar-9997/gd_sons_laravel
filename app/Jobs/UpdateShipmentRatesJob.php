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

class UpdateShipmentRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    public $timeout = 600;
    public $backoff = 10;
    protected $pincodeId;

    public function __construct($pincodeId)
    {
        $this->pincodeId = $pincodeId;
    }

    public function handle(ShiprocketService $ship)
    {
        $pincode = Pincode::find($this->pincodeId);

        if (!$pincode) {
            return;
        }

        $weights = WeightCategory::all();
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');

        foreach ($weights as $weightCategory) {

            try {

                $response = $ship->getServiceability(
                    $fromPin,
                    $pincode->pincode,
                    $weightCategory->primary_weight,
                    0
                );

                $companies = $response['raw']['data']['available_courier_companies'] ?? [];

                $filtered = collect($companies)
                    ->filter(fn($item) =>
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
                }

                sleep(5);

            } catch (\Exception $e) {
                Log::error('Shiprocket Error', [
                    'pincode' => $pincode->pincode,
                    'weight' => $weightCategory->primary_weight,
                    'message' => $e->getMessage(),
                ]);
                sleep(5);
                continue;
            }
        }
    }
}