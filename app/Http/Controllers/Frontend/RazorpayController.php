<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Orders;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    public function createMagicOrder(Request $request)
    {
         $validated = $request->validate([
        'amount' => 'required|numeric|min:100',
        'currency' => 'required|string|in:INR',
        'receipt' => 'required|string|max:40',
        'line_items_total' => 'required|numeric',
        'line_items' => 'required|array',
        'cart_items' => 'sometimes|array'
    ]);

    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $razorpayOrder = $api->order->create([
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'receipt' => $validated['receipt'],
            'payment_capture' => 1,
            'notes' => [
                'line_items_total' => $validated['line_items_total'],
                'source' => 'magic_checkout'
            ]
        ]);

            // Create local order record
            // $order = Order::create([
            //     'user_id' => Auth::guard('customer')->id(),
            //     'razorpay_order_id' => $razorpayOrder->id,
            //     'amount' => $validated['amount'] / 100, // Convert back to rupees
            //     'currency' => $validated['currency'],
            //     'status' => 'created',
            //     'payment_method' => 'razorpay_magic',
            //     'items' => json_encode($validated['cart_items'] ?? [])
            // ]);

            return response()->json([
                'id' => $razorpayOrder->id,
                'order_id' => 12121,
                'amount' => $validated['amount'],
                'currency' => $validated['currency']
            ]);

        } catch (\Exception $e) {
            Log::error('Magic Checkout Order Error: ' . $e->getMessage());
            return response()->json(['error' => 'Order creation failed'], 500);
        }
    }

    public function handleMagicCallback(Request $request)
    {
        $validated = $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
            'razorpay_magic_id' => 'sometimes',
            'razorpay_magic_status' => 'sometimes'
        ]);

        try {
            
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $attributes = [
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'razorpay_order_id' => $validated['razorpay_order_id'],
                'razorpay_signature' => $validated['razorpay_signature']
            ];

            $api->utility->verifyPaymentSignature($attributes);
            $order = Orders::where('razorpay_order_id', $validated['razorpay_order_id'])
                         ->firstOrFail();

            $order->update([
                'razorpay_payment_id' => $validated['razorpay_payment_id'],
                'status' => 'paid',
                'paid_at' => now(),
                'payment_status' => 'completed'
            ]);

            // Here you would typically:
            // 1. Clear the user's cart
            // 2. Send order confirmation email
            // 3. Update inventory, etc.
            // Redirect to success page
            return redirect()->route('order.success', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            Log::error('Magic Checkout Callback Error: ' . $e->getMessage());
            if (isset($order)) {
                $order->update([
                    'status' => 'failed',
                    'payment_status' => 'failed',
                    'failure_reason' => $e->getMessage()
                ]);
            }

            return redirect()->route('order.failed');
        }
    }
}
