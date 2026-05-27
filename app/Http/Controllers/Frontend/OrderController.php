<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderDetailsMail;
use App\Mail\PaymentFailedMail;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\OrderStatus;
use App\Models\Orders;
use App\Models\OrderLines;
use App\Models\Wishlist;
use App\Models\Inventory;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\ShiprocketCourier;
use App\Models\DiscountCode;

class OrderController extends Controller
{


    public function checkOutFormSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'pick_up_status' => 'required|string|in:pick_up_online,pick_up_offline',
            'payment_type' => 'required|string|in:Cash on Delivery,Razorpay,Pick Up From Store',
            'product_id' => 'required|array',
            'product_id.*' => 'required|integer|exists:products,id',
            'cart_quantity' => 'required|array',
            'cart_quantity.*' => 'required|integer|min:1',
            'cart_offer_rate' => 'required|array',
            'cart_offer_rate.*' => 'required|numeric|min:0',
            'total_price' => 'required|array',
            'total_price.*' => 'required|numeric|min:0',
            'grand_total_amount' => 'required|numeric|min:0',
        ]);
        $addressExists = isset($request->customer_address_id) && $request->customer_address_id != '';
        if ($request->pick_up_status == 'pick_up_online') {
            if ($addressExists) {
                $request->validate([
                    'customer_address_id' => 'required|integer|exists:addresses,id',
                    'same_ship_bill_address' => 'nullable|boolean',
                ] + $this->getBillingValidation());
            } else {
                $request->validate([
                    'ship_full_name' => 'required|string|max:255',
                    'ship_phone_number' => ['required', 'numeric', 'digits:10', 'regex:/^[6-9]\d{9}$/'],
                    'ship_email' => 'required|email|max:255',
                    'ship_country' => 'required|string',
                    'ship_full_address' => 'required|string',
                    'ship_city_name' => 'required|string|max:255',
                    'ship_state' => 'required|string',
                    'ship_pin_code' => 'required|digits:6',
                ]);
            }
            $request->validate([
                'courier_name' => 'required|string|max:255',
                'courier_id' => 'required|string|max:100',
                'courier_company_id' => 'required|integer',
                'shipping_rate' => 'required|numeric|min:0',
                'cod_charges' => 'nullable|numeric|min:0',
                'delivery_expected_date' => 'required|string|max:50',
            ]);
        } else {
            $request->validate([
                'store_location_id' => 'required|integer|exists:store_locations,id',
                'pickup_date' => 'required|date',
                'pickup_time' => 'required|string',
            ]);
        }
        $productIds = $request->input('product_id', []);
        $quantities = $request->input('cart_quantity', []);
        $prices = $request->input('cart_offer_rate', []);
        $totalPrices = $request->input('total_price', []);
        if (
            count($productIds) !== count($quantities) ||
            count($productIds) !== count($prices) ||
            count($productIds) !== count($totalPrices)
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart data arrays must have the same length'
            ], 422);
        }

        $cartItems = [];
        foreach ($productIds as $index => $productId) {
            if (!isset($quantities[$index]) || !isset($prices[$index]) || !isset($totalPrices[$index])) {
                continue;
            }
            $cartItems[] = [
                'product_id' => $productId,
                'quantity' => $quantities[$index],
                'price' => $prices[$index],
                'total_price' => $totalPrices[$index],
            ];
        }
        if (empty($cartItems)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart is empty'
            ], 422);
        }

        /*Courier Serviceability check */
        $courierData = [];
        if ($request->pick_up_status == 'pick_up_online') {
            $courierData = [
                'courier_name' => $request->input('courier_name'),
                'courier_id' => $request->input('courier_id'),
                'courier_company_id' => $request->input('courier_company_id'),
                'courier_shipping_rate' => $request->input('shipping_rate'),
                'cod_charges' => $request->input('cod_charges'),
                'delivery_expected_date' => $request->input('delivery_expected_date'),
            ];
        }
        session([
            'checkout_data' => $request->all(),
            'cart_items' => $cartItems,
            'courierData' => $courierData,
        ]);
        session()->save();
        if ($request->input('payment_type') == 'Cash on Delivery') {
            try {
                //$response = $this->storeOrderAfterPayment($request);               
                return response()->json([
                    'status' => 'success',
                    'payment_type' => $request->input('payment_type'),
                    'message' => 'Verifying OTP and creating order...',
                ]);
            } catch (\Exception $e) {
                Log::error('COD Order creation failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'payment_type' => $request->input('payment_type'),
                    'message' => 'Otp geteneration or Order creation failed',
                ], 500);
            }
        } elseif ($request->input('payment_type') == 'Pick Up From Store') {
            try {
                //$response = $this->storeOrderAfterPayment($request);
                return response()->json([
                    'status' => 'success',
                    'payment_type' => $request->input('payment_type'),
                    'message' => 'Verifying OTP and creating order...',
                ]);
            } catch (\Exception $e) {
                Log::error('Store Pickup Order creation failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'payment_type' => $request->input('payment_type'),
                    'message' => 'Otp geteneration or Order creation failed',
                ], 500);
            }
        } elseif ($request->input('payment_type') == 'Razorpay') {
            Log::info('LOG 1: Starting Razorpay payment processing ===', [
                'payment_type' => $request->input('payment_type'),
                'grand_total_amount' => $request->input('grand_total_amount'),
                'user_id' => auth('customer')->id() ?? 'guest',
                'timestamp' => now()
            ]);
            try {
                Log::info('LOG 2: Calling storeOrderAfterPayment ===', [
                    'request_data' => $request->except(['_token']),
                    'session_checkout_data' => session('checkout_data'),
                    'timestamp' => now()
                ]);
                $orderResponse = $this->storeOrderAfterPayment($request);
                Log::info('=== LOG 3: storeOrderAfterPayment response received ===', [
                    'response_type' => gettype($orderResponse),
                    'response' => $orderResponse,
                    'timestamp' => now()
                ]);
                if (is_string($orderResponse)) {
                    $responseData = json_decode($orderResponse, true);
                } elseif ($orderResponse instanceof \Illuminate\Http\JsonResponse) {
                    $responseData = $orderResponse->getData(true);
                } elseif (is_object($orderResponse)) {
                    $responseData = (array) $orderResponse;
                } else {
                    $responseData = $orderResponse;
                }
                if (!isset($responseData['order_id'])) {
                    Log::error('Order creation failed - no order ID returned', ['response' => $responseData]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Order creation failed'
                    ], 500);
                }
                $order = Orders::find($responseData['order_id']);
                if (!$order) {
                    Log::error('Created order not found', ['order_id' => $responseData['order_id']]);
                    throw new \Exception('Created order not found');
                }

                Log::info('LOG 4: Creating Razorpay order ===', [
                    'order_db_id' => $order->id,
                    'order_id' => $order->order_id,
                    'grand_total_amount' => $order->grand_total_amount,
                    'payment_mode' => $order->payment_mode,
                    'customer_id' => $order->customer_id,
                    'timestamp' => now()
                ]);
                $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                $grandTotal = $request->input('grand_total_amount');
                if (!is_numeric($grandTotal) || $grandTotal <= 0) {
                    $order->delete();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid order amount'
                    ], 422);
                }
                //$razorpayAmount = 100;   
                $razorpayAmount = $grandTotal * 100;
                $actualAmount = $request->input('grand_total_amount');
                $orderData = [
                    'receipt' => 'order_rcpt_' . $order->id,
                    'amount' => (int) $razorpayAmount,
                    'currency' => 'INR',
                    'payment_capture' => 1,
                    'notes' => [
                        'order_db_id' => $order->id,
                        'actual_amount' => $actualAmount,
                        'is_test_payment' => false
                    ]
                ];
                Log::info('LOG 5: Sending request to Razorpay API ===', [
                    'razorpay_key' => config('services.razorpay.key'),
                    'order_data' => $orderData,
                    'razorpay_amount_in_paise' => $razorpayAmount,
                    'razorpay_amount_in_rupees' => $razorpayAmount / 100,
                    'actual_order_amount' => $actualAmount,
                    'timestamp' => now()
                ]);
                $razorpayOrder = $api->order->create($orderData);
                Log::info('LOG 6: RAZORPAY ORDER CREATED SUCCESSFULLY ===', [
                    'razorpay_order_id' => $razorpayOrder->id,
                    'razorpay_amount' => $razorpayOrder->amount,
                    'razorpay_currency' => $razorpayOrder->currency,
                    'razorpay_status' => $razorpayOrder->status,
                    'order_db_id' => $order->id,
                    'timestamp' => now()
                ]);
                return response()->json([
                    'status' => 'razorpay',
                    'order_id' => $razorpayOrder->id,
                    'amount' => $razorpayAmount,
                    'actual_amount' => $actualAmount,
                    'name' => auth('customer')->user()->name ?? $request->ship_full_name ?? 'Customer',
                    'email' => auth('customer')->user()->email ?? $request->ship_email,
                    'contact' => auth('customer')->user()->phone_number ?? $request->ship_phone_number,
                    'callback_url' => route('razorpay.callback'),
                    'payment_failed_url' => route('payment.failed'),
                    'order_db_id' => $order->id
                ]);
            } catch (\Exception $e) {
                Log::error('=== RAZORPAY PAYMENT INITIATION FAILED ===', [
                    'error_message' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'error_trace' => $e->getTraceAsString(),
                    'request_data' => $request->all(),
                    'timestamp' => now()
                ]);
                if (isset($order) && $order instanceof Orders) {
                    $order->delete();
                }
                Log::error('Razorpay payment initiation failed: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment initiation failed'
                ], 500);
            }
        } else {
            Log::warning('Unknown payment type selected: ' . $request->input('payment_type'));
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid payment method selected'
            ], 422);
        }
    }

    public function handleRazorpayCallback(Request $request)
    {
        $input = $request->all();
        $checkoutData = session('checkout_data');
        Log::info('Razorpay callback input handleRazorpayCallback:', $input);
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
            $payment_status = 'Paid';
            $order->update([
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'payment_received' => true,
                'payment_status' => $payment_status,
                'razorpay_signature_id' => $input['razorpay_signature'],
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_method' => 'Razorpay',
                'order_status_comment' => 'complete_order',
            ]);
            foreach ($order->orderLines as $orderLine) {
                $inventory = Inventory::where('product_id', $orderLine->product_id)
                    ->where('mrp', $orderLine->price)
                    ->first();

                if ($inventory) {
                    $inventory->decrement('stock_quantity', $orderLine->quantity);
                }
            }
            $orderDetails = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images'
            ])->find($order->id);

            $shipping = $orderDetails->shippingAddress;
            $customerName  = $shipping->full_name ?? '';
            $customerPhone = $shipping->phone_number ?? '';
            $customerEmail = $shipping->email_id ?? '';
            $courierData = session('courierData', []);
            $waPayload = $checkoutData;
            $waPayload['ship_full_name']      = $customerName;
            $waPayload['ship_email']          = $customerEmail;
            $waPayload['ship_phone_number']   = $customerPhone;
            $waPayload['delivery_expected_date'] =
                $courierData['delivery_expected_date']
                ?? now()->setTimezone('Asia/Kolkata')->addDays(2)->format('d-m-Y');
            // Mail::to($order->customer->email)->queue(new OrderDetailsMail($orderDetails));
            Mail::to('akshat.gd@gmail.com')->queue(new OrderDetailsMail($orderDetails, $customerName));
            //$this->sendWhatsAppNotifications($order->order_id, $payment_status, $waPayload);
            DB::commit();
            /* Clear session data */
            session()->forget(['checkout_data', 'cart_items', 'cart', 'courierData']);
            session()->save();
            $token = Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);
            session()->save();
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
            if (!$request->has(['order_db_id', 'razorpay_payment_id', 'razorpay_order_id'])) {
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
                'order_status_comment' => 'complete_order',

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
            // Mail::to($customerEmail)->queue(new PaymentFailedMail(
            //     order: $order,
            //     reason: $reason,
            //     customerName: $customerName
            // ));
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

    public function storeOrderAfterPayment(Request $request)
    {
        $checkoutData = session('checkout_data');
        Log::info('Checkout Data in: ', ['checkout_data' => $checkoutData]);
        if (!$checkoutData) {
            Log::info('Checkout Data in: ', ['checkout_data' => $checkoutData]);
            return response()->json(['message' => 'No checkout data found in session.'], 400);
        }
        $customer_address = null;
        $shippingAddress = null;
        if (auth()->guard('customer')->check()) {
            $customerId = auth('customer')->id();
        } else {
            $identifierEmail = $checkoutData['ship_email'] ?? null;
            $identifierPhone = $checkoutData['ship_phone_number'] ?? null;
            $customer = Customer::where(function ($q) use ($identifierEmail, $identifierPhone) {
                if ($identifierEmail) {
                    $q->orWhere('email', $identifierEmail);
                }
                if ($identifierPhone) {
                    $q->orWhere('phone_number', $identifierPhone);
                }
            })->first();
            if ($customer) {
                $customerId = $customer->id;
            } else {
                $email = $checkoutData['ship_email'] ?? $checkoutData['bill_email'] ?? null;
                $name = $checkoutData['ship_full_name'] ?? $checkoutData['bill_full_name'] ?? 'Customer';
                $phone = $checkoutData['ship_phone_number'] ?? $checkoutData['bill_phone_number'] ?? null;
                $randomPassword = Str::random(8);
                $hashedPassword = Hash::make($randomPassword);
                $customer_create = Customer::create([
                    'email' => $email,
                    'name' => $name,
                    'phone_number' => $phone,
                    'password' => $hashedPassword,
                ]);
                $customerId = $customer_create->id;
            }
        }

        DB::beginTransaction();
        try {
            /* Determine the shipping address ID and billing address ID */
            if (($checkoutData['pick_up_status'] ?? null) == 'pick_up_online') {
                if (isset($checkoutData['customer_address_id']) && $checkoutData['customer_address_id'] !== null) {
                    $customerAddressId = $checkoutData['customer_address_id'];
                    $customer_address = Address::where('id', $customerAddressId)
                        ->where('customer_id', $customerId)
                        ->first();
                    $shippingAddress = ShippingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $customer_address->name ?? ($customer_address->full_name ?? 'Customer'),
                        'phone_number' => $customer_address->phone_number ?? null,
                        'email_id' => $customer_address->email ?? null,
                        'country' => $customer_address->country ?? null,
                        'full_address' => $customer_address->address ?? null,
                        'apartment' => $customer_address->apartment ?? null,
                        'city_name' => $customer_address->city ?? null,
                        'state' => $customer_address->state ?? null,
                        'pin_code' => $customer_address->zip_code ?? null,
                    ]);

                    $shippingAddressId = $shippingAddress->id;
                } else {
                    $address = Address::create([
                        'customer_id' => $customerId,
                        'name' => $checkoutData['ship_full_name'] ?? ($checkoutData['bill_full_name'] ?? 'Customer'),
                        'phone_number' => $checkoutData['ship_phone_number'] ?? ($checkoutData['bill_phone_number'] ?? null),
                        'country' => $checkoutData['ship_country'] ?? null,
                        'address' => $checkoutData['ship_full_address'] ?? null,
                        'apartment' => $checkoutData['ship_apartment'] ?? null,
                        'city' => $checkoutData['ship_city_name'] ?? null,
                        'state' => $checkoutData['ship_state'] ?? null,
                        'zip_code' => $checkoutData['ship_pin_code'] ?? null,
                    ]);
                    $shippingAddress = ShippingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $checkoutData['ship_full_name'] ?? ($checkoutData['bill_full_name'] ?? 'Customer'),
                        'phone_number' => $checkoutData['ship_phone_number'] ?? ($checkoutData['bill_phone_number'] ?? null),
                        'email_id' => $checkoutData['ship_email'] ?? ($checkoutData['bill_email'] ?? null),
                        'country' => $checkoutData['ship_country'] ?? null,
                        'full_address' => $checkoutData['ship_full_address'] ?? null,
                        'apartment' => $checkoutData['ship_apartment'] ?? null,
                        'city_name' => $checkoutData['ship_city_name'] ?? null,
                        'state' => $checkoutData['ship_state'] ?? null,
                        'pin_code' => $checkoutData['ship_pin_code'] ?? null,
                    ]);

                    $shippingAddressId = $shippingAddress->id;
                }
                /* Determine the billing address ID */
                if (isset($checkoutData['same_ship_bill_address']) && $checkoutData['same_ship_bill_address'] == 1) {
                    $billingAddress = BillingAddress::create([
                        'customer_id' => $customerId,
                        'full_name' => $checkoutData['bill_full_name'] ?? ($checkoutData['ship_full_name'] ?? 'Customer'),
                        'phone_number' => $checkoutData['bill_phone_number'] ?? ($checkoutData['ship_phone_number'] ?? null),
                        'email_id' => $checkoutData['email_id'] ?? ($checkoutData['bill_email'] ?? $checkoutData['ship_email'] ?? null),
                        'country' => $checkoutData['bill_country'] ?? null,
                        'full_address' => $checkoutData['bill_full_address'] ?? null,
                        'apartment' => $checkoutData['bill_apartment'] ?? null,
                        'city_name' => $checkoutData['bill_city_name'] ?? null,
                        'state' => $checkoutData['bill_state'] ?? null,
                        'pin_code' => $checkoutData['bill_pin_code'] ?? null,
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
            /** Find order status id */
            $orderStatus = OrderStatus::where('status_name', 'New')->first();
            /* Create the order */
            $order = Orders::create([
                'order_date' => now()->setTimezone('Asia/Kolkata'),
                'order_id' => $orderId,
                'grand_total_amount' => $checkoutData['grand_total_amount'] ?? 0,
                'payment_mode' => $checkoutData['payment_type'] ?? null,
                'pick_up_status' => $checkoutData['pick_up_status'] ?? null,
                'customer_id' => $customerId,
                'shipping_address_id' => $shippingAddressId ?? null,
                'billing_address_id' => $billingAddressId ?? null,
                'order_status_id' => $orderStatus->id ?? null,

            ]);
            $this->trackCouponUsage($order);
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
            }
            $paymentType = $checkoutData['payment_type'] ?? null;
            if ($paymentType && ($paymentType == 'Cash on Delivery' || $paymentType == 'Razorpay')) {
                if ($paymentType == 'Cash on Delivery') {
                    $order->update(['order_status_comment' => 'complete_order']);
                }
                /* Shiprocket Courier Insert data */
                $courierData = session('courierData', []);
                if (!empty($courierData)) {
                    ShiprocketCourier::create([
                        'customer_id' => $customerId,
                        'order_id' => $order->id,
                        'courier_name' => $courierData['courier_name'] ?? null,
                        'courier_id' => $courierData['courier_id'] ?? null,
                        'courier_company_id' => $courierData['courier_company_id'] ?? null,
                        'courier_shipping_rate' => $courierData['courier_shipping_rate'] ?? null,
                        'cod_charges' => $courierData['cod_charges'] ?? null,
                        'delivery_expected_date' => $courierData['delivery_expected_date'] ?? null,
                    ]);
                }
            }
            if ($paymentType && $paymentType == 'Cash on Delivery') {
                $orderDetails = Orders::with([
                    'orderStatus',
                    'shippingAddress',
                    'billingAddress',
                    'orderLines.product',
                    'orderLines.product.images'
                ])->find($order->id);
                $payment_status = "Unpaid";
                $resolvedShippingName = $checkoutData['ship_full_name']
                    ?? ($customer_address->name ?? null)
                    ?? ($shippingAddress->full_name ?? null)
                    ?? ($orderDetails->shippingAddress->full_name ?? null)
                    ?? 'Customer';

                $resolvedShippingEmail = $checkoutData['ship_email']
                    ?? ($customer_address->email ?? null)
                    ?? ($shippingAddress->email_id ?? null)
                    ?? ($orderDetails->shippingAddress->email_id ?? null)
                    ?? null;

                $resolvedShippingPhone = $checkoutData['ship_phone_number']
                    ?? ($customer_address->phone_number ?? null)
                    ?? ($shippingAddress->phone_number ?? null)
                    ?? ($orderDetails->shippingAddress->phone_number ?? null)
                    ?? null;
                $mailTo = $resolvedShippingEmail ?? ($order->customer->email ?? null);
                if ($mailTo) {
                    //Mail::to($mailTo)->queue(new OrderDetailsMail($orderDetails));
                } else {
                    Log::warning('No email found to send OrderDetailsMail', [
                        'order_id' => $order->id,
                        'resolved_email' => $resolvedShippingEmail,
                        'customer_email' => $order->customer->email ?? null
                    ]);
                }
                Mail::to('akshat@gdsons.co.in')->queue(new OrderDetailsMail($orderDetails, $resolvedShippingName));
                $waPayload = $checkoutData;
                $waPayload['ship_full_name'] = $resolvedShippingName;
                $waPayload['ship_email'] = $resolvedShippingEmail;
                $waPayload['ship_phone_number'] = $resolvedShippingPhone;
                $waPayload['delivery_expected_date'] = $courierData['delivery_expected_date'] ?? now()->setTimezone('Asia/Kolkata')->addDays(2)->format('d-m-Y');
                $this->sendWhatsAppNotifications($orderId, $payment_status, $waPayload);
                /* Clear session data */
                session()->forget(['checkout_data', 'cart_items', 'cart', 'courierData']);
                session()->save();
            }
            DB::commit();
            $token = Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);
            session()->save();
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

    protected function trackCouponUsage(Orders $order)
    {
        if (session()->has('applied_coupon')) {
            $appliedCoupon = session('applied_coupon');
            if (isset($appliedCoupon['id'])) {
                $coupon = DiscountCode::find($appliedCoupon['id']);
                if ($coupon) {
                    $customer = Auth::guard('customer')->user();
                    $customerId = $customer ? $customer->id : null;
                    $userIp = request()->ip();
                    $coupon->markAsUsed($customerId, $userIp);
                }
            }
            $order->coupon_code = $appliedCoupon['code'];
            $order->coupon_discount_amount = $appliedCoupon['discount_amount'];
            $order->save();
            session()->forget('applied_coupon');
        }
    }

    protected function sendWhatsAppNotifications($orderId, $payment_status, array $checkoutData)
    {
        $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY';
        Log::info('sendWhatsAppNotifications Function', [
            'order_id'        => $orderId,
            'payment_status'  => $payment_status,
            'checkout_data'   => $checkoutData,
            'delivery_date'   =>  $checkoutData['delivery_expected_date'] ?? null,
        ]);
        $customerPhone = $checkoutData['ship_phone_number'] ?? null;
        $isValidPhone = $customerPhone && preg_match('/^[0-9]{10}$/', $customerPhone);
        if ($isValidPhone) {
            $this->sendWhatsAppMessage([
                'apiKey' => $apiKey,
                'campaignName' => 'Order Confirmation to Customer',
                'destination' => $customerPhone,
                'userName' => $checkoutData['ship_full_name'],
                'templateParams' => [
                    $checkoutData['ship_full_name'],
                    $orderId,
                    $checkoutData['grand_total_amount'],
                    $checkoutData['delivery_expected_date'],
                ],
                'source' => 'new-landing-page form',
                'paramsFallbackValue' => ['FirstName' => 'user']
            ]);
        } else {
            Log::warning('WhatsApp not sent to customer: invalid phone number', [
                'invalid_phone' => $customerPhone
            ]);
        }
        /* ----------------------------------------
        Always Send Admin Notification
        ---------------------------------------- */
        $this->sendWhatsAppMessage([
            'apiKey' => $apiKey,
            'campaignName' => 'Order Confirmation to Admin',
            'destination' => '9935070000',
            'userName' => 'Akshat Agrawal',
            'templateParams' => [
                $orderId,
                $checkoutData['grand_total_amount'] . ' (' . $checkoutData['payment_type'] . ')',
                $payment_status
            ],
            'source' => 'new-landing-page form',
            'paramsFallbackValue' => ['FirstName' => 'user']
        ]);
    }

    protected function sendWhatsAppMessage(array $data)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://backend.aisensy.com/campaign/t1/api/v2', [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $data
            ]);

            Log::info('WhatsApp notification sent', [
                'campaign' => $data['campaignName'],
                'destination' => $data['destination'],
                'response' => $response->getBody()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification', [
                'campaign' => $data['campaignName'],
                'destination' => $data['destination'],
                'error' => $e->getMessage()
            ]);
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
                'orderLines.product.images',
                'shiprocketCourier'
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
            'orderLines.product.images',
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
            'shiprocketCourier',
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

    public function handleOTPVerificationModal(Request $request)
    {
        $mobile = $request->input('mobile_number');
        $form = '
        <div class="pt-2 pb-4">
            <form method="POST"
                action="' . route('product-enquiry-modal-form.submit') . '"
                accept-charset="UTF-8"
                enctype="multipart/form-data"
                id="productEnquiryForm">
                ' . csrf_field() . '
                <div class="text-center"> 
                    <h2 class="text-2xl font-bold text-primary-navy">
                        OTP Verification
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Enter the 6-digit OTP we sent to Your Whatapp number
                        <span class="font-semibold text-gray-700">
                            ' . $mobile . '
                        </span>
                    </p>
                </div>
                <div class="mb-3">
                    <label for="otp"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Enter OTP <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        id="otp"
                        name="otp"
                        maxlength="6"
                        autocomplete="off"
                        placeholder="••••••"
                        class="w-full rounded border border-gray-200 bg-white-50 px-3 py-2 text-center text-2xl tracking-[10px] text-gray-800 outline-none transition duration-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">

                </div>
                <div class="flex items-center justify-between text-sm mb-3">
                    <span class="text-gray-500">
                        Didn’t receive OTP?
                    </span>
                    <button type="button" class="font-semibold text-blue-600 transition hover:text-blue-700 resend-otp-btn" data-mobile="' . $mobile . '"
                    data-route="' .route('checkout.otp.resend') .'">
                        Resend OTP
                    </button>

                </div>
                <div class="mb-3">
                    <button type="submit"
                        class="w-full rounded bg-primary-teal px-3 py-3 text-[16px] text-white shadow-lg transition duration-300 hover:scale-[1.01] hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                        Verify OTP & Place Order
                    </button>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Form created successfully',
            'form' => $form,
        ]);
    }

    public function handleOTPResend(Request $request)
    {
        $mobile = $request->input('mobile_number');
        $cacheKey = 'otp_resend_' . $mobile;
        $attempts = Cache::get($cacheKey, 0);
        /* Max 3 attempts */
        if ($attempts >= 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maximum resend limit reached. Please try again after 1 hour.'
            ], 429);
        }
        Cache::put($cacheKey, $attempts + 1, now()->addHour());
        Log::info('Resending OTP to mobile number: ' . $mobile);
        return response()->json([
            'status' => 'success',
            'message' => 'OTP resent successfully to ' . $mobile,
            'remaining_attempts' => 3 - ($attempts + 1)
        ]);
    }
}
