<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BulkFeaturedProduct;
use App\Models\Product;

class BulkFeaturedProductController extends Controller
{
    public function index()
    {
        $bulkFeaturedProducts = BulkFeaturedProduct::with('product')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('backend.bulk.bulk-feature.index', compact('bulkFeaturedProducts'));
    }
    
    public function create()
    {
        return view('backend.bulk.bulk-feature.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'bulk_rate'  => 'required|numeric|min:0',
            'min_qty'    => 'required|integer|min:1',
            'sort_order' => 'nullable|integer',
            'status'     => 'nullable|boolean',
        ]);

        BulkFeaturedProduct::create([
            'product_id' => $validated['product_id'],
            'bulk_rate'  => $validated['bulk_rate'],
            'min_qty'    => $validated['min_qty'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => $request->boolean('status', true),
        ]);

        return redirect()->route('bulk-featured-products.index')->with('success', 'Bulk featured product added successfully.');
    }

    public function edit(BulkFeaturedProduct $bulkFeaturedProduct)
    {
        $bulkFeaturedProduct->load('product');
        return view('backend.bulk.bulk-feature.edit', compact('bulkFeaturedProduct'));
    }
   
    public function update(Request $request, BulkFeaturedProduct $bulkFeaturedProduct)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'bulk_rate'  => 'required|numeric|min:0',
            'min_qty'    => 'required|integer|min:1',
            'sort_order' => 'nullable|integer',
            'status'     => 'nullable|boolean',
        ]);
        $bulkFeaturedProduct->update([
            'product_id' => $validated['product_id'],
            'bulk_rate'  => $validated['bulk_rate'],
            'min_qty'    => $validated['min_qty'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => $request->boolean('status', true),
        ]);
        return redirect()->route('bulk-featured-products.index')->with('success', 'Bulk featured product updated successfully.');
    }
    
    public function destroy(BulkFeaturedProduct $bulkFeaturedProduct)
    {
        $bulkFeaturedProduct->delete();
        return redirect()->route('bulk-featured-products.index')->with('success', 'Bulk featured product deleted successfully.');
    }
    
    public function productAutocomplete(Request $request)
    {
        $term = $request->get('term');
        $products = Product::select('id', 'title')
            ->where('title', 'like', '%' . $term . '%')
            ->orderBy('title')
            ->limit(15)
            ->get()
            ->map(function ($product) {
                return [
                    'id'    => $product->id,
                    'label' => $product->title,
                    'value' => $product->title,
                ];
            });

        return response()->json($products);
    }
}