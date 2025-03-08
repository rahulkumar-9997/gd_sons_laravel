<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    /*public function boot()
    {
        View::composer('backend.layouts.sidebar', function ($view) {
            $user = auth()->user();

            $menus = collect();

            if ($user) {
                $roles = $user->roles()->pluck('name');
                $permissions = $user->getAllPermissions()->pluck('name');
                
                $menus = Menu::whereNull('parent_id')
                    ->where(function ($query) use ($roles, $permissions) {
                        $query->whereHas('roles', function ($roleQuery) use ($roles) {
                            $roleQuery->whereIn('name', $roles);
                        })->orWhereHas('permissions', function ($permQuery) use ($permissions) {
                            $permQuery->whereIn('name', $permissions);
                        });
                    })
                    ->with(['children' => function ($query) use ($roles, $permissions) {
                        $query->whereHas('roles', function ($roleQuery) use ($roles) {
                            $roleQuery->whereIn('name', $roles);
                        })->orWhereHas('permissions', function ($permQuery) use ($permissions) {
                            $permQuery->whereIn('name', $permissions);
                        });
                    }])
                    ->get();
            }
            dd(json_encode($menus, JSON_PRETTY_PRINT));
            $view->with('menus', $menus);
        });
    }
        */
    public function boot()
    {
        View::composer('backend.layouts.sidebar', function ($view) {
            $menus = Menu::whereNull('parent_id')
                ->with('children')
                ->get();

            $view->with('menus', $menus);
        });
    }
}
