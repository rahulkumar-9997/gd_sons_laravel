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
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
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
use App\Models\ProductEnquiry;
use App\Models\ClickTrackers;

class FrontendController extends Controller
{
    public function home()
    {

        $labels = Label::whereIn('title', ['Popular Product', 'Trending Product'])
            ->get()
            ->keyBy('title');
        $specialOffers = getCustomerSpecialOffers();
        $popular_label_id = $labels['Popular Product']->id ?? null;
        $trending_label_id = $labels['Trending Product']->id ?? null;
        $data['category_list'] = Category::where('status', 'on')->get(['id', 'title', 'slug', 'image']);
        /*$data['primary_category'] = PrimaryCategory::where('status', 1)
            ->whereNotNull('product_id')
            ->where('product_id', '<>', '')
            ->with([
                'product' => function($query) {
                    $query->select('id', 'title');
                },
                'product.firstSortedImage' => function($query) {
                    $query->select('id', 'product_id', 'image_path');
                }
            ])
        ->orderBy('title')
        ->get(['id', 'title', 'link', 'product_id']);
        */
        $data['primary_category'] = PrimaryCategory::where('status', 1)
        ->orderBy('title')
        ->get(['id', 'title', 'link']);
        //return response()->json($data['primary_category']); 
        $data['banner'] = Banner::orderBy('id', 'desc')->get(['id', 'image_path_desktop', 'link_desktop', 'title']);
        $data['video'] = Video::inRandomOrder()->select('video_url')->take(2)->get();
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
            $productsQuery = Product::where('category_id', $category->id)
                ->where('product_status', 1);
            $productsQuery->whereHas('attributes', function ($query) use ($attribute_top, $attributeValue) {
                $query->where('attributes_id', $attribute_top->id)
                    ->whereHas('values', function ($q) use ($attributeValue) {
                        $q->where('attributes_value_id', $attributeValue->id);
                    });
            });
            /* Apply additional filters from the request */
            if ($request->has('filter')) {
                Log::info('Filters attributes value catalog: ' . json_encode($request->query()));
                $filters = $request->except(['filter', 'sort', 'page']);
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
                        $productsQuery->orderByRaw('ISNULL(inventories.offer_rate), inventories.offer_rate ASC');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderByRaw('ISNULL(inventories.offer_rate), inventories.offer_rate DESC');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            } else {
                $productsQuery->orderBy('created_at', 'desc');
            }

            /* Fetch attributes with values for the filter list (mapped attributes and counts) */
            $attributes_with_values_for_filter_list = $category->attributes()
                ->with(['AttributesValues' => function ($query) use ($category, $attribute_top, $attributeValue) {
                    $query->whereHas('map_attributes_value_to_categories', function ($q) use ($category) {
                        $q->where('category_id', $category->id);
                    })
                        ->withCount(['productAttributesValues' => function ($q) use ($category, $attribute_top, $attributeValue) {
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
            $products = $productsQuery->with([
                'category',
                'images' => function ($query) {
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
            ->whereHas('images')/*only select which product whose images have (if all product selected than remove this line)*/
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku', 'inventories.stock_quantity')
            ->paginate(32);
            /**special offer rate */
            $specialOffers = getCustomerSpecialOffers();
            /**special offer rate */
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                if ($request->has('load_more') && $request->get('load_more') == true) {
                    return response()->json([
                        'products' => view('frontend.pages.partials.product-catalog-load-more', compact('products', 'specialOffers', 'attributes_with_values_for_filter_list'))->render(),
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
        //if (!auth()->guard('customer')->check()) {
        if ($request->has('token') && !auth()->guard('customer')->check()) {
            $decoded = Hashids::decode($request->get('token'));
            $customer_id = $decoded[0] ?? null;
            $product_id = $decoded[1] ?? null;
            $originalUrl = $request->fullUrl();
            if (!is_null($customer_id) && !is_null($product_id))
            {
                $offer = SpecialOffer::where('customer_id', $customer_id)
                    ->where('product_id', $product_id)
                    ->first();
                if ($offer) {
                    $offer_url = $offer->url;
                    if (!$offer_url) {
                       // Log::warning('Offer URL is missing', ['offer_id' => $offer->id]);
                        return redirect('/')->with('error', 'Invalid offer URL.');
                    }
                    //$customer = Customer::select('phone_number')->where('id', $customer_id)->first();
                    $customer = Customer::where('id', $customer_id)->first();
                    if ($customer)
                    {
                        Auth::shouldUse('customer');
                        /*Manually set the customer in session before redirect*/
                        session()->put('auth.customer_id', $customer->id);
                        /*Force save the session*/
                        session()->save(); 
                        /*Now perform the actual login*/
                        Auth::guard('customer')->login($customer);
                        $cleanUrl = preg_replace('/([&?])token=[^&]+(&)?/', '$1', $originalUrl);
                        $cleanUrl = rtrim($cleanUrl, '?&');
                        if (auth()->guard('customer')->check()) {
                            return redirect()->to($cleanUrl)
                                ->with('success', 'Login successful!')
                                ->withHeaders([
                                    'Cache-Control' => 'no-store, no-cache, must-revalidate',
                                    'Pragma' => 'no-cache'
                                ]);
                        } else {
                            Log::error('Login verification failed', [
                                'customer_id' => $customer_id,
                                'session_id' => session()->getId()
                            ]);
                            return redirect('/')->with('error', 'Login failed. Please try again.');
                        }                        
                    } else {
                        return redirect('/')->with('error', 'Customer not found!');
                    }
                    /*$phone_number = $customer->phone_number;
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
                    
                    if ($response->successful()) {
                        return redirect()->route('wp.otp.form', ['redirect_to' => $originalUrl])->with([
                            'success' => 'OTP sent successfully to your WhatsApp No.!',
                            'phone_number' => $customer->phone_number,
                        ]);
                    } else {
                        Log::error('OTP send failed:', $response->json());
                        return redirect()->back()->with('error', 'Failed to send OTP. Try again.');
                    }
                    */
                }
            }
            else
            {
                $cleanUrl = preg_replace('/([&?])token=[^&]+(&)?/', '$1', $originalUrl);
                $clean_url = rtrim($cleanUrl, '?&');
                return redirect($clean_url)->with('error', 'You did not get special offer rate!');
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
                        $productsQuery->orderBy('inventories.offer_rate', 'asc');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderBy('inventories.offer_rate', 'desc');
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
            $category = Category::where('slug', $categorySlug)->first();
            $productsQuery = Product::where('category_id', $category->id)->where('product_status', 1);
            /** for filter code */            
            if ($request->has('filter')) {
                Log::info('Filters category catalog: ' . json_encode($request->query()));
                $filters = $request->except(['filter', 'sort', 'page']);
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
                        ->orderBy('name');
                }])
                ->orderBy('title')
                ->get();
            if ($request->has('sort')) {
                $sortOption = $request->get('sort');
                switch ($sortOption) {
                    case 'new-arrivals':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'price-low-to-high':
                        $productsQuery->orderByRaw('ISNULL(inventories.offer_rate), inventories.offer_rate ASC');
                        break;
                    case 'price-high-to-low':
                        $productsQuery->orderByRaw('ISNULL(inventories.offer_rate), inventories.offer_rate DESC');
                        break;
                    case 'a-to-z-order':
                        $productsQuery->orderBy('products.title', 'asc');
                        break;
                    default:
                        $productsQuery->orderBy('products.id', 'desc');
                        break;
                }
            } else {
                $productsQuery->orderBy('created_at', 'desc');
            }
            $products = $productsQuery->with([
                'category',
                'images' => function ($query) {
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
                ->whereHas('images')/*only select which product whose images have (if all product selected than remove this line)*/
                ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku', 'inventories.stock_quantity')
                ->paginate(32);
            $specialOffers = getCustomerSpecialOffers();
            //return response()->json($products); 
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

    public function productEnquiryModalFormSubmit(Request $request)
    {
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

    private function makeApiRequest($apiEndpoint, $data)
    {
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

    public function updateCounter(Request $request)
    {
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

    public function whatappLinkSendWhatappOtp($mobile_number, $otp)
    {
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY";

        $response = Http::post('https://backend.aisensy.com/campaign/t1/api/v2', [
            'apiKey' => $apiKey,
            'campaignName' => 'gdsons_login_otp',
            'destination' => $mobile_number,
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

    public function WhatAppClickShowOtpForm()
    {
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
        } else {
            $customer = Customer::where('phone_number', $phoneNumber)->first();
            Auth::guard('customer')->login($customer);
            Session::forget('whatsapp_otp');
            return redirect()->to($request->redirect_to)->with('success', 'OTP verified successfully!');
        }
    }

    public function privacyPolicy()
    {
        return view('frontend.pages.privacy-policy');
    }

    public function termsOfUse()
    {
        return view('frontend.pages.term-of-use');
    }

    public function flashSale(Request $request)
    {
        $flashLabel = Label::where('title', 'Flash Sale')->first();
        $flash_label_id = $flashLabel->id;
        $specialOffers = getCustomerSpecialOffers(); 
        $query = Product::where('product_status', 1)
            ->where('label_id', $flash_label_id)
            ->with([
                'images' => function ($query) {
                    $query->select('id', 'product_id', 'image_path')->orderBy('sort_order');
                },
                'category',
                'attributes.attribute',
                'attributes.values.attributeValue',
            ])
            ->leftJoin('inventories', function ($join) {
                $join->on('products.id', '=', 'inventories.product_id')
                    ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
            })
            ->select('products.*', 'inventories.mrp', 'inventories.offer_rate', 'inventories.purchase_rate', 'inventories.sku', 'inventories.stock_quantity');
        /*Apply filters*/        
        if ($request->has('filter')) {
            Log::info('Filters flash sale: ' . json_encode($request->query()));
            foreach ($request->all() as $attributeSlug => $valueSlugs) {
                if ($attributeSlug === 'filter' || $attributeSlug === 'sort' || strpos($attributeSlug, 'price') !== false) {
                    continue;
                }
                $valueSlugsArray = array_filter(explode(',', $valueSlugs));
                $query->whereHas('attributes.values.attributeValue', function($q) use ($attributeSlug, $valueSlugsArray) {
                    $q->whereHas('attribute', function($q) use ($attributeSlug) {
                        $q->where('slug', $attributeSlug);
                    })->whereIn('slug', $valueSlugsArray);
                });
            }
        }
        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price-low-to-high':
                    $query->orderBy('inventories.offer_rate', 'asc');
                    break;
                case 'price-high-to-low':
                    $query->orderBy('inventories.offer_rate', 'desc');
                    break;
                case 'a-to-z-order':
                    $query->orderBy('products.title', 'asc');
                    break;
                case 'new-arrivals':
                    $query->orderBy('products.created_at', 'desc');
                    break;
                default:
                    $query->orderBy('products.created_at', 'desc');
            }
        } else {
            $query->orderBy('products.created_at', 'desc');
        }
        $products = $query->get();
        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.pages.ajax-flash-deal', compact('products', 'specialOffers'))->render()
            ]);
        }

        $attributes_with_values_for_filter_list = [];
        $allProducts = Product::where('product_status', 1)
            ->where('label_id', $flash_label_id)
            ->with(['attributes.attribute', 'attributes.values.attributeValue'])
            ->get();

        foreach ($allProducts as $product) {
            foreach ($product->attributes as $attributeRelation) {
                $attribute = $attributeRelation->attribute;
                if (!$attribute) continue;

                $attrId = $attribute->id;
                $attrSlug = $attribute->slug;
                $attrTitle = $attribute->title;

                if (!isset($attributes_with_values_for_filter_list[$attrId])) {
                    $attributes_with_values_for_filter_list[$attrId] = [
                        'attribute_title' => $attrTitle,
                        'attribute_slug' => $attrSlug,
                        'values' => [],
                    ];
                }

                foreach ($attributeRelation->values as $valueRelation) {
                    $attributeValue = $valueRelation->attributeValue;
                    if ($attributeValue && !isset($attributes_with_values_for_filter_list[$attrId]['values'][$attributeValue->id])) {
                        if($attributeValue->name !== 'NA') {
                            $attributes_with_values_for_filter_list[$attrId]['values'][$attributeValue->id] = [
                                'id' => $attributeValue->id,
                                'name' => $attributeValue->name ?? $attributeValue->slug,
                                'slug' => $attributeValue->slug,
                            ];
                        }
                    }
                }
            }
        }

        DB::disconnect();
        return view('frontend.pages.flash-sale', compact('products', 'specialOffers', 'attributes_with_values_for_filter_list'));
    }

    public function requestProductEnquiryForm(Request $request){
        $form = '
        <form method="POST" action="' . route('request.product.enquiry.submit') . '" accept-charset="UTF-8" enctype="multipart/form-data" id="productEnquiryForm">
            ' . csrf_field() . '
            <input type="hidden" name="check_spam">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-md-4 mb-3 custom-form">
                        <div class="custom-input">
                            <input type="text" class="form-control" id="name" placeholder="Enter your name *" name="name">

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-md-4 mb-3 custom-form">
                        <div class="custom-input">
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number *" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                            this.value.slice(0, this.maxLength);" name="phone">

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-md-4 mb-3 custom-form">
                        <div class="custom-textarea">
                            <textarea class="form-control" id="message" placeholder="Enter your message" rows="3" name="message"></textarea>

                        </div>
                    </div>
                </div>
                
                
                <div class="modal-footer pb-0">
                    <!--<button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Close</button>-->
                    <button style="color:#ffffff;" type="submit" class="btn btn-2-animation btn-md fw-bold">Submit</button>
                </div>
            </div>
        </form>
        ';
        return response()->json([
            'message' => 'Form created successfully',
            'form' => $form,
        ]);
    }

    public function requestProductSubmit(Request $request)
    {
        if ($request->filled('check_spam')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Spam detected. Submission rejected.'
            ], 400);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $enquiry = ProductEnquiry::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);

            $basePayload = [
                'apiKey' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY',
                'userName' => 'Girdhar Das and Sons',
                'source' => 'new-landing-page form',
                'media' => new \stdClass(),
                'buttons' => [],
                'carouselCards' => [],
                'location' => new \stdClass(),
                'attributes' => new \stdClass(),
                'paramsFallbackValue' => [
                    'FirstName' => 'user'
                ]
            ];

            /*Send message to Customer*/
            $customerPayload = array_merge($basePayload, [
                'campaignName' => 'confirm_product_enq_upd_3',
                'destination' => '91' . $request->phone,
                'templateParams' => [
                    $request->name,
                    $request->message
                ],
            ]);

            $customerResponse = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $customerPayload);

            /* Send message to Admin*/
            $adminPayload = array_merge($basePayload, [
                'campaignName' => 'General Enquiry to Admin',
                'destination' => '919935070000',
                'templateParams' => [
                    $request->name,
                    $request->phone,
                    $request->message ?? 'No message provided'
                ],
            ]);

            $adminResponse = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $adminPayload);

            if (!$customerResponse->successful() || !$adminResponse->successful()) {
                throw new \Exception('Failed to send one or more AiSensy messages.');
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Your enquiry has been submitted successfully. Our team will contact you shortly.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ProductEnquiry Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while processing your enquiry. Please try again later.'
            ], 500);
        }
    }

    public function clickTracker(Request $request)
    {
        $validated = $request->validate([
            'btn_type' => 'required|string',
            'page_url' => 'required|url',
        ]);
        $agent = new Agent();
        $ip = $request->ip();
        $pageUrl = $request->page_url;
        /* Check if the same IP+URL clicked in the last 5 minutes */
        //$recentClickExists = ClickTrackers::where('ip_address', $ip)
         //   ->where('page_url', $pageUrl)
         //   ->where('click_time', '>=', now()->subMinutes(5))
         //   ->exists();
        //if (!$recentClickExists) {
            ClickTrackers::create([
                'button_type' => $request->btn_type,
                'page_url' => $request->page_url,
                'ip_address' => $request->ip(),
                'click_time' => now()->setTimezone('Asia/Kolkata'),
                'device_type' => $this->getDeviceType($agent),
            ]);
        //}
        return response()->json(['success' => true]);
    }
    
    protected function getDeviceType($agent)
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    public function checkServiceability(Request $request)
    {
        Log::info('Magic Checkout Request:', [
            'headers' => request()->headers->all(),
            'body' => request()->all(),
            'server' => request()->server->all()
        ]);
        $request->validate([
            'addresses' => 'required|array',
            'addresses.*.zipcode' => 'required|digits:6'
        ]);

        $pincode = $request->input('addresses.0.zipcode');
        $serviceablePincodes = [
            '221010' => ['fee' => 5000, 'cod' => true, 'delivery' => '2-3 days'],
            '560001' => ['fee' => 7000, 'cod' => true, 'delivery' => '1-2 days'],
            // ... other pincodes
        ];

        if (array_key_exists($pincode, $serviceablePincodes)) {
            $rules = $serviceablePincodes[$pincode];
            
            return response()->json([
                'serviceable' => true,
                'cod_serviceable' => $rules['cod'],
                'shipping_fee' => $rules['fee'],
                'cod_fee' => $rules['cod'] ? 0 : null,
                'delivery_time' => $rules['delivery']
            ])->header('Access-Control-Allow-Origin', '*');
        }

        return response()->json([
            'serviceable' => false,
            'cod_serviceable' => false,
            'shipping_fee' => 0,
            'cod_fee' => 0,
            'delivery_time' => 'Not serviceable'
        ])->header('Access-Control-Allow-Origin', '*');
    }

}



