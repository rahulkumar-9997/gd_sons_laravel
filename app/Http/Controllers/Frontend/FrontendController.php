<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute_values;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Inventory;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Banner;
use App\Models\Label;
use App\Models\Video;
use App\Models\PrimaryCategory;
use App\Mail\ContactUsMail;
use App\Models\WhatsappConversation;
use App\Models\Counter;
use App\Models\Customer;
use App\Models\SpecialOffer;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function home()
    {
        
        $labels = Label::whereIn('title', ['Popular Product', 'Trending Product'])
        ->get()
        ->keyBy('title');
        $specialOffers = getCustomerSpecialOffers();
        //dd($specialOffers);
        $popular_label_id = $labels['Popular Product']->id ?? null;
        $trending_label_id = $labels['Trending Product']->id ?? null;

        $data['primary_category'] = PrimaryCategory::where('status', 1)
        ->orderBy('title')
        ->get(['id', 'title', 'link']);
        $data['banner'] = Banner::orderBy('id', 'desc')->get(['id', 'image_path_desktop', 'link_desktop', 'title']);
        $data['video'] = Video::inRandomOrder()->select('video_url')->take(10)->get();
        /* Fetch all required products in one query */
        $products = Product::where('product_status', 1)
            ->whereIn('label_id', [$popular_label_id, $trending_label_id])
            ->with([
                'images' => function ($query) {
                    $query->select('id', 'product_id', 'image_path')->orderBy('sort_order');
                },
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with(['attributeValue:id,slug'])
                        ->orderBy('id');
                }
            ])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
            ->get()
            ->shuffle();

        /* Split products into popular and trending */
        $data['popular_products'] = $products->where('label_id', $popular_label_id)->take(20);
        $data['trending_products'] = $products->where('label_id', $trending_label_id)->take(20);
		DB::disconnect();
        return view('frontend.index', compact('data', 'specialOffers'));

    }

    public function showProductCatalogOld_29_1_25(Request $request, $categorySlug, $attributeSlug, $valueSlug)
    {

        try {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $attribute_top = Attribute::where('slug', $attributeSlug)->first();
            if (!$attribute_top) {
                Log::error("No attribute found for slug: {$attributeSlug}");
                return response()->json(['error' => 'Attribute not found'], 404);
            }
            Log::info('Route Attribute Slug:', ['slug' => $attributeSlug]);
            $attributeValue = Attribute_values::where('slug', $valueSlug)->firstOrFail();
            Log::info('Filters: ' . json_encode($request->query()));
            $productsQuery = Product::where('category_id', $category->id)->where('product_status', 1);

            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $attributeSlug => $valueSlugs) {
                    if ($attributeSlug !== $attribute_top->slug) {
                        if (is_string($valueSlugs)) {
                            $valueSlugs = explode(',', $valueSlugs);
                        }
                        $attribute = Attribute::where('slug', $attributeSlug)->first();
                        if (!$attribute) {
                            Log::warning("Attribute not found for slug: {$attributeSlug}");
                            continue;
                        }
                        $valueIds = Attribute_values::whereIn('slug', $valueSlugs)->pluck('id')->toArray();
                        $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                            $query->where('attributes_id', $attribute->id)
                                ->whereHas('values', function ($q) use ($valueIds) {
                                    $q->whereIn('attributes_value_id', $valueIds);
                                });
                        });
                    }
                }
            }
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                Log::warning("Attribute not found for slug: {$sortOption}");
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        $productsQuery->orderBy('inventories.mrp', 'asc');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderBy('inventories.mrp', 'desc');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            }

            $products = $productsQuery->with([
                'category',
                'images',
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
                ->paginate(32);
            $attributes_with_values_for_filter_list = $category->attributes()
                ->where('slug', '!=', $attribute_top->slug)
                ->with(['AttributesValues' => function ($query) use ($category, $products) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->whereHas('productAttributesValues', function ($q) use ($products) {
                            $q->whereHas('product', function ($q) use ($products) {
                                $q->whereIn('id', $products->pluck('id'));
                            });
                        })->orderBy('name');
                }])
                ->orderBy('title')
                ->get();
            if ($request->ajax()) {
                return response()->json([
                    'products' => view('frontend.pages.ajax-product-catalog', compact('products'))->render(),
                    'hasMore' => $products->hasMorePages(),
                ]);
            }
            return view('frontend.pages.product-catalog', compact('products', 'category', 'attributeValue', 'attribute_top', 'attributes_with_values_for_filter_list'));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function showProductCatalogOld_30_1_2025(Request $request, $categorySlug, $attributeSlug, $valueSlug)
    {

        try {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $attribute_top = Attribute::where('slug', $attributeSlug)->first();
            if (!$attribute_top) {
                Log::error("No attribute found for slug: {$attributeSlug}");
                return response()->json(['error' => 'Attribute not found'], 404);
            }
            Log::info('Route Attribute Slug:', ['slug' => $attributeSlug]);
            $attributeValue = Attribute_values::where('slug', $valueSlug)->firstOrFail();
            Log::info('Filters: ' . json_encode($request->query()));
            $productsQuery = Product::where('category_id', $category->id)->where('product_status', 1);

            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $attributeSlug => $valueSlugs) {
                    if ($attributeSlug !== $attribute_top->slug) {
                        if (is_string($valueSlugs)) {
                            $valueSlugs = explode(',', $valueSlugs);
                        }
                        $attribute = Attribute::where('slug', $attributeSlug)->first();
                        if (!$attribute) {
                            Log::warning("Attribute not found for slug: {$attributeSlug}");
                            continue;
                        }
                        $valueIds = Attribute_values::whereIn('slug', $valueSlugs)->pluck('id')->toArray();
                        $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                            $query->where('attributes_id', $attribute->id)
                                ->whereHas('values', function ($q) use ($valueIds) {
                                    $q->whereIn('attributes_value_id', $valueIds);
                                });
                        });
                    }
                }
            }
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                Log::warning("Attribute not found for slug: {$sortOption}");
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        $productsQuery->orderBy('inventories.mrp', 'asc');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderBy('inventories.mrp', 'desc');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            }

            $products = $productsQuery->with([
                'category',
                'images',
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
                ->paginate(32);
            // $attributes_with_values_for_filter_list = $category->attributes()
            // ->where('slug', '!=', $attribute_top->slug)
            // ->with(['AttributesValues' => function ($query) use ($category, $products) {
            //     $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
            //         $q->where('category_id', $category->id);
            //     })
            //     ->whereHas('productAttributesValues', function ($q) use ($products) {
            //         $q->whereHas('product', function ($q) use ($products) {
            //             $q->whereIn('id', $products->pluck('id'));
            //         });
            //     })->orderBy('name');
            // }])
            // ->orderBy('title')
            // ->get();
            $attributes_with_values_for_filter_list = $category->attributes()
                ->where('slug', '!=', $attribute_top->slug)
                ->with(['AttributesValues' => function ($query) use ($category) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->withCount(['productAttributesValues' => function ($q) use ($category) {
                            $q->whereHas('product', function ($q) use ($category) {
                                $q->where('category_id', $category->id);
                            });
                        }])
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();
            //return response()->json($attributes_with_values_for_filter_list);
            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-catalog-load-more', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                } else {
                    return response()->json([
                        'products' => view('frontend.pages.ajax-product-catalog', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                }
            }
            return view('frontend.pages.product-catalog', compact('products', 'category', 'attributeValue', 'attribute_top', 'attributes_with_values_for_filter_list'));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function showProductCatalogOld_31_1_2025(Request $request, $categorySlug, $attributeSlug, $valueSlug)
    {
        try {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $attribute_top = Attribute::where('slug', $attributeSlug)->first();
            if (!$attribute_top) {
                Log::error("No attribute found for slug: {$attributeSlug}");
                return response()->json(['error' => 'Attribute not found'], 404);
            }
            $attributeValue = Attribute_values::where('slug', $valueSlug)->firstOrFail();
            Log::info('Filters: ' . json_encode($request->query()));
            $productsQuery = Product::where('category_id', $category->id)
                ->where('product_status', 1);
            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $attributeSlug => $valueSlugs) {
                    if ($attributeSlug !== $attribute_top->slug) {
                        if (is_string($valueSlugs)) {
                            $valueSlugs = explode(',', $valueSlugs);
                        }
                        $attribute = Attribute::where('slug', $attributeSlug)->first();
                        if (!$attribute) {
                            Log::warning("Attribute not found for slug: {$attributeSlug}");
                            continue;
                        }
                        $valueIds = Attribute_values::whereIn('slug', $valueSlugs)->pluck('id')->toArray();
                        $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                            $query->where('attributes_id', $attribute->id)
                                ->whereHas('values', function ($q) use ($valueIds) {
                                    $q->whereIn('attributes_value_id', $valueIds);
                                });
                        });
                    }
                }
            }
            $attributes_with_values_for_filter_list = $category->attributes()
                ->where('slug', '!=', $attribute_top->slug)
                ->with(['AttributesValues' => function ($query) use ($category, $productsQuery) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->withCount(['productAttributesValues' => function ($q) use ($category, $productsQuery) {
                            $q->whereHas('product', function ($q) use ($category, $productsQuery) {
                                $q->where('category_id', $category->id)
                                    ->whereIn('id', $productsQuery->pluck('products.id'));
                            });
                        }])
                        // ->having('product_attributes_values_count', '>', 0)
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();
            $products = $productsQuery->with([
                'category',
                'images',
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with([
                            'attributeValue:id,slug',
                        ])
                        ->orderBy('id');
                },
            ])
                ->leftJoin('inventories', function ($join) {
                    $join->on('products.id', '=', 'inventories.product_id')
                        ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                })
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                ->paginate(32);
            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-catalog-load-more', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                } else {
                    return response()->json([
                        'products' => view('frontend.pages.ajax-product-catalog', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                }
            }
            return view('frontend.pages.product-catalog', compact(
                'products',
                'category',
                'attributeValue',
                'attribute_top',
                'attributes_with_values_for_filter_list'
            ));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function showProductCatalog(Request $request, $categorySlug, $attributeSlug, $valueSlug)
    {
        try {
            $primary_category = PrimaryCategory::where('link', $request->url())->first();
            $category = Category::where('slug', $categorySlug)->first();
            $attribute_top = Attribute::where('slug', $attributeSlug)->first();

            if (!$attribute_top) {
                Log::error("No attribute found for slug: {$attributeSlug}");
                return response()->json(['error' => 'Attribute not found'], 404);
            }

            $attributeValue = Attribute_values::where('slug', $valueSlug)->first();
            Log::info('Filters: ' . json_encode($request->query()));

            // Base products query
            $productsQuery = Product::where('category_id', $category->id)
                ->where('product_status', 1);

            // Apply the top attribute filter
            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });

            // Apply additional filters from the request
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $filterAttributeSlug => $filterValueSlugs) {
                    if ($filterAttributeSlug !== $attribute_top->slug) {
                        if (is_string($filterValueSlugs)) {
                            $filterValueSlugs = explode(',', $filterValueSlugs);
                        }
                        $attribute = Attribute::where('slug', $filterAttributeSlug)->first();
                        if (!$attribute) {
                            Log::warning("Attribute not found for slug: {$filterAttributeSlug}");
                            continue;
                        }
                        $valueIds = Attribute_values::whereIn('slug', $filterValueSlugs)->pluck('id')->toArray();
                        $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                            $query->where('attributes_id', $attribute->id)
                                ->whereHas('values', function ($q) use ($valueIds) {
                                    $q->whereIn('attributes_value_id', $valueIds);
                                });
                        });
                    }
                }
            }
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        $productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp ASC');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp DESC');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            } else {
                //$productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp ASC');
                $productsQuery->orderBy('created_at', 'desc');
            }

            // Fetch attributes with values for the filter list (mapped attributes and counts)
            $attributes_with_values_for_filter_list = $category->attributes()
                ->with(['AttributesValues' => function ($query) use ($category, $attribute_top, $attributeValue) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->withCount(['productAttributesValues' => function ($q) use ($category, $attribute_top, $attributeValue) {
                            // Calculate counts based on the filtered products query
                            $q->whereHas('product', function ($q) use ($category, $attribute_top, $attributeValue) {
                                $q->where('category_id', $category->id)
                                    ->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                                        $query->where('attributes_id', $attribute_top->id)
                                            ->whereHas('values', function ($q) use ($attributeValue) {
                                                $q->where('attributes_value_id', $attributeValue->id);
                                            });
                                    });
                            });
                        }])
                        ->having('product_attributes_values_count', '>', 0)
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();

            // Fetch paginated products (dynamic filtering)
            $products = $productsQuery->with([
                'category',
                'images' => function($query) {
                    $query->select('id', 'product_id', 'image_path')
                        ->orderBy('sort_order');
                },
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with([
                            'attributeValue:id,slug',
                        ])
                        ->orderBy('id');
                },
            ])
                ->leftJoin('inventories', function ($join) {
                    $join->on('products.id', '=', 'inventories.product_id')
                        ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
                })
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku')
                ->paginate(32);
                /**special offer rate */
                $specialOffers = getCustomerSpecialOffers();
                //dd($specialOffers);
                /**special offer rate */
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-catalog-load-more', compact('products','specialOffers', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                } else {
                    return response()->json([
                        'products' => view('frontend.pages.ajax-product-catalog', compact('products', 'specialOffers', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                }
            }
			DB::disconnect();
            // Return view for non-AJAX requests
            return view('frontend.pages.product-catalog', compact(
                'products',
                'category',
                'attributeValue',
                'attribute_top',
                'primary_category',
                'specialOffers',
                'attributes_with_values_for_filter_list'
            ));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function showProductDetails(Request $request, $slug, $attributes_value_slug)
    {
        /*Check customer whatapp click link is login or not */
        if (!auth()->guard('customer')->check()) {
            $decoded = Hashids::decode($request->get('token'));
            $customer_id = $decoded[0] ?? null;
            $product_id = $decoded[1] ?? null;
            if (!is_null($customer_id) && !is_null($product_id)) {
                $originalUrl = url()->full();
                $offer = SpecialOffer::where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->first();
                if ($offer) {
                    $customer = Customer::select('phone_number')->where('id', $customer_id)->first();
                    $phone_number = $customer->phone_number;
                    $otp = (string) rand(100000, 999999);
                    $sessionData = [
                        'otp' => $otp,
                        'expires_at' => now()->addMinutes(30),
                        'phone_number' => $phone_number,
                    ];
                    session(['whatsapp_otp' => $sessionData]);
                    $mobile_number = '91' . $phone_number;
                    Log::info('mobile Number:', ['no' => $mobile_number]);
                    Log::info('oTP:', ['no' => $otp]);
                    $response = $this->whatappLinkSendWhatappOtp($mobile_number, $otp);
                    // return redirect()->route('wp.otp.form', ['redirect_to' => $originalUrl])->with([
                    //     'success' => 'OTP sent successfully to your WhatsApp!',
                    //     'phone_number' => $phone_number,
                    // ]);
                    if ($response->successful()) {
                        return redirect()->route('wp.otp.form', ['redirect_to' => $originalUrl])->with([
                            'success' => 'OTP sent successfully to your WhatsApp No.!',
                            'phone_number' => $customer->phone_number,
                        ]);
                    }else {
                        Log::error('OTP send failed:', $response->json());
                        return redirect()->back()->with('error', 'Failed to send OTP. Try again.');
                    }
                }
            }
        }
        $specialOffers = getCustomerSpecialOffers();
        //dd($specialOffers);
        /*Check customer whatapp click link is login or not */
        $attributeValue = Attribute_values::where('slug', $attributes_value_slug)->first();
        /*First get the product and increment visitor count in one query*/
        $product = Product::where('slug', $slug)
        ->firstOrFail()
        ->increment('visitor_count');
        /*First get the product and increment visitor count in one query*/
       
        if (!$attributeValue) {
            $attributeValue = '';
        }
        $data['attributes_value_name'] = $attributeValue;
        $data['product_details'] = Product::with([
            'images' => function ($query) {
                $query->orderBy('sort_order');
            },
            'category',
            'brand',
            'attributes.attribute',
            'attributes.values.attributeValue',
            'additionalFeatures.feature'
        ])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku', 'inventories.stock_quantity')
            ->where('products.slug', $slug)
            ->firstOrFail();
        
        $categoryId = $data['product_details']->category->id;
        
        $data['related_products'] = Product::with([
            'images' => function ($query) {
                $query->orderBy('sort_order');
            },
            'category',
            'ProductImagesFront:id,product_id,image_path',
            'ProductAttributesValues' => function ($query) use ($attributeValue) {
                $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->where('attributes_value_id', $attributeValue->id)
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
            ->where('products.category_id', $categoryId)
            ->whereHas('productAttributesValues', function ($query) use ($attributeValue) {
                $query->where('attributes_value_id', $attributeValue->id);
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();
			DB::disconnect();
        /**Related product display */
        //return response()->json($data['product_details']);
        return view('frontend.pages.product', compact('data', 'specialOffers'));
    }

    public function showCategoryProduct_old_1_2_2025(Request $request, $categorySlug)
    {
        try {
            Log::info('Filters: ' . json_encode($request->query()));
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $productsQuery = Product::where('category_id', $category->id)->where('product_status', 1);

            /** for filter code */
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $attributeSlug => $valueSlugs) {
                    if (is_string($valueSlugs)) {
                        $valueSlugs = explode(',', $valueSlugs);
                    }
                    $attribute = Attribute::where('slug', $attributeSlug)->first();
                    if (!$attribute) {
                        Log::warning("Attribute not found for slug: {$attributeSlug}");
                        continue;
                    }
                    $valueIds = Attribute_values::whereIn('slug', $valueSlugs)->pluck('id')->toArray();
                    $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                        $query->where('attributes_id', $attribute->id)
                            ->whereHas('values', function ($q) use ($valueIds) {
                                $q->whereIn('attributes_value_id', $valueIds);
                            });
                    });
                }
            }
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                Log::warning("Attribute not found for slug: {$sortOption}");
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        Log::warning("Attribute not found for slug: {$sortOption}");
                        $productsQuery->orderBy('inventories.mrp', 'asc');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderBy('inventories.mrp', 'desc');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            }
            /** end filter code */

            $products = $productsQuery->with([
                'category',
                'images',
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
                ->paginate(32);

            $attributes_with_values_for_filter_list = $category->attributes()
                ->with(['AttributesValues' => function ($query) use ($category, $products) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->whereHas('productAttributesValues', function ($q) use ($products) {
                            $q->whereHas('product', function ($q) use ($products) {
                                $q->whereIn('id', $products->pluck('id'));
                            });
                        })->orderBy('name');
                }])
                ->orderBy('title')
                ->get();

            // if ($request->ajax()) {
            //     return response()->json([
            //         'products' => view('frontend.pages.ajax-product-category-catalog', compact('products'))->render(),
            //         'hasMore' => $products->hasMorePages(),
            //         'attributes' => $attributes_with_values_for_filter_list
            //     ]);
            // }

            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-catalog-load-more', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                } else {
                    return response()->json([
                        'products' => view('frontend.pages.ajax-product-category-catalog', compact('products', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                }
            }
			DB::disconnect();

            return view('frontend.pages.product-catalog-category', compact('products', 'category', 'attributes_with_values_for_filter_list'));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function showCategoryProduct(Request $request, $categorySlug)
    {
        try {
            $primary_category = PrimaryCategory::where('link', $request->url())->first();
            Log::info('Filters: ' . json_encode($request->query()));
            $category = Category::where('slug', $categorySlug)->first();
            $productsQuery = Product::where('category_id', $category->id)->where('product_status', 1);

            /** for filter code */
            $filters = $request->query();
            if (!empty($filters)) {
                foreach ($filters as $attributeSlug => $valueSlugs) {
                    if (is_string($valueSlugs)) {
                        $valueSlugs = explode(',', $valueSlugs);
                    }
                    $attribute = Attribute::where('slug', $attributeSlug)->first();
                    if (!$attribute) {
                        Log::warning("Attribute not found for slug: {$attributeSlug}");
                        continue;
                    }
                    $valueIds = Attribute_values::whereIn('slug', $valueSlugs)->pluck('id')->toArray();
                    $productsQuery->whereHas('attributes', function ($query) use ($attribute, $valueIds) {
                        $query->where('attributes_id', $attribute->id)
                            ->whereHas('values', function ($q) use ($valueIds) {
                                $q->whereIn('attributes_value_id', $valueIds);
                            });
                    });
                }
            }

            $attributes_with_values_for_filter_list = $category->attributes()
                ->with(['AttributesValues' => function ($query) use ($category) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->withCount(['productAttributesValues' => function ($q) use ($category) {
                            $q->whereHas('product', function ($q) use ($category) {
                                $q->where('category_id', $category->id);
                            });
                        }])
                        //->having('product_attributes_values_count', '>', 0)
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();
            // Sorting logic
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        $productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp ASC');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp DESC');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            } else {
                //$productsQuery->orderByRaw('ISNULL(inventories.mrp), inventories.mrp ASC');
                $productsQuery->orderBy('created_at', 'desc');
            }

            // Fetching products with the necessary relationships
            $products = $productsQuery->with([
                'category',
                'images' => function($query) {
                    $query->select('id', 'product_id', 'image_path')
                        ->orderBy('sort_order');
                },
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
                ->paginate(32);
            $specialOffers = getCustomerSpecialOffers();
            //dd($specialOffers);
            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-category-catalog-load-more', compact('products', 'specialOffers', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                } else {
                    return response()->json([
                        'products' => view('frontend.pages.ajax-product-category-catalog', compact('products', 'specialOffers', 'attributes_with_values_for_filter_list'))->render(),
                        'hasMore' => $products->hasMorePages(),
                    ]);
                }
            }
			DB::disconnect();
            return view('frontend.pages.product-catalog-category', compact('products', 'specialOffers', 'category', 'attributes_with_values_for_filter_list', 'primary_category'));
        } catch (\Exception $e) {
            Log::error('Error fetching product catalog: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    public function QuickViewModal(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::with([
            'images' => function ($query) {
                $query->orderBy('sort_order');
            },
            'category',
            'brand',
            'attributes.attribute',
            'attributes.values.attributeValue'
        ])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.sku')
            ->where('products.id', $product_id)
            ->firstOrFail();

        if ($product->images->isNotEmpty()) {
            $imageUrl = asset('images/product/large/' . $product->images->first()->image_path);
            $imagePaths = $product->images->map(function ($image) {
                return asset('images/product/small/' . $image->image_path);
            })->toArray();
            $thumbPaths = $product->images->map(function ($image) {
                return asset('images/product/thumb/' . $image->image_path);
            })->toArray();
        } else {
            $imageUrl = asset('frontend/assets/gd-img/product/no-image.png');
            $imagePaths = [$imageUrl];
            $thumbPaths = [$imageUrl];
        }

        if ($product->mrp === null) {
            $productMrp = '<span>Price not available</span>';
        } else {
            $productMrp = '<span>Rs. ' . $product->mrp . '</span>';
        }

        if ($product->offer_rate === null) {
            $productOfferRate = '';
        } else {
            $productOfferRate = '<del>Rs. ' . $product->offer_rate . '</del>';
        }

        $quickViewModal = '
        <div class="modal-body">
            <div class="row g-2">
                <div class="col-lg-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="overflow: hidden;">';
        foreach ($imagePaths as $key => $imagePath) {
            $quickViewModal .= '
                                <div class="carousel-item ' . ($key === 0 ? 'active' : '') . '">
                                    <img src="' . $imagePath . '" class="d-block w-100 img-fluid image_zoom_cls-0 blur-up lazyload" data-zoom-image="' . $imagePath . '" alt="' . ucwords(strtolower($product->title)) . '">
                                </div>';
        }
        $quickViewModal .= '
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!--<div class="thumb-slider mt-3 d-flex justify-content-center">';
        foreach ($thumbPaths as $key => $thumbPath) {
            $quickViewModal .= '
                            <div class="thumb-item mx-2" style="cursor: pointer;">
                                <img src="' . $thumbPath . '" class="img-thumbnail img-fluid blur-up lazyload" alt="Thumbnail" onclick="$(\'#carouselExampleIndicators\').carousel(' . $key . ')">
                            </div>';
        }
        $quickViewModal .= '
                    </div>-->
                </div>
                <div class="col-lg-6">
                    <div class="right-sidebar-modal">
                        <h4 class="title-name">
                            ' . ucwords(strtolower($product->title)) . '
                        </h4>
                        <h4 class="price">
                            ' . $productMrp . '
                            ' . $productOfferRate . '
                        </h4>
                        <div class="product-detail">
                            <h4>Product Details :</h4>
                            ' . ($product->product_description ?: 'No details available for this product.') . '
                        </div>';
        if (isset($product->attributes) && $product->attributes->isNotEmpty()) {
            $quickViewModal .= '<ul class="brand-list">';
            foreach ($product->attributes as $attribute) {
                $attributeName = $attribute->attribute->title ?? 'N/A';
                $values = $attribute->values->map(function ($value) {
                    return $value->attributeValue->name ?? '';
                })->filter()->join(', ');
                $quickViewModal .= '
                                <li>
                                    <div class="brand-box">
                                        <h5>' . htmlspecialchars($attributeName) . ':</h5>
                                        <h6>' . htmlspecialchars($values) . '</h6>
                                    </div>
                                </li>';
            }
            $quickViewModal .= '</ul>';
        }
        $quickViewModal .= '
                    <div class="modal-button">';
        if (auth()->guard('customer')->check()) {
            if ($product->mrp) {
                $quickViewModal .= '
                                <div class="product-package">
                                    <input type="hidden" class="qty-input" value="1">
                                    <button class="add-to-cart btn btn-md add-cart-button icon" 
                                        data-url="' . route('add.to.cart') . '" 
                                        data-pid="' . $product->id . '"
                                        data-mrp="' . $product->mrp . '">
                                        Add To Cart
                                    </button>
                                </div>';
            } else {
                $quickViewModal .= '
                                <button disabled class="btn btn-md add-cart-button icon">
                                    Out Of Stock
                                </button>';
            }
        } else {
            $quickViewModal .= '
                            <button onclick="location.href=\'' . route('logincustomer') . '?redirect=' . urlencode(url()->previous()) . '\';" 
                                class="btn btn-md add-cart-button icon">
                                Add To Cart
                            </button>';
        }

        $quickViewModal .= '
                            <button onclick="location.href=\'' . url('products/' . $product->slug) . '\'" 
                                class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                View More Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return response()->json([
            'message' => 'Quick view modal created successfully',
            'quickviewmodal' => $quickViewModal,
        ]);
    }

    public function blogList($blogCategorySlug)
    {
        $blog_category = BlogCategory::where('slug', $blogCategorySlug)->firstOrFail();
        $blog = Blog::where('blog_category_id', $blog_category->id)->get();
        $blog_recent_post = Blog::where('created_at', '>=', Carbon::now()->subMonth())
            /**one month pahele ka data */
            ->inRandomOrder()
            ->take(4)
            ->get();
			DB::disconnect();
        //return response()->json($blog);
        return view('frontend.pages.blog.blog-list', compact('blog', 'blog_category', 'blog_recent_post'));
    }

    public function blogDetails($slug)
    {
        $blog = Blog::with([
            'category',
            'paragraphs.productLinks.product' => function ($query) {
                $query->with([
                    'images' => function ($query) {
                        $query->select('id', 'product_id', 'image_path')->orderBy('sort_order');
                    },
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
        ->where('slug', $slug)
        ->firstOrFail();

        $blog_category_id = $blog->blog_category_id;
        $blog_recent_post = Blog::where('blog_category_id', $blog_category_id)
            ->where('slug', '!=', $slug)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            /**one month pahele ka data */
            ->inRandomOrder()
            ->take(4)
            ->get();
        $blog_categories = BlogCategory::withCount('blogs')
            ->where('status', 1)
            ->orderBy('title')
            ->get();
			DB::disconnect();
        //return response()->json($blog);
        return view('frontend.pages.blog.blog-details', compact('blog', 'blog_recent_post', 'blog_categories'));
    }

    public function contactUs()
    {
        return view('frontend.pages.contact-us.index');
    }

    public function contactUsSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:10',
            //'message' => 'required|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            Mail::to('akshat.gd@gmail.com')->send(new ContactUsMail($request));
            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message. Please try again.',
            ]);
        }
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us.index');
    }

    public function productEnquiryModalForm(Request $request)
    {
        $productId = $request->input('productId');
        $currentPageUrl = $request->input('currentPageUrl');
        if (auth('customer')->check()) {
            $customer = auth('customer')->user();
            $customerId = $customer->id;
            $customerName = $customer->name;
            $customerEmail = $customer->email;
            $customerPhone = $customer->phone_number;
        } else {
            $customerName = '';
            $customerEmail = '';
            $customerPhone = '';
        }

        $form = '
        <form method="POST" action="' . route('product-enquiry-modal-form.submit') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="productEnquiryForm">
            ' . csrf_field() . '
            <input type="hidden" value="' . $productId . '" name="product_id"> 
            <input type="hidden" value="' . $currentPageUrl . '" name="current_page_url"> 
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-2">
                        <label for="name" class="form-label">Enter your name *</label>
                        <input type="text" id="name" name="name" class="form-control" value="' . $customerName . '">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-2">
                        <label for="phone_number" class="form-label">Enter your phone number *</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" value="' . $customerPhone . '">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-2">
                        <label for="email" class="form-label">Enter your email</label>
                        <input type="email" id="email" name="email" class="form-control" value="' . $customerEmail . '">
                    </div>
                </div>
                
                
                <div class="modal-footer pb-0">
                    <!--<button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Close</button>-->
                    <button style="color:#ffffff;" type="submit" class="btn btn-2-animation btn-md fw-bold">Save changes</button>
                </div>
            </div>
        </form>
        ';
        return response()->json([
            'message' => 'Category Form created successfully',
            'form' => $form,
        ]);
    }

    public function productEnquiryModalFormSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|digits_between:10,15',
            //'email' => 'required|email',
            'product_id' => 'required|integer',
            'current_page_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $product = Product::with([
            'images' => function ($query) {
                $query->select('id', 'product_id', 'image_path')->orderBy('id');
            },
            'ProductAttributesValues' => function ($query) {
                $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                    ->with([
                        'attributeValue:id,slug'
                    ])
                    ->orderBy('id');
            }
        ])->where('id', $request->product_id)->firstOrFail();
        $firstImage = $product->images->first();
        if ($firstImage && !empty($firstImage->image_path)) {
            $imageFileName = str_replace('.webp', '.jpg', $firstImage->image_path);
            $imagePathWebP = asset('images/product/thumb/' . $firstImage->image_path);
            $imagePathJpg = asset('images/product/jpg-image/thumb/' . $imageFileName);
            if (!file_exists(public_path('images/product/jpg-image/thumb/' . $imageFileName))) {
                $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
            }
            $imageName = $imageFileName;
        } else {
            $imagePathWebP = null;
            $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
            $imageName = 'Girdhar-Das-and-Sons.jpg';
        }

        
        
        $this->sendAiSensyCampaign(
            $request->phone_number,
            $request->name,
            $request->current_page_url,
            $product->title,
            $imagePathJpg,
            $imageName
        );
        // $existingConversation = WhatsappConversation::where('mobile_number', $request->phone_number)->first();
        // if (!$existingConversation) {
            $conversation = WhatsappConversation::create([
                'mobile_number' => $request->phone_number,
                'name' => $request->name,
                'conversation_message' => $product->title,
            ]);
        //}
        return response()->json([
            'status' => 'success',
            'message' => 'Enquiry submitted successfully, Our team contact you shortly.!',
            'image_path' =>  $imagePathJpg,
            'image_name' => $imageName,
            'product_path' =>  $request->current_page_url,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    private function sendAiSensyCampaign(
        $customerPhone,
        $customerName,
        $currentPageUrl,
        $productName,
        $imagePath,
        $imageName
    ) {
        $apiEndpoint = "https://backend.aisensy.com/campaign/t1/api/v2";
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY";

        $data = [
            'apiKey' => $apiKey,
            'campaignName' => "confirm_product_enq_upd_3",
            'destination' => $customerPhone,
            'userName' => $customerName,
            'source' => "Product enquiry from website",
            "templateParams" => [
                $customerName,
                $productName
            ],
            "source" => "Product enquiry from website",
            "media" => new \stdClass(),
            "buttons" => [],
            "carouselCards" => [],
            "location" => new \stdClass(),
            "paramsFallbackValue" => [
                "FirstName" => "User"
            ]
        ];

        $this->makeApiRequest($apiEndpoint, $data);

        // Send notification to admin
        $adminData = [
            'apiKey' => $apiKey,
            'campaignName' => "Product_Enq_Admin",
            'destination' => "919935070000",
            'userName' => "Akshat Agrawal",
            'source' => "New Landing page form Facebook",
            'media' => [
                'url' => "https://www.app.aisensy.com/projects",
                'filename' => "pdf_file",
            ],
            'templateParams' => [$customerPhone, $customerName, $currentPageUrl],
            'tags' => ["new_lead", "bba"],
            'attributes' => [
                'attribute_name' => "attribute_name_value",
            ],
        ];

        $this->makeApiRequest($apiEndpoint, $adminData);
    }

    private function makeApiRequest($apiEndpoint, $data){
        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $data['apiKey'],
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function updateCounter(Request $request){
        $counter = Counter::where('title', $request->counter_type)->first();

        if ($counter) {
            $counter->increment('counter');
        } else {
            Counter::create([
                'title' => $request->counter_type,
                'counter' => 1
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Counter updated successfully!']);
    }

    public function whatappLinkSendWhatappOtp($mobile_number, $otp){
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY";
        
        $response = Http::post('https://backend.aisensy.com/campaign/t1/api/v2', [
            'apiKey' => $apiKey,
            'campaignName' => 'gdsons_login_otp',
            'destination' =>$mobile_number,
            'userName' => $mobile_number,
            'templateParams' => [$otp],
            'source' => 'new-landing-page form',
            'media' => new \stdClass(),
            'buttons' => [
                [
                    'type' => 'button',
                    'sub_type' => 'url',
                    'index' => 0,
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => $otp
                        ]
                    ]
                ]
            ],
            'carouselCards' => [],
            'location' => new \stdClass(),
            'attributes' => new \stdClass(),
            'paramsFallbackValue' => [
                'FirstName' => 'user'
            ]
        ]);
        return $response;
    }

    public function WhatAppClickShowOtpForm(){
        //dd(session()->all());
        return view('frontend.pages.whatapp-otp-form');
    }

    public function WhatappVerifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'redirect_to' => 'required|url',
        ]);
        
        $otpData = Session::get('whatsapp_otp');
        $storedOtp = $otpData['otp'] ?? null;
        $expiresAt = $otpData['expires_at'] ?? null;
        $phoneNumber = $otpData['phone_number'] ?? null;
        Log::info('OTP Session Data:', [
            'storedOtp' => $storedOtp,
            'expiresAt' => $expiresAt,
            'now' => now(),
            'isExpired' => \Carbon\Carbon::parse($expiresAt)->lt(now())
        ]);
        if (!$storedOtp || !$expiresAt || \Carbon\Carbon::parse($expiresAt)->lt(now())) {
            return back()->withErrors(['otp' => 'OTP expired. Please try again.']);
        }

        if ($request->otp !== $storedOtp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }else{
            $customer = Customer::where('phone_number', $phoneNumber)->first();
            Auth::guard('customer')->login($customer);
            Session::forget('whatsapp_otp');
            return redirect()->to($request->redirect_to)->with('success', 'OTP verified successfully!');
        }
      
    }

    
}
