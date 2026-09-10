<?php

namespace App\Console\Commands;

use App\Jobs\CalculateProductShipmentRates;
use App\Models\Product;
use App\Services\ShippingRateEstimator;
use Illuminate\Console\Command;

/**
 * this code for only queue job, and only inventory table update shipment rate and offer shipment rate, not update product table
 * 
 * php artisan shipping:product-rates             Queue the job for all products
 * php artisan shipping:product-rates --dry-run   Preview 20 products, writes nothing
 * php artisan shipping:product-rates --product=5 Run one product immediately (no queue)
 */
class CalculateProductShipmentRatesCommand extends Command
{
    protected $signature = 'shipping:product-rates
                            {--product= : Run a single product ID immediately}
                            {--dry-run : Preview calculations for 20 products, write nothing}';

    protected $description = 'Calculate volumetric shipment rates and update inventories via queue';

    public function handle(): int
    {
        if ($this->option('dry-run')) {
            return $this->dryRun();
        }

        if ($id = $this->option('product')) {
            CalculateProductShipmentRates::dispatchSync([(int) $id]);
            $this->info("Product {$id} done. See storage/logs/laravel.log for the result.");
            return self::SUCCESS;
        }

        CalculateProductShipmentRates::dispatch();
        $this->info('Job queued on "default". Run: php artisan queue:work');

        return self::SUCCESS;
    }

    private function dryRun(): int
    {
        $rows = Product::query()
            ->whereHas('inventories')
            ->select(['id', 'title', 'length', 'breadth', 'height'])
            ->with(['inventories:id,product_id,offer_rate'])
            ->orderBy('id')
            ->limit(20)
            ->get()
            ->flatMap(function ($product) {
                $vol  = CalculateProductShipmentRates::volumetricWeight($product);
                $rate = $vol !== null ? ShippingRateEstimator::estimate($vol)['rate'] : null;

                return $product->inventories->map(fn ($inv) => [
                    $product->id,
                    mb_strimwidth((string) $product->title, 0, 35, '…'),
                    "{$product->length}×{$product->breadth}×{$product->height}",
                    $vol ?? 'SKIP',
                    $rate !== null ? number_format($rate, 2) : '-',
                    $inv->offer_rate ?? '-',
                    $rate !== null
                        ? (CalculateProductShipmentRates::offerShipmentRate($inv->offer_rate, $rate) ?? 'NULL')
                        : '-',
                ]);
            });

        $this->table(
            ['Product', 'Title', 'L×B×H (cm)', 'Vol. kg', 'shipment_rate', 'offer_rate', 'offer_shipment_rate'],
            $rows
        );
        $this->comment('Dry run — nothing was written.');

        return self::SUCCESS;
    }
}