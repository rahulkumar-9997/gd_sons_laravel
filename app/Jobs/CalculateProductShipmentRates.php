<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ShippingRateEstimator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * this code for only queue job, and only inventory table update shipment rate and offer shipment rate, not update product table
 * 
 * 
 * 
 * CalculateProductShipmentRates
 *
 *   Fetch Product + Inventory
 *           ↓
 *   Calculate Volumetric Weight   (L × B × H / 5000)
 *           ↓
 *   Apply Today's Shipment Rate Logic   (ShippingRateEstimator::estimate)
 *           ↓
 *   Calculate Offer Shipment Rate   (offer_rate + shipment_rate)
 *           ↓
 *   Update Inventory
 *
 * Dispatch it ONCE with no arguments:
 *     CalculateProductShipmentRates::dispatch();
 * It splits all products into chunks and queues one copy of itself per chunk,
 * so no single job runs long enough to hit the worker timeout.
 */
class CalculateProductShipmentRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private const VOLUMETRIC_DIVISOR = 5000;
    private const CHUNK_SIZE = 200;
    public int $tries = 3;
    public int $timeout = 300;
    public array $backoff = [30, 120];

    /**
     * @param  int[]|null  $productIds  null = split all products into chunk jobs
     */
    public function __construct(public ?array $productIds = null)
    {
    }

    public function handle(): void
    {
        if ($this->productIds === null) {
            $this->dispatchChunks();
            return;
        }

        $this->processChunk();
    }

    /* ------------------------------------------------------------------ */
    /*  Fan-out: queue one job per chunk of product IDs                    */
    /* ------------------------------------------------------------------ */

    private function dispatchChunks(): void
    {
        $jobs = 0;

        Product::query()
            ->whereHas('inventories')
            ->select('id')
            ->chunkById(self::CHUNK_SIZE, function ($products) use (&$jobs) {
                static::dispatch($products->pluck('id')->all());
                $jobs++;
            });

        Log::info("CalculateProductShipmentRates: {$jobs} chunk jobs queued.");
    }

    /* ------------------------------------------------------------------ */
    /*  Step 3 → Step 7 for one chunk                                      */
    /* ------------------------------------------------------------------ */

    private function processChunk(): void
    {
        // Step 3: fetch products with their inventory records
        $products = Product::query()
            ->whereIn('id', $this->productIds)
            ->select(['id', 'length', 'breadth', 'height'])
            ->with(['inventories:id,product_id,offer_rate'])
            ->get();

        $updated = 0;
        $skipped = [];
        $failed  = [];

        foreach ($products as $product) {
            try {
                $volumetricKg = self::volumetricWeight($product);
                if ($volumetricKg === null) {
                    $skipped[] = $product->id;
                    continue;
                }
                $shipmentRate = ShippingRateEstimator::estimate($volumetricKg)['rate'];
                DB::transaction(static function () use ($product, $shipmentRate) {
                    foreach ($product->inventories as $inventory) {
                        DB::table('inventories')
                            ->where('id', $inventory->id)
                            ->update([
                                'shipment_rate'=> round($shipmentRate),
                                'offer_shipment_rate' => round(
                                    self::offerShipmentRate(
                                        $inventory->offer_rate,
                                        $shipmentRate
                                    )
                                ),
                            ]);
                    }
                });

                $updated++;
            } catch (Throwable $e) {
                $failed[] = $product->id;
                Log::error('Shipment rate failed', [
                    'product_id' => $product->id,
                    'error'      => $e->getMessage(),
                ]);
            }
        }

        Log::info('CalculateProductShipmentRates chunk done', [
            'updated'                 => $updated,
            'skipped_no_dimensions'   => $skipped,
            'failed'                  => $failed,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Helpers                                                            */
    /* ------------------------------------------------------------------ */

    /** L × B × H / 5000. Null if any dimension is missing or zero. */
    public static function volumetricWeight(Product $product): ?float
    {
        $l = (float) $product->length;
        $b = (float) $product->breadth;
        $h = (float) $product->height;

        if ($l <= 0 || $b <= 0 || $h <= 0) {
            return null;
        }

        return round(($l * $b * $h) / self::VOLUMETRIC_DIVISOR, 3);
    }

    /** offer_rate + shipment_rate. Null when the inventory has no offer_rate. */
    public static function offerShipmentRate($offerRate, float $shipmentRate): ?float
    {
        if ($offerRate === null || $offerRate === '' || (float) $offerRate <= 0) {
            return null;
        }

        return round((float) $offerRate + $shipmentRate, 2);
    }

    public function failed(Throwable $e): void
    {
        Log::critical('CalculateProductShipmentRates failed permanently', [
            'product_ids' => $this->productIds,
            'error'       => $e->getMessage(),
        ]);
    }
}