<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use Carbon\Carbon;
use App\Models\BlogCategory;


class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

       
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . url('/') . '</loc>';
        $sitemap .= '<lastmod>' . Carbon::now()->toAtomString() . '</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';

        /**category  */
        $categories = Category::get();
        foreach ($categories as $category) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . url('/categories/' . $category->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $category->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }

        /**Product details */
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
        foreach ($products as $product) {
            if($product->ProductAttributesValues->isNotEmpty()){
            $attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
            }
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . url('/products/' . $product->slug . '/' . $attributes_value) . '</loc>';
            $sitemap .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.7</priority>';
            $sitemap .= '</url>';
        }
        /** Blog */
        $blogCategories = BlogCategory::with('blogs')
        ->has('blogs') 
        ->orderBy('title')
        ->get();

        if ($blogCategories->isNotEmpty()) {
            foreach ($blogCategories as $blog_category) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . url('/blogs/list/' . $blog_category->slug) . '</loc>';
                $sitemap .= '<lastmod>' . $blog_category->updated_at->toAtomString() . '</lastmod>';
                $sitemap .= '<changefreq>monthly</changefreq>';
                $sitemap .= '<priority>0.6</priority>';
                $sitemap .= '</url>';

                foreach ($blog_category->blogs as $blog) {
                    $sitemap .= '<url>';
                    $sitemap .= '<loc>' . url('/blogs/' . $blog->slug) . '</loc>';
                    $sitemap .= '<lastmod>' . $blog->updated_at->toAtomString() . '</lastmod>';
                    $sitemap .= '<changefreq>monthly</changefreq>';
                    $sitemap .= '<priority>0.6</priority>';
                    $sitemap .= '</url>';
                }
            }
        }
        /**Product catelog */
        $categories = Category::with([
            'attributes' => function ($query) {
                $query->whereHas('mappedCategoryToAttributesForFront');
            },
            'attributes.AttributesValues' => function ($query) {
                $query->whereHas('map_attributes_value_to_categories');
            }
        ])->orderBy('title')->get();
        
        $formattedCategories = $categories->map(function ($category) {
            $attributesWithValues = [];
            $mappedAttributes = $category->attributes->filter(function ($attribute) use ($category) {
                return $attribute->mappedCategoryToAttributesForFront->where('category_id', $category->id)->isNotEmpty();
            });
        
            $mappedAttributes = $mappedAttributes->sortBy('title'); /** Alphabetical order */
        
            foreach ($mappedAttributes as $attribute) {
                $filteredValues = $attribute->AttributesValues->filter(function ($value) use ($category) {
                    return $value->map_attributes_value_to_categories->contains('id', $category->id);
                });
        
                if ($filteredValues->isNotEmpty()) {
                    $attributesWithValues[] = [
                        'title' => $attribute->title,
                        'slug' => $attribute->slug,
                        'values' => $filteredValues->map(function ($value) {
                            return [
                                'name' => $value->name,
                                'slug' => $value->slug
                            ];
                        })->values()
                    ];
                }
            }
        
            if (!empty($attributesWithValues)) {
                return [
                    'title' => $category->title,
                    'category-slug' => $category->slug,
                    'category-image' => $category->image,
                    'attributes' => $attributesWithValues
                ];
            }
        })->filter()->values();
        
        if ($formattedCategories->isNotEmpty()) {
            foreach ($formattedCategories as $category) {
                foreach ($category['attributes'] as $attribute) {
                    foreach ($attribute['values'] as $value) {
                        $sitemap .= '<url>';
                        $sitemap .= '<loc>' . url('/kitchen-catalog/' . $category['category-slug'] . '/' . $attribute['slug'] . '/' . $value['slug']) . '</loc>';
                        $sitemap .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
                        $sitemap .= '<changefreq>monthly</changefreq>';
                        $sitemap .= '<priority>0.6</priority>';
                        $sitemap .= '</url>';
                    }
                }
            }
        }
        
        /**Other page */
        $pages = [
            ['url' => url('contact-us'), 'priority' => '0.6'],
            ['url' => url('about-us'), 'priority' => '0.6'],
            ['url' => url('lp'), 'priority' => '0.5'],
            ['url' => url('checkout'), 'priority' => '0.8'],
            ['url' => url('order'), 'priority' => '0.8'],
            ['url' => url('wishlist'), 'priority' => '0.8'],
            ['url' => url('cart'), 'priority' => '0.8'],
            ['url' => url('myaccount'), 'priority' => '0.9']
        ];

        foreach ($pages as $page) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . $page['url'] . '</loc>';
            $sitemap .= '<lastmod>' . Carbon::now()->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>monthly</changefreq>';
            $sitemap .= '<priority>' . $page['priority'] . '</priority>';
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';

        return Response::make($sitemap, 200, ['Content-Type' => 'application/xml']);
    }
}
