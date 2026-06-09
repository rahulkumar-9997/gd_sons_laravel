<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Http\Controllers\Backend\ProductReviewAutoAiGenerateController;

class GenerateAllReviews extends Command
{
    protected $signature = 'reviews:generate-all';

    protected $description = 'Generate AI reviews for all products';

    public function handle()
    {
        $controller = app(ProductReviewAutoAiGenerateController::class);

        Product::chunk(10, function ($products) use ($controller) {

            foreach ($products as $product) {
                $this->info("Generating reviews for Product ID {$product->id}");
                try {
                    $controller->generateAIReview($product->id);
                    $this->info("Completed : {$product->title}");
                    sleep(2); 
                } catch (\Exception $e) {
                    $this->error(
                        "Failed Product {$product->id}: " . $e->getMessage()
                    );
                }
            }
        });

        $this->info('All products completed successfully.');
    }
}