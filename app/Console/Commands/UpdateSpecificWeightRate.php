<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Jobs\UpdateShipmentRatesJob;
use Illuminate\Support\Facades\Log;

class UpdateSpecificWeightRate extends Command
{
    protected $signature = 'shiprocket:update-1.5kg
            {--chunk=50 : Number of pincodes per chunk}
            {--delay=5 : Delay in seconds between each job}
            {--force : Force update even if already processed}';
    
    protected $description = 'Update shipping rates for 1.5 kg weight only';

    public function handle()
    {
        $this->info('Starting 1.5 kg rate update...');
        $this->line(now()->format('Y-m-d H:i:s'));
        $this->line('---');
        $weight = WeightCategory::where('primary_weight', 1.50)->first();
        
        if (!$weight) {
            $this->error('1.5 kg weight category not found!');
            return 1;
        }
        
        $this->info("Weight category: {$weight->primary_weight} kg (ID: {$weight->id})");
        
        $chunkSize = (int)$this->option('chunk');
        $delaySeconds = (int)$this->option('delay');
        $force = $this->option('force');
        
        $this->info("Chunk size: {$chunkSize}");
        $this->info("Job delay: {$delaySeconds} seconds");
        $this->info("Force update: " . ($force ? 'Yes' : 'No'));
        $this->line('---');
        $query = Pincode::query();
        
        if (!$force) {
            $processedPincodes = PincodeShippingRate::where('weight_category_id', $weight->id)
                ->whereNotNull('shipping_rate')
                ->pluck('pincode_id')
                ->toArray();            
            $query->whereNotIn('id', $processedPincodes);
        }        
        $totalPincodes = $query->count();        
        if ($totalPincodes === 0) {
            $this->info('All pincodes already have 1.5 kg rates!');
            return 0;
        }
        
        $this->info("Found {$totalPincodes} pincodes to update");
        $this->line('---');
        if ($this->input->isInteractive() && !$this->confirm("Process {$totalPincodes} pincodes?", true)) {
            $this->info('Cancelled by user');
            return 0;
        }
        
        $processedCount = 0;
        $chunkCount = 0;
        $bar = $this->output->createProgressBar($totalPincodes);
        $bar->start();
        
        $query->chunkById($chunkSize, function ($pincodes) use ($weight, $delaySeconds, &$processedCount, &$chunkCount, $bar) {
            $chunkCount++;
            $this->newLine();
            $this->info("📦 Processing chunk #{$chunkCount} with {$pincodes->count()} pincodes");
            
            foreach ($pincodes as $index => $pincode) {
                $jobDelay = $delaySeconds + ($index * 2);
                UpdateShipmentRatesJob::dispatch($pincode->id, $weight->id)
                    ->delay(now()->addSeconds($jobDelay));                
                $processedCount++;
                $bar->advance();
                
                if ($processedCount % 100 === 0) {
                    $this->line("\n Progress: {$processedCount} pincodes dispatched");
                }
            }
            
            if ($chunkCount % 5 === 0) {
                $this->line("\n⏳ Cooling down for 30 seconds...");
                sleep(30);
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info('Jobs dispatched successfully!');
        $this->info("Total jobs dispatched: {$processedCount}");
        $this->info('Check logs for processing details:');
        $this->line('   tail -f storage/logs/laravel.log');
        $this->line('---');
        
        Log::info('1.5 kg rate update completed', [
            'total_pincodes' => $processedCount,
            'chunk_size' => $chunkSize,
            'job_delay' => $delaySeconds,
            'force_update' => $force
        ]);
        
        return 0;
    }
}