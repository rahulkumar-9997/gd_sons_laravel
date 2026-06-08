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
           // Log::info('Available couriers: ' . json_encode($companies, JSON_PRETTY_PRINT));
            $filtered = collect($companies)
                ->filter(fn($item) => $weight >= ($item['min_weight'] ?? 0))
                ->sortBy('rate')
                ->values();
            $rate = $filtered->first()['rate'] ?? null;
            $postcode = $filtered->first()['postcode'] ?? null;
            $city = $filtered->first()['city'] ?? null;
            $update['post_office'] = $city;
            //Log::info('Available filtered: ' . json_encode($filtered, JSON_PRETTY_PRINT));
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

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'pincode' => 'required|string|max:10',
                'post_office' => 'required|string|max:255',
                'weight_450gm' => 'nullable|integer|min:0',
                'weight_750gm' => 'nullable|integer|min:0',
                'weight_1350gm' => 'nullable|integer|min:0',
                'weight_3400gm' => 'nullable|integer|min:0',
                'weight_7500gm' => 'nullable|integer|min:0',
                'weight_14kg' => 'nullable|integer|min:0',
                'weight_25kg' => 'nullable|integer|min:0',
            ]);
            
            $shippingRate = ShippingRates::findOrFail($id);
            
            $shippingRate->update([
                'pincode' => $validatedData['pincode'],
                'post_office' => $validatedData['post_office'],
                'weight_450gm' => $validatedData['weight_450gm'] ?? 0,
                'weight_750gm' => $validatedData['weight_750gm'] ?? 0,
                'weight_1350gm' => $validatedData['weight_1350gm'] ?? 0,
                'weight_3400gm' => $validatedData['weight_3400gm'] ?? 0,
                'weight_7500gm' => $validatedData['weight_7500gm'] ?? 0,
                'weight_14kg' => $validatedData['weight_14kg'] ?? 0,
                'weight_25kg' => $validatedData['weight_25kg'] ?? 0,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Shipping rate updated successfully!',
                'data' => $shippingRate
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update shipping rate: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function destroy($id)
    {
        $row = ShippingRates::find($id);
        if (!$row) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }
        try {
            $row->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete Shipping Rate Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
