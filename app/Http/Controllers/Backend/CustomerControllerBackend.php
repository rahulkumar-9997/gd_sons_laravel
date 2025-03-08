<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Orders;
use App\Imports\CustomerImport;
use App\Models\GroupCategories;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;


class CustomerControllerBackend extends Controller
{
    public function index(Request $request){
        $data['customer_list'] = Customer::orderBy('id', 'desc')->paginate(15);
        $data['category_group'] = GroupCategories::with('groups')->get();
        if ($request->ajax()) {
            return view('backend.manage-customer.partials.customer-list', compact('data'))->render();
        }
        //return response()->json($data['category_group']);
        return view('backend.manage-customer.index', compact('data'));
    }

    public function showCustomerDetails($customer_id){
        $customer = Customer::findOrFail($customer_id);
        $totalOrders = Orders::where('customer_id', $customer_id)->count();
        $orders = Orders::with([
            'orderStatus', 
            'shippingAddress', 
            'billingAddress', 
            'orderLines.product', 
            'orderLines.product.images'
        ])
        ->where('customer_id', $customer_id)
        ->orderBy('id', 'desc')
        ->take(5) 
        ->get();
        //return response()->json($orders);
        return view('backend.manage-customer.customer-details', compact('customer', 'totalOrders', 'orders'));
    }

    public function showCustomerOrdersList($customer_id){
        $customer = Customer::findOrFail($customer_id);
        //$totalOrders = Orders::where('customer_id', $customer_id)->count();
        $orders = Orders::with([
            'orderStatus', 
            'shippingAddress', 
            'billingAddress', 
            'orderLines.product', 
            'orderLines.product.images'
        ])
        ->where('customer_id', $customer_id)
        ->orderBy('id', 'desc')
        ->get();
        //return response()->json($orders);
        return view('backend.manage-customer.customer-order-list', compact('customer', 'orders'));
    }
    
    public function importForm(){
        return view('backend.manage-customer.import-customer');
    }

    public function importFormSubmit(Request $request){
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'import_file.required' => 'Please upload a file.',
            'import_file.mimes' => 'The file must be in .xlsx, .xls, or .csv format.',
            'import_file.max' => 'The file size must not exceed 2MB.',
        ]);

        try {
            Excel::import(new CustomerImport, $request->file('import_file'));
            return back()->with('success', 'Customers imported successfully.');
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

    public function updateCustomerGroup(Request $request){
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'group_category_id' => 'nullable|exists:groups_categories,id',
            ]);

            $customer = Customer::findOrFail($validated['customer_id']);
            $customer->group_category_id = $validated['group_category_id'];
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Group updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update group. ' . $e->getMessage(),
            ]);
        }
    }

    public function customerDelete($id){
        $customer_row = Customer::find($id);
        $customer_row->delete();
        return redirect('manage-customer')->with('success','Customer deleted successfully');
    }

    public function addNewCustomerModalForm(Request $request){
        $url = $request->input('url'); 
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-customer.add.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addNewCustomer">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label"> Name *</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label"> Email *</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label"> Phone Number *</label>
                            <input type="text" maxlenght="10" id="phone_number" name="phone_number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Customer Form created successfully',
            'form' => $form,
        ]);
    }

    public function addNewCustomerModalFormSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'phone_number' => ['required', 'string', 'max:10', 'unique:customers,phone_number'],
        ], $this->customValidationMessages());
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number', null),
            'customer_id' => $this->generateUniqueUserId($request->input('email')),
            'password' => Hash::make($this->generateRandomPassword()),
        ];
        $customer = Customer::create($data);
        return response()->json([
            'message' => 'Customer added successfully!',
            'status' => 'success',
        ]);
    }

    public function customValidationMessages(){
        return [
            'name.required' => 'The customer name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'The email :input is already taken.',
            'phone_number.string' => 'The phone number must be a valid string.',
            'phone_number.max' => 'The phone number must not exceed 10 characters.',
            'phone_number.unique' => 'The Phone Number :input is already taken.',
        ];
    }

    private function generateUniqueUserId($email){
        $userId = strtoupper(Str::random(6)) . substr($email, 0, 4);
        do {
            $userId = strtoupper(Str::random(6)) . substr($email, 0, 4);
        } while (Customer::where('customer_id', $userId)->exists());

        return $userId;
    }

    private function generateRandomPassword(){
        return Str::random(8);
    }

    public function showCustomerWishlist($id){
        $customerId = $id;
        $customer = Customer::findOrFail($customerId);
        $wishlist = Wishlist::with([
            'product' => function ($query) {
                $query->with([
                    'inventories' => function ($query) {
                        $query->orderBy('mrp', 'asc')->take(1);
                    },
                    'ProductImagesFront:id,product_id,image_path',
                    'ProductAttributesValues' => function ($query) {
                        $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                            ->with([
                                'attributeValue:id,slug'
                            ])
                            ->orderBy('id');
                    }
                ]);
            },
            'product.images',
            'product.inventories',
        ])->where('customer_id', $customerId)->get();
        
        return view('backend.manage-customer.wishlist.index', compact('customer', 'wishlist'));
    }

    public function editCustomerForm($id){
        $customer = Customer::where('id', $id)->orderBy('id', 'desc')->firstOrFail();
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-customer.update', $id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="updateCustomer">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label"> Name *</label>
                            <input type="text" id="name" name="name" class="form-control" value="'.$customer->name.'">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label"> Email *</label>
                            <input type="email" id="email" name="email" class="form-control" value="'.$customer->email.'">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label"> Phone Number *</label>
                            <input type="text" maxlenght="10" id="phone_number" name="phone_number" class="form-control" value="'.$customer->phone_number.'">
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Customer Form created successfully',
            'form' => $form,
        ]);
    }

    public function editCustomerFormSubmit(Request $request, $id){
        $customer = Customer::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $id,
            'phone_number' => 'nullable|string|max:10|unique:customers,phone_number,' . $id,
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Customer updated successfully',
        ]);
    }
}
