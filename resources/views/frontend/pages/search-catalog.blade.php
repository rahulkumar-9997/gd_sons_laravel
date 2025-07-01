@extends('frontend.layouts.master')
@section('title', ($query ?? 'Search'))
@section('description', 'GD Sons - ' . ($query ?? 'Search'))
@section('keywords', 'GD Sons - ' . ($query ?? 'Search'))
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
                            
                            <li class="breadcrumb-item active">{{$query ?? 'Search'}} </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Shop Section Start -->
<section class="section-b-space shop-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="h1-heading">
                <h1>
                    You search on {{$query ?? 'Search'}}
                </h1>
                </div>
            </div>
            <div class="col-custom-3">
                <div class="left-box">
                    <div class="shop-left-sidebar">
                        <div class="back-button">
                            <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                        </div>
                        @if (isset($categories) && $categories->isNotEmpty())
                        <div class="accordion custom-accordion" id="accordionExample">
                            <!-- Price Range Filter Section -->
                            <!--<div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        <span>Price</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse hide">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input type="text" class="js-range-slider" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- Category Filter Section (Single Accordion) -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCategories">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategories">
                                        <span>Categories</span>
                                    </button>
                                </h2>
                                <div id="collapseCategories" class="accordion-collapse collapse show" aria-labelledby="headingCategories">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding custom-height">
                                            @foreach($categories as $category)
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated filter-checkbox" type="checkbox"
                                                        data-category-id="{{ $category->id }}"
                                                        value="{{ $category->id }}"
                                                        id="check_category_{{ $category->id }}"
                                                        @if(in_array($category->id, explode(',', request()->query('category', '')))) checked @endif>
                                                    <label class="form-check-label" for="check_category_{{ $category->id }}">
                                                        <span class="name">{{ $category->title }}</span>
                                                    </label>
                                                </div>
                                            </li>
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
            <div class="col-custom-">

                <div class="show-button filter-bar">
                    <div class="filter-button-group d-lg-none">
                        <div class="filter-button d-inline-block ">
                            <a><i class="fa-solid fa-filter"></i> Filter</a>
                        </div>
                    </div>
                    <div class="top-filter-menu">
                        <div class="filter-category filter-bar-desktop secondary-bar" style="display: none;">
                            <ul>

                            </ul>
                            <div class="filter-title">
                                <a href="javascript:void(0)" id="clear-filters">Clear All</a>
                            </div>
                        </div>
                        <!--<div class="category-dropdown" style="margin-left: auto !important;">
							<h5 class="text-content">Sort By :</h5>
							<div class="dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown">
									<span>{{ request('sort', 'Most Popular') }}</span> <i class="fa-solid fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item" data-sortid="new-arrivals" href="javascript:void(0)">New Arrivals</a>
									</li>
									<li>
										<a class="dropdown-item" data-sortid="price-low-to-high" href="javascript:void(0)">Price Low To High</a>
									</li>
									<li>
										<a class="dropdown-item" data-sortid="price-high-to-low" href="javascript:void(0)">Price High To Low</a>
									</li>
									<li>
										<a class="dropdown-item" data-sortid="a-to-z-order" href="javascript:void(0)">A - Z Order</a>
									</li>
								</ul>
							</div>
						</div>-->

                    </div>
                </div>
                @if (isset($products) && $products->isNotEmpty())
                <div
                    class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-2 product-list-section" id="search-catalog-frontend">
                    @include('frontend.pages.partials.ajax-search-catalog', [$products])
                </div>
                @else
                <p>No products found on your search query !.</p>
                @endif

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection
@push('scripts')
<script src="{{asset('frontend/assets/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/search-catalog-filter.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/quick-view.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/addto-cart.js')}}"></script>
@endpush