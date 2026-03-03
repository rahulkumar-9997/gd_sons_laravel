<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RelatedProduct;

class RelatedProductController extends Controller
{
    public function index(Request $request)
    {
        $variants = RelatedProduct::select('variant_id')
            ->distinct()
            ->orderBy('variant_id', 'desc')
            ->paginate(20);

        $groups = RelatedProduct::with('product')
            ->whereIn('variant_id', $variants->pluck('variant_id'))
            ->get()
            ->groupBy('variant_id');

        return view('backend.product.related-product.index', compact('groups', 'variants'));
    }

    public function create(Request $request){     
        $products = Product::select('id', 'title', 'product_description', 'product_price', 'product_sale_price')
            ->orderBy('title')
            ->get();   
        return view('backend.product.related-product.create', compact('products'));
               
    }

    public function store(Request $request)
    {
        $request->validate([
            'relation_type' => 'required|string',
            'product_id'    => 'required|array',
            'product_id.*'  => 'sometimes|exists:products,id',
        ]);        
        DB::beginTransaction();
        //logger()->info($request->all());        
        try {
            $productIds = collect($request->product_id)
                ->filter(fn ($v) => !is_null($v) && $v !== '')
                ->values()
                ->toArray();            
            //logger()->info($productIds);            
            if (count($productIds) < 2) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please select at least 2 valid products.'
                ], 422);
            }
            $variantId = time() . '_' . uniqid();            
            // Method 2: Using incrementing number (last variant_id + 1)
            // $lastVariant = RelatedProduct::max('variant_id');
            // $variantId = $lastVariant ? (int)$lastVariant + 1 : 1;
            
            // Method 3: Using UUID
            // $variantId = (string) \Str::uuid();            
            $titles       = $request->related_title ?? [];
            $descriptions = $request->related_description ?? [];            
            $savedCount = 0;            
            foreach ($productIds as $i => $mainProductId) {
                RelatedProduct::create([
                    'variant_id' => $variantId,
                    'product_id' => $mainProductId,
                    'relation_type' => $request->relation_type,
                    'title' => $titles[$i] ?? null,
                    'description' => $descriptions[$i] ?? null,
                ]);
                $savedCount++;
            }            
            DB::commit();            
            return response()->json([
                'status'  => 'success',
                'message' => "{$savedCount} related products saved successfully with Variant ID: {$variantId}",
                'variant_id' => $variantId,
                'redirect_url' => route('manage-related-product.index'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();            
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
