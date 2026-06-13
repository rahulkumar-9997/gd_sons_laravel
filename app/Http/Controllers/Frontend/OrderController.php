<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
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
        $request->validate([
            'pick_up_status'        => 'required|string|in:pick_up_online,pick_up_offline',
            'payment_type'          => 'required|string|in:Cash on Delivery,Razorpay,Pick Up From Store',
            'product_id'            => 'required|array|min:1',
            'product_id.*'          => 'required|integer|exists:products,id',
            'cart_quantity'         => 'required|array|min:1',
            'cart_quantity.*'       => 'required|integer|min:1',
            'cart_offer_rate'       => 'required|array|min:1',
            'cart_offer_rate.*'     => 'required|numeric|min:0',
            'total_price'           => 'required|array|min:1',
            'total_price.*'         => 'required|numeric|min:0',
            'grand_total_amount'    => 'required|numeric|min:0',
        ]);

        /* ── Pick-up / shipping branch validation */
        if ($request->pick_up_status === 'pick_up_online') {
            $addressExists = filled($request->customer_address_id);
            if ($addressExists) {
                $request->validate([
                    'customer_address_id'    => 'required|integer|exists:addresses,id',
                    'same_ship_bill_address' => 'nullable|boolean',
                ] + $this->getBillingValidation());
            } else {
                $request->validate([
                    'ship_full_name'    => 'required|string|max:255',
                    'ship_phone_number' => 'required|digits:10',
                    'ship_email'        => 'required|email|max:255',
                    'ship_country'      => 'required|string',
                    'ship_full_address' => 'required|string|max:500',
                    'ship_city_name'    => 'required|string|max:255',
                    'ship_state'        => 'required|string',
                    'ship_pin_code'     => 'required|digits:6',
                ]);
            }
            if ($request->payment_type !== 'Pick Up From Store')
            {
                $request->validate([
                    'courier_name'           => 'required|string|max:255',
                    'courier_id'             => 'required|string|max:100',
                    'courier_company_id'     => 'required|integer',
                    'shipping_rate'          => 'required|numeric|min:0',
                    'cod_charges'            => 'nullable|numeric|min:0',
                    'delivery_expected_date' => 'required|string|max:50',
                ]);
            }
        } 
        $productIds  = $request->input('product_id', []);
        $quantities  = $request->input('cart_quantity', []);
        $prices      = $request->input('cart_offer_rate', []);
        $totalPrices = $request->input('total_price', []);

        if (
            count($productIds) !== count($quantities) ||
            count($productIds) !== count($prices) ||
            count($productIds) !== count($totalPrices)
        ) {
            return response()->json([
                'status'  => false,
                'message' => 'Cart data arrays must have the same length.',
            ], 422);
        }

        $cartItems = [];
        foreach ($productIds as $index => $productId) {
            $cartItems[] = [
                'product_id'  => $productId,
                'quantity'    => $quantities[$index],
                'price'       => $prices[$index],
                'total_price' => $totalPrices[$index],
            ];
        }

        if (empty($cartItems)) {
            return response()->json(['status' => false, 'message' => 'Cart is empty.'], 422);
        }

        /* Courier data */
        $courierData = [];
        if ($request->pick_up_status === 'pick_up_online') {
            $courierData = [
                'courier_name'          => $request->input('courier_name'),
                'courier_id'            => $request->input('courier_id'),
                'courier_company_id'    => $request->input('courier_company_id'),
                'courier_shipping_rate' => $request->input('shipping_rate'),
                'cod_charges'           => $request->input('cod_charges'),
                'delivery_expected_date' => $request->input('delivery_expected_date'),
            ];
        }

        session([
            'checkout_data' => $request->all(),
            'cart_items'    => $cartItems,
            'courierData'   => $courierData,
        ]);
        session()->save();
        /* ── Payment routing */
        $paymentType = $request->input('payment_type');
        if ($paymentType === 'Cash on Delivery' || $paymentType === 'Pick Up From Store') {
            try {
                $response = $this->storeOrderAfterPayment($request);

                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    $responseData = $response->getData(true);
                } else {
                    $responseData = (array) $response;
                }
                if (isset($responseData['error']) || !isset($responseData['order_id'])) {
                    return response()->json([
                        'status' => false, 
                        'message' => $responseData['message'] ?? 'Order creation failed.'
                    ], 500);
                }
                return response()->json([
                   'status'       => true,
                    'payment_type' => $paymentType,
                    'message'      => 'Order placed successfully!',
                    'redirect_url' => $responseData['redirect_url'] ?? null,
                ]);
            } catch (\Exception $e) {
               Log::error('COD/PickUp order creation failed: ' . $e->getMessage());
                return response()->json(['status' => false, 'message' => 'Order creation failed.'], 500);
            }
        }

        if ($paymentType === 'Razorpay') {
            try {
                $orderResponse = $this->storeOrderAfterPayment($request);

                if ($orderResponse instanceof \Illuminate\Http\JsonResponse) {
                    $responseData = $orderResponse->getData(true);
                } elseif (is_array($orderResponse)) {
                    $responseData = $orderResponse;
                } else {
                    $responseData = (array) $orderResponse;
                }

                if (!isset($responseData['order_id'])) {
                    Log::error('Order creation failed – no order_id returned', ['response' => $responseData]);
                    return response()->json(['status' => false, 'message' => 'Order creation failed.'], 500);
                }
                $order = Orders::findOrFail($responseData['order_id']);
                $grandTotal = (float) $request->input('grand_total_amount');
                if ($grandTotal <= 0) {
                    $order->delete();
                    return response()->json(['status' => false, 'message' => 'Invalid order amount.'], 422);
                }

                $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                $razorpayAmount = (int) round($grandTotal * 100);
                $razorpayOrder = $api->order->create([
                    'receipt'         => 'rcpt_' . $order->id,
                    'amount'          => $razorpayAmount,
                    'currency'        => 'INR',
                    'payment_capture' => 1,
                    'notes'           => [
                        'order_db_id'    => $order->id,
                        'actual_amount'  => $grandTotal,
                    ],
                ]);

                Log::info('Razorpay order created', [
                    'razorpay_order_id' => $razorpayOrder->id,
                    'order_db_id'       => $order->id,
                    'amount_paise'      => $razorpayAmount,
                ]);

                $user = auth('customer')->user();
                return response()->json([
                    'status'             => true,
                    'payment_type'       => $paymentType,
                    'order_id'           => $razorpayOrder->id,
                    'amount'             => $razorpayAmount,
                    'actual_amount'      => $grandTotal,
                    'name'               => $user->name ?? $request->ship_full_name    ?? 'Customer',
                    'email'              => $user->email ?? $request->ship_email         ?? '',
                    'contact'            => $user->phone_number ?? $request->ship_phone_number  ?? '',
                    'callback_url'       => route('razorpay.callback'),
                    'payment_failed_url' => route('payment.failed'),
                    'order_db_id'        => $order->id,
                ]);
            } catch (\Exception $e) {
                Log::error('Razorpay initiation failed: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                // if (isset($order) && $order instanceof Orders) {
                //     $order->delete();
                // }
                return response()->json(['status' => false, 'message' => 'Payment initiation failed. Please try again.'], 500);
            }
        }
        return response()->json(['status' => false, 'message' => 'Invalid payment method selected.'], 422);
    }

   
    /* RAZORPAY CALLBACK  (client-side verify after rzp.on handler) */

    public function handleRazorpayCallback(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
            'order_db_id'         => 'required|integer',
        ]);

        $input=$request->all();
        $checkoutData = session('checkout_data');
        Log::info('Razorpay callback received', ['order_db_id' => $input['order_db_id']]);
        DB::beginTransaction();
        try {
            $expectedSignature = hash_hmac(
                'sha256',
                $input['razorpay_order_id'] . '|' . $input['razorpay_payment_id'],
                config('services.razorpay.secret')
            );

            if (!hash_equals($expectedSignature, $input['razorpay_signature'])) {
                throw new \Exception('Payment signature verification failed.');
            }

            /* ── Fetch payment from Razorpay to confirm capture */
            $api     = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $payment = $api->payment->fetch($input['razorpay_payment_id']);
            if ($payment->status !== 'captured') {
                throw new \Exception('Payment not captured. Status: ' . $payment->status);
            }
            $order = Orders::findOrFail($input['order_db_id']);
            $order->update([
                'razorpay_payment_id'  => $input['razorpay_payment_id'],
                'razorpay_order_id'    => $input['razorpay_order_id'],
                'razorpay_signature_id' => $input['razorpay_signature'],
                'razorpay_method'      => 'Razorpay',
                'payment_received'     => true,
                'payment_status'       => 'Paid',
                'order_status_comment' => 'complete_order',
            ]);

            /*  Decrement inventory */
            foreach ($order->orderLines as $line) {
                Inventory::where('product_id', $line->product_id)
                    ->where('mrp', $line->price)
                    ->decrement('stock_quantity', $line->quantity);
            }
            /* Send order-confirmation email */
            $orderDetails = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images',
            ])->find($order->id);

            $shipping      = $orderDetails->shippingAddress;
            $customerName  = $shipping->full_name  ?? 'Customer';
            $customerPhone = $shipping->phone_number ?? '';
            $customerEmail = $shipping->email_id   ?? '';

            $courierData = session('courierData', []);
            $waPayload   = array_merge($checkoutData ?? [], [
                'ship_full_name'        => $customerName,
                'ship_email'            => $customerEmail,
                'ship_phone_number'     => $customerPhone,
                'delivery_expected_date' => $courierData['delivery_expected_date']
                    ?? now()->setTimezone('Asia/Kolkata')->addDays(2)->format('d-m-Y'),
            ]);
            Mail::to('akshat.gd@gmail.com')->queue(new OrderDetailsMail($orderDetails, $customerName));
            $this->sendWhatsAppNotifications($order->order_id, 'Paid', $waPayload);
            /* Clear session */
            session()->forget(['checkout_data', 'cart_items', 'cart', 'courierData']);
            DB::commit();
            $token=Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);
            return response()->json([
                'success'      => true,
                'redirect_url' => route('order.success', ['order_id' => $encodedOrderId, 'token' => $token]),
                'message'      => 'Payment successful! Order confirmed.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay callback error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed. Contact support with payment ID: '
                    . ($input['razorpay_payment_id'] ?? 'N/A'),
            ], 400);
        }
    }

    /* RAZORPAY WEBHOOK  (server-to-server, bypasses CSRF) */
    public function handleWebhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        /* Signature verification */
        if ($webhookSecret) {
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
            if (!hash_equals($expectedSignature, (string) $signature)) {
                Log::warning('Razorpay webhook: invalid signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }
        $event = json_decode($payload, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Razorpay webhook: malformed JSON payload');
            return response()->json(['error' => 'Malformed payload'], 400);
        }
        $eventName = $event['event'] ?? '';
        Log::info('Razorpay webhook received', ['event' => $eventName]);
        /*  Route by event type */
        match ($eventName) {
            'payment.captured'     => $this->webhookPaymentCaptured($event),
            'payment.failed'       => $this->webhookPaymentFailed($event),
            'order.paid'           => $this->webhookOrderPaid($event),
            'refund.created'       => $this->webhookRefundCreated($event),
            'refund.processed'     => $this->webhookRefundProcessed($event),
            default                => Log::info('Razorpay webhook: unhandled event', ['event' => $eventName]),
        };

        return response()->json(['status' => 'ok'], 200);
    }

    /* Webhook sub-handlers */
   
    private function webhookPaymentCaptured(array $event): void
    {
        $paymentEntity = $event['payload']['payment']['entity'] ?? [];
        $razorpayPaymentId = $paymentEntity['id']       ?? null;
        $razorpayOrderId   = $paymentEntity['order_id'] ?? null;
        $orderDbId         = $paymentEntity['notes']['order_db_id'] ?? null;

        if (!$razorpayPaymentId || !$razorpayOrderId || !$orderDbId) {
            Log::warning('Razorpay webhook payment.captured: missing fields', $paymentEntity);
            return;
        }
        $order = Orders::find($orderDbId);
        if (!$order) {
            Log::warning('Razorpay webhook payment.captured: order not found', ['order_db_id' => $orderDbId]);
            return;
        }
        if ($order->payment_received) {
            Log::info('Razorpay webhook payment.captured: already processed', ['order_db_id' => $orderDbId]);
            return;
        }
        DB::beginTransaction();
        try {
            $order->update([
                'razorpay_payment_id'   => $razorpayPaymentId,
                'razorpay_order_id'     => $razorpayOrderId,
                'razorpay_method'       => 'Razorpay',
                'payment_received'      => true,
                'payment_status'        => 'Paid',
                'order_status_comment'  => 'complete_order',
            ]);
            foreach ($order->orderLines as $line) {
                Inventory::where('product_id', $line->product_id)
                    ->where('mrp', $line->price)
                    ->decrement('stock_quantity', $line->quantity);
            }
            $orderDetails = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images',
            ])->find($order->id);
            $customerName = $orderDetails->shippingAddress->full_name ?? 'Customer';
            Mail::to('akshat.gd@gmail.com')->queue(new OrderDetailsMail($orderDetails, $customerName));
            DB::commit();
            Log::info('Razorpay webhook payment.captured: order updated', ['order_db_id' => $orderDbId]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay webhook payment.captured error: ' . $e->getMessage(), ['order_db_id' => $orderDbId]);
        }
    }

    /**
     * payment.failed
     * Fired when a payment attempt fails on Razorpay's end.
     */
    private function webhookPaymentFailed(array $event): void
    {
        $paymentEntity     = $event['payload']['payment']['entity'] ?? [];
        $razorpayPaymentId = $paymentEntity['id']       ?? null;
        $razorpayOrderId   = $paymentEntity['order_id'] ?? null;
        $orderDbId         = $paymentEntity['notes']['order_db_id'] ?? null;
        $failureReason     = $paymentEntity['error_description'] ?? 'Payment failed';
        if (!$orderDbId) {
            Log::warning('Razorpay webhook payment.failed: missing order_db_id', $paymentEntity);
            return;
        }
        $order = Orders::find($orderDbId);
        if (!$order) {
            Log::warning('Razorpay webhook payment.failed: order not found', ['order_db_id' => $orderDbId]);
            return;
        }
        DB::beginTransaction();
        try {
            $order->update([
                'razorpay_payment_id'  => $razorpayPaymentId,
                'razorpay_order_id'    => $razorpayOrderId,
                'payment_received'     => false,
                'payment_status'       => 'Failed',
                'razorpay_method'      => 'Razorpay',
                'failure_reason'       => $failureReason,
            ]);

            $this->sendPaymentFailedNotification($order, $failureReason);

            DB::commit();
            Log::warning('Razorpay webhook payment.failed: order marked failed', ['order_db_id' => $orderDbId]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay webhook payment.failed error: ' . $e->getMessage(), ['order_db_id' => $orderDbId]);
        }
    }

    /**
     * order.paid
     * Alternative success signal – fired when an order transitions to "paid".
     * Same idempotency guard as payment.captured.
     */
    private function webhookOrderPaid(array $event): void
    {
        $orderEntity   = $event['payload']['order']['entity'] ?? [];
        $orderDbId     = $orderEntity['notes']['order_db_id'] ?? null;
        $razorpayOrderId = $orderEntity['id'] ?? null;
        $paymentEntity     = $event['payload']['payment']['entity'] ?? [];
        $razorpayPaymentId = $paymentEntity['id'] ?? null;
        if (!$orderDbId) {
            Log::warning('Razorpay webhook order.paid: missing order_db_id', $orderEntity);
            return;
        }
        $order = Orders::find($orderDbId);
        if (!$order || $order->payment_received) {
            return; 
        }

        DB::beginTransaction();
        try {
            $order->update([
                'razorpay_payment_id'  => $razorpayPaymentId,
                'razorpay_order_id'    => $razorpayOrderId,
                'razorpay_method'      => 'Razorpay',
                'payment_received'     => true,
                'payment_status'       => 'Paid',
                'order_status_comment' => 'complete_order',
            ]);
            DB::commit();
            Log::info('Razorpay webhook order.paid: order updated', ['order_db_id' => $orderDbId]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay webhook order.paid error: ' . $e->getMessage());
        }
    }
    /**
     * refund.created  – log for now; extend as needed.
     */
    private function webhookRefundCreated(array $event): void
    {
        $refundEntity = $event['payload']['refund']['entity'] ?? [];
        Log::info('Razorpay webhook refund.created', [
            'refund_id'  => $refundEntity['id'] ?? null,
            'payment_id' => $refundEntity['payment_id'] ?? null,
            'amount'     => $refundEntity['amount'] ?? null,
        ]);
        // TODO: update order refund status / notify customer
    }

    /**
     * refund.processed – log for now; extend as needed.
     */
    private function webhookRefundProcessed(array $event): void
    {
        $refundEntity = $event['payload']['refund']['entity'] ?? [];
        Log::info('Razorpay webhook refund.processed', [
            'refund_id'  => $refundEntity['id'] ?? null,
            'payment_id' => $refundEntity['payment_id'] ?? null,
        ]);
        // TODO: mark order as refunded
    }

    // =========================================================================
    // PAYMENT FAILED  (client-side handler called from JS on rzp failure)
    // =========================================================================

    public function handlePaymentFailed(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id'   => 'required|string',
            'order_db_id'         => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $order = Orders::findOrFail($request->input('order_db_id'));
            $failureReason = 'Payment declined';
            if ($request->filled('razorpay_payment_id')) {
                try {
                    $api     = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                    $payment = $api->payment->fetch($request->razorpay_payment_id);
                    $failureReason = $payment->error_description ?? $failureReason;
                } catch (\Exception $ex) {
                    Log::warning('Could not fetch Razorpay payment details: ' . $ex->getMessage());
                }
            }
            $order->update([
                'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                'razorpay_order_id'   => $request->input('razorpay_order_id'),
                'payment_received'    => false,
                'payment_status'      => 'Failed',
                'razorpay_method'     => 'Razorpay',
                'failure_reason'      => $failureReason,
            ]);
            $this->sendPaymentFailedNotification($order, $failureReason);
            DB::commit();
            return response()->json([
                'success'      => true,
                'message'      => 'Payment failed status updated.',
                'redirect_url' => route('checkout'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment failed handler error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /* STORE ORDER */
    public function storeOrderAfterPayment(Request $request)
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return response()->json(['message' => 'No checkout data found in session.'], 400);
        }
        if (auth()->guard('customer')->check()) {
            $customerId = auth('customer')->id();
        } else {
            $email  = $checkoutData['ship_email'] ?? $checkoutData['bill_email']        ?? null;
            $phone  = $checkoutData['ship_phone_number'] ?? $checkoutData['bill_phone_number'] ?? null;
            $name   = $checkoutData['ship_full_name']    ?? $checkoutData['bill_full_name']    ?? 'Customer';

            $customer = Customer::where(function ($q) use ($email, $phone) {
                if ($email) $q->orWhere('email', $email);
                if ($phone) $q->orWhere('phone_number', $phone);
            })->first();

            $customerId = $customer
                ? $customer->id
                : Customer::create([
                    'email'        => $email,
                    'name'         => $name,
                    'phone_number' => $phone,
                    'password'     => Hash::make(Str::random(8)),
                ])->id;
        }

        DB::beginTransaction();
        try {
            $pickUpStatus     = $checkoutData['pick_up_status'] ?? null;
            $shippingAddressId = null;
            $billingAddressId  = null;
            $shippingAddress   = null;
            $customer_address  = null;

            if ($pickUpStatus === 'pick_up_online') {

                if (filled($checkoutData['customer_address_id'] ?? null)) {
                    $customer_address = Address::where('id', $checkoutData['customer_address_id'])
                        ->where('customer_id', $customerId)
                        ->first();

                    $shippingAddress = ShippingAddress::create([
                        'customer_id'  => $customerId,
                        'full_name'    => $customer_address->name          ?? $customer_address->full_name ?? 'Customer',
                        'phone_number' => $customer_address->phone_number  ?? null,
                        'email_id'     => $customer_address->email         ?? null,
                        'country'      => $customer_address->country       ?? null,
                        'full_address' => $customer_address->address       ?? null,
                        'apartment'    => $customer_address->apartment     ?? null,
                        'city_name'    => $customer_address->city          ?? null,
                        'state'        => $customer_address->state         ?? null,
                        'pin_code'     => $customer_address->zip_code      ?? null,
                    ]);
                } else {
                    Address::create([
                        'customer_id'  => $customerId,
                        'name'         => $checkoutData['ship_full_name']    ?? 'Customer',
                        'phone_number' => $checkoutData['ship_phone_number'] ?? null,
                        'country'      => $checkoutData['ship_country']      ?? null,
                        'address'      => $checkoutData['ship_full_address'] ?? null,
                        'apartment'    => $checkoutData['ship_apartment']    ?? null,
                        'city'         => $checkoutData['ship_city_name']    ?? null,
                        'state'        => $checkoutData['ship_state']        ?? null,
                        'zip_code'     => $checkoutData['ship_pin_code']     ?? null,
                    ]);

                    $shippingAddress = ShippingAddress::create([
                        'customer_id'  => $customerId,
                        'full_name'    => $checkoutData['ship_full_name']    ?? 'Customer',
                        'phone_number' => $checkoutData['ship_phone_number'] ?? null,
                        'email_id'     => $checkoutData['ship_email']        ?? null,
                        'country'      => $checkoutData['ship_country']      ?? null,
                        'full_address' => $checkoutData['ship_full_address'] ?? null,
                        'apartment'    => $checkoutData['ship_apartment']    ?? null,
                        'city_name'    => $checkoutData['ship_city_name']    ?? null,
                        'state'        => $checkoutData['ship_state']        ?? null,
                        'pin_code'     => $checkoutData['ship_pin_code']     ?? null,
                    ]);
                }

                $shippingAddressId = $shippingAddress->id;

                if (!empty($checkoutData['same_ship_bill_address'])) {
                    $billingAddress = BillingAddress::create([
                        'customer_id'  => $customerId,
                        'full_name'    => $checkoutData['bill_full_name']    ?? $checkoutData['ship_full_name']    ?? 'Customer',
                        'phone_number' => $checkoutData['bill_phone_number'] ?? $checkoutData['ship_phone_number'] ?? null,
                        'email_id'     => $checkoutData['bill_email']        ?? $checkoutData['ship_email']        ?? null,
                        'country'      => $checkoutData['bill_country']      ?? null,
                        'full_address' => $checkoutData['bill_full_address'] ?? null,
                        'apartment'    => $checkoutData['bill_apartment']    ?? null,
                        'city_name'    => $checkoutData['bill_city_name']    ?? null,
                        'state'        => $checkoutData['bill_state']        ?? null,
                        'pin_code'     => $checkoutData['bill_pin_code']     ?? null,
                    ]);
                    $billingAddressId = $billingAddress->id;
                }
            }

            // ── Generate unique order_id ───────────────────────────────────────
            $nextSerial = ((int) (Orders::max('order_id') ?? 0)) + 1;
            $orderId    = str_pad($nextSerial, 10, '0', STR_PAD_LEFT);

            $orderStatus = OrderStatus::firstOrCreate(['status_name' => 'New']);

            $order = Orders::create([
                'order_date'         => now()->setTimezone('Asia/Kolkata'),
                'order_id'           => $orderId,
                'grand_total_amount' => $checkoutData['grand_total_amount'] ?? 0,
                'payment_mode'       => $checkoutData['payment_type']       ?? null,
                'pick_up_status'     => $pickUpStatus,
                'customer_id'        => $customerId,
                'shipping_address_id' => $shippingAddressId,
                'billing_address_id' => $billingAddressId,
                'order_status_id'    => $orderStatus->id,
            ]);

            $this->trackCouponUsage($order);

            // ── Order lines ───────────────────────────────────────────────────
            foreach (session('cart_items', []) as $item) {
                OrderLines::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $item['quantity'],
                    'price'       => $item['price'],
                    'total_price' => $item['total_price'],
                ]);
            }

            // ── Courier / shiprocket ──────────────────────────────────────────
            $paymentType = $checkoutData['payment_type'] ?? null;
            $courierData = session('courierData', []);

            if (!empty($courierData)) {
                ShiprocketCourier::create([
                    'customer_id'           => $customerId,
                    'order_id'              => $order->id,
                    'courier_name'          => $courierData['courier_name']          ?? null,
                    'courier_id'            => $courierData['courier_id']            ?? null,
                    'courier_company_id'    => $courierData['courier_company_id']    ?? null,
                    'courier_shipping_rate' => $courierData['courier_shipping_rate'] ?? null,
                    'cod_charges'           => $courierData['cod_charges']           ?? null,
                    'delivery_expected_date' => $courierData['delivery_expected_date'] ?? null,
                ]);
            }

            // ── COD / Pick-up: mark complete and notify ───────────────────────
            if ($paymentType === 'Cash on Delivery' || $paymentType === 'Pick Up From Store') {
                $order->update(['order_status_comment' => 'complete_order']);

                $orderDetails = Orders::with([
                    'orderStatus',
                    'shippingAddress',
                    'billingAddress',
                    'orderLines.product',
                    'orderLines.product.images',
                ])->find($order->id);

                $resolvedName  = $checkoutData['ship_full_name']    ?? $customer_address->name          ?? $shippingAddress->full_name  ?? 'Customer';
                $resolvedEmail = $checkoutData['ship_email']        ?? $customer_address->email         ?? $shippingAddress->email_id   ?? null;
                $resolvedPhone = $checkoutData['ship_phone_number'] ?? $customer_address->phone_number  ?? $shippingAddress->phone_number ?? null;

                Mail::to('akshat@gdsons.co.in')->queue(new OrderDetailsMail($orderDetails, $resolvedName));

                $waPayload = array_merge($checkoutData, [
                    'ship_full_name'         => $resolvedName,
                    'ship_email'             => $resolvedEmail,
                    'ship_phone_number'      => $resolvedPhone,
                    'delivery_expected_date' => $courierData['delivery_expected_date']
                        ?? now()->setTimezone('Asia/Kolkata')->addDays(2)->format('d-m-Y'),
                ]);

                $this->sendWhatsAppNotifications($orderId, 'Unpaid', $waPayload);

                session()->forget(['checkout_data', 'cart_items', 'cart', 'courierData']);
                session()->save();
            }

            DB::commit();

            $token          = Str::random(32);
            $encodedOrderId = Crypt::encrypt($order->id);
            session(['order_token' => $token]);
            session()->save();

            return response()->json([
                'message'      => 'Order stored successfully!',
                'order_id'     => $order->id,
                'redirect_url' => route('order.success', ['order_id' => $encodedOrderId, 'token' => $token]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('storeOrderAfterPayment failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json(['message' => 'Failed to store order.', 'error' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    protected function trackCouponUsage(Orders $order): void
    {
        if (!session()->has('applied_coupon')) return;

        $applied = session('applied_coupon');
        if (isset($applied['id'])) {
            $coupon = DiscountCode::find($applied['id']);
            if ($coupon) {
                $customer   = Auth::guard('customer')->user();
                $customerId = $customer?->id;
                $coupon->markAsUsed($customerId, request()->ip());
            }
        }

        $order->coupon_code            = $applied['code']            ?? null;
        $order->coupon_discount_amount = $applied['discount_amount'] ?? 0;
        $order->save();

        session()->forget('applied_coupon');
    }

    protected function sendPaymentFailedNotification(Orders $order, string $reason): void
    {
        try {
            $customerEmail = $order->customer->email ?? null;
            $customerName  = $order->customer->name  ?? 'Customer';

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
            Log::error('Failed to send PaymentFailedMail', [
                'order_id' => $order->id ?? null,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    private function getBillingValidation(): array
    {
        return [
            'bill_full_name'    => 'nullable|required_if:same_ship_bill_address,1|string|max:255',
            'bill_phone_number' => 'nullable|required_if:same_ship_bill_address,1|digits:10',
            'bill_country'      => 'nullable|required_if:same_ship_bill_address,1',
            'bill_full_address' => 'nullable|required_if:same_ship_bill_address,1',
            'bill_city_name'    => 'nullable|required_if:same_ship_bill_address,1|string',
            'bill_state'        => 'nullable|required_if:same_ship_bill_address,1',
            'bill_pin_code'     => 'nullable|required_if:same_ship_bill_address,1|digits:6',
        ];
    }

    protected function sendWhatsAppNotifications(string $orderId, string $payment_status, array $checkoutData): void
    {
        $apiKey       = config('services.aisensy.api_key'); // move to config!
        $customerPhone = $checkoutData['ship_phone_number'] ?? null;

        if ($customerPhone && preg_match('/^[0-9]{10}$/', $customerPhone)) {
            $this->sendWhatsAppMessage([
                'apiKey'         => $apiKey,
                'campaignName'   => 'Order Confirmation to Customer',
                'destination'    => $customerPhone,
                'userName'       => $checkoutData['ship_full_name'] ?? 'Customer',
                'templateParams' => [
                    $checkoutData['ship_full_name']         ?? 'Customer',
                    $orderId,
                    $checkoutData['grand_total_amount']     ?? 0,
                    $checkoutData['delivery_expected_date'] ?? '',
                ],
                'source'             => 'checkout',
                'paramsFallbackValue' => ['FirstName' => 'user'],
            ]);
        }

        $this->sendWhatsAppMessage([
            'apiKey'         => $apiKey,
            'campaignName'   => 'Order Confirmation to Admin',
            'destination'    => '9935070000',
            'userName'       => 'Akshat Agrawal',
            'templateParams' => [
                $orderId,
                ($checkoutData['grand_total_amount'] ?? 0) . ' (' . ($checkoutData['payment_type'] ?? '') . ')',
                $payment_status,
            ],
            'source'             => 'checkout',
            'paramsFallbackValue' => ['FirstName' => 'user'],
        ]);
    }

    protected function sendWhatsAppMessage(array $data): void
    {
        try {
            $client   = new \GuzzleHttp\Client();
            $response = $client->post('https://backend.aisensy.com/campaign/t1/api/v2', [
                'headers' => ['Content-Type' => 'application/json'],
                'json'    => $data,
            ]);
            Log::info('WhatsApp sent', ['campaign' => $data['campaignName'], 'destination' => $data['destination']]);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', ['campaign' => $data['campaignName'], 'error' => $e->getMessage()]);
        }
    }

    // =========================================================================
    // VIEWS
    // =========================================================================

    public function showOrderSuccess(Request $request)
    {
        try {
            $orderId     = Crypt::decrypt($request->input('order_id'));
            $sessionToken = session('order_token');

            if ($request->input('token') !== $sessionToken) {
                abort(403, 'Unauthorized access.');
            }

            $order = Orders::with([
                'orderStatus',
                'shippingAddress',
                'billingAddress',
                'orderLines.product',
                'orderLines.product.images',
                'shiprocketCourier',
            ])->findOrFail($orderId);
        } catch (\Exception $e) {
            abort(403, 'Unauthorized access.');
        }

        return view('frontend.pages.order-success', compact('order'));
    }

    public function showCustomerOrder()
    {
        $order = Orders::with([
            'orderStatus',
            'shippingAddress',
            'billingAddress',
            'orderLines.product',
            'orderLines.product.images',
        ])
            ->where('customer_id', auth('customer')->id())
            ->orderByDesc('id')
            ->get();

        return view('frontend.pages.customer.orders.index', compact('order'));
    }

    public function showCustomerOrderDetails($encryptedOrderId)
    {
        $orderId    = decrypt($encryptedOrderId);
        $customerId = auth('customer')->id();

        $order = Orders::with([
            'orderStatus',
            'shippingAddress',
            'billingAddress',
            'orderLines.product',
            'orderLines.product.images',
            'shiprocketCourier',
            'orderLines.product.ProductAttributesValues' => function ($q) {
                $q->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->with(['attributeValue:id,slug'])
                    ->orderBy('id');
            },
        ])
            ->where('customer_id', $customerId)
            ->where('id', $orderId)
            ->firstOrFail();

        return view('frontend.pages.customer.orders.order-details', compact('order'));
    }

    public function showCustomerWishlist()
    {
        $wishlist = Wishlist::with([
            'product' => fn($q) => $q->with([
                'inventories'              => fn($q) => $q->orderBy('mrp')->take(1),
                'ProductImagesFront:id,product_id,image_path',
                'ProductAttributesValues'  => fn($q) => $q->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->with(['attributeValue:id,slug'])->orderBy('id'),
            ]),
            'product.images',
            'product.inventories',
        ])->where('customer_id', auth('customer')->id())->get();

        return view('frontend.pages.customer.wishlist.index', compact('wishlist'));
    }

    public function removeFromWishlist(Request $request)
    {
        try {
            $item = Wishlist::where('id', $request->wishlistid)
                ->where('customer_id', auth('customer')->id())
                ->first();

            if ($item) {
                $item->delete();
                return response()->json(['status' => 'success', 'message' => 'Item removed from wishlist.']);
            }
            return response()->json(['status' => 'error', 'message' => 'Item not found in wishlist.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    }

    public function orderParameter()
    {
        $customerId = auth('customer')->id();
        $carts      = $this->getCartWithProducts($customerId);
        return view('frontend.pages.checkout-param-page', compact('carts'));
    }

    public function pickUpStore()
    {
        $customerId    = auth('customer')->id();
        $specialOffers = getCustomerSpecialOffers();
        $carts         = $this->getCartWithProducts($customerId);
        return view('frontend.pages.pick-up-store-page', compact('carts', 'specialOffers'));
    }

    private function getCartWithProducts(int $customerId)
    {
        return Cart::where('customer_id', $customerId)
            ->with(['product' => function ($q) {
                $q->with(['category', 'images'])
                    ->leftJoin('inventories', function ($j) {
                        $j->on('products.id', '=', 'inventories.product_id')
                            ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                    })
                    ->select('products.*', 'inventories.mrp', 'inventories.purchase_rate', 'inventories.offer_rate', 'inventories.sku');
            }])
            ->get();
    }
}
