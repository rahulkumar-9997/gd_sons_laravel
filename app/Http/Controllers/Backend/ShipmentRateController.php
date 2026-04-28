<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingRates;
use Illuminate\Support\Facades\Log;

class ShipmentRateController extends Controller
{
    public function index(Request $request)
    {
        $shipping_rates = ShippingRates::orderBy('id', 'desc')->paginate(30);
        if ($request->ajax()) {
            return view('backend.shipment-rate.partials.shipment-rate-list', compact('shipping_rates'))->render();
        }
        return view('backend.shipment-rate.index', compact('shipping_rates'));
    }

    public function refreshSingle($id)
    {
        $row = ShippingRates::where('id', $id)->first();
        if (!$row) {
            return response()->json(['status' => false, 'message' => 'Record not found']);
        }
        $weights = [
            'weight_450gm' => 0.45,
            'weight_750gm' => 0.75,
            'weight_1350gm' => 1.35,
            'weight_3400gm' => 3.4,
            'weight_7500gm' => 7.5,
            'weight_14kg' => 14,
            'weight_25kg' => 25,
        ];
        $ship = app(\App\Services\ShiprocketService::class);
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        $update = [];
        $debug = [];
        foreach ($weights as $column => $weight) {
            $response = $ship->getServiceability(
                $fromPin,
                $row->pincode,
                $weight,
                0
            );
            $companies = $response['raw']['data']['available_courier_companies'] ?? [];
            $filtered = collect($companies)
                ->filter(fn($item) => $weight >= ($item['min_weight'] ?? 0))
                ->sortBy('rate')
                ->values();
            $rate = $filtered->first()['rate'] ?? null;
            if ($rate) {
                $update[$column] = $rate;
            }
            $debug[$column] = [
                'weight' => $weight,
                'rate' => $rate,
                'total_companies' => count($companies),
            ];
            usleep(300000);
        }
        if (!empty($update)) {
            $row->update($update);
        }

        return response()->json([
            'status' => true,
            'message' => 'Row updated successfully',
            'data' => $update,
            'debug' => $debug,
            'id' => $id
        ]);
    }
}
