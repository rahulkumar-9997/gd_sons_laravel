<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:embeddings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate embeddings for products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \App\Models\Product::whereNull('vector_embedding')
        ->chunk(50, function ($products) {
            foreach ($products as $product) {
                \App\Jobs\GenerateEmbeddingJob::dispatch($product);
            }
        });
        $this->info('Embedding jobs dispatched!');
    }
}
