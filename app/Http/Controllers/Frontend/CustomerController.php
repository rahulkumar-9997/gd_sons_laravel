<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;
use App\Models\Address;
use App\Models\Orders;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    public function uploadProfileImg(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $customer = Customer::find($request->input('customer_id'));
        if ($customer) {
            $image = $request->file('image');
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = 'customer-' . $customer->id . '-profile.webp';
            $destinationPath = public_path('images/customer');
            if ($customer->profile_img) {
                $existingImagePath = public_path('images/customer/' . $customer->profile_img);
                if (File::exists($existingImagePath)) {
                    File::delete($existingImagePath);
                }
            }
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90)->save($destinationPath . '/' . $imageName);
            $customer->profile_img = $imageName;
            $customer->save();
            $imagePath = $destinationPath . '/' . $imageName;
            if (File::exists($imagePath)) {
                clearstatcache(true, $imagePath);
            }

            return response()->json([
                'success' => true,
                'imageUrl' => asset('images/customer/' . $imageName . '?v=' . time()),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Customer not found',
        ]);
    }

    public function addToCart(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'product_mrp' => 'required',
        ]);
        $customerId = auth('customer')->id();
        if (!$customerId) {
            return response()->json(['success' => false, 'message' => 'User is not logged in']);
        }
        
        try {
            /*Get the inventory details of the product*/
            $inventory = Inventory::where('product_id', $request->product_id)
                ->where('mrp', $request->product_mrp)
                ->first();
        
            if (!$inventory) {
                return response()->json(['success' => false, 'message' => 'Inventory record not found']);
            }
        
            /*Check stock*/
            if ($inventory->stock_quantity < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'Not enough stock available']);
            }
            $cartItem = Cart::where('customer_id', $customerId)
                ->where('product_id', $request->product_id)
                ->first();
        
            if ($cartItem) {
                /*If the product exists in the cart, check the total quantity*/
                $totalQuantity = $cartItem->quantity + $request->quantity;                
                if ($inventory->stock_quantity < $totalQuantity) {
                    return response()->json(['success' => false, 'message' => 'Not enough stock available for the total quantity']);
                }
                $cartItem->update([
                    'quantity' => $totalQuantity,
                ]);
            } else {
                if ($inventory->stock_quantity < $request->quantity) {
                    return response()->json(['success' => false, 'message' => 'Not enough stock available']);
                }
        
                Cart::create([
                    'customer_id' => $customerId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
        
            $cacheKey = 'customer_cart_' . $customerId;
            $cartItems = Cache::remember($cacheKey, 60, function () use ($customerId) {
                return Cart::with(['product', 'product.inventories', 'product.images'])
                    ->where('customer_id', $customerId)
                    ->get();
            });
            $cartTotal = $cartItems->sum(function ($item) {
                $inventory = $item->product->inventories->sortBy('mrp')->first();
                $offerRate = $inventory ? $inventory->mrp : 0;
                return $item->quantity * $offerRate;
            });
            $cartCount = $cartItems->count();
            $isCartEmpty = $cartCount == 0;
            //$specialOffers = getCustomerSpecialOffers();
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal, 2),
                'cartItems' => view('frontend.pages.partials.cart_items', [
                    'cartItems' => $cartItems,
                    'cartCount' => $cartCount,
                    'isCartEmpty' => $isCartEmpty
                ])->render(),
            ]);
        
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
        
        
    }

    public function cartList(Request $request){
        $customerId = auth('customer')->id();
        $specialOffers = getCustomerSpecialOffers();
        dd($specialOffers);
        if ($request->isMethod('get')) {
            $carts = Cart::where('customer_id', $customerId)
                ->with([
                    'product' => function ($query) {
                        $query->with([
                            'category', 
                            'images',
                            'ProductImagesFront:id,product_id,image_path',
                            'ProductAttributesValues' => function ($query) {
                                $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                                    ->with([
                                        'attributeValue:id,slug'
                                    ])
                                    ->orderBy('id');
                            }
                        ])
                        ->leftJoin('inventories', function ($join) {
                            $join->on('products.id', '=', 'inventories.product_id')
                                ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                        })
                        ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku');
                    }
                ])
                ->get();
            return view('frontend.pages.cart', compact('carts'));
        }
        


        /*Handle POST Request: Update Cart Quantity (AJAX)*/
        if ($request->isMethod('post')) {
            $cartId = $request->input('cart_id');
            $quantity = (int)$request->input('quantity');
            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity. Quantity must be at least 1.'
                ]);
            }

            $cartItem = Cart::where('customer_id', $customerId)->where('id', $cartId)->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                $updatedCarts = Cart::where('customer_id', $customerId)
                    ->with([
                        'product' => function ($query) {
                            $query->with([
                                'category', 
                                'images',
                                'ProductImagesFront:id,product_id,image_path',
                                'ProductAttributesValues' => function ($query) {
                                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                                        ->with([
                                            'attributeValue:id,slug'
                                        ])
                                        ->orderBy('id');
                                }
                            ])
                            ->leftJoin('inventories', function ($join) {
                                $join->on('products.id', '=', 'inventories.product_id')
                                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                            })
                            ->select(
                                'products.*', 
                                'inventories.mrp', 
                                'inventories.offer_rate', 
                                'inventories.sku', 
                                'inventories.purchase_rate'
                            );
                        }
                    ])
                    ->get();

                $cartItemsHtml = view('frontend.pages.partials.ajax-cart', [
                    'carts' => $updatedCarts
                ])->render();

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully.',
                    'cart_items_html' => $cartItemsHtml,
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
    }

    public function removeFromCart(Request $request){
        $cart = Cart::find($request->cart_id);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'The requested cart item does not exist.'
            ]);
        }

        try {
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'The product has been successfully removed from your cart.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the product from the cart. Please try again.'
            ]);
        }
    }

    public function checkOut(Request $request){
        $customerId = auth('customer')->id();
        $customer_address = Address::where('customer_id', $customerId)->get();
        $carts = Cart::where('customer_id', $customerId)
            ->with(['product' => function ($query) {
                $query->with(['category', 'images'])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.purchase_rate', 'inventories.offer_rate', 'inventories.sku');
            }])
            ->get();
           // return response()->json($carts);
        //return view('frontend.emails.order_details_mail');
        return view('frontend.pages.checkout', compact('customer_address', 'carts'));
    }

    public function addAddressForm(Request $request){
        $token = $request->input('_token');
        $size = $request->input('size');
        $url = $request->input('url');
        $customer_id = $request->input('customer_id');
        $customer_details = Customer::where('id', $customer_id)->first();
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('add.address.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addAddressForm">
                <input type="hidden" name="customer_id" value="'.$customer_id.'">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_name"  placeholder="Enter full name" value="'.$customer_details->name.'">
                            <label for="fname">Enter full name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number"  placeholder="Enter phone number" value="'.$customer_details->phone_number.'"  maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, "")">
                            <label for="lname">Enter phone number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="select-option mb-4">
                            <div class="form-floating theme-form-floating">
                                <select class="form-select theme-form-select" name="country" >
                                    <option value="India">India
                                    </option>
                                </select>
                                <label>Select Country</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_address" placeholder="Enter address">
                            <label for="lname">Enter address</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                            <label for="lname">Apartment, suite, etc. (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-select theme-form-select" name="city_name">
                                <option value="Varanasi">Varanasi</option>
                            </select>
                            <label for="city">Select City</label>
                            <!--<input type="text" class="form-control" name="city_name" placeholder="Enter city">
                            <label for="lname">Enter city</label>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="select-option">
                            <div class="form-floating mb-4 theme-form-floating">
                                <select class="form-select theme-form-select" name="state">
                                    <option value="Uttar Pradesh">Uttar Pradesh
                                    </option>
                                </select>
                                <label>Select State</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text"  name="pin_code" class="form-control" placeholder="Enter pin code">
                            <label for="lname">Enter pin code</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md text-white">Save
                        changes</button>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Attributes Form created successfully',
            'form' => $form,
        ]);
    }

    public function addAddressFormSubmit(Request $request) {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'full_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city_name' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pin_code' => 'required|string|max:6',
            'customer_id' => 'required|exists:customers,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $address = Address::create([
                'name' => $request->input('full_name'),
                'phone_number' => $request->input('phone_number'),
                'country' => $request->input('country'),
                'address' => $request->input('full_address'),
                'apartment' => $request->input('apartment'),
                'city' => $request->input('city_name'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('pin_code'),
                'customer_id' => $request->input('customer_id'),
            ]);
    
            if ($address) {
                $customerId = $request->input('customer_id');
                $customer_address = Address::where('customer_id', $customerId)->get();
                $carts = Cart::getCartDetailsWithRelations($customerId);
                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully.',
                    'customer_address' => view('frontend.pages.partials.ajax-checkout-form', [
                        'customer_address' => $customer_address,
                        'customerId' => $customerId,
                        'carts' => $carts, 
                    ])->render(),
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add the address. Please try again.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.',
            ], 500);
        }
    }

    public function editAddressForm(Request $request){
        $address_id = $request->input('address_id');
        $address_dtails = Address::where('id', $address_id)->first();
        $customer_id = $request->input('customer_id');
        //$customer_details = Customer::where('id', $customer_id)->first();
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('update.address', ['id' => $address_id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="EditAddressForm">
                <input type="hidden" name="customer_id" value="'.$customer_id.'">
                '.csrf_field().'
                '.method_field('PUT').'
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_name"  placeholder="Enter full name" value="'.$address_dtails->name.'">
                            <label for="fname">Enter full name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number"  placeholder="Enter phone number" value="'.$address_dtails->phone_number.'"   maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, "")">
                            <label for="lname">Enter phone number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="select-option">
                            <div class="form-floating mb-4 theme-form-floating">
                                <select class="form-select theme-form-select" name="country" >
                                    <option value="India">India
                                    </option>
                                </select>
                                <label>Select Country</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_address" placeholder="Enter address" value="'.$address_dtails->address.'">
                            <label for="lname">Enter address</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="apartment" placeholder="Apartment, suite, etc. (optional)" value="'.$address_dtails->apartment.'">
                            <label for="lname">Apartment, suite, etc. (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-select theme-form-select" name="city_name">
                                <option value="Varanasi">Varanasi</option>
                            </select>
                            <label for="city">Select City</label>
                            <!--<input type="text" class="form-control" name="city_name" placeholder="Enter city" value="'.$address_dtails->city.'">
                            <label for="lname">Enter city</label>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="select-option">
                            <div class="form-floating mb-4 theme-form-floating">
                                <select class="form-select theme-form-select" name="state">
                                    <option value="Uttar Pradesh">Uttar Pradesh
                                    </option>
                                </select>
                                <label>Select State</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text"  name="pin_code" class="form-control" placeholder="Enter pin code" value="'.$address_dtails->zip_code.'">
                            <label for="lname">Enter pin code</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn theme-bg-color btn-md text-white">Update & Save
                        changes</button>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Attributes Form created successfully',
            'form' => $form,
        ]);
    }

    public function editAddressFormSubmit(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'full_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city_name' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pin_code' => 'required|string|max:6',
        ]);
        $customerId= $request->input('customer_id');
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $address = Address::find($id);
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ], 404);
        }
        try {
            $address->update([
                'name' => $request->input('full_name'),
                'phone_number' => $request->input('phone_number'),
                'country' => $request->input('country'),
                'address' => $request->input('full_address'),
                'apartment' => $request->input('apartment'),
                'city' => $request->input('city_name'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('pin_code'),
            ]);
            $customer_address = Address::where('customer_id', $customerId)->get();
            $carts = Cart::getCartDetailsWithRelations($customerId);
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully.',
                'customer_address' => view('frontend.pages.partials.ajax-checkout-form', [
                    'customer_address' => $customer_address,
                    'customerId' => $customerId,
                    'carts' => $carts, 
                ])->render(),
            ], 200);
        } catch (\Exception $e) {
            Log::info('address update: ', ['cache erro' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the address. Please try again.',
            ], 500);
        }
    }

    public function addToWishlist(Request $request){
        $customerId = $request->customer_id;
        $productId = $request->product_id;
        $wishlist = Wishlist::where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

            if ($wishlist) {
                $wishlist->delete();
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Item removed from your wishlist successfully.',
                ]);
            } else {
                Wishlist::create([
                    'customer_id' => $customerId,
                    'product_id' => $productId,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item added to your wishlist successfully.',
                ]);
            }
    }

    public function myaccount(){
        $customerId = auth('customer')->id();
        $wishlistcount = Wishlist::where('customer_id', $customerId)->count();
        $ordercount = Orders::where('customer_id', $customerId)->count();
        return view('frontend.pages.customer.customer-dashboard.myaccount', compact('wishlistcount', 'ordercount'));
    }

    public function showCustomerAddress(){
        $customerId = auth('customer')->id();
        $address = Address::where('customer_id', $customerId)->get();
        return view('frontend.pages.customer.address.index', compact('address'));
    }

    public function CustomerAddressStore(Request $request){
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'full_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city_name' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pin_code' => 'required|string|max:6',
            //'customer_id' => 'required|exists:customers,id',
        ]);
        $customerId = auth('customer')->id();
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::create([
            'name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'country' => $request->input('country'),
            'address' => $request->input('full_address'),
            'apartment' => $request->input('apartment'),
            'city' => $request->input('city_name'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('pin_code'),
            'customer_id' => $customerId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully.',
            'address' => $address,
        ]);
    }

    public function CustomerAddressEdit($id){
        $address = Address::find($id);
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'address' => $address,
        ]);
    }

    public function CustomerAddressUpdate(Request $request, $id){
        //Log::info('Request all : ', $request->all());
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'country' => 'required|string|max:50',
            'full_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city_name' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pin_code' => 'required|string|max:6',
        ]);
        //$customerId = auth('customer')->id();
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found.',
            ]);
        }

        $address->update([
            'name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'country' => $request->input('country'),
            'address' => $request->input('full_address'),
            'apartment' => $request->input('apartment'),
            'city' => $request->input('city_name'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('pin_code'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully.',
            'address' => $address,
        ]);
    }

    public function CustomerAddressRemove($customer_id, $address_id) {
        try {
            $address = Address::where('customer_id', $customer_id)
                ->where('id', $address_id)
                ->first();
    
            if ($address) {
                $address->delete();
                return response()->json(['success' => true, 'message' => 'Address removed successfully']);
            }
            return response()->json(['success' => false, 'message' => 'Address not found']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.']);
        }
    }
}
