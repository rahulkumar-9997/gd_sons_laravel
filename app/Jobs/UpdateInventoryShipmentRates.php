<?php

namespace App\Jobs;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateInventoryShipmentRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;
    public ?int $inventoryId;
    public ?int $pincodeId;

    public function __construct(?int $inventoryId = null, ?int $pincodeId = null)
    {
        $this->inventoryId = $inventoryId;
        $this->pincodeId   = $pincodeId;
    }

    public function handle(): void
    {
        Log::info('[UpdateInventoryShipmentRates] Job started.', [
            'inventory_id' => $this->inventoryId,
            'pincode_id'   => $this->pincodeId,
        ]);
        Log::info('[UpdateInventoryShipmentRates] Step 1: Calculating volumetric weights...');

        $productQuery = Product::whereNotNull('length')
            ->whereNotNull('breadth')
            ->whereNotNull('height')
            ->where('length', '>', 0)
            ->where('breadth', '>', 0)
            ->where('height', '>', 0);

        // Agar single inventory hai to sirf us product ka weight update karo
        if ($this->inventoryId) {
            $inventory = Inventory::find($this->inventoryId);
            if ($inventory) {
                $productQuery->where('id', $inventory->product_id);
            }
        }

        $productQuery->chunkById(100, function ($products) {
            $bulkProductUpdates = [];

            foreach ($products as $product) {
                $length  = (float) $product->length;
                $breadth = (float) $product->breadth;
                $height  = (float) $product->height;

                if ($length <= 0 || $breadth <= 0 || $height <= 0) {
                    continue;
                }
                $volumetricWeight = round(($length * $breadth * $height) / 5000, 2);
                $bulkProductUpdates[$product->id] = $volumetricWeight;
            }
            if (!empty($bulkProductUpdates)) {
                $this->bulkUpdateProducts($bulkProductUpdates);
            }
        });

        Log::info('[UpdateInventoryShipmentRates] Step 1 completed: Volumetric weights updated.');

        /* STEP 2: Load weight categories once */
        $weightCategories = WeightCategory::orderBy('min_weight')->get();

        if ($weightCategories->isEmpty()) {
            Log::warning('[UpdateInventoryShipmentRates] No weight categories found. Job aborted.');
            return;
        }

        /* STEP 3: Calculate shipment_rate for all inventories */
        Log::info('[UpdateInventoryShipmentRates] Step 2: Calculating shipment rates...');

        $inventoryQuery = Inventory::with(['product:id,volumetric_weight_kg'])
            ->whereHas('product', function ($q) {
                $q->whereNotNull('volumetric_weight_kg')
                  ->where('volumetric_weight_kg', '>', 0);
            });

        if ($this->inventoryId) {
            $inventoryQuery->where('id', $this->inventoryId);
        }

        $updated = 0;
        $skipped = 0;

        $inventoryQuery->chunkById(100, function ($inventories) use (
            $weightCategories,
            &$updated,
            &$skipped
        ) {
            $bulkInventoryUpdates = [];
            foreach ($inventories as $inventory) {
                $product = $inventory->product;
                if (!$product || blank($product->volumetric_weight_kg)) {
                    $skipped++;
                    continue;
                }
                $volumetricWeight = (float) $product->volumetric_weight_kg;

                // Match weight category
                $matchedCategory = $this->matchWeightCategory($weightCategories, $volumetricWeight);

                if (!$matchedCategory) {
                    Log::debug('[UpdateInventoryShipmentRates] No category matched.', [
                        'inventory_id'      => $inventory->id,
                        'volumetric_weight' => $volumetricWeight,
                    ]);
                    $skipped++;
                    continue;
                }

                // Get shipping rate (ceil = always round UP: 34.2→35, 34.67→35)
                $rate = $this->resolveShippingRate($matchedCategory->id);

                if ($rate === null) {
                    Log::debug('[UpdateInventoryShipmentRates] No rate found.', [
                        'inventory_id'       => $inventory->id,
                        'weight_category_id' => $matchedCategory->id,
                    ]);
                    $skipped++;
                    continue;
                }

                $bulkInventoryUpdates[$inventory->id] = $rate;
            }

            if (!empty($bulkInventoryUpdates)) {
                $this->bulkUpdateInventories($bulkInventoryUpdates);
                $updated += count($bulkInventoryUpdates);
            }
        });

        Log::info('[UpdateInventoryShipmentRates] Job fully completed.', [
            'updated' => $updated,
            'skipped' => $skipped,
        ]);
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Match volumetric weight to a weight category
     * Last category (max_weight = NULL) covers 40 KG and above
     */
    private function matchWeightCategory($weightCategories, float $weight): ?WeightCategory
    {
        foreach ($weightCategories as $category) {
            $min = (float) $category->min_weight;
            $max = $category->max_weight !== null ? (float) $category->max_weight : PHP_FLOAT_MAX;

            if ($weight >= $min && $weight <= $max) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Get shipping rate — ceil() always rounds UP (34.2→35, 34.67→35)
     * pincodeId set  → rate for that specific pincode
     * pincodeId null → minimum rate across all pincodes
     */
    private function resolveShippingRate(int $weightCategoryId): ?float
    {
        $query = PincodeShippingRate::where('weight_category_id', $weightCategoryId);

        if ($this->pincodeId) {
            $rateModel = $query->where('pincode_id', $this->pincodeId)->first();
            return $rateModel ? (float) ceil($rateModel->shipping_rate) : null;
        }

        $minRate = $query->min('shipping_rate');
        return $minRate !== null ? (float) ceil($minRate) : null;
    }

    /**
     * Bulk update products.volumetric_weight_kg
     */
    private function bulkUpdateProducts(array $updates): void
    {
        $cases  = '';
        $idList = implode(',', array_keys($updates));

        foreach ($updates as $id => $weight) {
            $cases .= "WHEN {$id} THEN {$weight} ";
        }

        DB::statement("
            UPDATE products
            SET    volumetric_weight_kg = CASE id {$cases} END,
                   updated_at           = NOW()
            WHERE  id IN ({$idList})
        ");
    }

    /**
     * Bulk update inventories.shipment_rate
     */
    private function bulkUpdateInventories(array $updates): void
    {
        $cases  = '';
        $idList = implode(',', array_keys($updates));

        foreach ($updates as $id => $rate) {
            $cases .= "WHEN {$id} THEN {$rate} ";
        }

        DB::statement("
            UPDATE inventories
            SET    shipment_rate = CASE id {$cases} END,
                   updated_at   = NOW()
            WHERE  id IN ({$idList})
        ");
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('[UpdateInventoryShipmentRates] Job failed.', [
            'inventory_id' => $this->inventoryId,
            'error'        => $exception->getMessage(),
        ]);
    }
}