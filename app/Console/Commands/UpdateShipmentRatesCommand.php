<?php

namespace App\Console\Commands;

use App\Jobs\UpdateInventoryShipmentRates;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Console\Command;

class UpdateShipmentRatesCommand extends Command
{
    protected $signature = 'shipment:update-inventory-shipment-rate
        {--inventory= : Single inventory ID update karne ke liye}
        {--pincode=   : Pincode ID for rate lookup (na do to minimum rate lega)}
        {--sync       : Queue me jaaye bina seedha run karo}';

    protected $description = 'Step 1: Products ka volumetric_weight_kg calculate karo (L×B×H/5000). Step 2: Inventory ka shipment_rate update karo.';

    public function handle(): int
    {
        $inventoryId = $this->option('inventory') ? (int) $this->option('inventory') : null;
        $pincodeId   = $this->option('pincode')   ? (int) $this->option('pincode')   : null;
        $sync        = $this->option('sync');
        if ($inventoryId && !Inventory::find($inventoryId)) {
            $this->error("Inventory ID {$inventoryId} nahi mila.");
            return self::FAILURE;
        }
        $productCount = Product::whereNotNull('length')
            ->whereNotNull('breadth')
            ->whereNotNull('height')
            ->where('length', '>', 0)
            ->where('breadth', '>', 0)
            ->where('height', '>', 0)
            ->when($inventoryId, function ($q) use ($inventoryId) {
                $inventory = Inventory::find($inventoryId);
                if ($inventory) {
                    $q->where('id', $inventory->product_id);
                }
            })
            ->count();

        $this->info('==================================================');
        $this->info('  Shipment Rate Update Job');
        $this->info('==================================================');
        $this->line("  Step 1 : Volumetric weight calculate hoga");
        $this->line("           Formula: L × B × H / 5000");
        $this->line("           Products found: {$productCount}");
        $this->line("  Step 2 : Inventory shipment_rate update hoga");
        $this->line("           Decimal rate ceil() se round UP hoga");
        $this->line("           Example: 34.2 → 35, 34.67 → 35");
        $this->info('==================================================');
        $this->line('');

        $job = new UpdateInventoryShipmentRates($inventoryId, $pincodeId);

        if ($sync) {
            $this->info('Synchronously run ho raha hai...');
            $job->handle();
            $this->line('');
            $this->info('✓ Step 1 complete: volumetric_weight_kg updated in products table.');
            $this->info('✓ Step 2 complete: shipment_rate updated in inventories table.');
        } else {
            dispatch($job);
            $this->info('Job queue me dispatch ho gaya.');
            $this->line('Worker start karo: <comment>php artisan queue:work</comment>');
        }

        return self::SUCCESS;
    }
}