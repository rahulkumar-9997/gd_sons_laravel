<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Models\Category;
use App\Models\Product;
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
        $this->app->singleton('customerGroupCategory', function () {
            $customer = Auth::guard('customer')->user();
            return $customer ? $customer->load(['customerGroup', 'groupCategory']) : null;
        });

        $this->app->singleton('cartData', function () {
            /*$customerId = Auth::guard('customer')->id();
            $specialOffers = getCustomerSpecialOffers();
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
                $cartCount = $cartItems->count();
            }
            else
            {
                $cartItems = collect();
                $cartCount = 0;
                $specialOffers = $specialOffers;
            }
            */
            $sessionCart = session('cart', []);
            $productIds = array_keys($sessionCart);
            $specialOffers = getCustomerSpecialOffers();
            $cartItems = Product::with([
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
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                ->whereIn('products.id', $productIds)
                ->get();
            
            $cartCount = count($cartItems);

            return [
                'cartItems' => $cartItems,
                'cart_count' => $cartCount,
                'specialOffers' => $specialOffers
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
        //Log::info("MenuComposer is being executed");
        View::composer('frontend.layouts.header-menu', MenuComposer::class);
        View::composer(
            ['frontend.pages.partials.cart-drawer', 'frontend.layouts.footer'],
            CartComposer::class
        );
        View::composer(
            //'*',
            [
                'frontend.index',
                'frontend.pages.blog.blog-details',
                'frontend.pages.blog.blog-list',
                'frontend.pages.partials.product-catalog-load-more',
                'frontend.pages.partials.cart-drawer',
                'frontend.layouts.footer',
                'frontend.pages.partials.product-category-catalog-load-more',
                'frontend.pages.product',
                'frontend.pages.partials.ajax-search-catalog',
                'frontend.pages.partials.ajax-checkout-form',
                'frontend.pages.partials.ajax-cart',
                'frontend.pages.partials.ajax-flash-sale-load-more',
                'frontend.pages.cart',
                'frontend.pages.customer.wishlist.index',
                'frontend.pages.checkout-param-page',
                'frontend.pages.pick-up-store-page',
                'frontend.pages.product-catalog-category',
                'frontend.pages.flash-sale',

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
