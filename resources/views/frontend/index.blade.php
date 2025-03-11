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
                    <div id="homeBannerCarousel" class="carousel slide silk-carousel-wrapper home-banner-carousel"  >
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
                                            loading="lazy"
                                            >
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
                <div class="row g-2">

                    <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dnone">
                        <div class="home-contain">
                            <img src="{{asset('frontend/assets/images/side-banner-1.png')}}" class="img-responsive blur-up lazyload"
                                alt="side banner" loading="lazy"
                                >
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
                                <a href="https://www.gdsons.co.in/about-us" class="btn theme-bg-color btn-md fw-bold text-white">
                                    Know more About us
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
<section class="banner-section ratio_60 wow fadeInUp">
    <div class="container-fluid-lg">
        <div class="banner-slider gd5">
            <div>
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/vacuum-flask">
                    <img 
                        src="{{ asset('frontend/assets/gd-img/banner-bottom/bottlesU.webp') }}" 
                        class="img-fluid blur-up lazyload"
                        alt="bottles" 
                        loading="lazy">
                    </a>
                    <!--<div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger">5% OFF</h6>
                            <h5>Hot Deals on New Items</h5>
                            <h6 class="text-content">Daily Essentials Eggs & Dairy</h6>
                        </div>
                        <a href="shop-left-sidebar.html" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>-->
                </div>
            </div>

            <div>
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/lpg-gas-stoves">
                    <img 
                        src="{{ asset('frontend/assets/gd-img/banner-bottom/stovesU.webp') }}" 
                        class="img-fluid blur-up lazyload" 
                        
                        alt="lpg gas stoves" 
                        loading="lazy">
                    </a>
                    <!--<div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger">5% OFF</h6>
                            <h5>Buy More & Save More</h5>
                            <h6 class="text-content">Fresh Vegetables</h6>
                        </div>
                        <a href="shop-left-sidebar.html" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>-->
                </div>
            </div>

            <div>
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/lunchbox-tiffin">
                        <img 
                        src="{{ asset('frontend/assets/gd-img/banner-bottom/tiffinsU.webp') }}" 
                        class="img-fluid blur-up lazyload" 
                        
                        alt="Tiffins" 
                        loading="lazy">
                    </a>
                    <!--<div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger">5% OFF</h6>
                            <h5>Organic Meat Prepared</h5>
                            <h6 class="text-content">Delivered to Your Home</h6>
                        </div>
                        <a href="shop-left-sidebar.html" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>-->
                </div>
            </div>

            <div>
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/kitchen-appliances">
                        <img 
                        src="{{ asset('frontend/assets/gd-img/banner-bottom/appliances_0.webp') }}" 
                        class="img-fluid blur-up lazyload" 
                        
                        alt="Application" 
                        loading="lazy">

                    </a>
                    <!--<div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger">5% OFF</h6>
                            <h5>Buy More & Save More</h5>
                            <h6 class="text-content">Nuts & Snacks</h6>
                        </div>
                        <a href="shop-left-sidebar.html" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>-->
                </div>
            </div>
            <div>
                <div class="banner-contain hover-effect">
                    <a href="https://gdsons.co.in/categories/pressure-cooker">
                        <img src="{{asset('frontend/assets/gd-img/banner-bottom/CookerPosterF1.webp')}}" class=" img-fluid blur-up lazyloaded" alt="" loading="lazy">
                    </a>
                    <!--<div class="banner-details">
                        <div class="banner-box">
                            <h6 class="text-danger">5% OFF</h6>
                            <h5>Buy More & Save More</h5>
                            <h6 class="text-content">Nuts & Snacks</h6>
                        </div>
                        <a href="shop-left-sidebar.html" class="banner-button text-white">Shop Now <i
                                class="fa-solid fa-right-long ms-2"></i></a>
                    </div>-->
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
            <div class="col-xxl-3 col-xl-3 col-md-3 col-lg-3">
                <div class="p-sticky home-sticky-category-section">
                    @if ($data['primary_category'] && $data['primary_category']->isNotEmpty())
                    <div class="category-menu">
                        <h3>Highlighted Products</h3>
                        <ul>
                            @foreach ($data['primary_category'] as $primary_category_row)
                            <li class="{{ $loop->last ? 'pb-30' : '' }}">
                                <div class="category-list">
                                    <h5>
                                        <a href="{{$primary_category_row->link}}">
                                            {{$primary_category_row->title}}
                                        </a>
                                    </h5>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9">
                @if ($data['popular_products'] && $data['popular_products']->isNotEmpty())
                <div class="title title-flex">
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
                    <div class="product-border border-row overflow-hidden">
                        <div class="product-box-slider no-arrow">
                            @php
                                $row_count = 0;
                                $num_of_item_display_new = 2;
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
                                        if ($groupCategory && $popular_product_row->offer_rate !== null) {
                                            $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                            if ($group_categoty_percentage > 0) {
                                                $purchase_rate = $popular_product_row->purchase_rate;
                                                $offer_rate = $popular_product_row->offer_rate;
                                                $percent_discount = 100 / $group_categoty_percentage;
                                                $final_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * $percent_discount / 100;
                                                $final_offer_rate = floor($final_offer_rate);
                                            }
                                        }
                                    @endphp
                                    @php
                                    $discountPercentage = ($mrp > 0) ? round(((($mrp - $final_offer_rate) / $mrp) * 100), 2) : 0;
                                    @endphp
                                    <div class="col-12 px-0">
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
                                                <a href="{{ url('products/'.$popular_product_row->slug.'/'.$attributes_value) }}">
                                                @if ($firstImage)
                                                    <img 
                                                        class="img-fluid blur-up lazyload" 
                                                        data-src="{{ asset('images/product/thumb/'. $firstImage->image_path) }}" 
                                                        src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}" 
                                                        srcset="{{ asset('images/product/thumb/'. $firstImage->image_path) }} 600w, 
                                                                {{ asset('images/product/thumb/'. $firstImage->image_path) }} 1200w"
                                                        sizes="(max-width: 600px) 600px, 1200px"
                                                        alt="{{ $popular_product_row->title }}" 
                                                        title="{{ $popular_product_row->title }}" 
                                                        loading="lazy">
                                                @else
                                                    <img 
                                                        src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                        class="img-fluid blur-up lazyload" 
                                                        alt="{{ $popular_product_row->title }}" 
                                                        loading="lazy">
                                                @endif

                                                </a>
                                                
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
                    <div class="title d-block">
                        <h2>Trending Products</h2>
                        <span class="title-leaf">
                            <!-- <svg class="icon-width">
                                <use xlink:href="{{asset('frontend/assets/svg/leaf.svg#leaf')}}"></use>
                            </svg> -->
                        </span>
                        <!-- <p>A virtual assistant collects the products from your list</p> -->
                    </div>
                    <div class="home-trending-section">
                        <div class="product-border overflow-hidden wow fadeInUp">
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
                                    $final_offer_rate = $trending_products_row->offer_rate;
                                    $mrp = $trending_products_row->mrp;

                                    if ($groupCategory && $trending_products_row->offer_rate !== null) {
                                        $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                        if ($group_categoty_percentage > 0) {
                                            $purchase_rate = $trending_products_row->purchase_rate;
                                            $offer_rate = $trending_products_row->offer_rate;
                                            $percent_discount = 100 / $group_categoty_percentage;
                                            $final_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * $percent_discount / 100;
                                            $final_offer_rate = floor($final_offer_rate);
                                        }
                                    }
                                    $discountPercentage = ($mrp > 0) ? round(((($mrp - $final_offer_rate) / $mrp) * 100), 2) : 0;
                                @endphp
                                <div>
                                    <div class="row m-0">
                                        <div class="col-12 px-0">
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
                                                    <a href="{{ url('products/'.$trending_products_row->slug.'/'.$attributes_value)}}">
                                                    @if ($firstImageTrending)
                                                        <img 
                                                            class="img-fluid blur-up lazyload" 
                                                            data-src="{{ asset('images/product/thumb/'. $firstImageTrending->image_path) }}" 
                                                            src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}" 
                                                            srcset="{{ asset('images/product/thumb/'. $firstImageTrending->image_path) }} 600w, 
                                                                    {{ asset('images/product/thumb/'. $firstImageTrending->image_path) }} 1200w"
                                                            sizes="(max-width: 600px) 600px, 1200px"
                                                            alt="{{ $trending_products_row->title }}" 
                                                            title="{{ $trending_products_row->title }}" 
                                                            loading="lazy">
                                                    @else
                                                        <img 
                                                            src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                            class="img-fluid blur-up lazyload" 
                                                            alt="{{ $trending_products_row->title }}" 
                                                            loading="lazy">
                                                    @endif

                                                    </a>
                                                    
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
@endsection
@push('scripts')
<script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/quick-view.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script>
@endpush