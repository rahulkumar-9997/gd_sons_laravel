<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\CartComposer;
use App\Http\ViewComposers\SharedDataComposer;
use App\Http\ViewComposers\CustomerGroupCategoryComposer;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Store Cart Data Singleton
        $this->app->singleton('customerGroupCategory', function () {
            $customer = Auth::guard('customer')->user();
            return $customer ? $customer->groupCategory()->with('groups')->first() : null;
        });

        // Store Cart Data Singleton
        $this->app->singleton('cartData', function () {
            $customerId = Auth::guard('customer')->id();
            if ($customerId) {
                $cartItems = Cart::where('customer_id', $customerId)
                    ->with([
                        'product' => function ($query) {
                            $query->with([
                                'ProductImagesFront:id,product_id,image_path',
                                'ProductAttributesValues' => function ($query) {
                                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                                        ->with([
                                            'attributeValue:id,slug'
                                        ])
                                        ->orderBy('id');
                                }
                            ])
                            ->leftJoin('inventories', function ($join) {
                                $join->on('products.id', '=', 'inventories.product_id')
                                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                            })
                            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku');
                        }
                    ])
                    ->get();
                $cartTotal = 0;
                $cartCount = $cartItems->count();
            } else {
                $cartItems = collect();
                $cartTotal = 0;
                $cartCount = 0;
            }

            return [
                'cartItems' => $cartItems,
                'cartTotal' => $cartTotal,
                'cartCount' => $cartCount,
                'isCartEmpty' => $cartCount == 0,
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    

    public function boot()
    {
        Log::info("MenuComposer is being executed");
        View::composer('frontend.layouts.header-menu', MenuComposer::class);
        View::composer(
            ['frontend.pages.partials.cart_items', 'frontend.layouts.header-menu'],
            CartComposer::class
        );
        View::composer(
            //'*',
            [
                'frontend.index',
                'frontend.pages.blog.blog-details',
                'frontend.pages.blog.blog-list',
                'frontend.pages.partials.product-catalog-load-more',
                'frontend.pages.partials.cart_items',
                'frontend.layouts.footer',
                'frontend.pages.partials.product-category-catalog-load-more',
                'frontend.pages.product',
                'frontend.pages.partials.ajax-search-catalog',
                'frontend.pages.partials.ajax-checkout-form',
                'frontend.pages.cart',
                'frontend.pages.customer.wishlist.index',
            ],
            CustomerGroupCategoryComposer::class
        );
        View::composer(
            [
                'frontend.layouts.footer',
                'frontend.layouts.header-menu',
            ],
            SharedDataComposer::class
        );
        // View::composer(
        //     '*',
        //     SharedDataComposer::class
        // );
        
    }

    
}
