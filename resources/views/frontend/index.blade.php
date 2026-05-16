@extends('frontend.layouts.master')
@section('title','Buy Kitchen Appliances & Cookware Online — Best Brands | GD Sons')
@section('description', 'Shop kitchen appliances, cookware, mixer grinders, pressure cookers and more from trusted brands of India. Genuine products, pan-India delivery and expert advice — from a store serving Indian kitchens since 1970.')
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
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-2">
                    <h1 class="class-h1-tags">
                        Buy Kitchen Appliances, Cookware & More Online — Pan-India delivery.
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

<section class="product-section">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            @if ($data['primary_category'] && $data['primary_category']->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-15">
                @foreach ($data['primary_category'] as $index =>$primary_category_row)

                <div class="p-1 group relative rounded overflow-hidden shadow-2xl hover:shadow-2xl transition-shadow duration-300">
                    <a href="{{ $primary_category_row['link'] ?? '#' }}">
                        <h3 class="text-[18px] sm:text-[16px] md:text-[18px] lg:text-[20px] mb-2 font-bold text-slate-800 group-hover/category:text-primary-600 transition-colors duration-300 text-center mt-1">
                            {{ $primary_category_row['title'] }}
                            <span class="block h-0.5 bg-primary-600 scale-x-0 group-hover/category:scale-x-100 transition-transform duration-300 origin-center"></span>
                        </h3>

                    </a>
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
                                                <span class="group/badge relative inline-flex items-center gap-1 bg-green-700 text-white text-[10px] font-bold tracking-wide px-2 py-[3px] rounded-full cursor-default shadow-badge hover:shadow-badge-hover hover:scale-105 transition-all duration-200">
                                                    {{ $discountPercentage }}% OFF
                                                </span>
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
                                                <del class="text-[14px] text-gray-400">Rs. {{ number_format($mrp) }}</del>
                                                @endif
                                            </div>
                                            @if($product['stock_quantity'] !== null)
                                                @if($product['stock_quantity'] <= 0)
                                                    <span class="text-xs text-red-500 block mt-1">
                                                        Out of Stock
                                                    </span>
                                                @endif
                                            @endif                                                
                                        </div>
                                    </div>
                                </a>
                            </div>
                    </div>
                    @endforeach
                </div>
                <div class="p-2 mt-2 text-center">
                    <a href="{{ $primary_category_row['link'] ?? '#' }}" class="inline-block group/category">

                        @if(isset($primary_category_row['description']))
                        <div class="mt-2 text-slate-500 line-clamp-2 text-[16px]">
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
                                                <span class="group/badge relative inline-flex items-center gap-1 bg-green-700 text-white text-[10px] font-bold tracking-wide px-2 py-[3px] rounded-full cursor-default shadow-badge hover:shadow-badge-hover hover:scale-105 transition-all duration-200">
                                                    {{ $discountPercentage }}% OFF
                                                </span>
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
                                        </div>
                                        <div class="product-detail">
                                            <a href="{{ url('products/'.$popular_product_row->slug.'/'.$attributes_value) }}">
                                                <h5 class="name line-clamp-2 text-sm font-medium text-gray-800 group-hover/product:text-primary-600 transition-colors">{{ ucwords(strtolower($popular_product_row->title)) }}</h5>
                                            </a>
                                            <div class="mt-2 flex justify-between items-center">
                                                @if ($final_offer_rate === null || $final_offer_rate == 0)
                                                <span class="text-xs text-gray-500">Price not available</span>
                                                @else
                                                <div class="flex flex-col">
                                                    <h5 class="text-base font-bold text-primary-600">Rs. {{ number_format($final_offer_rate) }}</h5>
                                                </div>
                                                @endif
                                                @if ($mrp !== null)
                                                <del class="text-[14px] text-gray-400">Rs. {{ number_format($mrp) }}</del>
                                                @endif
                                            </div>                                            
                                            @if(($popular_product_row->mrp > 0 && $popular_product_row->stock_quantity <= 0) || !$hasDimensions)
                                                <span class="text-xs text-red-500 block mt-1">
                                                    Out of Stock
                                                </span>
                                            @endif
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

<section class="why-choose-section bg-gray-50 pb-5">
    <div class="container-fluid-lg">
        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <div class="choose-card relative bg-[#0f1e36] p-10 lg:w-[480px] flex flex-col justify-between overflow-hidden shadow-2xl rounded-[16px]">
                <div class="relative text-center">
                    <p class="text-primary-teal text-[22px] font-semibold mb-1">Why Choose</p>
                    <h2 class="font-display text-white text-3xl leading-tight mb-4">
                        Girdhar Das & Sons?
                    </h2>
                    <p class="text-white leading-relaxed text-[16px]">
                        More than a store. A Kitchen Companion since 1970. For over five decades, Girdhar Das & Sons has been the kitchen the heart of kitchenware retail in Varanasi — trusted by home cooks, hotels, and professional chefs alike.


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
                        <p class="font-semibold text-slate-800 text-[17px] leading-tight mb-1">55+ Years of Trust</p>
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
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">55+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Years in Business</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">25+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Top Brands</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <span class="font-display text-2xl font-bold text-primary-teal stat-num">5K+</span>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Products</span>
                    </div>
                    <div class="feat-card bg-white rounded-xl p-2 flex flex-col items-center text-center shadow-[0_0px_30px_rgba(0,0,0,0.08)] hover:shadow-[0_0_25px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-200 cursor-default">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-teal" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                            <span class="font-display text-2xl font-bold text-primary-teal stat-num">4.8</span>
                        </div>
                        <span class="text-[15px] text-slate-400 leading-relaxed mt-1.5">Rated by Google</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($data['trending_products_weekly'] && $data['trending_products_weekly']->isNotEmpty())
<section class="current-week-product pb-12 bg-[#f5f5f0]">
    <div class="container-fluid-lg">
        <div class="title d-block text-center">
            <div>
                <h2>Trending This Week</h2>
                <span class="title-leaf"></span>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($data['trending_products_weekly'] as $index =>$product)
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
                @php
                    $hasDimensions =
                    !empty($product['length']) &&
                    !empty($product['breadth']) &&
                    !empty($product['height']) &&
                    !empty($product['weight']);
                @endphp 
                <div class="product-card bg-white rounded-2xl p-2">
                    <a href="{{ url('products/'.$product['slug'].'/'.$product['attributes_value_slug']) }}">
                        <div class="flex items-center gap-2">
                            <img src="{{ $product['image'] ?? 'https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png' }}" class="w-20 h-20 rounded-xl object-contain flex-shrink-0 bg-white p-1">
                            <div class="flex-1 min-w-0">
                                <div class="text-[13px] font-semibold tracking-widest text-primary-navy mb-1">
                                    {{ $product['category_title'] }}
                                </div>
                                <div class="product-detail">
                                    <h5 class="name line-clamp-1 text-sm font-medium text-gray-800 group-hover/product:text-primary-600 transition-colors">
                                        {{ ucwords(strtolower($product['title'])) }}
                                    </h5>
                                </div>
                                <div class="flex items-center gap-2 mt-2 flex-wrap">
                                    @if ($offer_rate === null || $offer_rate == 0)
                                        <h5 class="text-base font-bold text-primary-600">
                                            Price not available
                                        </h5>
                                    @else
                                        <h5 class="text-base font-bold text-primary-600">
                                            Rs. {{ number_format($offer_rate) }}
                                        </h5>
                                    @endif
                                    @if ($mrp !== null && $mrp > $final_offer_rate)
                                        <del class="text-[14px] text-gray-400">Rs. {{ number_format($mrp) }}</del>
                                    @endif
                                    @if($discountPercentage>0)
                                        <span class="group/badge relative inline-flex items-center gap-1 bg-green-700 text-white text-[10px] font-bold tracking-wide px-2 py-[3px] rounded-full cursor-default shadow-badge hover:shadow-badge-hover hover:scale-105 transition-all duration-200">
                                            {{ $discountPercentage }}% OFF
                                        </span>
                                    @endif
                                </div>
                                @if(($product['mrp'] > 0 && $product['stock_quantity'] <= 0) || !$hasDimensions)
                                    <span class="text-xs text-red-500 block mt-1">
                                        Out of Stock
                                    </span>
                                @endif                                
                            </div>
                            <button class="arrow-btn w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($data['blogs'] && $data['blogs']->isNotEmpty())
<section class="home-blog-section pb-4">
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
                        <p class="text-slate-500 text-[16px] leading-relaxed line-clamp-3">
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

@if ($data['attributes_value'] && $data['attributes_value']->isNotEmpty())
<section class="top-brand-we-dealin pb-5">
    <div class="container-fluid-lg">
        <div class="flex flex-wrap items-center gap-3 mb-7">
            <h4 class="lg:text-[20px] md:text-[18px] font-bold text-[#222]">Top Brands We Deal In</h4>
            <div class="flex-1 h-[1px] bg-primary-teal max-w-[100px]"></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 bg-gray-100 p-4 rounded-xl animate-fadeup">
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-2">
                    @foreach($data['attributes_value'] as $value)
                    <a href="{{ route('search', ['query' => strtolower(urlencode($value->name))]) }}" class="block">
                        <div class="group flex flex-col items-center justify-center bg-white rounded-xl border-black-600">
                            <div class="aspect-square w-full h-[100px] flex items-center justify-center overflow-hidden rounded-lg">
                                <img src="{{ asset('images/attribute-values/' . $value->images) }}"
                                    alt="{{ $value->name }}"
                                    loading="lazy"
                                    class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105 rounded-lg"
                                    onerror="this.outerHTML='<span class=\'text-[16px] font-semibold text-red-500 px-2 py-1 bg-red-50 rounded-lg\'>{{ $value->name }}</span>'">
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="bg-gray-100 rounded-xl p-6 flex items-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-center w-full">
                    <div class="flex justify-center lg:order-2 sm:order-1 md:order-1">
                        <img src="{{ asset('frontend/assets/gd-img/bulk-image.png') }}" alt="Bulk Orders" class="w-full max-w-[220px] animate-floatbox">
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 leading-tight mb-2 tracking-tight">
                            Bulk
                            <span class="text-primary-teal">
                                Orders?
                            </span>
                            <br />
                            <span class="text-black-700 text-xl">Save More.</span>
                        </h2>
                        <p class="mb-6 text-slate-500 text-[16px]">
                            Exclusive discounts for businesses, restaurants &amp; wholesalers on bulk purchases.
                        </p>
                        <a href="{{ route('contact-us') }}"
                            class="group flex items-center gap-2 bg-slate-900 hover:bg-slate-700 text-white text-[13px] font-bold px-4 py-3 rounded-full w-fit transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                            Contact Us
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
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