@php
$brand = '';
$schema_offer = 0;
$categorytitle = $data['product_details']->category->title;
if (substr($categorytitle, -1) === 's')
{
$categorytitle = substr($categorytitle, 0, -1);
}
if ($data['product_details']->meta_title) {
$meta_title = $data['product_details']->meta_title;
} else {
$meta_title = removeDuplicateWords(ucwords(strtolower($categorytitle . ' ' . $data['attributes_value_name']->name. ' ' . $data['product_details']->title)));
}

if ($data['product_details']->meta_description) {
$meta_description = $data['product_details']->meta_description;
} else {
$meta_description = 'Great Offer on '. $categorytitle.'. Best '.ucwords(strtolower($data['attributes_value_name']->name)). ' Product. '.ucwords(strtolower($data['product_details']->title))
. ' at best Online Price. Best Retail Store in Varanasi. Get more discount for Bulk Orders.';
}
@endphp
@section('meta')
@php
$firstImage = $data['product_details']->images->isNotEmpty()
? asset('images/product/thumb/' . $data['product_details']->images->first()->image_path)
: asset('frontend/assets/gd-img/product/no-image.png');
@endphp
<meta property="og:title" content="{{ ucwords(strtolower($data['product_details']->title)) }}" />
<meta property="og:description" content="{{ $meta_description }}" />
<meta property="og:image" content="{{ $firstImage }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="product" />
@endsection
@extends('frontend.layouts.master')
@section('title', $meta_title)
@section('description', $meta_description)
@section('keywords', 'GD Sons, ' . $data['product_details']->title . ', Girdar das and sons')
@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <!-- <h2>{{ucwords(strtolower($data['product_details']->title))}}</h2> -->
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url()->previous() }}">
                                    {{$data['product_details']->category->title}} : {{$data['attributes_value_name']->name}}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ucwords(strtolower($data['product_details']->title))}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Product Left Sidebar Start -->
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-9 col-xl-8 col-lg-7">
                <div class="row g-4">
                    <div class="col-xl-6">
                        @if(preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
                        <div class="right-box-contain for-mobile-price">
                            <h1 class="name">{{$data['product_details']->title}}</h1>
                            <div class="price-rating">
                                <h3 class="theme-color price">
                                    @php
                                        $product = $data['product_details'];
                                        $final_offer_rate = null;
                                        $offer_rate_display = '';
                                        $special_offer_rate = null;
                                        $group_offer_rate = null;
                                        $schema_offer = null;
                                        if ($product->offer_rate) {
                                            $final_offer_rate = $product->offer_rate;
                                        }
                                        if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                        if ($group_percentage > 0) {
                                        $purchase_rate = $product->purchase_rate;
                                        $offer_rate = $product->offer_rate;
                                        // Calculate group offer rate based on the group's discount percentage
                                        $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                                        $group_offer_rate = floor($group_offer_rate);
                                        // Prepare the display for the regular (default) offer rate if the group offer is applied
                                        $offer_rate_display = '<br><span>Regular offer price</span><del class="text-content"> Rs. ' . number_format($offer_rate, 2) . '</del>';
                                        }
                                        }

                                        // Check for a special offer rate (provided by $specialOffers array)
                                        if (isset($specialOffers[$product->id])) {
                                        $special_offer_rate = (float) $specialOffers[$product->id];
                                        }

                                        // Determine the minimum (best) offer from available offers
                                        $all_offer_prices = array_filter([
                                        $special_offer_rate,
                                        $group_offer_rate,
                                        $product->offer_rate,
                                        ]);

                                        if (!empty($all_offer_prices)) {
                                        $final_offer_rate = min($all_offer_prices);
                                        }
                                    @endphp

                                    @if($final_offer_rate)
                                    @php
                                    $schema_offer = $final_offer_rate;
                                    @endphp
                                    <div>
                                        Rs. {{ number_format($final_offer_rate, 2) }}

                                        {{-- Discount Calculation --}}
                                        @if($product->mrp)
                                        @php
                                        $discountPercentage = round((($product->mrp - $final_offer_rate) / $product->mrp) * 100, 2);
                                        @endphp
                                        <span class="offer theme-color">
                                            ({{ $discountPercentage }}% off)
                                        </span>
                                        @endif

                                        {{-- Display M.R.P. (crossed out) --}}
                                        @if($product->mrp)
                                        <br>
                                        <span>M.R.P.</span>
                                        <del class="text-content">
                                            Rs. {{ number_format($product->mrp, 2) }}
                                        </del>
                                        @endif

                                        {{-- Display the "regular offer" price if group rate is applied --}}
                                        {!! $offer_rate_display !!}
                                    </div>
                                    @endif

                                </h3>
                            </div>
                        </div>
                        @endif
                        <div class="product-left-box">
                            <div class="row g-2">
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main no-arrow">
                                        @if($data['product_details']->images->isNotEmpty())
                                        @foreach($data['product_details']->images as $key => $image)
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{ asset('images/product/large/' . (!empty($image->image_path) ? $image->image_path : 'frontend/assets/gd-img/product/no-image.png')) }}"
                                                    id="img-{{ $key }}"
                                                    data-zoom-image="{{ asset('images/product/large/' . (!empty($image->image_path) ? $image->image_path : 'frontend/assets/gd-img/product/no-image.png')) }}"
                                                    class="img-fluid image_zoom_cls-{{ $key }} blur-up lazyload" alt="img">
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                    id="img-default"
                                                    data-zoom-image="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                    class="img-fluid blur-up lazyload" alt="No Image Available">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1 thumb-img">
                                    <div class="left-slider-image left-slider no-arrow slick-top">
                                        @if($data['product_details']->images->isNotEmpty())
                                        @foreach($data['product_details']->images as $key => $image)
                                        <div>
                                            <div class="sidebar-image">
                                                @if(!empty($image->image_path))
                                                <img src="{{ asset('images/product/icon/' . $image->image_path) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                                @else
                                                <img src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div>
                                            <div class="sidebar-image">
                                                <img src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                    class="img-fluid blur-up lazyload" alt="No Image Available">
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-6" data-wow-delay="0.1s">
                        <div class="right-box-contain">
                            @if(preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
                          
                            @else
                            <div class="for-desktop-price">
                                <h1 class="name">{{$data['product_details']->title}}</h1>

                                <div class="price-rating">
                                    <h3 class="theme-color price">
                                        @php
                                        $offer_rate_display ='';
                                        @endphp
                                        @php
                                        $product = $data['product_details'];
                                        $final_offer_rate = null;
                                        
                                        $offer_rate_display = '';
                                        $special_offer_rate = null;
                                        $group_offer_rate = null;

                                        /* Default offer */
                                        if ($product->offer_rate) {
                                        $final_offer_rate = $product->offer_rate;
                                        }

                                        /* Group offer calculation */
                                        if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                        if ($group_percentage > 0) {
                                        $purchase_rate = $product->purchase_rate;
                                        $offer_rate = $product->offer_rate;
                                        $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                                        $group_offer_rate = floor($group_offer_rate);
                                        $offer_rate_display = '<br><span>Regular offer price</span><del class="text-content"> Rs. ' . number_format($offer_rate, 2) . '</del>';
                                        }
                                        }

                                        /* Special offer */
                                        if (isset($specialOffers[$product->id])) {
                                        $special_offer_rate = (float) $specialOffers[$product->id];
                                        }

                                        /* Get minimum of all available offer prices*/
                                        $all_offer_prices = array_filter([
                                        $special_offer_rate,
                                        $group_offer_rate,
                                        $product->offer_rate,
                                        ]);

                                        if (!empty($all_offer_prices)) {
                                        $final_offer_rate = min($all_offer_prices);
                                        }
                                        @endphp
                                        @if($final_offer_rate)
                                        <div>
                                            Rs. {{ number_format($final_offer_rate, 2) }}

                                            {{-- Discount --}}
                                            @if($product->mrp)
                                            @php
												$discountPercentage = round((($product->mrp - $final_offer_rate) / $product->mrp) * 100, 2);
												$schema_offer = $final_offer_rate;

                                            @endphp
                                            <span class="offer theme-color">
                                                ({{ $discountPercentage }}% off)
                                            </span>
                                            @endif

                                            {{-- Show crossed MRP --}}
                                            @if($product->mrp)

                                            <br><span>M.R.P.</span><del class="text-content">
                                                Rs. {{ number_format($product->mrp, 2) }}
                                            </del>
                                            @endif

                                            {{-- Show "regular offer" if group rate was applied --}}
                                            {!! $offer_rate_display !!}
                                        </div>
                                        @endif

                                    </h3>
                                </div>
                            </div>
                            @endif
                            <div class="additional_discount_area">
                                <div class="additional-tex">
                                    <h4>Get Additional Discount</h4>
                                </div>
                                <div class="additional-info">
                                    <div class="help-tip">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <defs>
                                                <circle id="b" cx="8" cy="8" r="8"></circle>
                                                <filter id="a" width="130%" height="130%" x="-15%" y="-8.8%" filterUnits="objectBoundingBox">
                                                    <feMorphology in="SourceAlpha" operator="dilate" radius=".4" result="shadowSpreadOuter1"></feMorphology>
                                                    <feOffset dy="1" in="shadowSpreadOuter1" result="shadowOffsetOuter1"></feOffset>
                                                    <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation=".5"></feGaussianBlur>
                                                    <feComposite in="shadowBlurOuter1" in2="SourceAlpha" operator="out" result="shadowBlurOuter1"></feComposite>
                                                    <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0"></feColorMatrix>
                                                </filter>
                                            </defs>
                                            <g fill="none">
                                                <g transform="translate(2 1)">
                                                    <use fill="#000" filter="url(#a)" xlink:href="#b"></use>
                                                    <use fill="#FCFCFC" stroke="#000" stroke-opacity=".3" stroke-width=".8" xlink:href="#b"></use>
                                                </g>
                                                <text fill="#1D1D1D" font-family="Roboto, sans-serif" font-size="11" font-weight="400" opacity="0.59" transform="translate(2 1)">
                                                    <tspan x="6.6" y="12.2">i</tspan>
                                                </text>
                                            </g>
                                        </svg>
                                        <div class="tooltips-class tooltips-other">
                                            <p>
                                                If you Pick up your Order from our Varanasi Sigra Store, you get additional discount on all our Products. The final offer price will be displayed in the Shopping Cart Page.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="note-box product-package">
                                <div class="cart_qty qty-box product-qty">
                                    <div class="input-group">
                                        <button type="button" class="qty-left-minus" data-type="minus"
                                            data-field="">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input class="form-control input-number qty-input" type="text"
                                            name="quantity" value="1">
                                        <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                @if(intval($data['product_details']->mrp) > 0 && intval($data['product_details']->stock_quantity) > 0)
                                <button class="add-to-cart btn btn-md bg-dark cart-button text-white w-100" data-url="{{route('add.to.cart')}}" data-pid="{{$data['product_details']->id}}"
                                    data-mrp="{{$data['product_details']->mrp}}"
                                    data-track-btn-type="Add to cart without login"
                                    data-track-click="true"
                                    data-track-route="{{route('click.tracker')}}">
                                    Add To Cart
                                </button>
                                @else
                                <button disabled="" class="btn btn-md bg-dark cart-button text-white w-100">
                                    Out Of Stock
                                </button>
                                @endif
                            </div>

                            <!--<div class="buy-box">
                                @if (auth()->guard('customer')->check())
                                @php
                                $customerId = auth('customer')->id();
                                $isInWishlist = \App\Models\Wishlist::where('customer_id', $customerId)->where('product_id', $data['product_details']->id)->exists();
                                @endphp
                                <a href="javascript:void(0)"
                                    class="btn theme-bg-color text-white addwishlist {{ $isInWishlist ? 'added-to-wishlist' : '' }}"
                                    data-pid="{{ $data['product_details']->id }}"
                                    data-url="{{ route('wishlist.add') }}"
                                    data-cuid="{{ $customerId }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-track-btn-type="Add To Wishlist"
                                    data-track-click="true"
                                    data-track-route="{{route('click.tracker')}}"
                                    title="Wishlist">
                                    @if ($isInWishlist)
                                    <i class="feather-icon heart-icon filled" data-feather="heart"></i>
                                    @else
                                    <i class="feather-icon heart-icon" data-feather="heart"></i>
                                    @endif
                                    <span>{{ $isInWishlist ? 'In Wishlist' : 'Add To Wishlist' }}</span>
                                </a>

                                @else
                                <a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}"
                                    class="addwishlist-le btn theme-bg-color text-white"
                                    data-pid="{{ $data['product_details']->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Wishlist"
                                    data-track-btn-type="Add To Wishlist"
                                    data-track-click="true"
                                    data-track-route="{{route('click.tracker')}}">
                                    <i data-feather="heart"></i>
                                    <span>Add To Wishlist</span>
                                </a>
                                @endif
                            </div>-->
                            <div class="whatsapp-area">
                                <div class="whatapp-enquirybtn">
                                    <a
                                        class="product_detail_whattsapp btn mr-10 btn-md"
                                        data-title="{{ucwords(strtolower($data['product_details']->title))}}" data-pid="{{$data['product_details']->id}}"
                                        data-url="{{route('product-enquiry-modal-form')}}"
                                        data-pageurl="{{url()->current()}}"
                                        data-size="md" href="javascript:void(0);"
                                        data-track-btn-type="Send Enquiry through WhatsApp"
                                        data-track-click="true"
                                        data-track-route="{{route('click.tracker')}}">
                                        <i class="fa fa-whatsapp"></i> Send Enquiry through WhatsApp
                                    </a>
                                </div>
                            </div>
                            @if(isset($data['product_details']->attributes) && $data['product_details']->attributes->isNotEmpty())
                            <div class="pickup-box">
                                <!--<div class="product-title">
                                        <h4>Store Information</h4>
                                    </div>-->
                                <div class="product-info">
                                    <ul class="product-info-list product-info-list-2">
                                        @foreach($data['product_details']->attributes as $attribute)
                                        @if(isset($attribute->values) && $attribute->values->isNotEmpty())
                                        <li>
                                            @php
                                            if($attribute->attribute->title == 'Brand')
                                            {
												$brand = $attribute->values->first()->attributeValue->name;
                                            }
                                            @endphp
                                            {{ $attribute->attribute->title }} :
                                            @foreach($attribute->values as $value)
                                            <a href="javascript:void(0)">{{ $value->attributeValue->name }}</a>@if(!$loop->last),@endif
                                            @endforeach
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($data['product_details']->additionalFeatures->isNotEmpty())
                    <div class="col-12">
                        <div class="product-section-box description-box">
                            <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#additionalinfo" type="button" role="tab">Additional info</button>
                                </li>
                            </ul>
                            <div class="tab-content custom-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="additionalinfo" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table">
                                            @foreach($data['product_details']->additionalFeatures as $index => $additionalFeature)
                                            <tr>
                                                <td>
                                                    {{ $additionalFeature->feature->title }}
                                                </td>
                                                <td>
                                                    {{ $additionalFeature->product_additional_featur_value }}
                                                </td>
                                            </tr>
                                            @endforeach

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(!empty($data['product_details']->product_description))
                    <div class="col-12 mt-1 mb-1">
                        <div class="product-section-box description-box">
                            <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab">Product Description</button>
                                </li>
                            </ul>
                            <div class="tab-content custom-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="table-responsive">
                                        <p>
                                            {!! $data['product_details']->product_description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($data['product_details']->video_id)
                    <div class="col-12">
                        <div class="product-video-section">
                            <div class="product-short-container">
                                <div class="product-video-container"
                                    id="yt-{{ $data['product_details']->video_id }}"
                                    data-video-id="{{ $data['product_details']->video_id }}">
                                    <div class="video-loading">
                                        <div class="loading-spinner"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-5 d-lg-block mb-5">
                <div class="right-sidebar-box">
                    <div class="pt-25">
                        <div class="category-menu">
                            <h2>More {{$data['attributes_value_name']->name}} {{$data['product_details']->category->title}} Products</h2>

                            <ul class="product-list product-right-sidebar border-0 p-0">
                                @if($data['related_products']->isEmpty())
                                <li>No related products available</li>
                                @else
                                @foreach ($data['related_products'] as $key => $related_product_row)
                                @php
                                $firstImageTrending = $related_product_row->images->get(0);
                                $secondImageTrending = $related_product_row->images->get(1);
                                $attributes_value ='na';
                                if($related_product_row->ProductAttributesValues->isNotEmpty()){
                                $attributes_value = $related_product_row->ProductAttributesValues->first()->attributeValue->slug;
                                }
                                @endphp

                                <li class="{{ $loop->last ? 'mb-0' : '' }}">
                                    <div class="offer-product">
                                        <a href="{{ url('products/'.$related_product_row->slug.'/'.$attributes_value)}}" class="offer-image">
                                            @if ($firstImageTrending)
                                            <img src="{{ asset('images/product/thumb/'. $firstImageTrending->image_path) }}" class="img-fluid blur-up lazyload" alt="{{ $related_product_row->title }}">
                                            @else
                                            <img src="{{asset('frontend/assets/gd-img/product/no-image.png')}}"
                                                class="img-fluid blur-up lazyload" alt="{{ $related_product_row->title }}">
                                            @endif
                                        </a>

                                        <div class="offer-detail">
                                            <div>
                                                <a href="{{ url('products/'.$related_product_row->slug.'/'.$attributes_value)}}">
                                                    <h6 class="name">
                                                        {{ ucwords(strtolower($related_product_row->title)) }}
                                                    </h6>
                                                </a>
                                                <span>{{ $related_product_row->category->title ?? 'N/A' }}</span>
                                                <h6 class="price theme-color">
                                                    @if ($related_product_row->offer_rate === null)
                                                    <span class="theme-color price">Price not available</span>
                                                    @else
                                                    @php
                                                    $final_offer_rate = $related_product_row->offer_rate;
                                                    if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                                                    $group_category_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                                    if ($group_category_percentage > 0) {
                                                    $purchase_rate = $related_product_row->purchase_rate;
                                                    $offer_rate = $related_product_row->offer_rate;
                                                    $percent_discount = 100/$group_category_percentage;
                                                    $final_offer_rate =
                                                    $purchase_rate+($offer_rate-$purchase_rate)*$percent_discount/100;
                                                    $final_offer_rate = floor($final_offer_rate);
                                                    }
                                                    }
                                                    @endphp
                                                    <span class="theme-color">Rs. {{$final_offer_rate}}</span>
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--product review-->
<section class="product-section-box review-section">
    <div class="container-fluid-lg">
        <div class="review-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="review-header">
                        <h2 class="jdgm-rev-widg__title">Customer Reviews</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5">
                    <div class="product-rating-box">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="product-main-rating">
                                    @if($data['review_stats']['average_rating'] >0)
                                        <h2>
                                            {{ $data['review_stats']['average_rating'] ?? 0 }}
                                            <i data-feather="star"></i>
                                        </h2>

                                        <h5>
                                            {{ ($data['review_stats']['total_reviews'] ?? 0) }}
                                            {{ ($data['review_stats']['total_reviews'] ?? 0) == 1 ? 'Review' : 'Overall Rating' }}
                                        </h5>
                                    @else
                                        <h2 class="no-review">
                                            <i data-feather="star"></i>
                                            <i data-feather="star"></i>
                                            <i data-feather="star"></i>
                                            <i data-feather="star"></i>
                                            <i data-feather="star"></i>
                                            <i data-feather="star"></i>
                                        </h2>
                                    @endif
                                </div>
                            </div>
                            @if(($data['review_stats']['total_reviews'] ?? 0) > 0)
                                <div class="col-xl-12">
                                    <ul class="product-rating-list">
                                        @for($i = 5; $i >= 1; $i--)
                                        <li>
                                            <div class="rating-product">
                                                <h5>
                                                    @for($j = 1; $j <= 5; $j++)
                                                        @if($j <= $i)
                                                            <span class="re-star-icon-on">
                                                                <i data-feather="star"></i>
                                                            </span>
                                                        @else
                                                            <span class="re-star-icon-off">
                                                                <i data-feather="star"></i>
                                                            </span>
                                                        @endif
                                                    @endfor
                                                </h5>
                                                <div class="progress">
                                                    @php
                                                        $totalReviews = $data['review_stats']['total_reviews'];
                                                        $starCount = $data['review_stats']['star_counts'][$i] ?? 0;
                                                        $percentage = $totalReviews > 0 ? ($starCount / $totalReviews) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar" style="width: {{ $percentage }}%;"></div>
                                                </div>
                                                <h5 class="total">{{ $starCount }}</h5>
                                            </div>
                                        </li>
                                        @endfor
                                    </ul>
                                </div>
                            @else
                                <div class="col-xl-12">
                                    <p class="text-muted">Be the first to write a review</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="write-re-btn">
                        <a href="javascript:void(0);" class="write-rev-link" role="button" aria-expanded="false">Write a review</a>
                    </div>
                </div>
            </div>
            <div class="review-form-section" style="display: none;">
                <div class="row justify-content-md-center">
                    <div class="col-lg-6">
                        <form class="review-form" action="{{ route('product.review.store') }}" method="POST" id="reviewForm" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $data['product_details']->id }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-2 custom-form">
                                        <label for="rating-stars" class="form-label">Your Rating *</label>
                                        <div class="form-group">
                                            <div class="stars-box" id="rating-stars">
                                                <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                                                <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                                                <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                                                <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                                                <i class="star fa fa-star" title="5 stars" data-message="Very good quality" data-value="5"></i>
                                            </div>
                                            <input type="hidden" name="rating" id="rating-value" required>
                                            <div id="rating_error" class="invalid-feedback-error" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_title" class="form-label">Review Title</label>
                                        <div class="custom-input">
                                            <input type="text" name="review_title" class="form-control" id="review_title" placeholder="Give your review title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_message" class="form-label">Review *</label>
                                        <div class="custom-textarea">
                                            <textarea class="form-control" id="review_message" placeholder="Write your comments here" name="review_message" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_pic_or_video" class="form-label">Picture/Video (optional)</label>
                                        <div class="custom-input">
                                            <input type="file" class="form-control" id="review_pic_or_video" name="review_pic_or_video" placeholder="Picture or video file">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_pic_or_video" class="form-label">Picture/Video (optional)</label>

                                        <div class="jdgm-media-fieldset__container">
                                            <div class="jdgm-picture-fieldset__box jdgm-picture-fieldset__box--input">
                                                <div class="jdgm-picture-fieldset__box-wrapper">
                                                    <div class="jdgm-media-fieldset__icon">
                                                        <i class="fa fa-upload" style="font-size: 24px; color: #aaa;"></i>
                                                    </div>
                                                </div>
                                                <input
                                                    type="file"
                                                    name="review_pic_or_video[]"
                                                    id="review_pic_or_video"
                                                    class="jdgm-media-fieldset__input"
                                                    multiple
                                                    accept="image/gif,image/jpeg,image/jpg,image/png,image/webp,video/mp4,video/quicktime"
                                                    aria-label="Choose a review picture/video (optional)">
                                                <div style="display: none !important;" aria-label="Choose a review picture/video (optional)">
                                                    Choose a review picture/video (optional)
                                                </div>
                                            </div>
                                        </div>
                                        <div id="preview-container" style="margin-top: 10px;" class="preview-flex"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_name" class="form-label">Name *</label>
                                        <div class="custom-input">
                                            <input type="text" class="form-control" id="review_name" name="review_name" placeholder="Enter your name (public)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-md-4 mb-2 custom-form">
                                        <label for="review_email" class="form-label">Email *</label>
                                        <div class="custom-input">
                                            <input type="email" class="form-control" id="review_email" name="review_email" placeholder="Enter your email (private)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="review_btn">
                                        <a href="javascript:void(0);" role="button" class="cancel-review-btn">Cancel review</a>
                                        <button type="submit" class="review-submit">Submit Review</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('frontend.pages.partials.ajax-product-review-list', ['data' => $data])
        </div>
    </div>
</section>
<!--product review-->
<!-- Sticky Cart Box Start -->
<div class="sticky-bottom-cart">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="cart-content">
                    <div class="product-image">

                        @if ($data['product_details']->images->isNotEmpty() && $data['product_details']->images->first()->image_path)
                        <img src="{{ asset('images/product/thumb/' . $data['product_details']->images->first()->image_path) }}"
                            class="img-fluid blur-up lazyload"
                            alt="{{ ucwords(strtolower($data['product_details']->title ?? 'Product')) }}">
                        @else
                        <img src="{{asset('frontend/assets/gd-img/product/no-image.png')}}"
                            class="img-fluid blur-up lazyload"
                            alt="Default Image">
                        @endif


                        <div class="content">
                            <h5>{{ ucwords(strtolower($data['product_details']->title)) }}</h5>
                            <h6>
                                @if($data['product_details']->offer_rate)
                                Rs. {{ number_format($data['product_details']->offer_rate, 2) }}
                                @endif
                                @if($data['product_details']->mrp)
                                <del class="text-danger">Rs. {{ number_format($data['product_details']->mrp, 2) }}</del>
                                @endif
                                @if($data['product_details']->mrp && $data['product_details']->offer_rate)
                                @php
                                $discountPercentage = round(((($data['product_details']->mrp - $data['product_details']->offer_rate) / $data['product_details']->mrp) * 100), 2);
                                @endphp
                                <span>({{ $discountPercentage }}% off)</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                    <div class="selection-section">

                        <div class="cart_qty qty-box product-qty m-0">
                            <div class="input-group h-100">
                                <button type="button" class="qty-left-minus" data-type="minus" data-field="">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input class="form-control input-number qty-input" type="text" name="quantity"
                                    value="1">
                                <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="add-btn">
                        <a class="btn theme-bg-color text-white wishlist-btn" href="#"><i
                                class="fa fa-bookmark"></i> Wishlist</a>
                        <a class="btn theme-bg-color text-white" href="#"><i
                                class="fas fa-shopping-cart"></i> Add To Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sticky Cart Box End -->
<!--sticky cart code -->
@endsection


@push('schema')
<script type="application/ld+json">
    {
        @php
        $imageschema = '';
        if (!empty($data['product_details']->images->first()->image_path)) {
            $imageschema = asset('images/product/large/'.$data['product_details']->images->first()->image_path);
        } else {
            $imageschema = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
        }
        @endphp

            "@context": "http://schema.org",
            "@type": "Product",
            "name": "{{ $data['product_details']->title }}",
            "description": "{{$meta_description}}",
            "image": "{{ $imageschema }}",
            "sku": "{{$data['product_details']->sku}}",
			"gtin": "{{$data['product_details']->g_tin_no}}",
            "category": "{{ $categorytitle }}",
            "brand": "{{ $brand }}",
            "offers": {
                "@type": "Offer",
                "price": "{{ $schema_offer }}",
                "priceCurrency": "INR",
                "url": "{{ url()->current() }}",
                "priceSpecification": {
                    "@type": "PriceSpecification",
                    "price": "{{ $product->mrp }}",
                    "priceCurrency": "INR",
                    "valueAddedTaxIncluded": "true",
					"priceType": "ListPrice"
                },
                "availability": "http://schema.org/InStock",
				"itemCondition": "https://schema.org/NewCondition",
				"priceValidUntil": "{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
            },
			"additionalProperty": [
			  {
				"@type": "PropertyValue",
				"name": "MRP",
				"value": "{{ $product->mrp }}"
			  },
			  {
				"@type": "PropertyValue",
				"name": "Discount",
				"value": "{{ $product->mrp - $schema_offer }}"
			  },
			  {
				"@type": "PropertyValue",
				"name": "Product type",
				"value": "{{ $categorytitle }}"
			  }
			]
			@php
				if($data['review_stats']['total_reviews'] > 0)
				{
			@endphp,
			"aggregateRating": {
			  "@type": "AggregateRating",
			  "ratingValue": "{{ $data['review_stats']['average_rating'] }}",
			  "reviewCount": "{{ $data['review_stats']['total_reviews'] }}"
			}
			@php
				}
			@endphp
    }
</script>
@endpush

@push('scripts')
<script src="{{asset('frontend/assets/js/jquery.elevatezoom.js')}}"></script>
<script src="{{asset('frontend/assets/js/zoom-filter.js')}}"></script>
<script src="{{asset('frontend/assets/js/sticky-cart-bottom.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/review.js')}}"></script>
<script>
    $(document).ready(function() {
        function isYouTubeShort(videoId) {
            return videoId.length === 11;
        }

        function loadYouTubePlayer($container) {
            const videoId = $container.data('video-id');
            const isShort = isYouTubeShort(videoId);
            $container.addClass(isShort ? 'short' : 'regular');
            const params = {
                autoplay: 1,
                mute: 0,
                enablejsapi: 1,
                playsinline: 1,
                rel: 0,
                modestbranding: 1
            };
            if (isShort) {
                params.loop = 1;
                params.playlist = videoId;
            }

            const iframe = $('<iframe/>', {
                src: `https://www.youtube.com/embed/${videoId}?${$.param(params)}`,
                allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                allowfullscreen: '',
                loading: 'lazy'
            });
            iframe.on('load', function() {
                $container.find('.video-loading').hide();
            });
            $container.append(iframe);
        }


        function initVideoObserver() {
            const observer = new IntersectionObserver(function(entries) {
                $.each(entries, function(index, entry) {
                    if (entry.isIntersecting) {
                        const $container = $(entry.target);
                        loadYouTubePlayer($container);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '200px'
            });
            $('.product-video-container').each(function() {
                observer.observe(this);
            });
        }
        initVideoObserver();
    });
</script>
<script>
    const stars = document.querySelectorAll('.stars-box .star');
    const ratingInput = document.getElementById('rating-value');
    let selectedRating = 0;
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
            updateStars(index + 1, 'hovered');
        });

        star.addEventListener('mouseout', () => {
            updateStars(selectedRating, 'selected');
        });

        star.addEventListener('click', () => {
            selectedRating = index + 1;
            ratingInput.value = selectedRating;
            updateStars(selectedRating, 'selected');
        });
    });

    function updateStars(rating, className) {
        stars.forEach((star, index) => {
            star.classList.remove('selected', 'hovered');
            if (index < rating) {
                star.classList.add(className);
            }
        });
    }
</script>

@endpush