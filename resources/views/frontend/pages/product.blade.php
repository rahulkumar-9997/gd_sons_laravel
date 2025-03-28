@php
if ($data['product_details']->meta_title) {
$meta_title = $data['product_details']->meta_title;
} else {
$meta_title = ucwords(strtolower($data['product_details']->title))
. ' | ' . $data['product_details']->category->title . ' - ' . $data['attributes_value_name']->name;
}

if ($data['product_details']->meta_description) {
$meta_description = $data['product_details']->meta_description;
} else {
$meta_description = ucwords(strtolower($data['product_details']->title))
. ' | ' . $data['product_details']->category->title . ' - ' . $data['attributes_value_name']->name;
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
                                                    class="img-fluid image_zoom_cls-{{ $key }} blur-up lazyload" alt="">
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
                                                <img src="{{ asset('images/product/thumb/' . $image->image_path) }}"
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
                            <h1 class="name">{{$data['product_details']->title}}</h1>

                            <div class="price-rating">
                                <h3 class="theme-color price">
                                    @php
                                    $offer_rate_display ='';
                                    @endphp
                                    @if($data['product_details']->offer_rate)
                                    @php

                                    $final_offer_rate = $data['product_details']->offer_rate;
                                    if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory)) {
                                    $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                    if ($group_categoty_percentage > 0) {
                                        $purchase_rate = $data['product_details']->purchase_rate;
                                        $offer_rate = $data['product_details']->offer_rate;
                                        $percent_discount = 100/$group_categoty_percentage;
                                        $final_offer_rate =
                                        $purchase_rate+($offer_rate-$purchase_rate)*$percent_discount/100;
                                        $final_offer_rate = floor($final_offer_rate);
                                        $offer_rate_display = '<br><span>Regular offer price</span><del class="text-content"> Rs. ' . number_format($offer_rate, 2) . '</del>';
                                    }
                                    }
                                    @endphp
                                    Rs. {{ number_format($final_offer_rate, 2) }}
                                    @endif
                                    @if($data['product_details']->mrp && $final_offer_rate)
                                    @php
                                    $discountPercentage = round(((($data['product_details']->mrp -$final_offer_rate) / $data['product_details']->mrp) * 100), 2);
                                    @endphp
                                    <span class="offer theme-color">({{ $discountPercentage }}% off)</span>
                                    @endif
                                    {!! $offer_rate_display !!}
                                    @if($data['product_details']->mrp)
                                    <br><span> M.R.P.</span><del class="text-content">
                                        Rs. {{ number_format($data['product_details']->mrp, 2) }}
                                    </del>
                                    @endif
                                </h3>
                            </div>
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
                            <!--@if(!empty($data['product_details']->product_description))
                            <div class="product-contain">
                                <p>
                                    {{ Str::limit(strip_tags($data['product_details']->product_description), 200) }}
                                </p>
                            </div>
                            @endif-->
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
                                @if (auth()->guard('customer')->check())
                                @if(intval($data['product_details']->mrp) > 0 && intval($data['product_details']->stock_quantity) > 0)
                                <button class="add-to-cart btn btn-md bg-dark cart-button text-white w-100" data-url="{{route('add.to.cart')}}" data-pid="{{$data['product_details']->id}}"
                                    data-mrp="{{$data['product_details']->mrp}}">
                                    Add To Cart
                                </button>
                                @else
                                <button disabled="" class="btn btn-md bg-dark cart-button text-white w-100">
                                    Out Of Stock
                                </button>
                                @endif
                                @else
                                @if(intval($data['product_details']->mrp) > 0 && intval($data['product_details']->stock_quantity) > 0)
                                <button onclick="location.href = '{{ route('logincustomer') }}?redirect={{ url()->current() }}';"
                                    class="btn btn-md bg-dark cart-button text-white w-100">Add To Cart
                                </button>
                                @else
                                <button disabled class="btn btn-md bg-dark cart-button text-white w-100">
                                    Out Of Stock
                                </button>
                                @endif
                                @endif
                            </div>

                            <div class="buy-box">
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
                                    title="Wishlist">
                                    <i data-feather="heart"></i>
                                    <span>Add To Wishlist</span>
                                </a>
                                @endif
                            </div>
                            <div class="whatsapp-area">
                                <div class="whatapp-enquirybtn">
                                    <a class="product_detail_whattsapp btn mr-10 btn-md" data-title="{{ucwords(strtolower($data['product_details']->title))}}" data-pid="{{$data['product_details']->id}}" data-url="{{route('product-enquiry-modal-form')}}" data-pageurl="{{url()->current()}}" data-size="md" href="javascript:void(0);">
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
                    <div class="col-12">
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
                                        @if(!empty($data['product_details']->product_description))
                                        <p>
                                            {!! $data['product_details']->product_description !!}
                                        </p>
                                        @else
                                        <p>Product description not available !</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-1 mb-5">
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
                                        @if($data['product_details']->additionalFeatures->isNotEmpty())
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
                                        @else
                                        <span>No additional feature available !</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12">
                        <div class="product-section-box description-box">
                            <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#review" type="button" role="tab">Review</button>
                                </li>
                            </ul>

                            <div class="tab-content custom-tab" id="myTabContent">
                                <div class="tab-pane fade" id="review" role="tabpanel">
                                    <div class="review-box">
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <div class="product-rating-box">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="product-main-rating">
                                                                <h2>3.40
                                                                    <i data-feather="star"></i>
                                                                </h2>

                                                                <h5>5 Overall Rating</h5>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <ul class="product-rating-list">
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>5<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 40%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">2</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>4<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>3<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 0%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">0</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>2<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>1<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>

                                                            </ul>

                                                            <div class="review-title-2">
                                                                <h4 class="fw-bold">Review this product</h4>
                                                                <p>Let other customers know what you think</p>
                                                                <button class="btn" type="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#writereview">Write a
                                                                    review</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-7">
                                                <div class="review-people">
                                                    <ul class="review-list">
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="{{asset('frontend/assets/images/images/review/1.jpg')}}">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)"
                                                                            class="name">Jack Doe</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                06:40:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>Avoid this product. The quality is
                                                                            terrible, and
                                                                            it started falling apart almost
                                                                            immediately. I
                                                                            wish I had read more reviews before
                                                                            buying.
                                                                            Lesson learned.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
<!-- Product Left Sidebar End -->
<!--sticky cart code -->
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
@push('scripts')
<script src="{{asset('frontend/assets/js/jquery.elevatezoom.js')}}"></script>
<script src="{{asset('frontend/assets/js/zoom-filter.js')}}"></script>
<!-- Sticky-bar js -->
<script src="{{asset('frontend/assets/js/sticky-cart-bottom.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
@endpush