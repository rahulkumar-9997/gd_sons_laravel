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

    public $tries = 25;
    public $timeout = 120;
    public $backoff = [60, 120, 300, 600];

    protected $pincodeId;
    protected $weightId;

    public function __construct($pincodeId, $weightId)
    {
        $this->pincodeId = $pincodeId;
        $this->weightId  = $weightId;
    }

    public function retryUntil()
    {
        return now()->addDays(5);
    }

    public function handle(ShiprocketService $ship)
    {
        $pincode = Pincode::find($this->pincodeId);
        $weight  = WeightCategory::find($this->weightId);
        if (!$pincode || !$weight) {
            return;
        }
        if (!$this->allowedByRateLimit()) {
            $this->release(45);
            return;
        }
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        try {
            $response = $ship->getServiceability([
                'pickup_postcode'   => $fromPin,
                'delivery_postcode' => $pincode->pincode,
                'weight'            => (string) $weight->primary_weight,
                'cod'               => 0,
            ]);
        } catch (\Throwable $e) {
            Log::error('Shiprocket API exception', [
                'pincode' => $pincode->pincode,
                'weight'  => $weight->primary_weight,
                'attempt' => $this->attempts(),
                'message' => $e->getMessage(),
            ]);
            throw $e;        }
        if (empty($response['raw'])) {
            throw new \RuntimeException(
                'Shiprocket request failed: ' . ($response['message'] ?? 'unknown error')
            );
        }
        $companies = $response['raw']['data']['available_courier_companies'] ?? [];
        $courier = collect($companies)
        ->filter(function ($item) use ($weight) {
            $min = isset($item['min_weight']) && $item['min_weight'] !== ''
                ? (float) $item['min_weight'] : 0.0;
            $max = isset($item['max_weight']) && $item['max_weight'] > 0
                ? (float) $item['max_weight'] : PHP_FLOAT_MAX;
            return $weight->primary_weight >= $min && $weight->primary_weight <= $max;
        })
        ->filter(fn($item) => isset($item['rate']) && is_numeric($item['rate']))
        ->filter(fn($item) => empty($item['blocked']))
        ->sortBy(fn($item) => (float) $item['rate'])
        ->first();
        PincodeShippingRate::updateOrCreate(
            [
                'pincode_id' => $pincode->id,
                'weight_category_id' => $weight->id,
            ],
            [
                'shipping_rate' => $courier ? (float) $courier['rate'] : null,              
            ]
        );

        if (!$courier) {
            Log::warning('Not serviceable', [
                'pincode' => $pincode->pincode,
                'weight'  => $weight->primary_weight,
            ]);
        }
    }

    protected function allowedByRateLimit(): bool
    {
        $key = 'shiprocket_api_' . now()->format('YmdHi');
        Cache::add($key, 0, 120);
        return Cache::increment($key) <= 22;
    }

    public function failed(\Throwable $e)
    {
        Log::error('UpdateShipmentRatesJob permanently failed', [
            'pincode_id' => $this->pincodeId,
            'weight_id'  => $this->weightId,
            'message'    => $e->getMessage(),
        ]);
    }
}
