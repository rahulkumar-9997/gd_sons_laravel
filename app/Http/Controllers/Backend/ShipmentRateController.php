<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\ShippingRates;
use App\Models\Pincode;
use App\Models\WeightCategory;
use App\Models\PincodeShippingRate;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShipmentRateExport;

class ShipmentRateController extends Controller
{
    
    public function index(Request $request)
    {
        // $shipping_rates = PincodeShippingRate::with([
        //     'pincode',
        //     'weightCategory'
        // ])->latest()->paginate(50);
        $shipping_rates = Pincode::with([
            'shippingRates.weightCategory'
        ])->paginate(50);
        $weight_categories = WeightCategory::orderBy('primary_weight')->get();
        if ($request->ajax()) {
            return view('backend.shipment-rate.partials.shipment-rate-list', compact('shipping_rates', 'weight_categories'))->render();
        }
        return view('backend.shipment-rate.index', compact('shipping_rates', 'weight_categories'));
    }

    public function refreshSingle($id)
    {
        $pincode = Pincode::find($id);
        if (!$pincode) {
            return response()->json([
                'status' => false,
                'message' => 'Pincode not found'
            ]);
        }
        $ship = app(\App\Services\ShiprocketService::class);
        $fromPin = config('services.shiprocket.shiprocket_pickup_pincode');
        $weights = WeightCategory::all();
        $debug = [];
        foreach ($weights as $weightCategory) {
            $weight = $weightCategory->primary_weight;
            $response = $ship->getServiceability(
                $fromPin,
                $pincode->pincode,
                $weight,
                0
            );
            $companies = $response['raw']['data']['available_courier_companies'] ?? [];
            $filtered = collect($companies)
                ->filter(function ($item) use ($weight) {
                    return $weight >= ($item['min_weight'] ?? 0);
                })
                ->sortBy('rate')
                ->values();
            if (!$filtered->isEmpty()) {
                $rate = $filtered->first()['rate'];
                PincodeShippingRate::updateOrCreate(
                    [
                        'pincode_id' => $pincode->id,
                        'weight_category_id' => $weightCategory->id,
                    ],
                    [
                        'shipping_rate' => $rate,
                    ]
                );
                $debug[] = [
                    'weight' => $weight,
                    'rate' => $rate,
                ];
            }
            usleep(300000);
        }
        return response()->json([
            'status' => true,
            'message' => 'Shipping rates refreshed successfully',
            'debug' => $debug,
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
        $pincode = Pincode::find($id);
        if (!$pincode) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }
        try {
            $pincode->delete();
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

    public function ExcelExport(Request $request)
    {
        $request->validate([
            'weight_category_ids' => ['required', 'array', 'min:1'],
            'weight_category_ids.*' => ['exists:weight_categories,id'],
        ], [
            'weight_category_ids.required' => 'Please select at least one weight category.',
            'weight_category_ids.min' => 'Please select at least one weight category.',
        ]);        
        $weightIds = $request->weight_category_ids;
        $weights = WeightCategory::whereIn('id', $weightIds)
            ->orderBy('primary_weight')
            ->get();        
        $names = $weights->map(function ($weight) {
            return number_format($weight->primary_weight, 2)
                . ' KG-('
                . number_format($weight->min_weight, 2)
                . ' - '
                . ($weight->max_weight ? number_format($weight->max_weight, 2) : 'Above')
                . 'KG)';
        })->implode('_');
        if (strlen($names) > 200) {
            $names = substr($names, 0, 200);
        }        
        $fileName = $names . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(
            new ShipmentRateExport($weightIds),
            $fileName
        );
    }
}
