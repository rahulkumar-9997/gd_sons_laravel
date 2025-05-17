<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
// use App\Models\Customer;
// use App\Models\Cart;
// use App\Models\Product;
// use App\Models\Inventory;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
// use App\Models\Wishlist;
use App\Models\Address;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\OrderStatus;
use App\Models\Orders;
use App\Models\OrderLines;
use App\Models\Wishlist;
use App\Models\Inventory;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
// use App\Mail\OrderDetailsMail;
use App\Mail\OrderDetailsMail;
use App\Mail\PaymentFailedMail;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;
use Razorpay\Api\Api;

class OrderController extends Controller
{

    public function checkOutFormSubmit(Request $request)
    {
        $addressExists = isset($request->customer_address_id) && $request->customer_address_id != '';

        if ($request->pick_up_status == 'pick_up_store') {
            // Handle store pickup logic
        } else {
            if ($addressExists) {
                $validatedData = $request->validate([
                    'customer_address_id' => 'required|exists:addresses,id',
                    'same_ship_bill_address' => 'nullable|boolean',
                ] + $this->getBillingValidation());
            } else {
                $validatedData = $request->validate([
                    'ship_full_name' => 'required|string|max:255',
                    'ship_phone_number' => 'required|digits:10',
                    'ship_country' => 'required',
                    'ship_full_address' => 'required',
                    'ship_city_name' => 'required|string',
                    'ship_state' => 'required',
                    'ship_pin_code' => 'required|digits:6',
                ] + $this->getBillingValidation());
            }
        }

        $cartItems = [];
        $cartProductIds = $request->input('product_id', []);
        $cartQuantities = $request->input('cart_quantity', []);
        $cartPrices = $request->input('cart_offer_rate', []);
        $cartTotalPrices = $request->input('total_price', []);

        foreach ($cartProductIds as $index => $productId) {
            $cartItems[] = [
                'product_id' => $productId,
                'quantity' => $cartQuantities[$index],
                'price' => $cartPrices[$index],
                'total_price' => $cartTotalPrices[$index],
            ];
        }

        session([
            'checkout_data' => $request->all(),
            'cart_items' => $cartItems,
        ]);

        if ($request->input('payment_type') == 'Cash on Delivery') {
            $response = $this->storeOrderAfterPayment($request);
            return response()->json([
                'data' => $response,
                'status' => 'cash_on_delivery',
            ]);
        } elseif ($request->input('payment_type') == 'Razorpay') {
            $orderResponse = $this->storeOrderAfterPayment($request);
            $responseData = json_decode($orderResponse->getContent(), true);
            if (!isset($responseData['order_id'])) {
                throw new \Exception('Order creation failed - no order ID returned');
            }

            $order = Orders::find($responseData['order_id']);
            if (!$order) {
                throw new \Exception('Created order not found');
            }
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $grandTotal = $request->input('grand_total_amount') * 100;
            $orderData = [
                'receipt' => 'order_rcpt_' . $order->id,
                'amount' => $grandTotal,
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            try {
                $razorpayOrder = $api->order->create($orderData);
                return response()->json([
                    'status' => 'razorpay',
                    'order_id' => $razorpayOrder->id,
                    'amount' => $grandTotal,
                    'name' => auth('customer')->user()->name ?? $request->ship_full_name,
                    'email' => auth('customer')->user()->email ?? '',
                    'contact' => auth('customer')->user()->phone_number ?? $request->ship_phone_number,
                    'callback_url' => route('razorpay.callback'),
                    'payment_failed_url' => route('payment.failed'),
                    'order_db_id' => $order->id
                ]);
            } catch (\Exception $e) {
                $order->delete();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Razorpay error: ' . $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Session created successfully!',
                'payment_type' => $request->input('payment_type'),
            ]);
        }
    }

    public function handleRazorpayCallback(Request $request)
    {
        $input = $request->all();
        Log::info('Razorpay callback input:', $input);
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        DB::beginTransaction();
        try {
            $generatedSignature = hash_hmac('sha256', $input['razorpay_order_id'] . "|" . $input['razorpay_payment_id'], config('services.razorpay.secret'));

            if ($generatedSignature !== $input['razorpay_signature']) {
                throw new \Exception('Payment verification failed.');
            }
            $payment = $api->payment->fetch($input['razorpay_payment_id']);
            if ($payment->status !== 'captured') {
                throw new \Exception('Payment not captured. Status: ' . $payment->status);
            }
            $order = Orders::findOrFail($input['order_db_id']);
            $paidStatus = OrderStatus::where('status_name', 'New')->first();
            if (!$paidStatus) {
                $paidStatus = OrderStatus::create(['status_name' => 'New']);
            }

            $order->update([
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'payment_received' => true,
                'payment_status' => 'Success',
                'razorpay_signature_id' => $input['razorpay_signature'],
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_method' => 'Razorpay'
            ]);

            foreach ($order->orderLines as $orderLine) {
                $inventory = Inventory::where('product_id', $orderLine->product_id)
                    ->where('mrp', $orderLine->price)
                    ->first();

                if ($inventory) {
                    $inventory->decrement('stock_quantity', $orderLine->quantity);
                }
            }

            Cart::where('customer_id', $order->customer_id)->delete();

            $orderDetails = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images'
            ])->find($order->id);

            $customerName = $order->customer->name;
            Mail::to($order->customer->email)->queue(new OrderDetailsMail($orderDetails));
            Mail::to('akshat.gd@gmail.com')->queue(new OrderDetailsMail($orderDetails, $customerName));

            DB::commit();
            /* Clear session data */
            session()->forget(['checkout_data', 'cart_items']);
            $token = Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('order.success', [
                    'order_id' => $encodedOrderId,
                    'token' => $token,
                ]),
                'message' => 'Payment successful! Order status updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Razorpay callback error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'redirect_url' => route('checkout')
            ], 400);
        }
    }

    public function handlePaymentFailed(Request $request)
    {
        DB::beginTransaction();
        Log::info('Razorpay payment failed callback:', ['data' => $request->all()]);
        try {
            if (!$request->has(['order_db_id', 'razorpay_payment_id', 'razorpay_order_id']))
            {
                throw new \Exception('Missing required payment parameters');
            }
            $order = Orders::findOrFail($request->order_db_id);

            $failedStatus = OrderStatus::where('status_name', 'New')->first();
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $failureReason = $payment->error_description ?? 'Payment failed';
            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'payment_received' => false,
                'payment_status' => 'Failed',
                'order_status_id' => $failedStatus->id,
                'razorpay_method' => 'Razorpay',
                'failure_reason' => $failureReason,
            ]);
            Log::warning('Payment failed details', [
                'order_id' => $order->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'status' => $payment->status ?? null,
                'error' => $payment->error ?? null
            ]);
            $this->sendPaymentFailedNotification($order, $failureReason);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment failed status updated',
                'redirect_url' => route('checkout')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment failed handler error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'redirect_url' => route('checkout')
            ], 500);
        }
    }

    protected function sendPaymentFailedNotification(Orders $order, string $reason): void
    {
        try {
            $customerEmail = $order->customer->email;
            $customerName = $order->customer->name;
            Mail::to($customerEmail)->queue(new PaymentFailedMail(
                order: $order,
                reason: $reason,
                customerName: $customerName
            ));
            Mail::to('rahulkumarmaurya464@gmail.com')->queue(new PaymentFailedMail(
                order: $order,
                reason: $reason,
                customerName: $customerName
            ));
            Mail::to('akshat.gd@gmail.com')->queue(new PaymentFailedMail(
                order: $order,
                reason: $reason,
                customerName: $customerName,
                isAdmin: true
            ));
           
        } catch (\Exception $e) {
            Log::error('Failed to send payment failed notification', [
                'order_id' => $order->id ?? null,
                'customer_email' => $customerEmail ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function getBillingValidation()
    {
        return [
            'bill_full_name' => 'nullable|required_if:same_ship_bill_address,1|string|max:255',
            'bill_phone_number' => 'nullable|required_if:same_ship_bill_address,1|digits:10',
            'bill_country' => 'nullable|required_if:same_ship_bill_address,1',
            'bill_full_address' => 'nullable|required_if:same_ship_bill_address,1',
            'bill_city_name' => 'nullable|required_if:same_ship_bill_address,1|string',
            'bill_state' => 'nullable|required_if:same_ship_bill_address,1',
            'bill_pin_code' => 'nullable|required_if:same_ship_bill_address,1|digits:6',
        ];
    }

    public function payModalForm(Request $request)
    {
        $response_data = $request->input('response_data');
        Log::info('response_date: ', ['response_data' => $response_data]);
        $gPayScannerPath = asset('frontend/assets/images/gpay-scanner.jpeg');
        $payTmScannerPath = asset('frontend/assets/images/paytm-scanner.jpeg');
        $form = '
        <form method="POST" action="' . route('pay-modal-form.submit') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="payModalFormSubmit">
            ' . csrf_field() . '
            <div class="row">

                <div class="col-md-12">';
        if ($response_data == 'Pay to GPay ID of Girdhar Das and Sons') {
            $form .= '
                        <div class="text-center">
                            <!--<div class="mb-3">
                                <h4>Google id : girdhardas.sons@okhdfcbank</h4>
                            </div>
                            <div class="or-area">
                                <h6>
                                    OR
                                </h6>
                            </div>-->
                            <div class="scanner-image mt-3 mb-3">
                                <img src="' . $gPayScannerPath . '" class="img-fluid blur-up lazyloaded pay-scanner">
                            </div>
                            <div class="mt-2 mb-3">
                                <span>Note: After payment successfull please click "Confirm Place Order" button.</span>
                            </div>
                        </div>';
        } elseif ($response_data == 'Pay to PayTM ID of Girdhar Das and Sons') {
            $form .= '
                        <div class="text-center">
                            <!--<div class="mb-3">
                                <h4>Paytm id : girdhardas.sons@paytm</h4>
                            </div>
                            <div class="or-area">
                                <h6>
                                    OR
                                </h6>
                            </div>-->
                            <div class="scanner-image mt-3 mb-3">
                                <img src="' . $payTmScannerPath . '" class="img-fluid blur-up lazyloaded pay-scanner">
                            </div>
                            <div class="mt-2 mb-3">
                                <span>Note: After payment successfull please click "Confirm Place Order" button.</span>
                            </div>
                        </div>';
        } else {
            $form .= '
                        <div class="text-center">
                            <div class="mb-3">
                                <h4>Note: Please click "Confirm Place Order" button.</h4>
                            </div>
                        </div>';
        }
        $form .= '
                </div>
                <div class="modal-footer pb-0">
                    
                    <button style="color:#ffffff;" type="submit" class="btn btn-2-animation btn-md fw-bold">Confirm Place Order</button>
                </div>
            </div>
        </form>
        ';
        return response()->json([
            'message' => 'Category Form created successfully',
            'form' => $form,
            'status' => 'success',
        ]);
    }

    public function payModalFormSubmit(Request $request)
    {
        $response = $this->storeOrderAfterPayment($request);
        return response()->json([
            'data' => $response,
        ]);
    }

    public function storeOrderAfterPayment(Request $request)
    {

        $checkoutData = session('checkout_data');
        $customerId = auth('customer')->id();
        if (!$checkoutData) {
            Log::info('Checkout Data in: ', ['checkout_data' => $checkoutData]);
            return response()->json(['message' => 'No checkout data found in session.'], 400);
        }
        //Log::info('Calling storeOrderAfterPayment come order bahar');
        DB::beginTransaction();
        try {
            /* Determine the shipping address ID */
            if ($checkoutData['pick_up_status'] == 'pick_up_online') {
                if (isset($checkoutData['customer_address_id']) && $checkoutData['customer_address_id'] !== null) {
                    /* Add the new shipping address to the 'shipping_addresses' table */
                    $customerAddressId = $checkoutData['customer_address_id'];
                    $customer_address = Address::where('id', $customerAddressId)
                        ->where('customer_id', $customerId)
                        ->first();
                    $shippingAddress = ShippingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $customer_address->name,
                        'phone_number' => $customer_address->phone_number,
                        'email_id' => null,
                        'country' => $customer_address->country,
                        'full_address' => $customer_address->address,
                        'apartment' => $customer_address->apartment ?? null,
                        'city_name' => $customer_address->city,
                        'state' => $customer_address->state,
                        'pin_code' => $customer_address->zip_code,
                    ]);
                    $shippingAddressId = $shippingAddress->id;
                } else {
                    $address = Address::create([
                        'customer_id' => $customerId,
                        'name' => $checkoutData['ship_full_name'],
                        'phone_number' => $checkoutData['ship_phone_number'],
                        'country' => $checkoutData['ship_country'],
                        'address' => $checkoutData['ship_full_address'],
                        'apartment' => $checkoutData['ship_apartment'] ?? null,
                        'city' => $checkoutData['ship_city_name'],
                        'state' => $checkoutData['ship_state'],
                        'zip_code' => $checkoutData['ship_pin_code'],
                    ]);
                    /* Add the new shipping address to the 'shipping_addresses' table */
                    $shippingAddress = ShippingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $checkoutData['ship_full_name'],
                        'phone_number' => $checkoutData['ship_phone_number'],
                        'email_id' => $checkoutData['email_id'] ?? null,
                        'country' => $checkoutData['ship_country'],
                        'full_address' => $checkoutData['ship_full_address'],
                        'apartment' => $checkoutData['ship_apartment'] ?? null,
                        'city_name' => $checkoutData['ship_city_name'],
                        'state' => $checkoutData['ship_state'],
                        'pin_code' => $checkoutData['ship_pin_code'],
                    ]);
                    $shippingAddressId = $shippingAddress->id;
                }
                /* Determine the billing address ID */
                if ($checkoutData['same_ship_bill_address'] == 1) {
                    $billingAddress = BillingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $checkoutData['bill_full_name'],
                        'phone_number' => $checkoutData['bill_phone_number'],
                        'email_id' => $checkoutData['email_id'] ?? null,
                        'country' => $checkoutData['bill_country'],
                        'full_address' => $checkoutData['bill_full_address'],
                        'apartment' => $checkoutData['bill_apartment'] ?? null,
                        'city_name' => $checkoutData['bill_city_name'],
                        'state' => $checkoutData['bill_state'],
                        'pin_code' => $checkoutData['bill_pin_code'],
                    ]);
                    $billingAddressId = $billingAddress->id;
                } else {
                    $billingAddressId = null;
                }
            } else {
                $shippingAddressId = null;
                $billingAddressId = null;
            }
            /* Generate unique 10-digit serial number for order_id */
            $lastOrder = Orders::latest('id')->first();
            $nextSerial = $lastOrder ? ((int) $lastOrder->order_id + 1) : 1;
            $orderId = str_pad($nextSerial, 10, '0', STR_PAD_LEFT);
            /**Find order status id */
            $orderStatus = OrderStatus::where('status_name', 'New')->first();
            /* Create the order */
            $order = Orders::create([
                'order_date' => now()->setTimezone('Asia/Kolkata'),
                'order_id' => $orderId,
                'grand_total_amount' =>  $checkoutData['grand_total_amount'],
                'payment_mode' => $checkoutData['payment_type'],
                'pick_up_status' => $checkoutData['pick_up_status'],
                'customer_id' => $customerId,
                'shipping_address_id' => $shippingAddressId,
                'billing_address_id' => $billingAddressId,
                'order_status_id' => $orderStatus->id,
            ]);
            Log::info('storeOrderAfterPayment in: ', ['create order' => $order]);
            /* Add order lines */
            $cartItems = session('cart_items', []);
            foreach ($cartItems as $item) {
                OrderLines::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price'],
                ]);
                /*Update inventory for the product after placing the order*/
                // $inventory = Inventory::where('product_id', $item['product_id'])
                //     ->where('mrp', $item['price'])
                //     ->first();
                // if ($inventory) {
                //     $newStockQuantity = $inventory->stock_quantity - $item['quantity'];
                //     $inventory->update([
                //         'stock_quantity' => $newStockQuantity
                //     ]);
                // } else {
                //     Log::warning('Inventory not found for product_id: ' . $item['product_id']);
                // }
            }
            /*Delete cart after payment*/
            //Cart::where('customer_id', $customerId)->delete();
            /*Delete cart after payment*/
            /* Clear session data */
            //session()->forget(['checkout_data', 'cart_items']);
            /**send mail process */
            // $orderDetails = Orders::with([
            //     'orderStatus',
            //     'shippingAddress',
            //     'billingAddress',
            //     'orderLines.product',
            //     'orderLines.product.images'
            // ])->where('id', $order->id)->first();
            // $customerName = auth('customer')->user()->name;

            //Log::info('Sending order details email to customer: ' . auth('customer')->user()->email);
            // Queue the email
            // Mail::to(auth('customer')->user()->email)->queue(new OrderDetailsMail($orderDetails));
            // Mail::to('akshat.gd@gmail.com')->queue(new OrderDetailsMail($orderDetails, $customerName));
            // Log::info('Order details email queued successfully to: ' . auth('customer')->user()->email);
            /**send mail process */
            DB::commit();
            $token = Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);

            //ALTER TABLE failed_jobs MODIFY COLUMN id BIGINT AUTO_INCREMENT;
            return response()->json([
                'message' => 'Order stored successfully!',
                'order_id' => $order->id,
                'redirect_url' => route('order.success', [
                    'order_id' => $encodedOrderId,
                    'token' => $token,
                ])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Checkout Data in Exception: ', ['cache erro' => $e]);
            return response()->json(['message' => 'Failed to store order.', 'error' => $e->getMessage()], 500);
        }
    }

    public function showOrderSuccess(Request $request)
    {
        $encodedOrderId = $request->input('order_id');
        $token = $request->input('token');
        try {
            $orderId = Crypt::decrypt($encodedOrderId);
            $sessionToken = session('order_token');
            if ($token !== $sessionToken) {
                abort(403, 'Unauthorized access.');
            }
            $order = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images'
            ])
                ->where('id', $orderId)
                ->first();
        } catch (\Exception $e) {
            abort(403, 'Unauthorized access.');
        }
        //return response()->json($order);
        return view('frontend.pages.order-success', compact('order'));
    }

    public function showCustomerOrder()
    {
        $customerId = auth('customer')->id();
        $order = Orders::with([
            'orderStatus',
            'shippingAddress',
            'billingAddress',
            'orderLines.product',
            'orderLines.product.images'
        ])
            ->where('customer_id', $customerId)
            ->orderBy('id', 'desc')->get();
        //->paginate(10);
        //return response()->json($order);
        return view('frontend.pages.customer.orders.index', compact('order'));
    }

    public function showCustomerOrderDetails($encryptedOrderId)
    {
        $orderId = decrypt($encryptedOrderId);
        $customerId = auth('customer')->id();
        $order = Orders::with([
            'orderStatus',
            'shippingAddress',
            'billingAddress',
            'orderLines.product',
            'orderLines.product.images',
            'orderLines.product.ProductAttributesValues' => function ($query) {
                $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->with([
                        'attributeValue:id,slug'
                    ])
                    ->orderBy('id');
            }
        ])
            ->where('customer_id', $customerId)
            ->where('id', $orderId)
            ->first();
        //return response()->json($order);
        return view('frontend.pages.customer.orders.order-details', compact('order'));
    }

    public function showCustomerWishlist()
    {
        $customerId = auth('customer')->id();
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

        return view('frontend.pages.customer.wishlist.index', compact('wishlist'));
    }

    public function removeFromWishlist(Request $request)
    {
        $customerId = auth('customer')->id();
        try {
            $wishlistItem = Wishlist::where('id', $request->wishlistid)
                ->where('customer_id', $customerId)
                ->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
                return response()->json(['status' => 'success', 'message' => 'Item removed from wishlist.']);
            }

            return response()->json(['status' => 'error', 'message' => 'Item not found in wishlist !']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong !']);
        }
    }

    public function orderParameter()
    {
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
        return view('frontend.pages.checkout-param-page', compact('carts'));
    }

    public function pickUpStore()
    {
        $customerId = auth('customer')->id();
        $customer_address = Address::where('customer_id', $customerId)->get();
        $specialOffers = getCustomerSpecialOffers();
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
        return view('frontend.pages.pick-up-store-page', compact('carts', 'specialOffers'));
    }

    public function createOrder(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $orderData = [
            'amount' => $request->amount * 100, // Razorpay expects amount in paise
            'currency' => 'INR',
            'receipt' => 'order_rcpt_' . uniqid(),
            'payment_capture' => 1 // auto capture
        ];

        $order = $api->order->create($orderData);

        return response()->json($order);
    }

    public function handleSuccess(Request $request)
    {
        // Verify payment signature
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment successful - process order
            return view('payment.success');
        } catch (\Exception $e) {
            // Handle failed payment
            return view('payment.failed');
        }
    }
}
