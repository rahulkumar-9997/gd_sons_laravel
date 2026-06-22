<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SalesReportController extends Controller
{
     public function saleReportIndex(Request $request)
    {
        $years = Orders::select(DB::raw('YEAR(order_date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year'); 
        $months = range(1, 12); 
        $orders = Orders::with([
            'orderLines',
            'orderLines.product.images',
            'orderLines.product.inventories',
            'orderStatus',
            'shiprocketCourier',
        ])
        ->whereHas('orderStatus', function ($query) {
            $query->where('status_name', 'Delivered');
        })
        ->when($request->filled('year'),   fn($q) => $q->whereYear('order_date',  $request->year))
        ->when($request->filled('month'),  fn($q) => $q->whereMonth('order_date', $request->month))
        ->when($request->filled('search'), fn($q) => $q->where('order_id', 'like', '%' . $request->search . '%'))
        ->orderBy('order_date', 'desc')
        ->paginate(20);
        $summary = $this->calculateSummary($orders);
        if ($request->ajax()) {
            return view('backend.sales-report.partials.sale-report-list', compact('orders', 'summary'))->render();
        } 
        return view('backend.sales-report.index', compact('orders', 'years', 'months', 'summary'));
    }

    private function calculateSummary($orders): array
    {
        $totalOrderAmount    = $orders->sum('grand_total_amount');
        $totalPurchaseCost   = 0;
        foreach ($orders as $order) {
            foreach ($order->orderLines as $line) {
                $rate = $line->product->inventories->first()->purchase_rate ?? 0;
                $totalPurchaseCost += $rate * $line->quantity;
            }
        } 
        $totalDiscount       = $orders->sum('coupon_discount_amount');
        $totalGatewayCharges = $orders->sum('payment_gateway_charges');
        $totalSmsCharges     = $orders->sum('sms_charges');
        $totalShipping = $orders->sum(function ($order) {
            return (float) $order->actual_shipping_amount > 0
                ? (float) $order->actual_shipping_amount
                : 0;
        });
        $totalDeductions = $totalPurchaseCost
                         + $totalDiscount
                         + $totalShipping
                         + $totalGatewayCharges
                         + $totalSmsCharges;
        $totalProfit      = $totalOrderAmount - $totalDeductions;
        $profitPercentage = $totalPurchaseCost > 0
                          ? ($totalProfit / $totalPurchaseCost) * 100
                          : 0;
 
        return [
            'total_orders'          => $orders->count(),
            'total_order_amount'    => $totalOrderAmount,
            'total_purchase_cost'   => $totalPurchaseCost,
            'total_discount'        => $totalDiscount,
            'total_shipping'        => $totalShipping,
            'total_gateway_charges' => $totalGatewayCharges,
            'total_sms_charges'     => $totalSmsCharges,
            'total_deductions'      => $totalDeductions,
            'total_net_sale'        => $totalProfit,
            'total_profit'          => $totalProfit,  
            'profit_percentage'     => $profitPercentage,
        ];
    }

}