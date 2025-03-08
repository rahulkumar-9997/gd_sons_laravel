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

class SearchController extends Controller
{
    public function searchSuggestions(Request $request){
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

        return response()->json(['suggestions' => $suggestions]);
    }

    public function searchListProduct_old(Request $request){
        $query = $request->get('query');
        $category = $request->get('category');

        if (!$query) {
           // return redirect('/');
        }

        $searchTerms = explode(' ', $query);
        $booleanQuery = '+' . implode(' +', $searchTerms);

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
            ->with('firstImage');

        if ($category) {
            $categoryIds = explode(',', $category);
            $productsQuery->whereIn('category_id', $categoryIds);
        }

        $products = $productsQuery->paginate(100);

        $categories = Category::whereHas('products', function ($query) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $query->where('title', 'like', '%' . $term . '%');
            }
        })->get();

        return view('frontend.pages.search-catalog', [
            'products' => $products,
            'categories' => $categories,
            'query' => $query
        ]);
    }

    public function searchListProduct(Request $request){
        $query = $request->get('query');
        $category = $request->get('category');

        if (!$query) {
           // return redirect('/');
        }

        $searchTerms = explode(' ', $query);
        $booleanQuery = '+' . implode(' +', $searchTerms);

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
                //'firstImage',
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
        })->get();

        return view('frontend.pages.search-catalog', [
            'products' => $products,
            'categories' => $categories,
            'query' => $query
        ]);
    }
}
