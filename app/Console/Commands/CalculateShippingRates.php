<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Jobs\UpdateShipmentRatesJob;

class CalculateShippingRates extends Command
{
    protected $signature = 'shiprocket:update-rates
            {--chunk=200 : Pincodes fetched per chunk}
            {--force : Re-dispatch pairs that already have a rate}';

    protected $description = 'Dispatch Shiprocket rate lookups for every pincode x weight pair';
    public function handle()
    {
        $weights = WeightCategory::orderBy('primary_weight')->get();
        if ($weights->isEmpty()) {
            $this->error('No weight categories found. Run WeightCategorySeeder first.');
            return 1;
        }
        $force     = $this->option('force');
        $chunkSize = (int) $this->option('chunk');
        $existing = [];
        if (!$force) {
            DB::table('pincode_shipping_rates')
                ->whereNotNull('shipping_rate')
                ->select('pincode_id', 'weight_category_id')
                ->orderBy('id')
                ->chunk(5000, function ($rows) use (&$existing) {
                    foreach ($rows as $r) {
                        $existing[$r->pincode_id . ':' . $r->weight_category_id] = true;
                    }
                });
        }
        $this->info('Weight slabs: ' . $weights->count());
        $this->info('Pincodes: ' . Pincode::count());
        $this->info('Already done: ' . count($existing));
        $this->line('---');
        $dispatched = 0;
        $offset     = 0;
        Pincode::orderBy('id')->chunkById($chunkSize, function ($pincodes) use ($weights, $existing, &$dispatched, &$offset) {
            foreach ($pincodes as $pincode) {
                foreach ($weights as $weight) {
                    if (isset($existing[$pincode->id . ':' . $weight->id])) {
                        continue;
                    }
                    UpdateShipmentRatesJob::dispatch($pincode->id, $weight->id)
                        ->delay(now()->addSeconds(intdiv($offset, 20) * 60 + ($offset % 20) * 3));
                    $offset++;
                    $dispatched++;
                }
            }
            $this->line("Dispatched so far: {$dispatched}");
        });
        $this->newLine();
        $this->info("Total jobs queued: {$dispatched}");
        return 0;
    }
}
