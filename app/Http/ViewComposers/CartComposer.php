<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Cart;

class CartComposer
{
    public function compose(View $view)
    {
        $cartData = app('cartData');
        $view->with($cartData);
    }
}
