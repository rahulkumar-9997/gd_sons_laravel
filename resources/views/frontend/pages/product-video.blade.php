@extends('frontend.layouts.master')
@php
if ($product->meta_title) {
    $meta_title = $product->meta_title;
} else {
    $meta_title = $product->title;
}

if ($product->meta_description) {
    $meta_description = $product->meta_description;
} else {
    $meta_description = strip_tags($product->product_description);
}
@endphp
@section('title','Gd Sons - '.$meta_title)
@section('description', substr(strip_tags($meta_description), 0, 120))
@section('main-content')
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain bred-back">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ $ref ?? url()->previous() }}">
                                   Back to Product Page
                                </a>
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
            <div class="col-lg-12">
                <div class="video-ptitle">
                    <h1 class="pv-title">
                        {{ $product->title }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="product-video-section">
                    <div class="product-short-container">
                        <div class="product-video-container short" data-video-id="{{ $product->video_id }}">
                            <iframe 
                                src="https://www.youtube.com/embed/{{ $product->video_id }}?autoplay=1&mute=0&enablejsapi=1&playsinline=1&rel=0&modestbranding=1&loop=1&playlist={{ $product->video_id }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($product->product_description))
            <div class="col-lg-8">
                <div class="product-section-box description-box">                   
                    <div class="tab-content custom-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="description">
                            <div class="product-description-content">
                                <p>
                                    {!! $product->product_description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
@push('scripts')
@endpush