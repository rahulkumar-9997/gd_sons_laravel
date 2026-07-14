<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute_values;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function searchSuggestions(Request $request)
    {
        $query = trim($request->get('query', ''));
        if (empty($query)) {
            return response()->json(['suggestions' => []]);
        }

        $searchTerms = explode(' ', $query);

        $products = $this->searchProducts($searchTerms);
        $categories = $this->searchCategories($searchTerms);
        $attributeValues = $this->searchAttributeValues($searchTerms);
        if ($products->isEmpty() && $categories->isEmpty() && $attributeValues->isEmpty()) {
            $corrected = $this->getFuzzyCorrectedTerms($searchTerms);
            if ($corrected !== array_map('strtolower', $searchTerms)) {
                $products = $this->searchProducts($corrected);
                $categories = $this->searchCategories($corrected);
                $attributeValues = $this->searchAttributeValues($corrected);
            }
        }

        $suggestions = collect();
        $suggestions = $suggestions->merge($attributeValues->map(function ($value) {
            return ['type' => 'suggestion', 'title' => ucwords(strtolower($value->title)), 'image' => null];
        }));
        $suggestions = $suggestions->merge($categories->map(function ($category) {
            return ['type' => 'suggestion', 'title' => ucwords(strtolower($category->title)), 'image' => null];
        }));

        $suggestions = $suggestions->merge($products->map(function ($product) {
            $image = $product->firstImage;
            $attributes_value = null;
            if ($product->ProductAttributesValues->isNotEmpty()) {
                $attributes_value = $product->ProductAttributesValues->first()->attributeValue->slug;
            }
            $offer_rate = $product->offer_rate ? 'Rs. ' . $product->offer_rate : 'Price not available';

            return [
                'type' => 'product',
                'title' => ucwords(strtolower($product->title)),
                'slug' => $product->slug,
                'attributes_value' => $attributes_value,
                'category' => $product->category->title,
                'offer_rate' => $offer_rate,
                'image' => $image ? asset('images/product/icon/' . $image->image_path) : null,
            ];
        }));

        return response()->json(['suggestions' => $suggestions]);
    }

    private function searchProducts(array $searchTerms)
    {
        $booleanQuery = '+' . implode(' +', $searchTerms);
        return Product::whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
            ->orWhere(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where('title', 'like', '%' . $term . '%');
                }
            })
            ->whereHas('images')
            ->with([
                'firstImage',
                'category',
                'ProductAttributesValues' => function ($q) {
                    $q->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
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
    }

    private function searchCategories(array $searchTerms)
    {
        return Category::where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->where('title', 'like', '%' . $term . '%');
            }
        })->limit(5)->get(['id', 'title']);
    }

    private function searchAttributeValues(array $searchTerms)
    {
        return Attribute_values::where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->where('name', 'like', '%' . $term . '%');
            }
        })->with('attribute')->limit(5)->get(['id', 'name as title', 'attributes_id']);
    }

    private function getFuzzyCorrectedTerms(array $terms): array
    {
        $buckets = Cache::remember('search_dictionary_buckets', 3600, function () {
            $words = collect();
            $words = $words->merge(
                Product::pluck('title')->flatMap(fn($t) => explode(' ', strtolower($t)))
            );
            $words = $words->merge(
                Category::pluck('title')->flatMap(fn($t) => explode(' ', strtolower($t)))
            );
            $words = $words->merge(
                Attribute_values::pluck('name')->flatMap(fn($t) => explode(' ', strtolower($t)))
            );
            $clean = $words
                ->map(fn($w) => preg_replace('/[^a-z0-9]/', '', $w))
                ->filter(fn($w) => strlen($w) > 2)
                ->unique()
                ->values();
            return $clean->groupBy(fn($w) => $w[0])->map->values()->toArray();
        });

        $corrected = [];
        foreach ($terms as $term) {
            $termLower = strtolower($term);
            $len = strlen($termLower);
            $maxDistance = $len <= 4 ? 1 : ($len <= 7 ? 2 : 3);
            $firstChar = $termLower[0] ?? '';
            $candidates = $buckets[$firstChar] ?? [];
            $bestMatch = $termLower;
            $bestDistance = PHP_INT_MAX;
            foreach ($candidates as $word) {
                if (abs(strlen($word) - $len) > $maxDistance) {
                    continue;
                }
                $distance = levenshtein($termLower, $word);
                if ($distance < $bestDistance) {
                    $bestDistance = $distance;
                    $bestMatch = $word;
                    if ($distance === 0) break;
                }
            }

            $corrected[] = $bestDistance <= $maxDistance ? $bestMatch : $termLower;
        }

        return $corrected;
    }
    
    public function searchSuggestions_14_07_2026(Request $request)
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
			->whereHas('images')
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
        $searchTerms = array_values(array_filter(explode(' ', trim($cleanedQuery)), function ($term) {
            return strlen($term) >= 2;
        }));

        if (empty($searchTerms)) {
            return view('frontend.pages.search-catalog', [
                'productGroups' => [],
                'categories' => collect(),
                'query' => $query,
                'specialOffers' => getCustomerSpecialOffers()
            ]);
        }

        // Build all combinations from full length down to 1
        $allCombinations = [];
        $totalTerms = count($searchTerms);

        for ($len = $totalTerms; $len >= 1; $len--) {
            $combos = $this->getCombinations($searchTerms, $len);
            foreach ($combos as $combo) {
                $allCombinations[] = $combo;
            }
        }

        $seenProductIds = [];
        $productGroups = [];

        foreach ($allCombinations as $combo) {
            $booleanQuery = implode(' ', array_map(fn($t) => '+' . $t . '*', $combo));

            $productsQuery = Product::leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
            ->with([
                'images' => fn($q) => $q->orderBy('sort_order'),
                'category',
                'ProductAttributesValues' => function ($q) {
                    $q->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->with(['attributeValue:id,slug'])
                    ->orderBy('id');
                }
            ])
            ->where(function ($q) use ($combo) {
                foreach ($combo as $term) {
                    $q->where('title', 'like', '%' . $term . '%');
                }
            })
            ->whereNotIn('products.id', $seenProductIds)
            ->whereHas('images');

            if ($category) {
                $categoryIds = explode(',', $category);
                $productsQuery->whereIn('category_id', $categoryIds);
            }

            $products = $productsQuery->get();

            if ($products->isNotEmpty()) {
                // Build group heading
                if (count($combo) === $totalTerms && $totalTerms > 1) {
                    $heading = 'Best Match: "' . implode(' ', $combo) . '"';
                } elseif (count($combo) === 1) {
                    $heading = 'Results for "' . $combo[0] . '"';
                } else {
                    $heading = 'Results for "' . implode(' ', $combo) . '"';
                }

                $productGroups[] = [
                    'heading' => $heading,
                    'products' => $products,
                ];

                $seenProductIds = array_merge($seenProductIds, $products->pluck('id')->toArray());
            }
        }

        $categories = Category::whereHas('products', function ($q) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $q->orWhere('title', 'like', '%' . $term . '%');
            }
        })->orderBy('created_at', 'desc')->get();

        DB::disconnect();

        return view('frontend.pages.search-catalog', [
            'productGroups' => $productGroups,
            'categories' => $categories,
            'query' => $query,
            'specialOffers' => getCustomerSpecialOffers()
        ]);
    }

    private function getCombinations(array $terms, int $length): array
    {
        if ($length === 1) {
            return array_map(fn($t) => [$t], $terms);
        }
        $combos = [];
        $count = count($terms);
        for ($i = 0; $i <= $count - $length; $i++) {
            $rest = $this->getCombinations(array_slice($terms, $i + 1), $length - 1);
            foreach ($rest as $combo) {
                $combos[] = array_merge([$terms[$i]], $combo);
            }
        }
        return $combos;
    }    
}
