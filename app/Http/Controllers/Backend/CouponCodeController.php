<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class CouponCodeController extends Controller
{
    public function index()
    {
        $coupons = DiscountCode::latest()->paginate(20);
        return view('backend.manage-coupon.index', compact('coupons'));
    }

    public function create(Request $request)
    {
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $coupon_code = $request->input('coupon_code');
        $form ='
        <div class="modal-body">
            <form action="'.route('manage-coupon.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addCouponForm" method="POST">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Code</label>
                        <input type="text" name="discount_code" id="discount_code" value="'.$coupon_code.'" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mode</label>
                        <select name="mode" class="form-select" id="mode">
                            <option value="">Select</option>
                            <option value="Amount">Amount</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value</label>
                        <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Order Value</label>
                        <input type="number" step="0.01" name="minimum_order_value" id="minimum_order_value" class="form-control" value="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Maximum Discount</label>
                        <input type="number" step="0.01" name="maximum_discount" id="maximum_discount" class="form-control" value="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="1" placeholder="0 = Unlimited">
                        <small class="text-muted">Total times this coupon can be used</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid From</label>
                        <input type="text" name="valid_from" id="valid_from" class="form-control flatpickr-date">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid Till</label>
                        <input type="text" name="valid_till" id="valid_till" class="form-control flatpickr-date">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveCouponBtn">Save Coupon</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        
        return response()->json([
            'message' => 'Form loaded successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount_code'        => 'required|string|max:50|unique:discount_codes,discount_code',
            'mode'                 => 'required|in:Amount,Percentage',
            'discount_value'       => 'required|numeric|min:0.01',
            'minimum_order_value'  => 'nullable|numeric|min:0',
            'maximum_discount'     => 'nullable|numeric|min:0',
            'valid_from'           => 'required|date',
            'valid_till'           => 'required|date|after_or_equal:valid_from',
            'short_description'    => 'nullable|string|max:500',
            'usage_limit'          => 'nullable|integer|min:1',
            'is_active'            => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $coupon = DiscountCode::create([
                'discount_code'       => $request->discount_code,
                'mode'                => $request->mode,
                'discount_value'      => $request->discount_value,
                'minimum_order_value' => $request->minimum_order_value ?? 0,
                'maximum_discount'    => $request->maximum_discount ?? 0,
                'valid_from'          => $request->valid_from,
                'valid_till'          => $request->valid_till,
                'short_description'   => $request->short_description,
                'usage_limit'         => $request->usage_limit ?? 1,
                'is_active'           => $request->has('is_active') ? 1 : 0,
            ]);
            DB::commit();
            if($coupon){
                $coupons = DiscountCode::latest()->paginate(20);
                return response()->json([
                    'message' => 'Coupon created successfully',
                    'status' => 'success',
                    'couponContent' => view('backend.manage-coupon.partials.coupon-list', compact('coupons'))->render(),
                ]);
            }else{
                return response()->json([
                    'message' => 'Somthings wents wrongs',
                    'status' => 'fail',
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $coupons_row = DiscountCode::findOrFail($id);
        $form = '
        <div class="modal-body">
            <form action="'.route('manage-coupon.update', $coupons_row->id).'" 
                accept-charset="UTF-8" 
                enctype="multipart/form-data" 
                id="updateCouponForm" 
                method="POST">
                '.csrf_field().'
                '.method_field('PUT').'
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Code</label>
                        <input type="text" name="discount_code" id="discount_code" value="'.e($coupons_row->discount_code).'" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mode</label>
                        <select name="mode" class="form-select" id="mode">
                            <option value="">Select</option>
                            <option value="Amount" '.($coupons_row->mode=='Amount'?'selected':'').'>Amount</option>
                            <option value="Percentage" '.($coupons_row->mode=='Percentage'?'selected':'').'>Percentage</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value</label>
                        <input type="number" step="0.01" name="discount_value" id="discount_value"
                            value="'.$coupons_row->discount_value.'" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Order Value</label>
                        <input type="number" step="0.01" name="minimum_order_value" id="minimum_order_value" value="'.$coupons_row->minimum_order_value.'"
                        class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Maximum Discount</label>
                        <input type="number" step="0.01" name="maximum_discount" id="maximum_discount"
                            value="'.$coupons_row->maximum_discount.'" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="'.$coupons_row->usage_limit.'" placeholder="0 = Unlimited">
                        <small class="text-muted">Total times this coupon can be used</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid From</label>
                        <input type="text" name="valid_from" id="valid_from" value="'.optional($coupons_row->valid_from)->format('Y-m-d').'" class="form-control flatpickr-date">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Valid Till</label>
                        <input type="text" name="valid_till" id="valid_till" value="'.optional($coupons_row->valid_till)->format('Y-m-d').'" class="form-control flatpickr-date">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="2">'.e($coupons_row->short_description).'</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                '.($coupons_row->is_active ? 'checked' : '').'>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateCouponBtn">Update Coupon</button>
                    </div>
                </div>
            </form>
        </div>
        ';

        return response()->json([
            'message' => 'Form loaded successfully',
            'form' => $form,
        ]);
    }

    public function update(Request $request, $id)
    {
        $coupon = DiscountCode::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'discount_code'        => 'required|string|max:50|unique:discount_codes,discount_code,' . $coupon->id,
            'mode'                 => 'required|in:Amount,Percentage',
            'discount_value'       => 'required|numeric|min:0.01',
            'minimum_order_value'  => 'nullable|numeric|min:0',
            'maximum_discount'     => 'nullable|numeric|min:0',
            'valid_from'           => 'required|date',
            'valid_till'           => 'required|date|after_or_equal:valid_from',
            'short_description'    => 'nullable|string|max:500',
            'usage_limit'          => 'nullable|integer|min:1',
            'is_active'            => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $updated = $coupon->update([
                'discount_code'       => $request->discount_code,
                'mode'                => $request->mode,
                'discount_value'      => $request->discount_value,
                'minimum_order_value' => $request->minimum_order_value ?? 0,
                'maximum_discount'    => $request->maximum_discount ?? 0,
                'valid_from'          => $request->valid_from,
                'valid_till'          => $request->valid_till,
                'short_description'   => $request->short_description,
                'usage_limit'         => $request->usage_limit ?? 1,
                'is_active'           => $request->has('is_active') ? 1 : 0,
            ]);
            DB::commit();
            if ($updated) {
                $coupons = DiscountCode::latest()->paginate(20);
                return response()->json([
                    'message'       => 'Coupon updated successfully',
                    'status'        => 'success',
                    'couponContent' => view('backend.manage-coupon.partials.coupon-list', compact('coupons'))->render(),
                ]);
            } else {
                return response()->json([
                    'message' => 'Somthings wents wrongs',
                    'status'  => 'fail',
                ]);
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $coupon = DiscountCode::findOrFail($id);
            $coupon->delete();
            DB::commit();
            return redirect()
                ->route('manage-coupon.index')
                ->with('success', 'Coupon deleted successfully');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('manage-coupon.index')
                ->with('error', 'Something went wrong while deleting coupon');
        }
    }

}
