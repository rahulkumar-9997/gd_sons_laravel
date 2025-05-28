@extends('frontend.layouts.master')
@section('title','Best Kitchen Retail Store in Varanasi now goes Online')
@section('description', 'Best Kitchen Retail Store in Varanasi now goes Online')
@section('keywords', 'Best Kitchen Retail Store in Varanasi now goes Online')

@section('main-content')
<!-- Home Section Start -->
<section class="home-section pt-2">
    <div class="container-fluid-lg">
        <div class="row g-2">
            <div class="col-xl-8 ratio_65">
                <div class="home-contain h-1001">
                    <!-- data-bs-ride="carousel" data-bs-interval="3000" -->
                    @if ($data['banner'] && $data['banner']->isNotEmpty())
                    <div id="homeBannerCarousel" class="carousel slide silk-carousel-wrapper home-banner-carousel" data-bs-ride="carousel" data-bs-interval="3000">
                        <!-- Indicators/Dots -->
                        <div class="carousel-indicators">
                            @foreach ($data['banner'] as $index => $banner)
                            <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : '' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <!-- Carousel Inner -->
                        <div class="carousel-inner">
                            @foreach ($data['banner'] as $index => $banner)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row1">
                                    <div class="col1">
                                        <a href="{{ $banner->link_desktop }}">
                                            <img src="{{ asset($banner->image_path_desktop) }}"
                                                class="d-block w-100"
                                                srcset="{{ asset($banner->image_path_desktop) }} 600w, {{ asset($banner->image_path_desktop) }} 1200w"
                                                sizes="(max-width: 600px) 600px, 1200px"
                                                alt="{{ $banner->title }}"
                                                loading="lazy">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    @endif

                </div>
            </div>
            <div class="col-xl-4 ratio_65 banner-side two-banner-home">
                <div class="row g-2 h-100">
                    <!-- @if (!isset($_SERVER['HTTP_USER_AGENT']) || !preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
                    <div class="single-bn-mo-dnone h-100">
                        <div class="home-enquiry-form h-100">
                            <div class="home-enquiry-title text-center">
                                <h3>
                                    Request a Product or Item
                                </h3>
                            </div>
                            <div class="form">
                                <form action="{{ route('request.product.enquiry.submit')}}" method="post" id="requestAproductEnquiry">
                                    @csrf
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <div class="custom-input">
                                            <input type="text" class="form-control" id="name" placeholder="Enter your name *" name="name">

                                        </div>
                                    </div>
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <div class="custom-input">
                                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number *" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                                this.value.slice(0, this.maxLength);" name="phone">

                                        </div>
                                    </div>
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <div class="custom-textarea">
                                            <textarea class="form-control" id="message" placeholder="Enter your message" rows="3" name="message"></textarea>

                                        </div>
                                    </div>
                                    <button class="btn btn-animation btn-md fw-bold ms-auto" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif -->
                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dnone">
                        <div class="home-contain">
                            <img src="{{asset('frontend/assets/images/side-banner-1.png')}}" class="img-responsive blur-up lazyload"
                                alt="side banner" loading="lazy">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h3 class="mt-0 theme-color fw-bold">eCom Website</h3>
                                    <h4 class="text-danger">Kitchenware & Dinnerware</h4>
                                    <p class="organic">Exclusive for Varanasi & Nearby</p>
                                    <a href="{{ route('contact-us') }}" class="shop-button">Contact Now <i
                                            class="fa-solid fa-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dnone">
                        <div class="home-contain">
                            <img src="{{asset('frontend/assets/images/side-banner-2.jpg')}}" class="img-responsive blur-up lazyload"
                                alt="side banner" loading="lazy">
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h3 class="mt-0 theme-color fw-bold">Buy from Store</h3>
                                    <h4 class="text-danger">or Online</h4>
                                    <p class="organic">Biggest range of Kitchenware</p>
                                    <a href="{{ route('contact-us') }}" class="shop-button">Call Now <i
                                            class="fa-solid fa-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dblock">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <a href="https://maps.app.goo.gl/8hPKnwQUX2Z3cT7GA" target="_blank" class="btn theme-bg-color btn-md fw-bold text-white">
                                    Visit our Store
                                </a>
                            </div>
                            <div class="col-md-6 col-6">
                                <a class="btn theme-bg-color btn-md fw-bold text-white mobile-category">
                                    Explore All Products
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dblock">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <a href="tel:+918318894257" class="btn theme-bg-color btn-md fw-bold text-white">
                                    Call us Now
                                </a>
                            </div>
                            <div class="col-md-6 col-6">
                                <a href="javascript:void(0)"
                                    data-url="{{ route('request.product.enquiry.form') }}" data-title="Request a Product or Item"
                                    data-pageurl="{{url()->current()}}"
                                    data-size="md"
                                    class="btn theme-bg-color btn-md fw-bold text-white requestProductBtn">
                                    Need Something ?
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dblock">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-6 mobile-flash-sale-div">
                                <a href="{{ route('flash.sale')}}" class="flash-sale-button">
                                    Flash Sale <small>Only Limited Time</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-2">
                    <h1 class="class-h1-tags">
                        Best Kitchen Retail Store in Varanasi now goes Online.
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home Section End -->
<!-- Banner Section Start -->
<section class="banner-section ratio_60 gd5">
    <div class="container-fluid-lg">
        <div class="row g-3">
            <div class="col-xl-20">
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/vacuum-flask" aria-label="Browse Vacuum Flasks">
                        <img
                            src="{{ asset('frontend/assets/gd-img/banner-bottom/bottlesU.webp') }}"
                            class="img-fluid blur-up lazyload"
                            alt="bottles"
                            loading="lazy"
                            width="400"
                            height="437"
                            decoding="async"
                            fetchpriority="low">
                    </a>
                </div>
            </div>

            <div class="col-xl-20">
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/lpg-gas-stoves" aria-label="Browse LPG Gas Stoves">
                        <img
                            src="{{ asset('frontend/assets/gd-img/banner-bottom/stovesU.webp') }}"
                            class="img-fluid blur-up lazyload"
                            alt="lpg gas stoves"
                            loading="lazy"
                            width="400"
                            height="437"
                            decoding="async"
                            fetchpriority="low">
                    </a>
                </div>
            </div>

            <div class="col-xl-20">
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/lunchbox-tiffin" aria-label="Browse Lunchboxes and Tiffins">
                        <img
                            src="{{ asset('frontend/assets/gd-img/banner-bottom/tiffinsU.webp') }}"
                            class="img-fluid blur-up lazyload"
                            alt="Tiffins"
                            loading="lazy"
                            width="400"
                            height="437"
                            decoding="async"
                            fetchpriority="low">
                    </a>
                </div>
            </div>

            <div class="col-xl-20">
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/kitchen-appliances" aria-label="Browse Kitchen Appliances">
                        <img
                            src="{{ asset('frontend/assets/gd-img/banner-bottom/appliances_0.webp') }}"
                            class="img-fluid blur-up lazyload"
                            alt="Application"
                            loading="lazy"
                            width="400"
                            height="437"
                            decoding="async"
                            fetchpriority="low">
                    </a>
                </div>
            </div>

            <div class="col-xl-20">
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/pressure-cooker" aria-label="Browse Pressure Cookers">
                        <img
                            src="{{ asset('frontend/assets/gd-img/banner-bottom/CookerPosterF1.webp') }}"
                            class="img-fluid blur-up lazyload"
                            alt="Pressure Cooker"
                            loading="lazy"
                            width="236"
                            height="258"
                            decoding="async"
                            fetchpriority="low">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Banner Section End -->
<!-- Product Section Start -->
<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">

            @if ($data['primary_category'] && $data['primary_category']->isNotEmpty())
            <div class="highlighted-products">
                <div class="title d-block text-center">
                    <div>
                        <h2>Highlighted Products</h2>
                        <span class="title-leaf"></span>
                    </div>
                </div>
                <div class="section-b-space h-button-area">
                    <ul class="list text-center">
                        @php
                        $colors = [
                        '#FF5733', '#a1521b', '#FF69B4',
                        '#8A2BE2', '#efab49', '#00CED1', '#DC143C',
                        '#4682B4', '#FF8C00', '#8B008B', '#2E8B57'
                        ];
                        @endphp
                        @foreach ($data['primary_category'] as $index =>$primary_category_row)
                        <li>
                            <a class="btn text-white" href="{{$primary_category_row->link}}" style="background-color: {{ $colors[$index % count($colors)] }};">
                                {{$primary_category_row->title}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                @if ($data['popular_products'] && $data['popular_products']->isNotEmpty())
                <div class="title d-block text-center">
                    <div>
                        <h2>Popular Products</h2>
                        <span class="title-leaf">
                            <!-- <svg class="icon-width">
                                <use xlink:href="{{asset('frontend/assets/svg/leaf.svg#leaf')}}"></use>
                            </svg> -->
                        </span>
                        <!-- <p>Don't miss this opportunity at a special discount just for this week.</p> -->
                    </div>
                </div>
                <div class="section-b-space">
                    <div class="non-product-border non-border-row no-overflow-hidden">
                        <div class="product-box-slider no-arrow">
                            @php
                            $row_count = 0;
                            $num_of_item_display_new = 3;
                            @endphp
                            <div>
                                <div class="row m-0">
                                    @foreach ($data['popular_products'] as $popular_product_row)
                                    @php
                                    $firstImage = $popular_product_row->images->get(0);
                                    $secondImage = $popular_product_row->images->get(1);
                                    $attributes_value ='na';
                                    if($popular_product_row->ProductAttributesValues->isNotEmpty()){
                                    $attributes_value = $popular_product_row->ProductAttributesValues->first()->attributeValue->slug;
                                    }
                                    @endphp
                                    @php
                                    $final_offer_rate = $popular_product_row->offer_rate;
                                    $mrp = $popular_product_row->mrp;

                                    $purchase_rate = $popular_product_row->purchase_rate;
                                    $offer_rate = $popular_product_row->offer_rate;

                                    $group_offer_rate = null;
                                    $special_offer_rate = null;

                                    /*Group Offer*/
                                    if ($groupCategory && $offer_rate !== null) {
                                    $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                    if ($group_percentage > 0) {
                                    $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                                    $group_offer_rate = floor($group_offer_rate);
                                    }
                                    }

                                    /*Special Offer*/
                                    if (isset($specialOffers[$popular_product_row->id])) {
                                    $special_offer_rate = (float) $specialOffers[$popular_product_row->id];
                                    }

                                    /* Choose lowest rate */
                                    $all_rates = array_filter([
                                    $offer_rate,
                                    $group_offer_rate,
                                    $special_offer_rate
                                    ]);
                                    if (!empty($all_rates)) {
                                    $final_offer_rate = min($all_rates);
                                    }

                                    /* Calculate discount */
                                    $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
                                    ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                                    : 0;
                                    @endphp
                                    <div class="col-12 px-1">
                                        <div class="product-box mb-1">
                                            <div class="product-image">
                                                @if ($discountPercentage>0)
                                                <div class="label-flex">
                                                    <div class="discount">
                                                        <label>
                                                            Save {{ $discountPercentage }}%
                                                        </label>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="product-img">
                                                    <a href="{{ url('products/'.$popular_product_row->slug.'/'.$attributes_value) }}">
                                                        @if ($firstImage)
                                                        <picture>
                                                            {{-- Mobile image from "icon" folder --}}
                                                            <source
                                                                media="(max-width: 767px)"
                                                                srcset="{{ asset('images/product/icon/' . $firstImage->image_path) }}">

                                                            {{-- Desktop image from "thumb" folder --}}
                                                            <img
                                                                class="img-fluid blur-up lazyload"
                                                                data-src="{{ asset('images/product/thumb/' . $firstImage->image_path) }}"
                                                                src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                srcset="{{ asset('images/product/thumb/' . $firstImage->image_path) }} 600w, 
                                                                {{ asset('images/product/thumb/' . $firstImage->image_path) }} 1200w"
                                                                sizes="(max-width: 600px) 600px, 1200px"
                                                                alt="{{ $popular_product_row->title }}"
                                                                title="{{ $popular_product_row->title }}"
                                                                loading="lazy"
                                                                width="300"
                                                                height="300"
                                                                onload="this.style.opacity=1">
                                                        </picture>
                                                        @else
                                                        <img
                                                            src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                            class="img-fluid blur-up lazyload"
                                                            alt="{{ $popular_product_row->title }}"
                                                            loading="lazy"
                                                            width="300"
                                                            height="300">
                                                        @endif
                                                    </a>
                                                </div>


                                            </div>
                                            <div class="product-detail">
                                                <a href="{{ url('products/'.$popular_product_row->slug.'/'.$attributes_value) }}">
                                                    <h6 class="name">{{ ucwords(strtolower($popular_product_row->title)) }}</h6>
                                                </a>
                                                <h5 class="sold text-content">
                                                    @if ($final_offer_rate === null)
                                                    <span class="theme-color price">Price not available</span>
                                                    @else
                                                    <span class="theme-color">Rs. {{ $final_offer_rate }}</span>
                                                    @endif

                                                    @if ($mrp !== null)
                                                    <del>Rs. {{ $mrp }}</del>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                    $row_count++;
                                    @endphp

                                    @if ($row_count % $num_of_item_display_new == 0 && $row_count < count($data['popular_products']))
                                        </div>
                                </div>
                                <div>
                                    <div class="row m-0">
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                    @if ($data['trending_products'] && $data['trending_products']->isNotEmpty())
                    <div class="title d-block text-center">
                        <h2>Trending Products</h2>
                        <span class="title-leaf">
                            <!-- <svg class="icon-width">
                                <use xlink:href="{{asset('frontend/assets/svg/leaf.svg#leaf')}}"></use>
                            </svg> -->
                        </span>
                        <!-- <p>A virtual assistant collects the products from your list</p> -->
                    </div>
                    <div class="home-trending-section">
                        <div class="no-product-border no-overflow-hidden">
                            <div class="product-box-slider no-arrow">
                                @foreach ($data['trending_products'] as $trending_products_row)
                                @php
                                $firstImageTrending = $trending_products_row->images->get(0);
                                $secondImageTrending = $trending_products_row->images->get(1);
                                $attributes_value ='na';
                                if($trending_products_row->ProductAttributesValues->isNotEmpty()){
                                $attributes_value = $trending_products_row->ProductAttributesValues->first()->attributeValue->slug;
                                }
                                @endphp
                                @php
                                $purchase_rate = $trending_products_row->purchase_rate;
                                $offer_rate = $trending_products_row->offer_rate;
                                $mrp = $trending_products_row->mrp;

                                $group_offer_rate = null;
                                $special_offer_rate = null;

                                /* Group Price Calculation */
                                if ($groupCategory && $offer_rate !== null) {
                                $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                if ($group_percentage > 0) {
                                $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                                $group_offer_rate = floor($group_offer_rate);
                                }
                                }

                                /* Special Offer from array */
                                if (isset($specialOffers[$trending_products_row->id])) {
                                $special_offer_rate = (float) $specialOffers[$trending_products_row->id];
                                }

                                /* Final Rate: Minimum of all */
                                $all_rates = array_filter([
                                $offer_rate,
                                $group_offer_rate,
                                $special_offer_rate
                                ]);
                                $final_offer_rate = !empty($all_rates) ? min($all_rates) : null;

                                /* Discount Calculation */
                                $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
                                ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                                : 0;
                                @endphp
                                <div>
                                    <div class="row m-1">
                                        <div class="col-12 px-1">
                                            <div class="product-box">
                                                <div class="product-image">
                                                    @if ($discountPercentage>0)
                                                    <div class="label-flex">
                                                        <div class="discount">
                                                            <label>
                                                                Save {{ $discountPercentage }}%
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="product-img">
                                                        <a href="{{ url('products/'.$trending_products_row->slug.'/'.$attributes_value) }}">
                                                            @if ($firstImageTrending)
                                                            <picture>
                                                                <source
                                                                    media="(max-width: 767px)"
                                                                    srcset="{{ asset('images/product/icon/' . $firstImageTrending->image_path) }}">
                                                                <img
                                                                    class="img-fluid blur-up lazyload"
                                                                    data-src="{{ asset('images/product/thumb/' . $firstImageTrending->image_path) }}"
                                                                    src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                    srcset="{{ asset('images/product/thumb/' . $firstImageTrending->image_path) }} 600w, 
                                                                    {{ asset('images/product/thumb/' . $firstImageTrending->image_path) }} 1200w"
                                                                    sizes="(max-width: 600px) 600px, 1200px"
                                                                    alt="{{ $trending_products_row->title }}"
                                                                    title="{{ $trending_products_row->title }}"
                                                                    loading="lazy"
                                                                    width="300"
                                                                    height="300"
                                                                    onload="this.style.opacity=1">
                                                            </picture>
                                                            @else
                                                            <img
                                                                src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                class="img-fluid blur-up lazyload"
                                                                alt="{{ $trending_products_row->title }}"
                                                                loading="lazy"
                                                                width="300"
                                                                height="300"
                                                                onload="this.style.opacity=1">
                                                            @endif
                                                        </a>
                                                    </div>


                                                </div>
                                                <div class="product-detail">
                                                    <a href="{{ url('products/'.$trending_products_row->slug.'/'.$attributes_value)}}">
                                                        <h6 class="name h-100">
                                                            {{ ucwords(strtolower($trending_products_row->title)) }}
                                                        </h6>
                                                    </a>
                                                    <h5 class="sold text-content">
                                                        @if ($trending_products_row->offer_rate === null)
                                                        <span class="theme-color price">Price not available</span>
                                                        @else
                                                        <span class="theme-color">Rs. {{ $final_offer_rate }}</span>
                                                        @endif

                                                        @if ($mrp !== null)
                                                        <del>Rs. {{ $mrp }}</del>
                                                        @endif
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Product Section End -->
@if (!empty($data['video']) && $data['video']->isNotEmpty())
@push('head')
<link rel="preconnect" href="https://www.youtube.com">
<link rel="preconnect" href="https://www.google.com">
<link rel="dns-prefetch" href="https://www.youtube.com">
@endpush

<section class="video-shorts">
    <div class="container-fluid-lg">
        <div class="videoSwiper">
            @foreach ($data['video'] as $video_row)
            @php
            $videoId = str_replace(['https://www.youtube.com/shorts/','https://youtube.com/shorts/'], '', $video_row->video_url);
            @endphp
            <div>
                <div class="row m-1">
                    <div class="col-12 px-0">
                        <div class="short-container">
                            <div class="youtube-lazy"
                                data-id="{{ $videoId }}"
                                data-loaded="false">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-2">
                <div class="youtube-btn mt-2">
                    <a class="btn text-white" target="_blank" href="https://www.youtube.com/@GirdharDasandSons" style="background-color: #FF5733;">
                        <i class="youtube-icon fa fa-youtube"></i> Visit Our Youtube
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endif




@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    if (container.dataset.loaded === 'true') return;

                    const videoId = container.dataset.id;
                    container.innerHTML = `
                        <iframe 
                            src="https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&loop=1&mute=1&playlist=${videoId}&enablejsapi=1" 
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            style="width:100%;height:100%;border-radius: 10px!important;"
                            title="YouTube Short">
                        </iframe>`;

                    container.dataset.loaded = 'true';
                    observer.unobserve(container);
                }
            });
        }, {
            rootMargin: '500px',
            threshold: 0.01
        });

        document.querySelectorAll('.youtube-lazy').forEach(el => {
            observer.observe(el);
        });
    });
</script>
<!-- <script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/quick-view.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script> -->
@endpush