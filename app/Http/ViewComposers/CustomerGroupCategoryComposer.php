<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
class CustomerGroupCategoryComposer
{
    public function compose(View $view)
    {
        $groupCategory = app('customerGroupCategory');
        //dd(json_encode($groupCategory, JSON_PRETTY_PRINT));
        $view->with('groupCategory', $groupCategory);
    }
}
