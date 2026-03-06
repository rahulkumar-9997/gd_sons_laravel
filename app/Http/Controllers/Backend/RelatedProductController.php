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
            ->groupBy('variant_id')
            ->orderByDesc('variant_id')
            ->paginate(20);

        $groups = RelatedProduct::with(['product:id,title,slug'])
            ->whereIn('variant_id', $variants->pluck('variant_id'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('variant_id');

        return view('backend.product.related-product.index', compact('groups', 'variants'));
    }
    public function create(Request $request){ 
        return view('backend.product.related-product.create');
               
    }

    public function store(Request $request)
    {
        $request->validate([
            'relation_type' => 'required|string',
            'group_title' => 'required|string|max:255',
            'product_id'    => 'required|array',
            'product_id.*'  => 'sometimes|exists:products,id',
            'related_title' => 'required|array',
            'related_title.*' => 'required|string|max:255',
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
                    'relation_type' => $request->relation_type,
                    'variant_id' => $variantId,
                    'group_title' => $request->group_title,
                    'product_id' => $mainProductId,                   
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

    public function edit($variantId)
    {
        $relatedProducts = RelatedProduct::with('product')
        ->where('variant_id', $variantId)
        ->get();
        
        if ($relatedProducts->isEmpty()) {
            return redirect()->route('manage-related-product.index')
                ->with('error', 'Related products not found.');
        }
        
        $relationType = $relatedProducts->first()->relation_type;
        //return response()->json($relatedProducts);
        return view('backend.product.related-product.edit', compact('relatedProducts', 'relationType', 'variantId'));
    }

    public function update(Request $request, $variantId)
    {
        $request->validate([
            'relation_type'       => 'required|string',
            'group_title' => 'required|string|max:255',
            'product_id'          => 'required|array',
            'product_id.*'        => 'required|exists:products,id',
            'related_product_id'  => 'required|array',
            'related_product_id.*'=> 'nullable|exists:related_products,id',
            'related_title'       => 'required|array',
            'related_title.*'     => 'required|string|max:255',
        ]);
        DB::beginTransaction();        
        try {
            $productIds = collect($request->product_id)
                ->filter(fn ($v) => !is_null($v) && $v !== '')
                ->values()
                ->toArray();            
            
            if (count($productIds) < 2) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please select at least 2 valid products.'
                ], 422);
            }            
            $titles = $request->related_title ?? [];
            $descriptions = $request->related_description ?? [];
            $relatedProductIds = $request->related_product_id ?? [];
            $existingRecords = RelatedProduct::where('variant_id', $variantId)->get();
            $existingIds = $existingRecords->pluck('id')->toArray();
            $processedIds = [];
            $savedCount = 0;
            foreach ($productIds as $i => $mainProductId) {
                if (isset($relatedProductIds[$i]) && !empty($relatedProductIds[$i])) {
                    $relatedProduct = RelatedProduct::find($relatedProductIds[$i]);
                    if ($relatedProduct) {
                        $relatedProduct->update([
                            'product_id' => $mainProductId,
                            'relation_type' => $request->relation_type,
                            'group_title' => $request->group_title,
                            'title' => $titles[$i] ?? null,
                            'description' => $descriptions[$i] ?? null,
                        ]);
                        $processedIds[] = $relatedProduct->id;
                        $savedCount++;
                    }
                } else {
                    $newRelatedProduct = RelatedProduct::create([
                        'variant_id' => $variantId,
                        'relation_type' => $request->relation_type,
                        'group_title' => $request->group_title,                        
                        'product_id' => $mainProductId,
                        'title' => $titles[$i] ?? null,
                        'description' => $descriptions[$i] ?? null,
                    ]);
                    $processedIds[] = $newRelatedProduct->id;
                    $savedCount++;
                }
            }
            $recordsToDelete = array_diff($existingIds, $processedIds);
            if (!empty($recordsToDelete)) {
                RelatedProduct::whereIn('id', $recordsToDelete)->delete();
            }            
            DB::commit(); 
            return response()->json([
                'status'  => 'success',
                'message' => "{$savedCount} related products updated successfully.",
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

    public function destroy($variantId)
    {
        DB::beginTransaction();        
        try {
            $relatedProducts = RelatedProduct::where('variant_id', $variantId)->get();            
            if ($relatedProducts->isEmpty()) {
                if (request()->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Related products not found.'
                    ], 404);
                }
                return redirect()->route('manage-related-product.index')
                    ->with('error', 'Related products not found.');
            }
            $deletedCount = RelatedProduct::where('variant_id', $variantId)->delete();
            DB::commit();                      
            return redirect()->route('manage-related-product.index')
                ->with('success', "{$deletedCount} related products deleted successfully.");
                
        } catch (\Throwable $e) {
            DB::rollBack(); 
            return redirect()->route('manage-related-product.index')
                ->with('error', 'Error deleting related products: ' . $e->getMessage());
        }
    }
}
