@extends('frontend.layouts.master')
@section('title','Best Kitchen Retail Store in Varanasi now goes Online')
@section('description', 'Best Kitchen Retail Store in Varanasi now goes Online')
@section('keywords', 'Best Kitchen Retail Store in Varanasi now goes Online')
@section('main-content')
@if(isset($data['category_list']) && count($data['category_list']) > 0)
<section class="category-section-2 home-category-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="category-slider-wrapper new-grid">
                    <div class="category-slider arrow-slider category-slider-home collection_list" data-view="6-3">
                        @foreach($data['category_list'] as $index => $category)
                        <div class="category-item-home grid-item">
                            <div class="shop-category-box border-0">
                                <a href="{{ route('categories', ['categorySlug' => $category->slug]) }}" class="category-link circle-{{ ($index % 4) + 1 }}">
                                    <div class="category-img-container">
                                        @if($category->image)
                                        <img src="https://www.cdn.gdsons.co.in/category/icon/{{ $category->image }}" class="img-fluid blur-up lazyload"
                                            alt="{{ $category->title }}" loading="lazy">
                                        @else

                                        @endif
                                    </div>
                                </a>
                                <div class="category-name">
                                    <h6>{{ $category->title }}</h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<section class="home-section pt-2">
    <div class="container-fluid-lg">
        <!--
        <div class="row g-2">
            <div class="col-xl-8 ratio_65">
                <div class="home-contain h-1001">
                    @if ($data['banner'] && $data['banner']->isNotEmpty())
                    <div id="homeBannerCarousel" class="carousel slide silk-carousel-wrapper home-banner-carousel" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-indicators">
                            @foreach ($data['banner'] as $index => $banner)
                            <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : '' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
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
                    
                </div>
            </div>
        </div>
        -->
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

<section class="single-bn-mo-dblock">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dblock">
                <div class="row">
                    <div class="col-md-6 col-6 mb-2">
                        <a href="https://maps.app.goo.gl/8hPKnwQUX2Z3cT7GA" target="_blank" class="btn theme-bg-color btn-md fw-bold text-white">
                            Visit our Store
                        </a>
                    </div>
                    <div class="col-md-6 col-6 mb-2">
                        <a class="btn theme-bg-color btn-md fw-bold text-white mobile-category">
                            Explore All Products
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-6 mobile-gap single-bn-mo-dblock">
                <div class="row">
                    <div class="col-md-6 col-6 mb-2">
                        <a href="tel:+918318894257" class="btn theme-bg-color btn-md fw-bold text-white">
                            Call us Now
                        </a>
                    </div>
                    <div class="col-md-6 col-6 mb-2">
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
</section>

<section class="why-choose-section">
    <div class="container-fluid-lg">
        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <div class="choose-card relative bg-[#0f1e36] p-10 lg:w-[480px] flex flex-col justify-between overflow-hidden shadow-2xl rounded-[16px]">
                <div class="relative text-center">
                    <p class="text-primary-teal text-[22px] font-semibold mb-1">Why Choose</p>
                    <h2 class="font-display text-white text-3xl leading-tight mb-4">
                        Girdhar Das & Sons?
                    </h2>
                    <p class="text-white leading-relaxed text-[16px]">
                        Since 1970, we've been Varanasi's most trusted kitchen store. From pressure cookers to chimneys — we have everything to make your cooking experience better.
                    </p>
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('about-us') }}"
                        class="inline-block relative bg-primary-teal text-white hover:!text-black hover:bg-background-light text-sm font-semibold px-6 py-3 rounded-full transition-all duration-300">
                        Read More
                    </a>
                </div>
            </div>
            <div class="flex-1 flex flex-col gap-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="icon-circle w-14 h-14 bg-primary-teal rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-800 text-[17px] leading-tight mb-1">50+ Years of Trust</p>
                        <p class="text-[15px] text-slate-400 leading-relaxed">Serving Varanasi since 1970</p>
                    </div>
                    <!-- Feature 2: Wide Range -->
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="icon-circle w-14 h-14 bg-primary-teal rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-800 text-[17px] leading-tight mb-1">Wide Range of Products</p>
                        <p class="text-[15px] text-slate-400 leading-relaxed">Everything for your kitchen</p>
                    </div>
                    <!-- Feature 3: Best Quality -->
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="icon-circle w-14 h-14 bg-primary-teal rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-800 text-[17px] leading-tight mb-1">Best Quality Guarantee</p>
                        <p class="text-[15px] text-slate-400 leading-relaxed">100% original &amp; durable</p>
                    </div>
                    <!-- Feature 4: Fast Delivery -->
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="icon-circle w-14 h-14 bg-primary-teal rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-800 text-[17px] leading-tight mb-1">Fast &amp; Safe Delivery</p>
                        <p class="text-[15px] text-slate-400 leading-relaxed">Quick delivery across Varanasi</p>
                    </div>
                </div>

                <!-- second grid: 4 stat cards (metrics) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Stat 1: Happy Customers -->
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">15K+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Happy Customers</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">200+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Top Brands</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">10K+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Products</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-teal" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                            <span class="font-display text-2xl font-bold text-primary-teal stat-num">4.8</span>
                        </div>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Average Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            @if ($data['primary_category'] && $data['primary_category']->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-15">
                @foreach ($data['primary_category'] as $index =>$primary_category_row)
                <div class="p-1 group relative rounded overflow-hidden shadow-2xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($primary_category_row['products'] as $productIndex => $product)
                        @php
                        $offer_rate = $product['offer_rate'];
                        $mrp = $product['mrp'];
                        $purchase_rate = $product['purchase_rate'];
                        $group_offer_rate = null;
                        $special_offer_rate = null;

                        if ($groupCategory && $offer_rate !== null) {
                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                        if ($group_percentage > 0) {
                        $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                        $group_offer_rate = floor($group_offer_rate);
                        }
                        }

                        /*Special Offer*/
                        if (isset($specialOffers[$product['id']])) {
                        $special_offer_rate = (float) $specialOffers[$product['id']];
                        }
                        /* Choose lowest rate */
                        $all_rates = array_filter([
                        $offer_rate,
                        $group_offer_rate,
                        $special_offer_rate
                        ]);
                        if (!empty($all_rates)) {
                        $final_offer_rate = min($all_rates);
                        } else {
                        $final_offer_rate = $offer_rate;
                        }

                        /* Calculate discount */
                        $discountPercentage = ($mrp > 0 && $final_offer_rate > 0 && $final_offer_rate < $mrp)
                            ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                            : 0;

                            @endphp
                            <div class="w-full h-full border border-gray-600 rounded-xl bg-white group/product transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-lg">
                            <div class="relative w-full h-full">
                                <a href="{{ url('products/'.$product['slug'].'/'.$product['attributes_value_slug']) }}" class="block">
                                    <div class="overflow-hidden rounded-t-xl">
                                        <div class="relative overflow-hidden image-shine product-img aspect-square">
                                            <img src="{{ $product['image'] ?? 'https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png' }}"
                                                alt="{{ $product['title'] }}"
                                                loading="lazy"
                                                class="absolute top-0 left-0 w-full h-full object-contain blur-up lazyloaded transition-transform duration-500 group-hover/product:scale-105">
                                            @if($discountPercentage > 0)
                                            <div class="discount absolute top-2 left-2 z-1">
                                                <label class="bg-gradient-to-r bg-primary-teal text-white px-2 py-1 rounded-md text-xs font-bold shadow-md">
                                                    Save {{ $discountPercentage }}%
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-full px-2 py-2 space-y-2">
                                        <div class="mt-1 product-detail">
                                            <h5 class="name line-clamp-2 text-sm font-medium text-gray-800 group-hover/product:text-primary-600 transition-colors">
                                                {{ ucwords(strtolower($product['title'])) }}
                                            </h5>
                                            <div class="mt-2 flex justify-between items-center">
                                                @if ($offer_rate === null || $offer_rate == 0)
                                                <span class="text-xs text-gray-500">Price not available</span>
                                                @else
                                                <div class="flex flex-col">
                                                    <h5 class="text-base font-bold text-primary-600">Rs. {{ number_format($offer_rate) }}</h5>
                                                </div>
                                                @endif
                                                @if ($mrp !== null && $mrp > $final_offer_rate)
                                                <del class="text-xs text-gray-400">Rs. {{ number_format($mrp) }}</del>
                                                @endif
                                            </div>
                                            @if($product['stock_quantity'] !== null)
                                            @if($product['stock_quantity'] <= 0)
                                                <span class="text-xs text-red-500 block mt-1">Out of Stock</span>
                                                @endif
                                                @endif
                                                <!--<div class="flex items-center mt-2">
                                                <div class="flex text-yellow-400 text-xs">
                                                    ★★★★★
                                                </div>
                                                <span class="text-xs text-gray-500 ml-1">(0)</span>
                                            </div>-->
                                        </div>
                                    </div>
                                </a>
                            </div>
                    </div>
                    @endforeach
                </div>
                <div class="p-2 mt-2 text-center">
                    <a href="{{ $primary_category_row['link'] ?? '#' }}" class="inline-block group/category">
                        <h3 class="text-lg font-bold text-slate-800 group-hover/category:text-primary-600 transition-colors duration-300">
                            {{ $primary_category_row['title'] }}
                            <span class="block h-0.5 bg-primary-600 scale-x-0 group-hover/category:scale-x-100 transition-transform duration-300 origin-center"></span>
                        </h3>
                        @if(isset($primary_category_row['description']))
                        <div class="mt-2 text-[black] text-sm line-clamp-2">
                            {!! strip_tags($primary_category_row['description']) !!}
                        </div>
                        @endif
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
            @if ($data['popular_products'] && $data['popular_products']->isNotEmpty())
            <div class="title d-block text-center">
                <div>
                    <h2>Popular Products</h2>
                    <span class="title-leaf"></span>
                </div>
            </div>
            <div class="section-b-space">
                <div class="non-product-border non-border-row no-overflow-hidden">
                    <div class="product-box-slider1 no-arrow1">
                        @php
                        $row_count = 0;
                        @endphp
                        <div>
                            <div class="row g-sm-4 g-3 row-cols-xxl-6 row-cols-xl-6 row-cols-lg-5 row-cols-md-3 row-cols-2 m-0">
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
                                <div>
                                    <div class="p-1 group relative rounded overflow-hidden shadow-2xl hover:shadow-2xl transition-shadow duration-300 product-box mb-1 h-100">
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
                                                        <source
                                                            media="(max-width: 767px)"
                                                            srcset="https://www.cdn.gdsons.co.in/product/icon/{{ $firstImage->image_path }}">

                                                        <img
                                                            class="img-fluid blur-up lazyload"
                                                            data-src="https://www.cdn.gdsons.co.in/product/thumb/{{ $firstImage->image_path }}"
                                                            src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                            srcset="
                                                                    https://www.cdn.gdsons.co.in/product/thumb/{{ $firstImage->image_path }} 600w,
                                                                    https://www.cdn.gdsons.co.in/product/thumb/{{ $firstImage->image_path }} 1200w
                                                                "
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
                                            @php
                                            $hasDimensions =
                                            !empty($popular_product_row->length) &&
                                            !empty($popular_product_row->breadth) &&
                                            !empty($popular_product_row->height) &&
                                            !empty($popular_product_row->weight);
                                            @endphp
                                            @if(($popular_product_row->mrp > 0 && $popular_product_row->stock_quantity <= 0) || !$hasDimensions)
                                                <ul class="product-option">
                                                <li title="Out of Stock">
                                                    <a href="javascript:void(0)" class="out_of_stock">
                                                        Out of Stock
                                                    </a>
                                                </li>
                                                </ul>
                                                @endif
                                        </div>
                                        <div class="product-detail">
                                            <a href="{{ url('products/'.$popular_product_row->slug.'/'.$attributes_value) }}">
                                                <h5 class="name">{{ ucwords(strtolower($popular_product_row->title)) }}</h5>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    </div>
    </div>
</section>
@if ($data['blogs'] && $data['blogs']->isNotEmpty())
    <section class="home-blog-section pb-5">
        <div class="container-fluid-lg">
            <div class="blog-heading text-center mb-4">
                <div class="title d-block text-center">
                    <div>
                        <h2>Our Blog</h2>
                        <span class="title-leaf"></span>
                    </div>
                </div>
                <p class="leading-relaxed text-[16px]">
                    Expert advice, product guides and cooking tips from Varanasi's most trusted kitchen store since 1970.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($data['blogs'] as $blog_row)
                    <div class="blog-card bg-white rounded-2xl overflow-hidden shadow-[0_0_20px_rgba(0,0,0,0.07)]">
                        <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}">
                            <div class="overflow-hidden h-56 relative">
                                <img src="{{asset($blog_row->blog_image) }}" alt="{{$blog_row->title}}"
                                class="blog-img w-full h-full object-cover" />
                                <span class="absolute top-4 left-4 bg-primary-teal text-white text-[10px] font-semibold px-3 py-1 rounded-full shadow">
                                   {{$blog_row->category->title}}
                                </span>
                            </div>
                            <div class="p-3 pb-2">
                                <h6 class="font-display text-slate-800 text-[20px] mb-3 line-clamp-3">
                                    {{$blog_row->title}}
                                </h6>                                
                                @if(!empty($blog_row->bog_description))
                                <p class="text-slate-500 text-[15px] leading-relaxed line-clamp-3">
                                    {!! strip_tags($blog_row->bog_description) !!}
                                </p>
                                @endif
                            </div>
                        </a>
                        <div class="px-2 pb-3 pt-3 border-t border-slate-100 text-center">
                            <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}" class="inline-flex items-center gap-1.5 text-primary-teal text-[16px] font-semibold hover:gap-3 transition-all">
                                Read More
                                <svg class="w-3.5 h-3.5 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
@push('schema')
<!-- Organization Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Girdhar Das & Sons",
        "url": "https://gdsons.co.in",
        "logo": "{{ asset('frontend/assets/gd-img/fav-icon.png') }}",
        "description": "Best Kitchen Retail Store in Varanasi offering a wide range of kitchenware, dinnerware, and appliances.",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "W.H.Smith School Road, Sigra, Varanasi",
            "addressLocality": "Varanasi",
            "addressRegion": "Uttar Pradesh",
            "postalCode": "221010",
            "addressCountry": "IN"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+919935070000",
            "contactType": "customer service",
            "areaServed": "IN",
            "availableLanguage": ["en", "hi"]
        },
        "sameAs": [
            "https://www.instagram.com/gdsons.vns/",
            "https://www.youtube.com/@GirdharDasandSons",
            "https://www.facebook.com/gdandsons"
        ]
    }
</script>
<!-- Website Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Girdhar Das & Sons",
        "url": "https://www.gdsons.co.in/",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://www.gdsons.co.in/search?query={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
</script>
<!-- Local Business Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Store",
        "name": "Girdhar Das & Sons",
        "image": "{{ asset('frontend/assets/images/logo.png') }}",
        "description": "Best Kitchen Retail Store in Varanasi now goes Online",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "W.H.Smith School Road, Sigra, Varanasi",
            "addressLocality": "Varanasi",
            "addressRegion": "Uttar Pradesh",
            "postalCode": "221010",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "25.3108",
            "longitude": "83.0106"
        },
        "url": "https://www.gdsons.co.in/",
        "telephone": "+919935070000",
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ],
            "opens": "10:00",
            "closes": "20:00"
        },
        "priceRange": "₹₹"
    }
</script>
@endpush
@push('scripts')

@endpush