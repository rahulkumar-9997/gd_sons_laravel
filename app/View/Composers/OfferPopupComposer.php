<?php
namespace App\View\Composers;

use App\Models\OfferPopup;
use Illuminate\View\View;

class OfferPopupComposer
{
    public function compose(View $view): void
    {
        $view->with('activeOfferPopup', OfferPopup::active()->inRandomOrder()->first());
    }
}