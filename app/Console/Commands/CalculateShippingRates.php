<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use App\Jobs\UpdateShipmentRatesJob;
use Illuminate\Support\Facades\Log;

class CalculateShippingRates extends Command
{
    protected $signature = 'shiprocket:update-rates
            {--chunk=50 : Number of pincodes per chunk}
            {--delay=5 : Delay in seconds between each job}
            {--force : Force update even if all weights are processed}';
    
    protected $description = 'Update shipping rates from Shiprocket with rate limiting';

    public function handle()
    {
        $this->info('🚀 Starting Shiprocket rates update...');
        $this->line('📅 ' . now()->format('Y-m-d H:i:s'));
        $this->line('---');
        
        $totalWeights = WeightCategory::count();
        
        if ($totalWeights === 0) {
            $this->error('❌ No weight categories found!');
            return 1;
        }
        
        $chunkSize = (int)$this->option('chunk');
        $delaySeconds = (int)$this->option('delay');
        $force = $this->option('force');
        
        $this->info("📊 Total weight categories: {$totalWeights}");
        $this->info("📦 Chunk size: {$chunkSize}");
        $this->info("⏱️  Job delay: {$delaySeconds} seconds");
        $this->info("🔄 Force update: " . ($force ? 'Yes' : 'No'));
        $this->line('---');
        
        // Build query to get pincodes that need updating
        $query = Pincode::query();
        
        if (!$force) {
            // Get pincodes that are fully processed
            $processedPincodes = PincodeShippingRate::select('pincode_id')
                ->whereNotNull('shipping_rate')
                ->groupBy('pincode_id')
                ->havingRaw('COUNT(DISTINCT weight_category_id) >= ?', [$totalWeights])
                ->pluck('pincode_id')
                ->toArray();
            
            $query->whereNotIn('id', $processedPincodes);
            
            // ❌ REMOVED: Error tracking since columns don't exist
            // Just process pincodes that are not fully processed
        }
        
        $totalPincodes = $query->count();
        
        if ($totalPincodes === 0) {
            $this->info('✅ All pincodes are already up to date!');
            return 0;
        }
        
        $this->info("📍 Found {$totalPincodes} pincodes to update");
        $this->line('---');
        
        // Skip confirmation for cron (use --no-interaction)
        if ($this->input->isInteractive() && !$this->confirm("Process {$totalPincodes} pincodes?", true)) {
            $this->info('❌ Cancelled by user');
            return 0;
        }
        
        $processedCount = 0;
        $chunkCount = 0;
        $bar = $this->output->createProgressBar($totalPincodes);
        $bar->start();
        
        $query->chunkById($chunkSize, function ($pincodes) use ($delaySeconds, &$processedCount, &$chunkCount, $bar) {
            $chunkCount++;
            $this->newLine();
            $this->info("📦 Processing chunk #{$chunkCount} with {$pincodes->count()} pincodes");
            
            foreach ($pincodes as $index => $pincode) {
                // Calculate delay for each job
                $jobDelay = $delaySeconds + ($index * 2);
                
                UpdateShipmentRatesJob::dispatch($pincode->id)
                    ->delay(now()->addSeconds($jobDelay));
                
                $processedCount++;
                $bar->advance();
                
                // Log progress every 100 pincodes
                if ($processedCount % 100 === 0) {
                    $this->line("\n📊 Progress: {$processedCount} pincodes dispatched");
                }
            }
            
            // Extra delay between chunks to prevent queue overload
            if ($chunkCount % 5 === 0) {
                $this->line("\n⏳ Cooling down for 30 seconds...");
                sleep(30);
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info('✅ Jobs dispatched successfully!');
        $this->info("📋 Total jobs dispatched: {$processedCount}");
        $this->info('🔍 Check logs for processing details:');
        $this->line('   tail -f storage/logs/laravel.log');
        $this->line('---');
        
        Log::info('Shiprocket rate update completed', [
            'total_pincodes' => $processedCount,
            'chunk_size' => $chunkSize,
            'job_delay' => $delaySeconds,
            'force_update' => $force
        ]);
        
        return 0;
    }
}