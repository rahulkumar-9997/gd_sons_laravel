<?php

namespace App\Services;

/**
 * ShippingRateEstimator
 *
 * Purpose: estimate a representative shipping cost for ANY product weight,
 * to bake into product pricing for the "free shipping" feature.
 *
 * This is NOT for live checkout — checkout already calls the Shiprocket API
 * directly with the exact order weight and gets a real, accurate quote.
 *
 * Method: piecewise-linear interpolation between anchor points gathered by
 * the pincode/weight-category cron job (509 non-outlier pincodes, mean rate
 * per category, monotonic-corrected).
 *
 * FIX (2026-09-10): anchors were previously stored as [weight => rate] with
 * float keys. PHP silently truncates float array keys to int, so 0.5kg was
 * stored as 0kg and 7.5kg as 7kg — corrupting every estimate below 1kg and
 * between 5kg and 10kg. Anchors are now [weight, rate] pairs.
 *
 * Source: weight_category_final_rates table, computed 2026-09-10.
 * Regenerate whenever that table is recomputed.
 */
class ShippingRateEstimator
{
    /** [weight_kg, final_rate_rupees], sorted ascending by weight. */
    private const ANCHORS = [
        [0.5,  69.55],
        [1.0,  126.00],
        [2.0,  158.81],
        [3.0,  220.26],
        [4.0,  280.93],
        [5.0,  280.93], 
        [7.5,  413.12],
        [10.0, 439.25],
        [15.0, 644.54],
        [25.0, 896.65],
        [50.0, 1721.08],
    ];

    /**
     * @return array{rate: float, status: string}
     *   status: 'at_min' | 'interpolated' | 'above_50kg'
     *   above_50kg continues the 25–50kg segment's per-kg rate (₹32.98/kg), not capped.
     */
    public static function estimate(float $weightKg): array
    {
        $anchors = self::ANCHORS;
        $count   = count($anchors);

        if ($weightKg <= $anchors[0][0]) {
            return ['rate' => $anchors[0][1], 'status' => 'at_min'];
        }

        for ($i = 1; $i < $count; $i++) {
            [$w1, $r1] = $anchors[$i - 1];
            [$w2, $r2] = $anchors[$i];

            if ($weightKg <= $w2) {
                $rate = $r1 + (($r2 - $r1) / ($w2 - $w1)) * ($weightKg - $w1);
                return ['rate' => round($rate, 2), 'status' => 'interpolated'];
            }
        }

        [$w1, $r1] = $anchors[$count - 2]; // 25kg
        [$w2, $r2] = $anchors[$count - 1]; // 50kg
        $rate = $r2 + (($r2 - $r1) / ($w2 - $w1)) * ($weightKg - $w2);

        return ['rate' => round($rate, 2), 'status' => 'above_50kg'];
    }
}