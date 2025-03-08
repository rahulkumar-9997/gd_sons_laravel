<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Category;
use App\Models\Product;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate a dynamic sitemap for the application';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add Home Page
        $sitemap->add(Url::create(url('/'))->setLastModificationDate(now()));

        // Add Static Pages
        $sitemap->add(Url::create(route('about-us'))->setLastModificationDate(now()));
        $sitemap->add(Url::create(route('contact-us'))->setLastModificationDate(now()));

        // Add Categories Dynamically
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->add(Url::create(route('categories', ['categorySlug' => $category->slug]))
                        ->setLastModificationDate($category->updated_at));
        }

        // Add Products Dynamically
        $products = Product::with([
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with([
                            'attributeValue:id,slug'
                        ])
                        ->orderBy('id');
                }
            ])
            ->get();
            foreach ($products as $product_row) {
                if($product_row->ProductAttributesValues->isNotEmpty()){
                    $attributes_value = $product_row->ProductAttributesValues->first()->attributeValue->slug;
                    }
                $sitemap->add(Url::create(route('product', ['slug' => $product_row->slug, 'attributesvalue' =>  $attributes_value]))
                            ->setLastModificationDate($product_row->updated_at));
            }

        // Save sitemap to public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }
}
