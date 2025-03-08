<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\VendorPurchaseBill;
use App\Models\VendorPurchaseLine;
use App\Models\Inventory;
use App\Models\Vendors;
use App\Models\UpdateHsnGstWithAttributes;
use App\Models\Attribute;

use Carbon\Carbon;


class ItemController extends Controller
{
    public function index(Request $request){
        $query = VendorPurchaseBill::with(['vendor', 'purchaseLines.product'])->orderBy('id', 'desc');
        if ($request->has('vendor_id') && $request->vendor_id != '') {
            $query->where('vendor_id', $request->vendor_id);
        }
        if ($request->has('bill_daterange') && $request->bill_daterange != '') {
            [$startDate, $endDate] = explode(' - ', $request->bill_daterange);
            $query->whereBetween('bill_date', [$startDate, $endDate]);
        }
        $vendor_purchase_bills = $query->paginate(20)->through(function ($bill) {
            $bill->formatted_bill_date = Carbon::parse($bill->bill_date)->format('d-m-Y');
            return $bill;
        });

        $data['vendor_list'] = Vendors::orderBy('id', 'DESC')->get();
        if ($request->ajax()) {
            $html = view('backend.manage-purchase.manage-item.partials.vendor_purchase_list_table', compact('vendor_purchase_bills'))->render();
            return response()->json(['html' => $html]);
        }
        return view('backend.manage-purchase.manage-item.index', compact('vendor_purchase_bills', 'data'));
    }

    public function create(Request $request){
        return view('backend.manage-purchase.manage-item.create');
    }

    public function store(Request $request){
        $request->validate([
            'vendor_name' => 'required',
            'bill_date' => 'required|date',
            'product_name' => 'required|array',
            'product_name.*' => 'required|string',
            'mrp' => 'required|array',
            'mrp.*' => 'required|numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric',
            'total_amount' => 'required|array',
            'total_amount.*' => 'required|numeric',
            'purchase_rate' => 'required|array',
            'purchase_rate.*' => 'required|numeric',
            'offer_rate' => 'required|array',
            'offer_rate.*' => 'required|numeric',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
        ]);

        DB::beginTransaction();
        try {
                $vendorBill = VendorPurchaseBill::create([
                    'vendor_id' => $request->vendor_id,
                    'bill_date' => $request->bill_date,
                    'bill_no' => $request->bill_no,
                    'grand_total_amount' => $request->grand_total,
                ]);

                foreach ($request->product_name as $index => $productName) {
                    $productId = $request->product_id[$index];
                    $mrp = $request->mrp[$index];
                    $quantity = $request->quantity[$index];
                    $totalAmount = $request->total_amount[$index];
                    $purchaseRate = $request->purchase_rate[$index];
                    $offerRate = $request->offer_rate[$index];
                    $hsnCode = $request->hsn_code[$index];
                    $gstinPerce = $request->gst_in_per[$index];
                    $inventory = Inventory::where('product_id', $productId)
                        ->where('mrp', $mrp)
                        ->where('purchase_rate', $purchaseRate)
                        ->first();
                    if ($inventory)
                    {
                        $inventory->stock_quantity += $quantity;
                        $inventory->save();
                        $inventoryId = $inventory->id;
                    }
                    else
                    {
                        $inventoryId = null;
                        /*Inventory save*/
                        Inventory::firstOrCreate([
                            'product_id' => $productId,
                            'mrp' => $mrp,
                            'purchase_rate' => $purchaseRate,
                            'offer_rate' => $offerRate,
                            'stock_quantity' => $quantity
                        ]);
                        /*Inventory save*/
                    }
                    VendorPurchaseLine::create([
                        'vendor_purchase_bill_id' => $vendorBill->id,
                        'product_id' => $productId,
                        'inventory_id' => $inventoryId,
                        'mrp' => $mrp,
                        'qty' => $quantity,
                        'total_amount' => $totalAmount,
                        'purchase_rate' => $purchaseRate,
                        'offer_rate' => $offerRate,
                        'hsn_code' => $hsnCode,
                        'gst_dis_percentage' => $gstinPerce,
                    ]);
                }
                DB::commit();
                return redirect()->route('manage-item.index')->with('success', 'Purchase Bill created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withError('Error: ' . $e->getMessage());
        }
    }

    public function deleteMultiplePurchaseItem(Request $request){
        $billIds = $request->input('selected_bills', []);
        if (!empty($billIds)) {
            $bills = VendorPurchaseBill::with('purchaseLines')->whereIn('id', $billIds)->get();
            foreach ($bills as $bill) {
                $bill->purchaseLines()->delete();
                $bill->delete();
            }
            return redirect()->back()->with('success', 'Selected bills and their related purchase lines were deleted successfully.');
        }
        return redirect()->back()->with('error', 'No bills selected for deletion.');
    }

    public function createNewProductModal(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $data['categories'] = Category::all();
        $form = '
        <div class="modal-body">
            <form method="POST" action="' . route('brand.store') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="product-categories" class="form-label">Select Product Categories *</label>
                            <select class="js-example-basic-single" id="product_categories_modal"   name="product_categories" required="required" data-url="'.route('append-product-modal-form-content').'">
                                <option value="">Choose a category</option>';
                                foreach ($data['categories'] as $category) {
                                    $selected = request('category') == $category->id ? 'selected' : '';
                                    $form .= '<option value="' . htmlspecialchars($category->id) . '" ' . $selected . '>' . htmlspecialchars($category->title) . '</option>';
                                }
                                $form .= '
                            </select>
                        </div>
                    </div>
                </div>
                <div id="append-pro-form">
                
                </div>
                <div class="row">
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>';
        return response()->json([
        'message' => 'Product form created successfully',
        'form' => $form,
    ]);

    }
    public function appendProductModalFormContent(Request $request){
        $category_id = $request->input('category_id'); 
        $attributesWithValues = UpdateHsnGstWithAttributes::where('category_id', $category_id)
            ->with(['attribute', 'attribute.AttributesValues', 'attribute.AttributesValues.hsnGst'])
            ->get()
            ->groupBy(function ($item) {
                return $item->attribute->title ?? 'N/A';
            });

        $excludedTitles = $attributesWithValues->keys()->toArray();
        $data['product_attributes_list'] = Attribute::whereNotIn('title', $excludedTitles)
            ->orderBy('title', 'asc')->get();

        $form = '
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-1">
                    <label for="product_name_modal" class="form-label">Product Name *</label>
                    <input type="text" name="product_name_modal" required="required" id="product_name_modal" class="form-control" placeholder="Items Name">
                </div>
            </div>';
            if ($attributesWithValues->isNotEmpty()) {
                $form .= '<div class="card mb-0">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title">Primary Product Attributes <span class="text-danger">(Mandatory)</span></h4>
                            </div>
                            <div class="card-body p-1">
                                <div class="row">';
                foreach ($attributesWithValues as $attributeName => $items) {
                    $form .= '<div class="col-lg-6">
                                <div class="mb-1">
                                    <label for="attribute">' . $attributeName . '</label>
                                    <select class="primary_product_attributes js-example-basic-single" name="primary-product-attributes[]" id="primary_product_attributes" required>
                                        <option selected disabled>Select an option</option>';
                                        $uniqueAttributes = [];
                                        foreach ($items as $item) {
                                            if (!in_array($item->attribute->title, $uniqueAttributes)) {
                                                $form .= '<option value="' . $item->attribute->id . '">' . $item->attribute->title . '</option>';
                                                $uniqueAttributes[] = $item->attribute->title;
                                            }
                                        }

                    $form .= '</select></div></div>';

                    $form .= '<div class="col-lg-6">
                                <div class="mb-1">
                                    <label for="attribute-value">' . $attributeName . ' Values</label>
                                    <select class="primary_product_attributes_value js-example-basic-single" name="primary-product-attributes-value[]" id="primary_product_attributes_value" required>
                                        <option selected>Select Attribute Values</option>';

                    $uniqueValues = [];
                    foreach ($items as $item) {
                        if ($item->attribute->AttributesValues->isNotEmpty()) {
                            foreach ($item->attribute->AttributesValues as $value) {
                                if (!in_array($value->name, $uniqueValues)) {
                                    $form .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                                    $uniqueValues[] = $value->name;
                                }
                            }
                        }
                    }

                    $form .= '</select></div></div>';
                }

                $form .= '</div></div></div>';
            }

            $form .= '
            <div class="card mb-0">
                <div class="card-header d-flex justify-content-between align-items-center gap-1">
                    <h4 class="card-title">Product Attributes <span class="text-danger">(Mandatory)</span></h4>
                    <button class="btn btn-primary add-more-attributes-modal btn-sm" type="button">Add More Product Attributes</button>
                </div>
                <div class="card-body add-more-attributes-append-modal p-1">
                    <div class="row" id="attribute-row-1">
                        <div class="col-lg-6">
                            <div class="mb-1">
                                <select class="product_attributes js-example-basic-single" name="product_attributes[]" id="pro-att-0" required>
                                    <option selected>Select an option</option>';
                                    foreach ($data['product_attributes_list'] as $attributes_list_row) {
                                        $form .= '<option value="' . $attributes_list_row->id . '">' . $attributes_list_row->title . '</option>';
                                    }
                                    $form .= '</select></div></div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-1">
                                                                <input type="text" name="product_attributes_value[0][]" required="required" id="pro-att-value-0" class="form-control" placeholder="Enter attributes value comma separated">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';

        return response()->json([
            'message' => 'Product form created successfully',
            'form' => $form,
        ]);


    }

}
