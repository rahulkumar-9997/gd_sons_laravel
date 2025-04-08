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
            <div class="col-xxl-3 col-xl-4 col-lg-5 d-lg-block d-none">
                <div class="left-sidebar-box">
                    <div class="accordion left-accordion-box" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne">
                                    Recent Post
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="recent-post-box">
                                        @if($blog_recent_post->isNotEmpty())
                                        @foreach($blog_recent_post as $post)
                                        <div class="recent-box">
                                            <a href="{{ route('blog.details', ['slug' => $blog->slug]) }}" class="recent-image">
                                                <img src="{{ asset($post->blog_image) }}" class="img-fluid blur-up lazyload" alt="{{ $post->title }}">
                                            </a>

                                            <div class="recent-detail">
                                                <a href="{{ route('blog.details', ['slug' => $blog->slug]) }}">
                                                    <h5 class="recent-name">{{ $post->title }}</h5>
                                                </a>
                                                <h6>{{ \Carbon\Carbon::parse($post->created_at)->format('d M, Y') }}
                                                    <!-- <i data-feather="thumbs-up"></i> -->
                                                </h6>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <p>No recent posts available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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

            <div class="col-xxl-9 col-xl-8 col-lg-7 ratio_50">
                <div class="blog-detail-image rounded-3 mb-4">
                    <div class="blog-deta-img">
                        <img src="{{asset($blog->blog_image) }}" class="pc__img_blog bg-img-blog-details blur-up lazyload" alt="{{$blog->title}}">
                    </div>
                    <div class="blog-image-contain">
                        <h1>{{$blog->title}}</h1>
                        <ul class="contain-comment-list">
                            <li>
                                <div class="user-list">
                                    <i data-feather="calendar"></i>
                                    <span>{{$blog->created_at->format('F j, Y')}}</span>
                                </div>
                            </li>

                        </ul>
                    </div>
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
                                                    $firstImageBlog = $product->ProductImagesFront->first();
                                                    $attributes_value ='na';
                                                    $attributes_value_slug ='';
                                                    if($product->ProductAttributesValues->isNotEmpty()){
                                                        $attributes_value = $product->ProductAttributesValues->first()->attributeValue;
                                                        $attributes_value_slug = $attributes_value->slug;
                                                    }
                                                @endphp
                                                <div>
                                                    <div class="product-box product-white-bg wow fadeIn">
                                                        <div class="product-box">
                                                            <div class="product-image">
                                                                <a href="{{ url('products/'.$product->slug.'/'.$attributes_value_slug) }}">
                                                                    @if ($firstImageBlog)
                                                                    <img class="img-fluid blur-up lazyload"
                                                                        data-src="{{ asset('images/product/large/'. $firstImageBlog->image_path) }}"
                                                                        src="{{ asset('images/product/large/'. $firstImageBlog->image_path) }}"
                                                                        alt="{{ $product->title }}" title="{{ $product->title }}">
                                                                    @else
                                                                    <img src="{{ asset('frontend/assets/gd-img/product/no-image.png') }}"
                                                                        class="img-fluid blur-up lazyload" alt="{{ $product->title }}">
                                                                    @endif
                                                                </a>
                                                                <!--<ul class="product-option">
                                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                        <a href="javascript:void(0)" data-url="{{ route('quick.view') }}" data-product-id="{{ $product->id }}" class="quick-view">
                                                                            <i data-feather="eye"></i>
                                                                        </a>
                                                                    </li>
                                                                    @if (auth()->guard('customer')->check())
                                                                    @php
                                                                    $customerId = auth('customer')->id();
                                                                    $isInWishlist = \App\Models\Wishlist::where('customer_id', $customerId)->where('product_id', $product->id)->exists();
                                                                    @endphp
                                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                                        <a href="javascript:void(0)"
                                                                            class="addwishlist {{ $isInWishlist ? 'added-to-wishlist' : '' }}"
                                                                            data-pid="{{ $product->id }}"
                                                                            data-url="{{ route('wishlist.add') }}"
                                                                            data-cuid="{{ $customerId }}">
                                                                            @if ($isInWishlist)
                                                                            <i class="feather-icon heart-icon filled" data-feather="heart"></i>
                                                                            @else
                                                                            <i class="feather-icon heart-icon" data-feather="heart"></i>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                    @else
                                                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                                        <a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}" class="addwishlist-le" data-pid="{{ $product->id }}">
                                                                            <i data-feather="heart"></i>
                                                                        </a>
                                                                    </li>
                                                                    @endif
                                                                </ul>-->
                                                            </div>
                                                            <div class="product-detail">
                                                                <a href="{{ url('products/'.$product->slug.'/'.$attributes_value_slug) }}">
                                                                    <h6 class="name h-100">
                                                                        {{ ucwords(strtolower($product->title)) }}
                                                                    </h6>
                                                                </a>
                                                                <h5 class="sold text-content">
                                                                    @if ($product->offer_rate === null)
                                                                        <span class="theme-color price">
                                                                            Price not available
                                                                        </span>
                                                                    @else
                                                                    @php
                                                                        $final_offer_rate = $product->offer_rate;
                                                                        if($groupCategory){
                                                                            $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);
                                                                            if ($group_categoty_percentage > 0) {
                                                                            $purchase_rate = $product->purchase_rate;
                                                                            $offer_rate = $product->offer_rate;
                                                                            $percent_discount = 100 / $group_categoty_percentage;
                                                                            $final_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * $percent_discount / 100;
                                                                            $final_offer_rate = floor($final_offer_rate);
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <span class="theme-color">Rs. {{$final_offer_rate}}</span>
                                                                    @endif
                                                                    @if ($product->mrp !== null)
                                                                    <del>Rs. {{ $product->mrp }}</del>
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
        </div>
    </div>
</section>
<!-- Blog Details Section End -->
@endsection
@push('scripts')
<!-- <script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script> -->
@endpush