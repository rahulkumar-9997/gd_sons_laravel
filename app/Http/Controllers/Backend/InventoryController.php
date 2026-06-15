<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\VendorPurchaseLine;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exports\InventoryExport;
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ShippingRates;
class InventoryController extends Controller
{
    public function index(Request $request){       
        $data['categories'] = Category::all(); 
        $query = Product::with(['images', 'category', 'brand', 'inventories']);
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
       
        if ($request->has('search') && $request->search) {
            $searchTerms = explode(' ', $request->search); 
            $booleanQuery = '+' . implode(' +', $searchTerms);
        
            $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            $query->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            });
        }
        if ($request->has('product_status') && is_numeric($request->product_status)) {
            $query->where('product_status', $request->product_status);
        }
        $data['product_list'] = $query->orderBy('id', 'desc')->paginate(50);
        /*Check inventories and count how many rows in vendor_purchase_lines reference each inventory*/
        $data['product_list']->getCollection()->each(function ($product) {
            $product->inventories->each(function ($inventory) {
                $inventory->purchase_line_count = VendorPurchaseLine::where('inventory_id', $inventory->id)->count();
                $inventory->is_in_vendor_purchase = $inventory->purchase_line_count > 0;
            });
        });
        Log::info('Request Data:', $request->all());
        if ($request->ajax()) {
            return view('backend.manage-inventory.partials.product_inventory_table', compact('data'))->render();
        }
        //return response()->json($data['product_list']); 
        return view('backend.manage-inventory.index', compact('data'));  
    }

    public function create(Request $request){
        $token = $request->input('_token');
        $size = $request->input('size');
        $url = $request->input('url');
        $product_id = $request->input('product_id');
        $product_row = Product::with('inventories')->findOrFail($product_id);
        $shipping_rates = ShippingRates::first();
        $uniqueSku = 'SKU-' . strtoupper(uniqid());
        $form = '
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="mb-2 text-primary">' . $product_row->title . '</h5>
                    <div id="error-container"></div>
                </div>
            </div>            
            <form method="POST" action="' . route('manage-inventory.store') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="inventoryAddForm">
                ' . csrf_field() . '
                <input type="hidden" name="product_id" value="' . $product_id . '">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <div class="mb-3 w-100">
                            <label for="simpleinput" class="form-label">GST in %</label>
                            <input type="text" name="gst_in_per" class="form-control" value="'.$product_row->gst_in_per.'">
                        </div>
                    </div>
                    <div class="col-lg-6">';
                        if($product_row->length && $product_row->breadth && $product_row->height && $product_row->weight){
                            $form .= '
                            <div class="product_volumetric">
                                <h4>
                                Volumetric Weight
                                </H4>
                            </div>
                            <div class="mt-1">
                                <span class="badge bg-light text-dark">L: '.number_format($product_row->length, 1).' cm</span>
                                <span class="badge bg-light text-dark">B: '.number_format($product_row->breadth, 1).' cm</span>
                                <span class="badge bg-light text-dark">H: '.number_format($product_row->height, 1).' cm</span>
                                <span class="badge bg-light text-dark">W: '.number_format($product_row->weight, 1).' kg</span>
                                <span class="badge bg-purple text-white">
                                    VW: '.number_format($product_row->volumetric_weight_kg, 2) .' kg
                                </span>
                            </div>';
                        }
                    $form .= '
                    </div>
                </div>
                <div class="table-responsive" style="overflow-x: auto;">
                    <div style="
                    max-height: 400px;
                    overflow-y: auto;
                    overflow-x: auto;
                    ">
                        <table class="table table-borderless table-centered" id="dynamic-fields-table">
                            <thead>
                                <tr>
                                    <th style="min-width: 150px;">MRP</th>
                                    <th style="min-width: 150px;">Purchase Rate</th>
                                    <th style="min-width: 150px;">Offer Rate</th>
                                    <th style="min-width: 150px;">Shipping Charge</th>
                                    <th style="min-width: 150px;">Stock Quantity</th>
                                    <th style="min-width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                                if (!$product_row->inventories->isEmpty()) {
                                    foreach ($product_row->inventories as $inventory) {
                                        $form .= '
                                        <input type="hidden" name="inventory_id[]" class="form-control" value="' . $inventory->id . '">
                                        
                                        <tr class="field-group">
                                            <td>
                                                <input type="number" name="mrp[]" class="form-control" value="' . $inventory->mrp . '">
                                            </td>
                                            <td>
                                                <input type="number" name="purchase_rate[]" class="form-control" value="' . $inventory->purchase_rate . '">
                                            </td>
                                            <td>
                                                <input type="number" name="offer_rate[]" class="form-control" value="' . $inventory->offer_rate . '">
                                            </td>
                                            <td>
                                                <input type="number" name="shipment_rate[]" class="form-control" value="' . $inventory->shipment_rate . '">
                                            </td>
                                            <td>
                                                <input type="number" name="stock_quantity[]" class="form-control" value="' . $inventory->stock_quantity . '" >
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" name="sku[]" class="form-control" value="' . $inventory->sku . '" readonly>
                                            </td>
                                            <td>
                                                <button type="button"  data-inventoryid="' . $inventory->id . '"  data-name="' . $inventory->sku . '" class="btn btn-danger btn-sm remove-field delete-inventory-btn">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>';
                                    }
                                }else{
                                $form .= '
                                <tr class="field-group">
                                    <td>
                                        <input type="number" name="mrp[]" class="form-control" required="">
                                    </td>
                                    <td>
                                        <input type="number" name="purchase_rate[]" class="form-control" required="">
                                    </td>
                                    <td>
                                        <input type="number" name="offer_rate[]" class="form-control" required="">
                                    </td>
                                    <td>
                                        <input type="number" name="stock_quantity[]" class="form-control" required="">
                                    </td>
                                    <td style="display: none;">
                                        <input type="text" name="sku[]" class="form-control" value="' . $uniqueSku . '" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-field">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>';
                                }
                                $form .= '
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-1">
                    <button type="button" class="btn btn-success btn-sm" id="add-more-fields">Add More</button>
                </div>
                <div class="modal-footer pb-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Inventory Form created successfully',
            'form' => $form,
        ]);

    }

    public function store(Request $request){
        $product_id = $request->input('product_id');
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'mrp' => 'required|array|distinct',
            'mrp.*' => 'required|numeric|min:0',
            'purchase_rate' => 'required|array',
            'purchase_rate.*' => 'required|numeric|min:0',
            'offer_rate' => 'required|array',
            'offer_rate.*' => 'required|numeric|min:0',
            'stock_quantity' => 'required|array',
            'stock_quantity.*' => 'required|integer|min:0',
            'sku' => 'required|array',
            //'sku.*' => 'required|string|unique:inventories,sku',
            'inventory_id' => 'array',
        ]);

        $data = [];
        $inventory_ids = $request->input('inventory_id', []);
        DB::beginTransaction();
        try {
            foreach ($request->input('mrp') as $key => $mrp) {
                $inventoryData = [
                    'product_id' => $product_id,
                    'mrp' => $mrp,
                    'purchase_rate' => $request->input('purchase_rate')[$key],
                    'offer_rate' => $request->input('offer_rate')[$key],
                    'stock_quantity' => $request->input('stock_quantity')[$key],
                    'sku' => $request->input('sku')[$key],
                ];

                if (isset($inventory_ids[$key]) && !empty($inventory_ids[$key])) {
                    Inventory::where('id', $inventory_ids[$key])
                        ->where('product_id', $product_id)
                        ->update($inventoryData);
                } else {
                    $data[] = $inventoryData;
                }
            }

            if (!empty($data)) {
                Inventory::insert($data);
            }
            DB::commit();
            return response()->json([
                'message' => 'Inventory records saved or updated successfully!',
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() === '23000') {
                return response()->json([
                    'message' => 'One or more MRP values already exist for this product. Please check your input.',
                ], 422);
            }
            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }    
    
    public function update(Request $request, $id){
        $request->validate([
            'mrp' => 'required|numeric',
            'purchase_rate' => 'required|numeric',
            'offer_rate' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);
        $inventory = Inventory::findOrFail($id);
        /*Check if the MRP already exists for the same product_id*/
        $existingInventory = Inventory::where('product_id', $inventory->product_id)
        ->where('mrp', $request->mrp)
        ->where('purchase_rate', $request->purchase_rate)
        ->first();

        /*If the same MRP already exists for this product, don't update the MRP*/
        if ($existingInventory && $existingInventory->id === $inventory->id) {
            $inventory->purchase_rate = $request->purchase_rate;
            $inventory->offer_rate = $request->offer_rate;
            $inventory->stock_quantity = $request->stock_quantity;
            try {
                $inventory->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Inventory updated successfully! MRP not updated as it is the same for this product.',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while saving the inventory.',
                ], 500);
            }
        } else {
            $inventory->mrp = $request->mrp;
            $inventory->purchase_rate = $request->purchase_rate;
            $inventory->offer_rate = $request->offer_rate;
            $inventory->stock_quantity = $request->stock_quantity;
            try {
                $inventory->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Inventory updated successfully!',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while saving the inventory.',
                ], 500);
            }
        }
    }

    public function destroy($id){
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();
            return response()->json([
                'success' => true,
                'message' => 'Inventory deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while deleting the inventory. Please try again.', 
            ], 500);
        }
    }

    public function exportInventory(){
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }

    public function importInventory(){
        return view('backend.manage-inventory.import-inventory.import'); 
    }

    public function inventoryImportForm(Request $request){
        // Validate the uploaded file
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'import_file.required' => 'Please upload a file.',
            'import_file.file' => 'The uploaded input must be a valid file.',
            'import_file.mimes' => 'The file must be in .xlsx, .xls, or .csv format.',
            'import_file.max' => 'The file size must not exceed 2MB.',
        ]);
        try {
            Excel::import(new InventoryImport, $request->file('import_file'));
            return redirect('manage-inventory')->with('success','Inventory imported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
                Log::error('Import Validation Error:', [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values(),
                ]);
            }
            return back()->withErrors($errors)->with('error', 'Some rows failed validation. Please check the details.');
        } catch (\Exception $e) {
            Log::error('Import General Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()->with('error', 'An error occurred while importing: ' . $e->getMessage());
        }
    }

    public function updateInventoryShipmentRate(Request $request, $id)
    {
        try {
            $product = Product::find($id);    
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
                ], 404);
            }
            
            if (!$product->length || !$product->breadth || !$product->height) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product dimensions (length, breadth, height) missing.',
                ], 422);
            }
            
            if ($product->length <= 0 || $product->breadth <= 0 || $product->height <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product dimensions must be greater than 0.',
                ], 422);
            }            
            
            $inventory = Inventory::where('product_id', $product->id)->first();
            
            if (!$inventory) {
                return response()->json([
                    'success' => false,
                    'message' => 'No inventory found for this product.',
                ], 404);
            }
            
            /* Calculate volumetric weight */
            $volumetricWeight = round(
                ($product->length * $product->breadth * $product->height) / 5000,
                2
            );
            Log::info('Updated volumetric weight', [
                'volumetric_weight' => $volumetricWeight
            ]);
            /* Update product with volumetric weight */
            $product->volumetric_weight_kg = $volumetricWeight;
            $product->save();
            
            /* Find weight category*/
            $weightCategory = $this->findWeightCategory($volumetricWeight);            
            
            if (!$weightCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'No weight category found for this product weight.',
                ], 422);
            }
            
            /* Calculate uniform shipping rate */
            $uniformRate = $this->calculateUniformShippingRate($weightCategory->id);
            
            if ($uniformRate <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to calculate shipping rate. No pincode rates found.',
                ], 422);
            }
            
            /* Update inventory with uniform rate */
            $inventory->shipment_rate = $uniformRate;
            $inventory->save();            
            
            return response()->json([
                'success'              => true,
                'message'              => 'Uniform shipping rate calculated successfully!',
                'volumetric_weight_kg' => $volumetricWeight,  // ← ADD THIS for AJAX compatibility
                'shipment_rate'        => $uniformRate,       // ← ADD THIS for AJAX compatibility
                'data' => [
                    'product_id' => $product->id,
                    'inventory_id' => $inventory->id,
                    'dimensions' => [
                        'length' => $product->length,
                        'breadth' => $product->breadth,
                        'height' => $product->height,
                    ],
                    'volumetric_weight_kg' => $volumetricWeight,
                    'weight_category' => [
                        'id' => $weightCategory->id,
                        'min_weight' => $weightCategory->min_weight,
                        'max_weight' => $weightCategory->max_weight,
                    ],
                    'uniform_shipment_rate' => $uniformRate,
                    'note' => 'This rate is same for all customers (local & distant)'
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('updateInventoryShipmentRate error: ' . $e->getMessage(), [
                'product_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Find weight category based on weight
     */
    private function findWeightCategory(float $weight)
    {
        return \App\Models\WeightCategory::where('min_weight', '<=', $weight)
            ->where(function($query) use ($weight) {
                $query->where('max_weight', '>=', $weight)
                    ->orWhereNull('max_weight');
            })
            ->first();
    }

    /**
     * Calculate uniform shipping rate (same for all customers)
     * Formula: Weighted average of all pincode rates + 15% margin
     */
    private function calculateUniformShippingRate(int $weightCategoryId): float
    {
        /* Get all shipping rates for this weight category */
        $allRates = \App\Models\PincodeShippingRate::where('weight_category_id', $weightCategoryId)
            ->pluck('shipping_rate')
            ->toArray();
        
        if (empty($allRates)) {
            return 0;
        }
        
        /* Simple Average (easy and works well) */
        $averageRate = array_sum($allRates) / count($allRates);
        
        // Method 2: Weighted by distance (more accurate)
        // $weightedAverage = $this->calculateWeightedAverageByDistance($weightCategoryId);
        
        /* Add 15% profit margin */
        $rateWithMargin = $averageRate * 1.15;
        
        /* Round up to nearest 10 or 50 for nice pricing */
        if ($rateWithMargin <= 100) {
            $finalRate = ceil($rateWithMargin / 10) * 10; 
        } else {
            $finalRate = ceil($rateWithMargin / 50) * 50;
        }
        
        return $finalRate;
    }

    /**
     * Advanced: Weighted average based on distance zones (optional)
     */
    private function calculateWeightedAverageByDistance(int $weightCategoryId): float
    {
        $zoneRates = \Illuminate\Support\Facades\DB::table('pincode_shipping_rates as psr')
            ->join('pincodes as p', 'psr.pincode_id', '=', 'p.id')
            ->join('cities as c', 'p.city_id', '=', 'c.id')
            ->select(
                \Illuminate\Support\Facades\DB::raw('
                    CASE 
                        WHEN c.distance_from_warehouse <= 50 THEN "local"
                        WHEN c.distance_from_warehouse <= 200 THEN "regional"
                        WHEN c.distance_from_warehouse <= 1000 THEN "national"
                        ELSE "far"
                    END as zone
                '),
                \Illuminate\Support\Facades\DB::raw('AVG(psr.shipping_rate) as avg_rate')
            )
            ->where('psr.weight_category_id', $weightCategoryId)
            ->groupBy('zone')
            ->get();
        
        $weights = [
            'local' => 0.20,     // 20% weight - lowest rates
            'regional' => 0.30,  // 30% weight - medium rates
            'national' => 0.35,  // 35% weight - high rates
            'far' => 0.15        // 15% weight - highest rates
        ];
        
        $weightedSum = 0;
        foreach ($zoneRates as $zone) {
            $weight = $weights[$zone->zone] ?? 0.25;
            $weightedSum += $zone->avg_rate * $weight;
        }
        
        return $weightedSum;
    }


}
