@extends('frontend.layouts.master')
@section('title','Gd Sons - '.$blog_category->title)
@section('description', substr(strip_tags($blog_category->title), 0, 120))
<!-- @section('keywords', 'Laravel Ecommerce') -->

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

                            <li class="breadcrumb-item active">
                                {{$blog_category->title}}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section Start -->
<section class="blog-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-4">
            <div class="col-xxl-9 col-xl-8 col-lg-7 order-lg-2">
                <div class="row g-4 ratio_65">
                    @if($blog->isNotEmpty())
                    @foreach ($blog as $blog_row)
                    <div class="col-xxl-4 col-sm-6">
                        <div class="blog-box wow fadeInUp">
                            <div class="blog-image pc-img-wrapper">
                                <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}">
                                    <img src="{{asset($blog_row->blog_image) }}"
                                        class="blog-bg blur-up lazyload pc__img" alt="{{$blog_row->title}}"/>
                                </a>
                            </div>

                            <div class="blog-contain">
                                <div class="blog-label">
                                    <span class="time"><i data-feather="clock"></i> <span>
                                            {{ $blog_row->created_at->format('d M, Y') }}
                                        </span></span>

                                </div>
                                <a href="{{ route('blog.details', ['slug' => $blog_row->slug]) }}">
                                    <h3>
                                        {{$blog_row->title}}
                                    </h3>
                                </a>
                                <button
                                    onclick="location.href='{{ route('blog.details', ['slug' => $blog_row->slug]) }}';"
                                    class="blog-button">
                                    Read More
                                    <i class="fa-solid fa-right-long"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-5 order-lg-1">
                <div class="left-sidebar-box wow fadeInUp">
                    <div class="accordion left-accordion-box" id="accordionPanelsStayOpenExample">
                        @if($blog_recent_post->isNotEmpty())

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne">
                                    Recent Post
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="recent-post-box">
                                        @foreach ($blog_recent_post as $blog_recent_post_row)
                                            <div class="recent-box">
                                                <a href="{{ route('blog.details', ['slug' => $blog_recent_post_row->slug]) }}" class="recent-image">
                                                    <img src="{{ asset($blog_recent_post_row->blog_image) }}" class="img-fluid blur-up lazyload" alt="{{ $blog_recent_post_row->title }}">
                                                </a>

                                                <div class="recent-detail">
                                                    <a href="{{ route('blog.details', ['slug' => $blog_recent_post_row->slug]) }}">
                                                        <h5 class="recent-name">{{ $blog_recent_post_row->title }}</h5>
                                                    </a>
                                                    <h6>{{ \Carbon\Carbon::parse($blog_recent_post_row->created_at)->format('d M, Y') }}
                                                        <!-- <i data-feather="thumbs-up"></i> -->
                                                    </h6>
                                                </div>
                                            </div>
                                        @endforeach
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
<!-- Blog Section End -->
@endsection
@push('scripts')
<!-- <script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script> -->
@endpush