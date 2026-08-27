<?php
namespace App\View\Composers;

use App\Models\OfferPopup;
use Illuminate\View\View;

class OfferPopupComposer
{
    public function compose(View $view): void
    {
        $dismissedIds = $this->getDismissedOfferIds();
        $popup = OfferPopup::active()
            ->when(!empty($dismissedIds), function ($query) use ($dismissedIds) {
                $query->whereNotIn('id', $dismissedIds);
            })
            ->inRandomOrder()
            ->first();
        if (!$popup && !empty($dismissedIds)) {
            $popup = OfferPopup::active()->inRandomOrder()->first();
        }
        $view->with('activeOfferPopup', $popup);
    }

    private function getDismissedOfferIds(): array
    {
        $raw = request()->cookie('gdsons_offer_dismissed');
        if (!$raw) {
            return [];
        }
        $cutoffMs = now()->subHours(24)->timestamp * 1000;
        $dismissedIds = [];
        foreach (explode('_', $raw) as $pair) {
            $parts = explode('-', $pair);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                if ((int) $parts[1] > $cutoffMs) {
                    $dismissedIds[] = (int) $parts[0];
                }
            }
        }
        return $dismissedIds;
    }
}