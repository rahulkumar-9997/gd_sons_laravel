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
use App\Models\ShiprocketShipmentAwbResponse;
use App\Models\ShiprocketPickupResponse;
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
                'shiprocketOrderResponse',
                'shiprocketCourier'
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
            'orderLines.product.images',
            'shiprocketCourier'
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
            'orderLines.product.images',
            'shiprocketCourier'
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
    public function createShipRocketOrder(Request $request, $id)
    {
        // return response()->json([
        //     'status' => 'error',
        //     'msg' => 'Shiprocket integration is disabled temporarily.'
        // ], 500);
        DB::beginTransaction();
        try {
            $order = Orders::with([
                'customer',
                'shippingAddress',
                'orderLines.product',
                'shiprocketCourier'
            ])->findOrFail($id);            
            if (!$order->shippingAddress) {
                throw new \Exception("Please add billing/shipping address first");
            }            
            
            $token = $this->shiprocket->getToken();
            if (!$token) {
                throw new \Exception("Unable to generate Shiprocket token");
            }
            
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
            $ship_rocket_courier_charges = optional($order->shiprocketCourier)->courier_shipping_rate ?? 0;            
            $sa = $order->shippingAddress;
            $customerEmail = $order->customer->email ?? 
                        $sa->email_id ?? 
                        'customer' . $order->id . '@gdsons.co.in';
            $payload = [
                "order_id" => $order->order_id,
                "order_date" => now()->format("Y-m-d H:i"),
                "pickup_location" => "work",
                "comment" => "",
                "billing_customer_name" => $sa->full_name,
                "billing_last_name" => "",
                "billing_address" => $sa->full_address,
                "billing_address_2" => $sa->apartment ?? "",
                "billing_city" => $sa->city_name,
                "billing_pincode" => (int)$sa->pin_code,
                "billing_state" => $sa->state,
                "billing_country" => $sa->country ?? "India",
                "billing_email" => $customerEmail,
                "billing_phone" => $sa->phone_number,
                
                "shipping_is_billing" => false,
                "shipping_customer_name" => $sa->full_name,
                "shipping_last_name" => "",
                "shipping_address" => $sa->full_address,
                "shipping_address_2" => $sa->apartment ?? "",
                "shipping_city" => $sa->city_name,
                "shipping_pincode" => (int)$sa->pin_code,
                "shipping_country" => $sa->country ?? "India",
                "shipping_state" => $sa->state,
                "shipping_email" => $customerEmail,
                "shipping_phone" => $sa->phone_number ??"",
                
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
            
            Log::info("Shiprocket Payload", $payload);            
            
            /*shiprocket create order api integrate */
            $response = Http::withToken($token)
                ->post("https://apiv2.shiprocket.in/v1/external/orders/create/adhoc", $payload)
                ->json();                
            
            Log::info("Shiprocket API Response", $response);            
            
            if (!isset($response['order_id'])) {
                throw new \Exception($response['message'] ?? "Shiprocket API Error");
            }        
            
            $shiprocketOrder = ShiprocketOrderResponse::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'shiprocket_order_id' => $response['order_id'],
                    'shiprocket_shipment_id' => $response['shipment_id'],
                    'shiprocket_awb_code' => $response['awb_code'] ?? null,
                    'create_order_date' => now(),
                    'is_order_created' => 1,
                    'is_order_updated' => 0,
                    'is_order_cancelled' => 0,
                    'is_address_updated' => 0,
                    'is_awb_generated' => isset($response['awb_code']) ? 1 : 0,
                    'is_pickup_requested' => 0,
                ]
            );  
            
            DB::commit();            
            $message = 'Shiprocket Order Created Successfully';            
            /* ----------------------- AUTO AWB ----------------------- */
            try {
                $awbResult = $this->generateShipRocketAWB($request, $id, true);
                if ($awbResult === true) {
                    $message .= ' + AWB Generated';
                }
            } catch (\Exception $e) {
                Log::error("Auto AWB Generation Failed", [
                    'order_id' => $id,
                    'error' => $e->getMessage()
                ]);
                $message .= ' (AWB Generation Failed: ' . $e->getMessage() . ')';
            }            
            return $this->successResponse($message, $request);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Shiprocket Order Creation Error", [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'order_id' => $id
            ]);            
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }
    }
    /* ============================================================
    *  AWB GENERATION
    * ============================================================ */
    public function generateShipRocketAWB(Request $request, $id, $auto = false)
    {
        DB::beginTransaction();
        try {
            $order = Orders::with(['shiprocketCourier', 'shiprocketOrderResponse'])
                ->findOrFail($id);

            $sr = $order->shiprocketOrderResponse;
            if (!$sr) {
                throw new \Exception("Shiprocket order not created!");
            }
            
            if (!$order->shiprocketCourier) {
                throw new \Exception("Courier not assigned in admin.");
            }
            
            $token = $this->shiprocket->getToken();
            
            if (empty($sr->shiprocket_shipment_id)) {
                throw new \Exception("Shipment ID is empty. Please check order creation.");
            }

            $payload = [
                "shipment_id" => (string)$sr->shiprocket_shipment_id,
                "courier_id"  => $order->shiprocketCourier->courier_company_id
            ];
            
            Log::info("AWB Generation Payload", $payload);
            
            $response = Http::withToken($token)
                ->timeout(30)
                ->post("https://apiv2.shiprocket.in/v1/external/courier/assign/awb", $payload);
                
            $res = $response->json();
            Log::info("AWB API Response Status", ['http_status' => $response->status()]);
            Log::info("AWB Full Response", $res);

            /* -----------------------------------------------------------
            FIX: Shiprocket error formats (nested + direct)
            ----------------------------------------------------------- */
            $directError  = $res['awb_assign_error'] ?? null;
            $nestedError  = $res['response']['data']['awb_assign_error'] ?? null;

            if ($directError || $nestedError) {
                throw new \Exception("AWB Generation Failed: " . ($directError ?? $nestedError));
            }

            /* -----------------------------------------------------------
            Status 400 handling
            ----------------------------------------------------------- */
            if ($response->status() === 400) {
                $detailedError = $this->getAWBErrorDetails(
                    $token,
                    $sr->shiprocket_shipment_id,
                    $order->shiprocketCourier->courier_company_id
                );
                
                if (isset($res['message'])) {
                    $msg = strtolower($res['message']);
                    if (str_contains($msg, 'serviceable')) {
                        throw new \Exception(
                            "Courier ID {$order->shiprocketCourier->courier_company_id} ".
                            "is not serviceable for pincode {$order->shippingAddress->pin_code}. ".
                            "Please assign a different courier."
                        );
                    }
                    if (str_contains($msg, 'invalid')) {
                        throw new \Exception(
                            "Invalid courier ID {$order->shiprocketCourier->courier_company_id} ".
                            "or shipment not ready for AWB assignment."
                        );
                    }
                }
                throw new \Exception("AWB Generation Failed: " . ($res['message'] ?? 'Unknown error.'));
            }

            /* -----------------------------------------------------------
            FIX: Shiprocket sends status_code 350 for wallet issues
            ----------------------------------------------------------- */
            if (($res['status_code'] ?? 200) != 200) {
                throw new \Exception($res['message'] ?? "AWB generation failed. Invalid response.");
            }

            /* -----------------------------------------------------------
            FIX: AWB must have assign_status = 1
            ----------------------------------------------------------- */
            if (!isset($res['awb_assign_status']) || $res['awb_assign_status'] != 1) {
                throw new \Exception($res['message'] ?? "AWB generation failed - invalid response");
            }

            /* -----------------------------------------------------------
            SUCCESS — extract data and perform database operations
            ----------------------------------------------------------- */
            $data = $res['response']['data'] ?? [];
            if (empty($data['awb_code'])) {
                throw new \Exception("AWB code missing from response");
            }
            
            if (empty($data['shipment_id'])) {
                throw new \Exception("Shipment ID missing from response");
            }
            
            $awbData = [
                'order_id' => $id,
                'shipment_id' => $data['shipment_id'],
                'courier_company_id' => $data['courier_company_id'] ?? null,
                'awb_code' => $data['awb_code'],
                'courier_name' => $data['courier_name'] ?? null,
                'applied_weight' => $data['applied_weight'] ?? null,
                'company_id' => $data['company_id'] ?? null,
                'child_courier_name' => $data['child_courier_name'] ?? null,
                'pickup_scheduled_date' => $data['pickup_scheduled_date'] ?? null,
                'routing_code' => $data['routing_code'] ?? null,
                'rto_routing_code' => $data['rto_routing_code'] ?? null,
                'invoice_no' => $data['invoice_no'] ?? null,
                'transporter_id' => $data['transporter_id'] ?? null,
                'transporter_name' => $data['transporter_name'] ?? null,
                'shipped_by' => isset($data['shipped_by']) ? json_encode($data['shipped_by']) : null,
                'assigned_date_time' => isset($data['assigned_date_time']['date']) ? 
                    $data['assigned_date_time']['date'] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $awbData = array_filter($awbData, function($value) {
                return $value !== null;
            });
            $awb_response = ShiprocketShipmentAwbResponse::updateOrCreate(
                ['order_id' => $id],
                $awbData
            );
            Log::info("AWB Response Record Created/Updated", [
                'order_id' => $id,
                'awb_code' => $data['awb_code'],
                'awb_response_id' => $awb_response->id
            ]);
            $updateData = [
                'shiprocket_awb_code' => $data['awb_code'],
                'is_awb_generated' => 1,
            ];
            
            $sr->update($updateData);            
            // Also update the order status if needed
            // $order->update(['status' => 'awb_generated']);            
            DB::commit();            
            Log::info("AWB Generated Successfully", [
                'order_id' => $id,
                'awb_code' => $data['awb_code']
            ]);
            
            $message = 'AWB Generated Successfully';
            
            /* ----------------------- AUTO Pickup ----------------------- */
            // Uncomment and modify as needed
            /*
            try {
                $pickupResult = $this->pickup($request, $id, true);
                if ($pickupResult === true) {
                    $message .= ' + Pickup Scheduled';
                }
            } catch (\Exception $e) {
                Log::error("Auto Pickup Scheduling Failed", [
                    'order_id' => $id,
                    'error' => $e->getMessage()
                ]);
                $message .= ' (Pickup Scheduling Failed: ' . $e->getMessage() . ')';
            }
            */
            
            if ($auto) return true;            
            return $this->successResponse($message, $request);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("AWB Generation Error", [
                'error' => $e->getMessage(),
                'order_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($auto) {
                throw $e;
            }
            
            return $this->errorResponse($e->getMessage());
        }
    }

    /* ============================================================
    *  PICKUP REQUEST
    * ============================================================ */
    public function pickup(Request $request, $id, $auto = false)
    {
        DB::beginTransaction();
        try {
            $order = Orders::with('shiprocketOrderResponse')->findOrFail($id);

            $sr = $order->shiprocketOrderResponse;
            if (!$sr) {
                throw new \Exception("Shiprocket order not created!");
            }

            if (!$sr->is_awb_generated) {
                throw new \Exception("AWB not generated!");
            }

            $token = $this->shiprocket->getToken();
            $res = Http::withToken($token)
                ->post("https://apiv2.shiprocket.in/v1/external/courier/generate/pickup", [
                    "shipment_id" => [$sr->shiprocket_shipment_id]
                ])
                ->json();            
            
            Log::info("Pickup Response", $res);  
            if (isset($res['message']) && str_contains(strtolower($res['message']), 'order is already canceled')) {
                $sr->update([
                    'is_order_cancelled' => 1,
                    'is_pickup_requested' => 0 
                ]);
                $order->update(['order_status_id' => 6]); 
                DB::commit();
                throw new \Exception("Order is already canceled in Shiprocket");
            }

            if (isset($res['status_code']) && $res['status_code'] != 200) {           
                throw new \Exception($res['message'] ?? "Pickup request failed.");
            }
            
            if (!isset($res['pickup_status']) || $res['pickup_status'] != 1) {
                throw new \Exception($res['message'] ?? "Pickup request failed.");
            }
            $responseData = $res['response'];
            $othersData = null;
            
            if (isset($responseData['others']) && is_string($responseData['others'])) {
                try {
                    $othersData = json_decode($responseData['others'], true);
                } catch (\Exception $e) {
                    Log::warning("Failed to decode others JSON in pickup response", [
                        'order_id' => $id,
                        'others_string' => $responseData['others']
                    ]);
                }
            }

            $shiprocket_pickup = ShiprocketPickupResponse::updateOrCreate(
                ['order_id' => $id],
                [
                    'pickup_status' => $res['pickup_status'],
                    'pickup_scheduled_date' => $responseData['pickup_scheduled_date'] ?? null,
                    'pickup_token_number' => $responseData['pickup_token_number'] ?? null,
                    'status' => $responseData['status'] ?? null,
                    'others' => $othersData,
                    'pickup_generated_date' => isset($responseData['pickup_generated_date']['date']) ? $responseData['pickup_generated_date']['date'] : null,
                    'data' => $responseData['data'] ?? null,
                ]
            );
            $sr->update(['is_pickup_requested' => 1]);
            $order->update(['order_status_id' => 4]); 
            Log::info("After Order Status Update", [
                'order_id' => $id,
                'sr_updated' => $sr->wasChanged(),
                'order_updated' => $order->wasChanged(),
                'new_status' => $order->fresh()->order_status_id,
                'is_pickup_requested' => $sr->fresh()->is_pickup_requested
            ]);

            DB::commit(); 
            
            if ($auto) return true;    
            return $this->successResponse("Pickup Scheduled Successfully", $request);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Pickup Scheduling Error", [
                'error' => $e->getMessage(),
                'order_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($auto) {
                throw $e;
            } 
            
            return $this->errorResponse($e->getMessage());
        }
    }

    /* ============================================================
    *  RESPONSE HELPERS
    * ============================================================ */

    private function successResponse($msg, Request $req)
    {
        $order_status_id = $req->query('order-status') ?? $req->input('order_status_id');
        
        $orders = Orders::with([
            'orderStatus', 
            'customer', 
            'orderLines.product', 
            'shiprocketOrderResponse',
            'shiprocketCourier'
        ])
        ->when($order_status_id, function($query) use ($order_status_id) {
            return $query->where('order_status_id', $order_status_id);
        })
        ->orderBy('id', 'desc')
        ->get();

        $orders_status = OrderStatus::all();

        return response()->json([
            'status' => 'success',
            'msg' => $msg,
            'order_list' => view(
                'backend.manage-order.partials.order-list-table',
                compact('orders', 'orders_status', 'order_status_id')
            )->render()
        ]);
    }

    private function errorResponse($msg, $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'msg' => $msg
        ], $code);
    }

    private function getAWBErrorDetails($token, $shipmentId, $courierId)
    {
        try {
            $shipmentResponse = Http::withToken($token)
                ->get("https://apiv2.shiprocket.in/v1/external/orders/show/{$shipmentId}")
                ->json();
                
            Log::info("Shipment Details", $shipmentResponse);            
            return $shipmentResponse;
        } catch (\Exception $e) {
            Log::error("Error getting shipment details", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function checkAvailableCouriers_Remove_it($id)
    {
        try {
            $order = Orders::with(['shippingAddress', 'shiprocketOrderResponse'])->findOrFail($id);
            $sr = $order->shiprocketOrderResponse;            
            if (!$sr) {
                throw new \Exception("Shiprocket order not created!");
            }
            $token = $this->shiprocket->getToken();
            $response = Http::withToken($token)
                ->get("https://apiv2.shiprocket.in/v1/external/courier/courierListWithCounts", [
                    "shipment_id" => $sr->shiprocket_shipment_id
                ])
                ->json();
                Log::info("Available Couriers for Shipment", [
                    'shipment_id' => $sr->shiprocket_shipment_id,
                    'available_couriers' => $response
                ]);
            return $response;
            
        } catch (\Exception $e) {
            Log::error("Available Couriers Check Failed", [
                'error' => $e->getMessage(),
                'order_id' => $id
            ]);
            return null;
        }
    }


    private function calculateVolumetricWeight(array $items, float $actualWeightKg, int $divisor = 5000, float $bufferPercent = 5)
    {
        $totalVolume = 0;
        $lengths = [];
        $widths = [];
        foreach ($items as $item) {
            $totalVolume += ($item['length'] * $item['width'] * $item['height'] * $item['qty']);
            $lengths[] = $item['length'];
            $widths[] = $item['width'];
        }
        $maxLength = max($lengths);
        $maxWidth = max($widths);
        $totalHeight = 0;        
        foreach ($items as $item) {
            $totalHeight += ($item['height'] * $item['qty']);
        }
        
        $bufferMultiplier = 1 + ($bufferPercent / 100);
        $finalLength = $maxLength * $bufferMultiplier;
        $finalWidth = $maxWidth * $bufferMultiplier;
        $finalHeight = $totalHeight * $bufferMultiplier;
        
        $volumetricWeight = ($finalLength * $finalWidth * $finalHeight) / $divisor;
        $billableWeight = max($actualWeightKg, $volumetricWeight);        
        return [
            'total_volume_cm3' => round($totalVolume, 2),
            'final_length_cm' => round($finalLength, 2),
            'final_width_cm' => round($finalWidth, 2),
            'final_height_cm' => round($finalHeight, 2),
            'volumetric_weight_kg' => round($volumetricWeight, 2),
            'actual_weight_kg' => round($actualWeightKg, 2),
            'billable_weight_kg' => round($billableWeight, 2)
        ];
    }
}

