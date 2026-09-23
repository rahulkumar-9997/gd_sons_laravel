<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supply;
use App\Models\Product;

class SupplyController extends Controller
{
    public function index(){
        $supplies = Supply::withCount('products')->orderBy('sort_order')->latest()->paginate(15); 
        return view('backend.bulk.bulk-supply.index', compact('supplies')); 
    }

    public function create()
    {
        return view('backend.bulk.bulk-supply.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'buyer'        => 'nullable|string|max:255',
            'place'        => 'nullable|string|max:255',
            'status'       => 'nullable|boolean',
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'qty'          => 'required|array',
            'qty.*'        => 'nullable|integer|min:1',
            'unit'         => 'nullable|array',
            'unit.*'       => 'nullable|string|max:50',
        ]);
 
        $supply = Supply::create([
            'title'      => $validated['title'],
            'buyer'      => $validated['buyer'] ?? null,
            'place'      => $validated['place'] ?? null,
            'status'     => $request->boolean('status', true),
        ]); 
        $this->syncProducts($supply, $request); 
        return redirect()->route('supplies.index')->with('success', 'Supply created successfully.');
    } 
    
    public function edit(Supply $supply)
    {
        $supply->load('products'); 
        return view('backend.bulk.bulk-supply.edit', compact('supply'));
    }

    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'buyer'        => 'nullable|string|max:255',
            'place'        => 'nullable|string|max:255',
            'status'       => 'nullable|boolean',
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'qty'          => 'required|array',
            'qty.*'        => 'nullable|integer|min:1',
            'unit'         => 'nullable|array',
            'unit.*'       => 'nullable|string|max:50',
        ]); 
        $supply->update([
            'title'      => $validated['title'],
            'buyer'      => $validated['buyer'] ?? null,
            'place'      => $validated['place'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => $request->boolean('status', true),
        ]); 
        $this->syncProducts($supply, $request); 
        return redirect()->route('supplies.index')->with('success', 'Supply updated successfully.');
    }

    public function destroy(Supply $supply)
    {
        $supply->products()->detach();
        $supply->delete();
 
        return redirect()
            ->route('supplies.index')
            ->with('success', 'Supply deleted successfully.');
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
 
    private function syncProducts(Supply $supply, Request $request): void
    {
        $productIds = $request->input('product_id', []);
        $qtys       = $request->input('qty', []);
        $units      = $request->input('unit', []); 
        $syncData = []; 
        foreach ($productIds as $index => $productId) {
            if (empty($productId)) {
                continue;
            } 
            $syncData[$productId] = [
                'qty'        => $qtys[$index] ?? 1,
                'unit'       => $units[$index] ?? null,
                'sort_order' => $index,
            ];
        }
 
        $supply->products()->sync($syncData);
    }
}

