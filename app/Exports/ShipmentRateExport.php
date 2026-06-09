<?php

namespace App\Exports;

use App\Models\Pincode;
use App\Models\WeightCategory;
use Maatwebsite\Excel\Concerns\FromArray;

class ShipmentRateExport implements FromArray
{
    protected $weightCategoryIds;

    public function __construct(array $weightCategoryIds)
    {
        $this->weightCategoryIds = $weightCategoryIds;
    }

    public function array(): array
    {
        $weights = WeightCategory::whereIn('id', $this->weightCategoryIds)
            ->orderBy('primary_weight')
            ->get();
        $header = [
            'Pincode',
            'District',
        ];
        foreach ($weights as $weight) {
            if ($weight->max_weight) {
                $range =
                    number_format($weight->min_weight, 2)
                    . ' - '
                    . number_format($weight->max_weight, 2);

            } else {
                $range =
                    number_format($weight->min_weight, 2)
                    . '+';
            }
            $header[] =
                $weight->primary_weight .
                ' KG (' .
                $range .
                ' KG)';
        }
        $rows = [];
        $rows[] = $header;
        $pincodes = Pincode::with('shippingRates')->get();
        foreach ($pincodes as $pincode) {
            $row = [
                $pincode->pincode,
                $pincode->district
            ];
            foreach ($weights as $weight) {
                $rate = $pincode->shippingRates
                    ->where('weight_category_id', $weight->id)
                    ->first();
                $row[] = optional($rate)->shipping_rate ?? '';
            }
            $rows[] = $row;
        }
        return $rows;
    }
}