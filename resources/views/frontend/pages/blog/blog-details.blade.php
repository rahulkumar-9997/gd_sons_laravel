@extends('frontend.layouts.master')
@section('title','Gd Sons - '.$blog->title)
@section('description', substr(strip_tags($blog->bog_description), 0, 120))
<!-- @section('keywords', substr(strip_tags($blog->bog_description), 0, 120)) -->

@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">
                                    Blog
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{$blog->title}}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section Start -->
<section class="blog-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
        <div class="col-xxl-9 col-xl-8 col-lg-7 ratio_50 order-md-1">
                <div class="blog-detail-image rounded-3 mb-4">
                    <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl border border-gray-100 group">
                        <div class="relative">
                            <img
                                src="{{ asset($blog->blog_image) }}"
                                alt="{{ $blog->title }}"
                                class="w-full h-auto object-cover transition duration-700 ease-in-out group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>                            
                        </div>
                    </div>                    
                </div>
                <div class="blog-image-contain">
                    <h1>{{$blog->title}}</h1> 
                </div>
                <div class="blog-detail-contain">
                    {!! $blog->bog_description !!}
                </div>
                @if($blog->paragraphs->isNotEmpty())
                <div class="blog-paragraphs-section">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach ($blog->paragraphs as $index => $paragraph)
                            @php
                            $linksOne = '';
                            $linksTwo = '';
                            if ($paragraph->productLinks->isNotEmpty()) {
                            $productLink = $paragraph->productLinks->first();
                            $links = json_decode($productLink->links, true);
                            $linksOne = '<p><a href="' . ($links['link_one'] ?? '') . '">' . ($links['link_one'] ?? '') . '</a></p>';
                            $linksTwo = '<p><a href="' . ($links['link_two'] ?? '') . '">' . ($links['link_two'] ?? '') . '</a></p>';
                            }
                            @endphp
                            <div class="blog-paragraphs">
                                <div class="row">
                                    @if($paragraph->bog_paragraph_image)
                                    @if($index % 2 == 0)
                                    <div class="col-lg-4">
                                        <img src="{{ asset($paragraph->bog_paragraph_image) }}" class="rounded-3 img-fluid blur-up lazyloaded" alt="{{ $paragraph->paragraphs_title }}">
                                    </div>
                                    <div class="col-lg-8">
                                        <h3 class="recent-name">{{ $paragraph->paragraphs_title }}</h3>
                                        <div class="paragraphs_description">
                                            {!! $paragraph->bog_paragraph_description !!}
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-8">
                                        <h3 class="recent-name">{{ $paragraph->paragraphs_title }}</h3>
                                        <div class="paragraphs_description">
                                            {!! $paragraph->bog_paragraph_description !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="{{ asset($paragraph->bog_paragraph_image) }}" class="rounded-3 img-fluid blur-up lazyloaded" alt="{{ $paragraph->paragraphs_title }}">
                                    </div>
                                    @endif
                                    @else
                                    <div class="col-lg-12">
                                        <h3 class="recent-name">{{ $paragraph->paragraphs_title }}</h3>
                                        <div class="paragraphs_description">
                                            {!! $paragraph->bog_paragraph_description !!}
                                        </div>
                                        @if ($paragraph->productLinks->isNotEmpty())
                                        <div class="row row-cols-xxl-3 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow section-b-space blog-product-row justify-content-center">
                                            @foreach ($paragraph->productLinks as $productLink)
                                                @php
                                                    $product = $productLink->product;
                                                    $firstImageBlog = 
                                                    $product->images->get(0);
                                                    $attributes_value ='na';
                                                    $attributes_value_slug ='';
                                                    if($product->ProductAttributesValues->isNotEmpty()){
                                                        $attributes_value = $product->ProductAttributesValues->first()->attributeValue;
                                                        $attributes_value_slug = $attributes_value->slug;
                                                    }
                                                @endphp
                                                @php
                                                    $purchase_rate = $product->purchase_rate;
                                                    $offer_rate = $product->offer_rate;
                                                    $mrp = $product->mrp;
                                                    $group_offer_rate = null;
                                                    $special_offer_rate = null;

                                                    /*Group price calculation*/
                                                    if ($groupCategory && $offer_rate !== null) {
                                                        $group_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                                        if ($group_percentage > 0) {
                                                            $group_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * (100 / $group_percentage) / 100;
                                                            $group_offer_rate = floor($group_offer_rate);
                                                        }
                                                    }

                                                    /* Special offer price from array/helper*/
                                                    if (isset($specialOffers[$product->id])) {
                                                        $special_offer_rate = (float) $specialOffers[$product->id];
                                                    }

                                                    /*Select the lowest price from all available options*/
                                                    $final_offer_rate = collect([
                                                    $offer_rate,
                                                    $group_offer_rate,
                                                    $special_offer_rate
                                                    ])->filter()->min();

                                                    /*Discount Percentage*/
                                                    $discountPercentage = ($mrp > 0 && $final_offer_rate > 0)
                                                    ? round((($mrp - $final_offer_rate) / $mrp) * 100, 2)
                                                    : 0;

                                                    $hasDimensions =
                                                    !empty($product->length) &&
                                                    !empty($product->breadth) &&
                                                    !empty($product->height) &&
                                                    !empty($product->weight);
                                                    $isOutOfStock = ($product->mrp > 0 && $product->stock_quantity <= 0) || !$hasDimensions;
                                                @endphp
                                                <div>
                                                    <div class="product-white-bg wow fadeIn">
                                                        <div class="product-box blog-product-box h-100 ">
                                                            <div class="blog-product-img">
                                                                <div class="product-image">
                                                                    @if ($discountPercentage>0)
                                                                    <div class="label-flex">
                                                                        <span class="group/badge relative inline-flex items-center gap-1 bg-green-700 text-white text-[10px] font-bold tracking-wide px-2 py-[3px] rounded-full cursor-default shadow-badge hover:shadow-badge-hover hover:scale-105 transition-all duration-200">
                                                                            {{ $discountPercentage }}% OFF
                                                                        </span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="product-img">
                                                                        <a href="{{ url('products/'.$product->slug.'/'.$attributes_value_slug) }}">
                                                                            @if ($firstImageBlog)
                                                                            <picture>
                                                                                <source
                                                                                    media="(max-width: 767px)"
                                                                                    srcset="{{ asset('images/product/icon/' . $firstImageBlog->image_path) }}">
                                                                                <img
                                                                                    class="img-fluid blur-up lazyload"
                                                                                    data-src="{{ asset('images/product/thumb/' . $firstImageBlog->image_path) }}"
                                                                                    src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                                    srcset="{{ asset('images/product/thumb/' . $firstImageBlog->image_path) }} 600w, 
                                                                                {{ asset('images/product/thumb/' . $firstImageBlog->image_path) }} 1200w"
                                                                                    sizes="(max-width: 600px) 600px, 1200px"
                                                                                    alt="{{ $product->title }}"
                                                                                    title="{{ $product->title }}"
                                                                                    loading="lazy">
                                                                            </picture>
                                                                            @else
                                                                            <img src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                                class="img-fluid blur-up lazyload" alt="{{ $product->title }}">
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-detail">
                                                                <span class="span-name">{{ucwords(strtolower($product->category->title))}}</span>
                                                                <a href="{{ url('products/'.$product->slug.'/'.$attributes_value_slug) }}">
                                                                    <h5 class="name">
                                                                        {{ ucwords(strtolower($product->title)) }}
                                                                    </h5>
                                                                </a>
                                                                <h5 class="price">
                                                                    @if ($final_offer_rate === null)
                                                                    <span class="theme-color">Price not available</span>
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
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-5 d-lg-block order-md-2">
                <div class="left-sidebar-box">
                    <div class="accordion left-accordion-box" id="accordionPanelsStayOpenExample">
                        @if($blog_categories->isNotEmpty())
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo">
                                    Category
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                                <div class="accordion-body p-0">
                                    <div class="category-list-box">
                                        <ul>
                                            @foreach ($blog_categories as $blog_category)
                                            @if($blog_category->blogs_count > 0)
                                            <li>
                                                <a href="{{ route('blog.list', ['slug' => $blog_category->slug]) }}">
                                                    <div class="category-name">
                                                        <h5>{{ $blog_category->title }}</h5>
                                                        <span>{{ $blog_category->blogs_count }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->
@endsection
@push('scripts')
<!-- <script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script> -->
@endpush