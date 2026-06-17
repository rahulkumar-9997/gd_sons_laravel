<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Jobs\UpdateShipmentRatesJob;

class UpdateSpecificWeightRate extends Command
{
    protected $signature = 'shiprocket:update-1.5kg
                            {--chunk=50}
                            {--force}';

    protected $description = 'Update shipping rates for 1.5 kg';

    public function handle()
    {
        $weight = WeightCategory::where('primary_weight', 1.50)->first();

        if (!$weight) {
            $this->error('Weight not found.');
            return 1;
        }

        $query = Pincode::query();

        if (!$this->option('force')) {

            $processed = PincodeShippingRate::where('weight_category_id', $weight->id)
                ->whereNotNull('shipping_rate')
                ->pluck('pincode_id');

            $query->whereNotIn('id', $processed);
        }

        $total = $query->count();
        $this->info("Total Pincodes: {$total}");
        $counter = 0;
        $query->chunkById(
            (int)$this->option('chunk'),
            function ($pincodes) use ($weight, &$counter) {
                foreach ($pincodes as $pincode) {
                    UpdateShipmentRatesJob::dispatch(
                        $pincode->id,
                        $weight->id
                    )->delay(
                        now()->addSeconds($counter * 5)
                    );
                    $counter++;
                }
            }
        );
        $this->info('Jobs dispatched successfully.');
        return 0;
    }
}