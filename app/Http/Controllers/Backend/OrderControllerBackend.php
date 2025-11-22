<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\ShiprocketService;
use App\Models\ShiprocketOrderResponse;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\OrderLines;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\OrderShipmentRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderControllerBackend extends Controller
{
    protected $shiprocket;
    public function __construct(ShiprocketService $shiprocket)
    {
        $this->shiprocket = $shiprocket;
    }

    public function showAllOrderList(Request $request){
        $orderStatusId = $request->query('order-status');
        if ($orderStatusId) {
            $orders = Orders::with([
                'orderStatus', 
                'customer',
                'orderLines.product',
                'shiprocketOrderResponse'
            ])
            ->where('order_status_id', $orderStatusId)
            ->orderBy('id', 'desc')
            ->get();
        } else {
            $orders = collect();
        }
        //return response()->json($orders);
        $orders_status = OrderStatus::all();
        return view('backend.manage-order.order-list', compact('orders', 'orders_status'));
       
    }

    public function orderDelete($orderId)
    {
        DB::beginTransaction();
        try {
            $order = Orders::where('id', $orderId)->first();
            if (!$order) {
                return redirect()->back()->with('error', 'Order not found.');
            }
            OrderLines::where('order_id', $order->id)->delete();
            if ($order->shipping_address_id) {
                ShippingAddress::where('id', $order->shipping_address_id)->delete();
            }
            if ($order->billing_address_id) {
                BillingAddress::where('id', $order->billing_address_id)->delete();
            }
            $order->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Order and related records deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete order. ' . $e->getMessage());
        }
    }

    public function showOrderDetails(Request $request, $id){
        $order = Orders::with([
            'customer',
            'orderStatus', 
            'shippingAddress', 
            'billingAddress', 
            'orderLines.product', 
            'orderLines.product.images'
        ])
        ->where('id', $id)
        ->first();
        //return response()->json($orders);
        return view('backend.manage-order.order-details', compact('order'));
    }

    public function updateOrderStatus(Request $request, $orderId){
        $request->validate([
            'order_status_id' => 'required|exists:order_status,id',
            'customer_id' => 'required|exists:customers,id',
        ]);
    
        DB::beginTransaction();
        try {
            $orderStatus = OrderStatus::findOrFail($request->order_status_id);
            $receiving_date = ($orderStatus->status_name == 'Delivered') ? now() : null;
    
            $existingRecord = OrderShipmentRecords::where('order_id', $orderId)
                ->where('order_status_id', $request->order_status_id)
                ->exists();
    
            if (!$existingRecord) {
                $order = Orders::findOrFail($orderId);
                $order->order_status_id = $request->order_status_id;
                $order->save();
    
                OrderShipmentRecords::create([
                    'order_id' => $order->id,
                    'order_status_id' => $request->order_status_id,
                    'customer_id' => $order->customer_id,
                    'tracking_no' => null,
                    'courier_name' => null,
                    'shipment_details' => 'Order status updated',
                    'shipment_date' => now(),
                    'receiving_date' => $receiving_date,
                ]);
    
                $message = 'Order status updated successfully and a new shipment record was added!';
            } else {
                $message = 'Order status updated, but a shipment record for this status already exists!';
            }
    
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function downloadInvoice(Request $request, $orderId){
        $order = Orders::with([
            'customer',
            'orderStatus', 
            'shippingAddress', 
            'billingAddress', 
            'orderLines.product', 
            'orderLines.product.images'
        ])->where('id', $orderId)->first();
        if (!$order) {
            abort(404, 'Order not found');
        }
        return view('backend.manage-order.download-invoice', compact('order'));
        // $pdf = app('dompdf.wrapper');
        // $pdf->loadView('backend.manage-order.download-invoice', compact('order'));
    
        //return $pdf->download('invoice_'.$order->id.'.pdf');
       // return $pdf->stream('invoice.pdf');
    }

    /*---------------------------------------------------------
         CREATE SHIPROCKET ORDER
    ----------------------------------------------------------*/
    public function createShipRocketOrder($id)
    {
        $order = Orders::with([
            'shippingAddress',
            'orderLines.product',
            'orderLines.product.images'
        ])->findOrFail($id);
        $token = $this->shiprocket->getToken();
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unable to generate Shiprocket token'
            ], 500);
        }
        Log::info("Creating Shiprocket Order", ['order_id' => $order->id]);
        $payment_method = ($order->payment_mode == 'Razorpay' || $order->payment_received == 1)
            ? "Prepaid"
            : "COD";
        $items = [];
        $actualWeightKg = 0;
        foreach ($order->orderLines as $line) {
            $product = $line->product;
            $items[] = [
                'length' => (float)$product->length,
                'width'  => (float)$product->breadth,
                'height' => (float)$product->height,
                'qty'    => (int)$line->quantity,
            ];
            $actualWeightKg += ((float)$product->weight * (int)$line->quantity);
        }
        $parcel = $this->calculateVolumetricWeight($items, $actualWeightKg);
        Log::info("Computed Parcel Details", $parcel);
        $sa = $order->shippingAddress;
        $payload = [
            "order_id" => $order->order_id,
            "order_date" => now()->format("Y-m-d H:i"),
            "pickup_location" => "Primary",
            "comment" => "Order from website",

            "billing_customer_name" => $sa->full_name,
            "billing_last_name" => "",
            "billing_address" => $sa->full_address,
            "billing_address_2" => $sa->apartment ?? "",
            "billing_city" => $sa->city_name,
            "billing_pincode" => (int)$sa->pin_code,
            "billing_state" => $sa->state,
            "billing_country" => $sa->country ?? "India",
            "billing_email" => $sa->email_id ?? "",
            "billing_phone" => $sa->phone_number,
            /* Shipping = Billing */
            "shipping_is_billing" => true,
            "shipping_customer_name" => "",
            "shipping_last_name" => "",
            "shipping_address" => "",
            "shipping_address_2" => "",
            "shipping_city" => "",
            "shipping_pincode" => "",
            "shipping_country" => "",
            "shipping_state" => "",
            "shipping_email" => "",
            "shipping_phone" => "",

            "order_items" => [],
            "payment_method" => $payment_method,
            "shipping_charges" => 0,
            "giftwrap_charges" => 0,
            "transaction_charges" => 0,
            "total_discount" => 0,
            "sub_total" => (float)$order->grand_total_amount,
            "length" => $parcel['final_length_cm'],
            "breadth" => $parcel['final_width_cm'],
            "height" => $parcel['final_height_cm'],
            "weight" => $parcel['billable_weight_kg'],
        ];
        foreach ($order->orderLines as $item) {
            $payload["order_items"][] = [
                "name" => ucwords(strtolower($item->product->title)),
                "sku" => $item->product->hsn_code ?? "SKU123",
                "units" => $item->quantity,
                "selling_price" => (float)$item->price,
                "discount" => "",
                "tax" => "",
                "hsn" => $item->product->hsn_code ?? 441122,
            ];
        }
        Log::info("Shiprocket Payload", print_r($payload));

        /*
        // API CALL
        $response = Http::withToken($token)
            ->post($this->shiprocket->base . "/orders/create/adhoc", $payload)
            ->json();

        if (!isset($response['order_id'])) {
            return response()->json([
                'status' => 'error',
                'msg' => $response['message'] ?? "Shiprocket API Error"
            ], 500);
        }

        ShiprocketOrderResponse::updateOrCreate(
            ['order_id' => $order->id],
            [
                'shiprocket_order_id' => $response['order_id'],
                'shiprocket_shipment_id' => $response['shipment_id'],
                'shiprocket_awb_code' => $response['awb_code'] ?? null,
                'create_order_date' => now(),
            ]
        );
        */

        return response()->json([
            'status' => 'success',
            'msg' => 'Shiprocket Order Created Successfully'
        ]);
    }


    private function calculateVolumetricWeight(array $items, float $actualWeightKg, int $divisor = 5000, float $bufferPercent = 5)
    {
        $totalVolume = 0;

        foreach ($items as $item) {
            $totalVolume += ($item['length'] * $item['width'] * $item['height'] * $item['qty']);
        }
        $maxLength = max(array_column($items, 'length'));
        $maxWidth  = max(array_column($items, 'width'));
        $totalHeight = 0;
        foreach ($items as $item) {
            $totalHeight += ($item['height'] * $item['qty']);
        }
        $bufferMultiplier = 1 + ($bufferPercent / 100);
        $finalLength = $maxLength * $bufferMultiplier;
        $finalWidth  = $maxWidth * $bufferMultiplier;
        $finalHeight = $totalHeight * $bufferMultiplier;
        $volumetricWeight = ($finalLength * $finalWidth * $finalHeight) / $divisor;
        $billableWeight = max($actualWeightKg, $volumetricWeight);
        return [
            'total_volume_cm3'    => round($totalVolume, 2),
            'final_length_cm'      => round($finalLength, 2),
            'final_width_cm'       => round($finalWidth, 2),
            'final_height_cm'      => round($finalHeight, 2),
            'volumetric_weight_kg' => round($volumetricWeight, 2),
            'actual_weight_kg'      => round($actualWeightKg, 2),
            'billable_weight_kg'    => round($billableWeight, 2)
        ];
    }

}

