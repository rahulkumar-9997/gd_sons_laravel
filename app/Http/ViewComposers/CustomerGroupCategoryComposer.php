<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
class CustomerGroupCategoryComposer
{
    public function compose(View $view)
    {
        $groupCategory = app('customerGroupCategory');
        $view->with('groupCategory', $groupCategory);
    }
}
