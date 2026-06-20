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

class SalesReportController extends Controller
{
    public function saleReportIndex(Request $request)
    {
        // Get distinct years for filter
        $years = Orders::select(DB::raw('YEAR(order_date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        // Get months for filter (1-12)
        $months = range(1, 12);

        // Build the query - load product images using the 'images' relationship
        $orders = Orders::with(['orderLines', 'orderStatus', 'orderLines.product.images'])
            ->whereHas('orderStatus', function ($query) {
                $query->where('status_name', 'Delivered');
            })
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('order_date', $request->year);
            })
            ->when($request->filled('month'), function ($query) use ($request) {
                $query->whereMonth('order_date', $request->month);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('order_id', 'like', '%' . $request->search . '%');
            })
            ->orderBy('order_date', 'desc')
            ->get();

        // Calculate summary statistics
        $summary = $this->calculateSummary($orders);

        return view('backend.sales-report.index', compact('orders', 'years', 'months', 'summary'));
    }

    private function calculateSummary($orders)
    {
        $totalOrders = $orders->count();
        $totalOrderAmount = $orders->sum('grand_total_amount');
        $totalDiscount = $orders->sum('coupon_discount_amount');
        $totalShipping = $orders->sum('actual_shipping_amount');
        $totalGatewayCharges = $orders->sum('payment_gateway_charges');
        $totalDeductions = $totalDiscount + $totalShipping + $totalGatewayCharges;
        $totalNetSale = $totalOrderAmount - $totalDeductions;

        return [
            'total_orders' => $totalOrders,
            'total_order_amount' => $totalOrderAmount,
            'total_discount' => $totalDiscount,
            'total_shipping' => $totalShipping,
            'total_gateway_charges' => $totalGatewayCharges,
            'total_deductions' => $totalDeductions,
            'total_net_sale' => $totalNetSale,
        ];
    }
}
