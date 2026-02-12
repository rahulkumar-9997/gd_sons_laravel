<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Wishlist;
use App\Models\Address;
use App\Models\Orders;
use App\Models\State;

class CustomerController extends Controller
{
    public function uploadProfileImg(Request $request)
    {
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

    public function changeQuantityCartDrawer(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $productId = $request->id;
            $quantity = (int) $request->quantity;
            $cart = session()->get('cart', []);
            Log::info('Cart Contents', ['cart' => $cart]);
            if ($quantity === 0) {
                unset($cart[$productId]);
            } else {
                $inventory = Inventory::where('product_id', $productId)
                    ->orderBy('mrp')
                    ->first();
                if (!$inventory || $inventory->stock_quantity < $quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available. Only ' . ($inventory->stock_quantity ?? 0) . ' items in stock.'
                    ]);
                }

                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }

            session(['cart' => $cart]);
            $cartCount = count($cart);
            $cacheKey = 'customer_cart_' . auth()->id() . '_' . md5(json_encode($cart));
            Cache::forget($cacheKey);
            $cartItems = Cache::remember($cacheKey, 60, function () use ($cart) {
                return Product::with(['images'])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                    ->whereIn('products.id', array_keys($cart))
                    ->get();
            });
            $specialOffers = getCustomerSpecialOffers();
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.',
                'cart_count' => $cartCount,
                'cart_html' => view('frontend.pages.partials.cart-drawer', [
                    'cartItems' => $cartItems,
                    'cart_count' => $cartCount,
                    'specialOffers' => $specialOffers,
                ])->render(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'product_mrp' => 'required|numeric|min:0',
        ]);

        try {
            $productId = $validated['product_id'];
            $quantity = $validated['quantity'];
            $mrp = $validated['product_mrp'];
            $inventory = Inventory::where('product_id', $productId)
                ->where('mrp', $mrp)
                ->first();
            if (!$inventory) {
                return response()->json(['success' => false, 'message' => 'Inventory record not found']);
            }
            $cart = session()->get('cart', []);
            $existingQuantity = $cart[$productId]['quantity'] ?? 0;
            $newQuantity = $existingQuantity + $quantity;
            /* Check stock against new total quantity */
            if ($inventory->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available. Only ' . $inventory->stock_quantity . ' items left.'
                ]);
            }
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $newQuantity,
            ];
            session(['cart' => $cart]);
            session()->save();
            $cartItems = Product::with(['images'])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select(
                'products.*',
                'inventories.mrp',
                'inventories.offer_rate',
                'inventories.purchase_rate',
                'inventories.sku'
            )
            ->whereIn('products.id', array_keys($cart))
            ->get();
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => count($cart),
                'cart_html' => view('frontend.pages.partials.cart-drawer', [
                    'cartItems' => $cartItems,
                    'cart_count' => count($cart),
                ])->render(),
                'header_cart_count' => view('frontend.layouts.component.header-cart-count', [
                    'cart_count' => count($cart),
                ])->render()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    public function cartList(Request $request)
    {
        $customerId = auth('customer')->id();
        $specialOffers = getCustomerSpecialOffers();
        //dd($specialOffers);
        if ($request->isMethod('get')) {
            $session_cart = session()->get('cart', []);
            Log::info('Cart Contents', ['cart' => $session_cart]);
            $carts = Product::with([
                'category',
                'images',
                'ProductImagesFront:id,product_id,image_path',
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with(['attributeValue:id,slug'])
                        ->orderBy('id');
                }
            ])
                ->leftJoin('inventories', function ($join) {
                    $join->on('products.id', '=', 'inventories.product_id')
                        ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                })
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                ->whereIn('products.id', array_keys($session_cart))
                ->get();
            return view('frontend.pages.cart', compact('carts', 'specialOffers'));
        }



        /*Handle POST Request: Update Cart Quantity (AJAX)*/
        if ($request->isMethod('post')) {
            $productId = $request->input('cart_id');
            $quantity = (int)$request->input('quantity');
            $cart = session()->get('cart', []);
            $message = '';
            $status = true;
            $shouldUpdateCart = true;
            if ($quantity < 1) {
                if (isset($cart[$productId])) {
                    unset($cart[$productId]);
                    session(['cart' => $cart]);
                    $message = 'Item removed from cart.';
                } else {
                    $message = 'Item not found in cart.';
                }
                $shouldUpdateCart = false;
            }
            if ($shouldUpdateCart) {
                $inventory = Inventory::where('product_id', $productId)
                    ->orderBy('mrp')
                    ->first();
                if (!$inventory || $inventory->stock_quantity < $quantity) {
                    $message = 'Not enough stock available. Only ' . ($inventory->stock_quantity ?? 0) . ' items in stock.';
                    $shouldUpdateCart = false;
                }
            }
            if ($shouldUpdateCart) {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
                session(['cart' => $cart]);
                $message = 'Cart updated successfully.';
            }
            $cacheKey = 'customer_cart_' . auth()->id() . '_' . md5(json_encode($cart));
            Cache::forget($cacheKey);
            $cartItems = Cache::remember($cacheKey, 60, function () use ($cart) {
                return Product::with(['images'])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                    ->whereIn('products.id', array_keys($cart))
                    ->get();
            });
            $specialOffers = getCustomerSpecialOffers();
            $cartItemsHtml = view('frontend.pages.partials.ajax-cart', [
                'carts' => $cartItems,
                'specialOffers' => $specialOffers
            ])->render();
            return response()->json([
                'success' => $status,
                'cart_items_html' => $cartItemsHtml,
                'message' => $message
            ]);
        }

        // For non-POST requests
        return response()->json([
            'cart_items_html' => '',
            'message' => 'Invalid request method.'
        ]);

    }

    public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->productId;
            $session_cart = session()->get('cart', []);
            Log::info('Cart Contents', ['cart' => $session_cart]);
            Log::info('product_id', ['cart' => $productId]);             
            $productWasInCart = array_key_exists($productId, $session_cart);            
            if ($productWasInCart) {
                unset($session_cart[$productId]);
                session(['cart' => $session_cart]);
            }
            $cacheKey = 'customer_cart_' . auth()->id() . '_' . md5(json_encode($session_cart));
            Cache::forget($cacheKey);
            $cartItems = Cache::remember($cacheKey, 60, function () use ($session_cart) {
                return Product::with(['images'])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                    ->whereIn('products.id', array_keys($session_cart))
                    ->get();
            });
            $specialOffers = getCustomerSpecialOffers();            
            $cartItemsHtml = view('frontend.pages.partials.ajax-cart', [
                'carts' => $cartItems,
                'specialOffers' => $specialOffers
            ])->render();
            return response()->json([
                'success' => true,
                'cart_items_html' => $cartItemsHtml,
                'message' => $productWasInCart 
                    ? 'Item removed from cart successfully' 
                    : 'Product not found in cart'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item from cart: ' . $e->getMessage()
            ]);
        }
    }

    public function checkOut(Request $request)
    {
        $session_cart = session()->get('cart', []);
        if (empty($session_cart)) {
            return redirect('/')->with('error', 'Your cart is empty. Please add items to proceed to checkout.');
        }
        $productIds = array_keys($session_cart);
        Log::info('Cart Contents', ['cart' => $session_cart]);
        $customerId = auth('customer')->id();
        $customer_address = Address::where('customer_id', $customerId)->get();
        $specialOffers = getCustomerSpecialOffers();
        $states = State::orderBy('name')->get();
        //dd($specialOffers);
        $carts = Product::with(['category', 'images'])
        ->leftJoin('inventories', function ($join) {
            $join->on('products.id', '=', 'inventories.product_id')
                ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
        })
        ->select('products.*', 'inventories.mrp', 'inventories.purchase_rate', 'inventories.offer_rate', 'inventories.sku')
        ->whereIn('products.id', $productIds)
        ->get();
        $couriers = []; 
        $rate = 0;
        $paymentType = 'online';
        //return response()->json($carts);
        //return view('frontend.emails.order_details_mail');
        return view('frontend.pages.checkout', compact('customer_address', 'carts', 'specialOffers', 'states', 'couriers', 'rate', 'paymentType'));
    }

    public function checkServiceability(Request $req)
    {
        $req->validate([
            'pincode' => 'required|digits:6',
            'total_weight' => 'required|numeric|min:0.1',
        ]);
        $session_cart = session()->get('cart', []);
        if (empty($session_cart)) {
            return redirect('/')->with('error', 'Your cart is empty. Please add items to proceed to checkout.');
        }
        $productIds = array_keys($session_cart); 
               
        $pincode = $req->pincode;
        $weight = (float) $req->total_weight;
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');

        if (!$fromPin) {
            return response()->json([
                'success' => false,
                'checkout_sidebar' => '<span class="text-danger">Pickup pincode missing.</span>'
            ]);
        }

        $ship = app(\App\Services\ShiprocketService::class);
        $cod = $req->cod ?? 0;
        $paymentType = $req->input('payment_type') ?? 'online';
        $response = $ship->getServiceability($fromPin, $pincode, $weight, $cod);
        //Log::info('Shiprocket Response: ' . json_encode($response, JSON_PRETTY_PRINT));
        if (!$response || !$response['success']) {
            if (!empty($response['response']['message'])) {
                $errorMessage = $response['response']['message'];
            } else {
                $errorMessage = 'Delivery not available at this pincode.';
            }
            return response()->json([
                'success' => false,
                'checkout_sidebar' => $errorMessage
            ]);
        }
        $couriers = [];
        foreach ($response['raw']['data']['available_courier_companies'] as $c) {
            $rate = $c['rate'] ?? $c['freight_charge'] ?? null;
            if (!$rate) continue;
            $couriers[] = [
                'courier' => $c['courier_name'] ?? 'Unknown',
                'service' => $c['service'] ?? '',
                'etd'     => $c['etd'] ?? '',
                'rate'    => $rate,
                'courier_company_id' => $c['courier_company_id'] ?? null,
                'cod_charges' => $c['cod_charges'] ?? 0,
                'id'=>$c['id'] ?? null,
            ];
        }
        
        if (empty($couriers)) {
            return response()->json([
                'success' => false,
                'checkout_sidebar' => '<span class="text-danger">No courier services available.</span>'
            ]);
        }
        /* Varanasi free delivery start logic code*/
        /*If free shipping for varanasi remove than this logic code remove */
        $localityResponse = $ship->getShiprocketLocalityDetails($pincode);
        $isFreeDelivery = false;
        if (!empty($localityResponse['success'])) {
            $city = strtolower(trim($localityResponse['data']['city'] ?? ''));
            if (
                str_contains($city, 'varanasi') ||
                str_contains($city, 'banaras') ||
                str_contains($city, 'benares')
            ) {
                $isFreeDelivery = true;
            }
        }

        if ($isFreeDelivery) {
            foreach ($couriers as &$courier) {
                $courier['rate'] = 0;
            }
            unset($courier);
        }
        /* Varanasi free delivery End logic code*/

        usort($couriers, fn($a, $b) => $a['rate'] <=> $b['rate']);
        $couriers = array_slice($couriers, 0, 5);
        $customerId = auth('customer')->id();
        $customer_address = Address::where('customer_id', $customerId)->get();
        $specialOffers = getCustomerSpecialOffers();
        $carts = Product::with(['category', 'images'])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.purchase_rate', 'inventories.offer_rate', 'inventories.sku')
            ->whereIn('products.id', $productIds)
            ->get();
                       
        return response()->json([
            'success' => true,
            'checkout_sidebar' => view('frontend.pages.partials.checkout.component.ajax-checkout-sidebar', [
                'couriers' => $couriers,
                'rate' => $couriers[0]['rate'],
                'carts' => $carts,
                'specialOffers' => $specialOffers,
                'paymentType' => $paymentType,
            ])->render(),
        ], 200);
    }

    public function checkLocalityDetails(Request $request){
        $request->validate([
            'pincode' => 'required|digits:6',
        ]);

        $pincode = $request->pincode;
        $ship = app(\App\Services\ShiprocketService::class);
        $response = $ship->getShiprocketLocalityDetails($pincode);
        Log::info('Shiprocket Response: ' . json_encode($response, JSON_PRETTY_PRINT));
        if (!$response || !$response['success']) {
            return response()->json([
                'success' => false,
                'message' => ""
            ]);
        }

        $details = $response['data'];
        $city = trim(strtolower($details['city'] ?? ''));
        $isFreeDelivery = in_array($city, [
            'varanasi',
            'banaras',
            'benares'
        ]);
        return response()->json([
            'success' => true,
            'state'   => $details['state'] ?? '',
            'city'    => $details['city'] ?? '',
            'locality_list' => $details['locality'] ?? [],
            'free_delivery'  => $isFreeDelivery
        ]);
    }


    public function addAddressForm(Request $request)
    {
        $token = $request->input('_token');
        $size = $request->input('size');
        $url = $request->input('url');
        $customer_id = $request->input('customer_id');
        $customer_details = Customer::where('id', $customer_id)->first();
        $states = State::orderBy('name')->get();
        $form = '
        <div class="modal-body">
            <form method="POST" action="' . route('add.address.submit') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="addAddressForm">
                <input type="hidden" name="customer_id" value="' . $customer_id . '">
                ' . csrf_field() . '
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_name"  placeholder="Enter full name" value="' . $customer_details->name . '">
                            <label for="fname">Enter full name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number"  placeholder="Enter phone number" value="' . $customer_details->phone_number . '"  maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, "")">
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
                            <input type="text"  name="pin_code" id="checkout_pincode_add_new_address" class="form-control" placeholder="Enter pin code">
                            <label for="lname">Enter pin code</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_address" placeholder="Enter address">
                            <label for="lname">Enter address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                            <label for="lname">Apartment, suite, etc. (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <!--<select class="form-select theme-form-select" name="city_name">
                                <option value="Varanasi">Varanasi</option>
                            </select>
                            <label for="city">Select City</label>-->
                            <input type="text" class="form-control" name="city_name" placeholder="Enter city" readonly="">
                            <label for="lname">Enter city</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="select-option">
                            <div class="form-floating mb-4 theme-form-floating">
                                <input type="text" class="form-control" name="state" placeholder="Enter state name" readonly="">
                                <label for="lname">Enter state</label>
                                <!--<select class="form-select theme-form-select" name="state">
                                    <option value="">Select State</option>';                                
                                    foreach($states as $state){
                                        $form .= '<option value="'.$state->name.'">'.$state->name.'
                                        </option>';
                                    }
                                $form .= '                                    
                                </select>
                                <label>Select State</label>-->
                            </div>
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

    public function addAddressFormSubmit(Request $request)
    {
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
                $specialOffers = getCustomerSpecialOffers();
                $session_cart = session()->get('cart', []);
                Log::info('Cart Contents', ['cart' => $session_cart]);
                $carts = Product::with([
                    'category',
                    'images',
                    'ProductImagesFront:id,product_id,image_path',
                    'ProductAttributesValues' => function ($query) {
                        $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                            ->with(['attributeValue:id,slug'])
                            ->orderBy('id');
                    }
                ])
                    ->leftJoin('inventories', function ($join) {
                        $join->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                    ->whereIn('products.id', array_keys($session_cart))
                    ->get();
                $couriers = []; 
                $rate = 0;
                $paymentType = 'online';
                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully.',
                    'customer_address' => view('frontend.pages.partials.checkout.ajax-checkout-form', [
                        'customer_address' => $customer_address,
                        'customerId' => $customerId,
                        'carts' => $carts,
                        'specialOffers' => $specialOffers,
                        'couriers' => $couriers,
                        'rate' => $rate,
                        'paymentType' => $paymentType,
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
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function editAddressForm(Request $request)
    {
        $address_id = $request->input('address_id');
        $address_dtails = Address::where('id', $address_id)->first();
        $customer_id = $request->input('customer_id');
        //$customer_details = Customer::where('id', $customer_id)->first();
        $states = State::orderBy('name')->get();
        $form = '
        <div class="modal-body">
            <form method="POST" action="' . route('update.address', ['id' => $address_id]) . '" accept-charset="UTF-8" enctype="multipart/form-data" id="EditAddressForm">
                <input type="hidden" name="customer_id" value="' . $customer_id . '">
                ' . csrf_field() . '
                ' . method_field('PUT') . '
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_name"  placeholder="Enter full name" value="' . $address_dtails->name . '">
                            <label for="fname">Enter full name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number"  placeholder="Enter phone number" value="' . $address_dtails->phone_number . '"   maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, "")">
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
                            <input type="text"  name="pin_code" id="checkout_pincode_edit_address" class="form-control" placeholder="Enter pin code" value="' . $address_dtails->zip_code . '" >
                            <label for="lname">Enter pin code</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="full_address" placeholder="Enter address"
                            value="' . $address_dtails->address . '" >
                            <label for="lname">Enter address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="apartment" placeholder="Apartment, suite, etc. (optional)"
                            value="' . $address_dtails->apartment . '" >
                            <label for="lname">Apartment, suite, etc. (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-4 theme-form-floating">
                            <!--<select class="form-select theme-form-select" name="city_name">
                                <option value="Varanasi">Varanasi</option>
                            </select>
                            <label for="city">Select City</label>-->
                            <input type="text" class="form-control" name="city_name" placeholder="Enter city" readonly="" value="' . $address_dtails->city . '" >
                            <label for="lname">Enter city</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="select-option">
                            <div class="form-floating mb-4 theme-form-floating">
                                <input type="text" class="form-control" name="state" placeholder="Enter state name" readonly="" value="' . $address_dtails->state . '" >
                                <label for="lname">Enter state</label>
                                <!--<select class="form-select theme-form-select" name="state">
                                    <option value="">Select State</option>';                                
                                    foreach($states as $state){
                                        $form .= '<option value="'.$state->name.'">'.$state->name.'
                                        </option>';
                                    }
                                $form .= '                                    
                                </select>
                                <label>Select State</label>-->
                            </div>
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

    public function editAddressFormSubmit(Request $request, $id)
    {

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
        $customerId = $request->input('customer_id');
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
            $session_cart = session()->get('cart', []);
            Log::info('Cart Contents', ['cart' => $session_cart]);
            $carts = Product::with([
                    'category',
                    'images',
                    'ProductImagesFront:id,product_id,image_path',
                    'ProductAttributesValues' => function ($query) {
                        $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                            ->with(['attributeValue:id,slug'])
                            ->orderBy('id');
                    }
                ])
                ->leftJoin('inventories', function ($join) {
                    $join->on('products.id', '=', 'inventories.product_id')
                        ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                })
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                ->whereIn('products.id', array_keys($session_cart))
                ->get();
            $specialOffers = getCustomerSpecialOffers();
            $couriers = []; 
            $rate = 0;
            $paymentType = 'online';
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully.',
                'customer_address' => view('frontend.pages.partials.checkout.ajax-checkout-form', [
                    'customer_address' => $customer_address,
                    'customerId' => $customerId,
                    'carts' => $carts,
                    'specialOffers' => $specialOffers,
                    'couriers' => $couriers,
                    'rate' => $rate,
                    'paymentType' => $paymentType,
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

    public function addToWishlist(Request $request)
    {
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

    public function myaccount()
    {
        $customerId = auth('customer')->id();
        $wishlistcount = Wishlist::where('customer_id', $customerId)->count();
        $ordercount = Orders::where('customer_id', $customerId)->count();
        return view('frontend.pages.customer.customer-dashboard.myaccount', compact('wishlistcount', 'ordercount'));
    }

    public function showCustomerAddress()
    {
        $customerId = auth('customer')->id();
        $address = Address::where('customer_id', $customerId)->get();
        return view('frontend.pages.customer.address.index', compact('address'));
    }

    public function CustomerAddressStore(Request $request)
    {
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

    public function CustomerAddressEdit($id)
    {
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

    public function CustomerAddressUpdate(Request $request, $id)
    {
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

    public function CustomerAddressRemove($customer_id, $address_id)
    {
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
