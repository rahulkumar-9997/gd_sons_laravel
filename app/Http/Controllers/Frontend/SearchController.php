<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute_values;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchSuggestionsOld(Request $request){
        $query = $request->get('query');
        $searchTerms = explode(' ', $query);
        $booleanQuery = '+' . implode(' +', $searchTerms);
        $products = Product::whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
            ->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->with('firstImage')
            ->limit(15)
            ->get(['id', 'title']);

        $suggestions = $products->map(function ($product) {
            $image = $product->images->first();
            return [
                'title' => ucwords(strtolower($product->title)),
                'image' => $image ? asset('images/product/icon/' . $image->image_path) : null,
            ];
        });
		DB::disconnect();
        return response()->json(['suggestions' => $suggestions]);
    }

    public function searchSuggestions_OLD(Request $request) {
        $query = $request->get('query');
        $searchTerms = explode(' ', $query);
        
        // Search products
        $booleanQuery = '+' . implode(' +', $searchTerms);
        $products = Product::whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
            ->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->with('firstImage')
            ->limit(5) // Reduced limit to make room for other types
            ->get(['id', 'title']);

        // Search categories
        $categories = Category::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->limit(5)
            ->get(['id', 'title']);

        // Search attributes
        $attributes = Attribute::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->limit(5)
            ->get(['id', 'title']);

        // Search attribute values
        $attributeValues = Attribute_values::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('name', 'like', '%' . $term . '%');
                }
            })
            ->limit(5)
            ->get(['id', 'name as title', 'attributes_id']);

        // Format all results
        $suggestions = collect();
        
        // Add products
        $suggestions = $suggestions->merge($products->map(function ($product) {
            $image = $product->firstImage;
            return [
                'type' => 'product',
                'title' => ucwords(strtolower($product->title)),
                'image' => $image ? asset('images/product/icon/' . $image->image_path) : null,
            ];
        }));
        
        // Add categories
        $suggestions = $suggestions->merge($categories->map(function ($category) {
            return [
                'type' => 'category',
                'title' => ucwords(strtolower($category->title)),
                'image' => null,
            ];
        }));
        
        // Add attributes
        $suggestions = $suggestions->merge($attributes->map(function ($attribute) {
            return [
                'type' => 'attribute',
                'title' => ucwords(strtolower($attribute->title)),
                'image' => null,
            ];
        }));
        
        // Add attribute values
        $suggestions = $suggestions->merge($attributeValues->map(function ($value) {
            return [
                'type' => 'attribute_value',
                'title' => ucwords(strtolower($value->title)),
                'image' => null,
            ];
        }));

        DB::disconnect();
        return response()->json(['suggestions' => $suggestions]);
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('query');
        if (empty(trim($query))) {
            return response()->json(['suggestions' => []]);
        }
        Log::error('suggestion log: ' . $query);           
        $searchTerms = explode(' ', $query);
        /* Search products */
        $booleanQuery = '+' . implode(' +', $searchTerms);
        $products = Product::whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
            ->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->with([
                'firstImage',
                'category',
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with(['attributeValue:id,slug'])
                        ->orderBy('id');
                }
            ])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
            ->limit(5)
            ->get(['id', 'title', 'slug']); 

        /* Search categories */
        $categories = Category::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->limit(5)
            ->get(['id', 'title']);

        /* Search attribute values */
        $attributeValues = Attribute_values::where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('name', 'like', '%' . $term . '%');
                }
            })
            ->with('attribute')
            ->limit(5)
            ->get(['id', 'name as title', 'attributes_id']);
        $suggestions = collect();
        
        /* Add attribute values (as suggestions) */
        $suggestions = $suggestions->merge($attributeValues->map(function ($value) {
            return [
                'type' => 'suggestion',
                'title' => ucwords(strtolower($value->title)),
                'image' => null,
            ];
        }));
        
        /* Add categories (as suggestions) */
        $suggestions = $suggestions->merge($categories->map(function ($category) {
            return [
                'type' => 'suggestion',
                'title' =>  ucwords(strtolower($category->title)),
                'image' => null,
            ];
        }));
        $attributes_value = null;
        $suggestions = $suggestions->merge($products->map(function ($product) {
            $image = $product->firstImage;
            if($product->ProductAttributesValues->isNotEmpty()){
                $attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
            }
            if ($product->offer_rate)
            {
                $offer_rate = 'Rs. ' . $product->offer_rate;
            }
            else
            {
                $offer_rate = 'Price not available';
            }
            return [
                'type' => 'product',
                'title' => ucwords(strtolower($product->title)),
                'slug' => $product->slug,
                'attributes_value' => $attributes_value,
                'category' => $product->category->title,
                'offer_rate' => $offer_rate,
                'image' => $image ? asset('images/product/icon/' . $image->image_path) : null,
                'slug' => $product->slug,
            ];
        }));

        return response()->json(['suggestions' => $suggestions]);
    }

    public function searchListProduct(Request $request)
    {
        $query = trim($request->get('query'));
        $category = trim($request->get('category'));
        $cleanedQuery = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $query);
        $cleanedQuery = preg_replace('/\s+/', ' ', $cleanedQuery);
        $searchTerms = array_filter(explode(' ', trim($cleanedQuery)), function($term) {
            return strlen($term) >= 2;
        });

        if(empty($searchTerms)) {
            return view('frontend.pages.search-catalog', [
                'products' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 100),
                'categories' => collect(),
                'query' => $query,
                'specialOffers' => getCustomerSpecialOffers()
            ]);
        }
        $booleanQuery = implode(' ', array_map(function($term) {
            return '+' . $term . '*';
        }, $searchTerms));
        try {
            $productsQuery = Product::leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
            ->with([
                'images' => function($query) {$query->orderBy('sort_order');},
                'ProductImagesFront:id,product_id,image_path',
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with(['attributeValue:id,slug'])
                        ->orderBy('id');
                }
            ]);
            $productsQuery->where(function($query) use ($booleanQuery, $searchTerms) {
                if (!empty($booleanQuery)) {
                    $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                }
                
                foreach ($searchTerms as $term) {
                    $query->orWhere('title', 'like', '%' . $term . '%');
                }
            });

            if ($category) {
                $categoryIds = explode(',', $category);
                $productsQuery->whereIn('category_id', $categoryIds);
            }
            $products = $productsQuery->paginate(100);
            $categories = Category::whereHas('products', function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })->orderBy('created_at', 'desc')->get();
            DB::disconnect();            
            return view('frontend.pages.search-catalog', [
                'products' => $products,
                'categories' => $categories,
                'query' => $query,
                'specialOffers' => getCustomerSpecialOffers()
            ]);

        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return view('frontend.pages.search-catalog', [
                'products' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 100),
                'categories' => collect(),
                'query' => $query,
                'specialOffers' => getCustomerSpecialOffers()
            ]);
        }
    }

    public function searchListProduct_19_7_25_remove_it(Request $request){
        $query = trim($request->get('query'));
        $category = trim($request->get('category'));
		$cleanedQuery = preg_replace('/[^a-zA-Z0-9\s]/', ' ', $query);
		$cleanedQuery = preg_replace('/\s+/', ' ', $cleanedQuery);
		$searchTerms = array_filter(explode(' ', trim($cleanedQuery)));
        if (empty($query)) {
            return view('frontend.pages.search-catalog', [
                'products' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 100),
                'categories' => collect(),
                'query' => $query
            ]);
        }
        $booleanQuery = count($searchTerms) > 0 ? '+' . implode(' +', $searchTerms) : '';
        //$booleanQuery = '+' . implode(' +', $searchTerms);

        $productsQuery = Product::leftJoin('inventories', function ($join) {
            $join->on('products.id', '=', 'inventories.product_id')
                ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
        })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
            ->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
            ->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            })
            ->with([
                'images' => function($query) {$query->orderBy('sort_order');},
                'ProductImagesFront:id,product_id,image_path',
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with([
                            'attributeValue:id,slug'
                        ])
                        ->orderBy('id');
                }
            ]);

        if ($category) {
            $categoryIds = explode(',', $category);
            $productsQuery->whereIn('category_id', $categoryIds);
        }

        $products = $productsQuery->paginate(100);

        $categories = Category::whereHas('products', function ($query) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $query->where('title', 'like', '%' . $term . '%');
            }
        })->orderBy('created_at', 'desc')->get();
        $specialOffers = getCustomerSpecialOffers();
        //dd($specialOffers);
		DB::disconnect();
        return view('frontend.pages.search-catalog', [
            'products' => $products,
            'categories' => $categories,
            'query' => $query,
            'specialOffers' =>$specialOffers
        ]);
    }
}
