<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Jobs\UpdateShipmentRatesJob;
class CalculateShippingRates extends Command
{
    protected $signature = 'shiprocket:update-rates';
    protected $description = 'Update shipping rates from Shiprocket';
    public function handle()
    {
        $this->info('Dispatching jobs...');
        $totalWeights = WeightCategory::count();
        Pincode::whereNotIn(
            'id',
            PincodeShippingRate::select('pincode_id')
                ->groupBy('pincode_id')
                ->havingRaw(
                    'COUNT(DISTINCT weight_category_id) >= ?',
                    [$totalWeights]
                )
        )
        ->chunkById(100, function ($pincodes) {
            foreach ($pincodes as $pincode) {
                UpdateShipmentRatesJob::dispatch($pincode->id);
            }
        });
        $this->info('Jobs dispatched successfully.');
    }
}