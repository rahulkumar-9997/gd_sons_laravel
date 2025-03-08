<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\OrderLines;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Models\OrderShipmentRecords;
use Illuminate\Support\Facades\DB;

class OrderControllerBackend extends Controller
{
    public function showAllOrderList(Request $request){
        $orderStatusId = $request->query('order-status');
        if ($orderStatusId) {
            $orders = Orders::with([
                    'orderStatus', 
                    'customer',
                    'orderLines.product',
                ])
                ->where('order_status_id', $orderStatusId)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $orders = collect();
        }
       
        $data['orders'] = $orders;
        //return response()->json($data);
        $data['order_status'] = OrderStatus::all();
        return view('backend.manage-order.order-list', compact('data'));
       
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
}

