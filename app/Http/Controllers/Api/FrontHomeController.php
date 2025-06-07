<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrimaryCategory;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Attribute_values;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FrontHomeController extends Controller
{
    public function showProductCatalog(Request $request, $categorySlug, $attributeSlug, $valueSlug)
    {
        try {
            $request->validate([
                'filter' => 'sometimes|array',
                'sort' => 'sometimes|string|in:new-arrivals,price-low-to-high,price-high-to-low,a-to-z-order',
                'page' => 'sometimes|integer|min:1'
            ]);

            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $attribute_top = Attribute::where('slug', $attributeSlug)->firstOrFail();
            $attributeValue = Attribute_values::where('slug', $valueSlug)->firstOrFail();
            $productsQuery = Product::where('category_id', $category->id)
                ->where('product_status', 1)
                ->with([
                    'category:id,title,slug',
                    'images' => fn($q) => $q->select('id', 'product_id', 'image_path')->orderBy('sort_order'),
                    'ProductAttributesValues' => fn($q) => $q->with('attributeValue:id,name,slug')
                ]);

            // Apply the top attribute filter
            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });

            // Apply additional filters
            if ($request->has('filter')) {
                foreach ($request->filter as $filterAttributeSlug => $filterValueSlugs) {
                    if ($filterAttributeSlug !== $attribute_top->slug) {
                        $attribute = Attribute::where('slug', $filterAttributeSlug)->first();
                        if (!$attribute) continue;
                        
                        $valueIds = Attribute_values::whereIn('slug', 
                            is_array($filterValueSlugs) ? $filterValueSlugs : explode(',', $filterValueSlugs)
                        )->pluck('id');
                        
                        $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                            $query->where('attributes_id', $attribute->id)
                                ->whereHas('values', function ($q) use ($valueIds) {
                                    $q->whereIn('attributes_value_id', $valueIds);
                                });
                        });
                    }
                }
            }

            // Apply sorting
            switch ($request->get('sort', 'new-arrivals')) {
                case 'price-low-to-high':
                    $productsQuery->orderBy('inventories.mrp', 'asc');
                    break;
                case 'price-high-to-low':
                    $productsQuery->orderBy('inventories.mrp', 'desc');
                    break;
                case 'a-to-z-order':
                    $productsQuery->orderBy('title', 'asc');
                    break;
                default:
                    $productsQuery->orderBy('created_at', 'desc');
            }

            // Get filterable attributes with counts
            $filterAttributes = $category->attributes()
                ->with(['AttributesValues' => function($query) use ($category, $attribute_top, $attributeValue) {
                    $query->whereHas('map_attributes_value_to_categories', fn($q) => $q->where('category_id', $category->id))
                        ->withCount(['productAttributesValues' => function($q) use ($category, $attribute_top, $attributeValue) {
                            $q->whereHas('product', function($q) use ($category, $attribute_top, $attributeValue) {
                                $q->where('category_id', $category->id)
                                    ->whereHas('attributes', fn($query) => $query
                                        ->where('attributes_id', $attribute_top->id)
                                        ->whereHas('values', fn($q) => $q->where('attributes_value_id', $attributeValue->id))
                                );
                            });
                        }])
                        ->having('product_attributes_values_count', '>', 0)
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();

            // Paginate results
            $products = $productsQuery
                ->leftJoin('inventories', function($join) {
                    $join->on('products.id', '=', 'inventories.product_id')
                        ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                })
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate')
                ->paginate($request->get('per_page', 32));

            return response()->json([
                'success' => true,
                'data' => [
                    'category' => $category,
                    'primary_attribute' => $attribute_top,
                    'primary_value' => $attributeValue,
                    'filter_attributes' => $filterAttributes,
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error("Catalog API Error: {$e->getMessage()}");
            return response()->json([
                'success' => false,
                'message' => 'Failed to load catalog',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
