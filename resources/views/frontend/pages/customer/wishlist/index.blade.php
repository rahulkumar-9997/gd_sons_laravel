@extends('frontend.layouts.master')
@section('title','GD Sons - My Wishlist')
@section('description', 'GD Sons - My Wishlist')
@section('keywords', 'GD Sons - My Wishlist')
@push('styles')
<style>
    /* .user-dashboard-section .dashboard-left-sidebar .profile-box .profile-contain .profile-image {
    position: relative; 
    display: inline-block; 
} */
    .user-dashboard-section .dashboard-left-sidebar .profile-box .profile-contain .profile-image .spinner {
        position: absolute;
        top: 0%;
        left: 30%;
        transform: translate(-50%, -50%);
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: calc(93px + 15*(100vw - 320px) / 1600);
        height: calc(93px + 15*(100vw - 320px) / 1600);
        animation: spin 2s linear infinite;
        z-index: 10;
        display: none;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@section('main-content')
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{URL::to('')}}">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Wishlist</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            @include('frontend.pages.customer.common.customer-menu')
            <div class="col-xxl-9 col-lg-8">
                <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                    Menu</button>
                <div class="dashboard-right-sidebar">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel">
                            <div class="dashboard-order">
                                <div class="title">
                                    <h2>My Wishlist History</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <!-- <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('images/leaf.svg#leaf')}}"></use>
                                        </svg> -->
                                    </span>
                                </div>
                                <div class="row g-sm-4 g-3">
                                    @if($wishlist->isNotEmpty())
                                        @foreach ($wishlist as $wishlistItem)
                                        @php
                                        $attributes_value ='na';
                                            if($wishlistItem->product->ProductAttributesValues->isNotEmpty()){
                                            $attributes_value = $wishlistItem->product->ProductAttributesValues->first()->attributeValue->slug;
                                        }
                                        @endphp
                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="{{ url('products/'.$wishlistItem->product->slug.'/'.$attributes_value)}}">
                                                            <!-- Check if product has images -->
                                                            @if($wishlistItem->product->images->isNotEmpty())
                                                            
                                                            <img 
                                                            
                                                            src="{{ asset('images/product/thumb/'.$wishlistItem->product->images->first()->image_path) }}"
                                                             class="img-fluid blur-up lazyloaded" alt="{{ $wishlistItem->product->title }}">
                                                            @else
                                                            <img src="{{asset('frontend/assets/gd-img/product/no-image.png')}}" class="img-fluid blur-up lazyloaded" alt="Default Image">
                                                            @endif
                                                        </a>

                                                        <div class="product-header-top">
                                                            <!-- Wishlist button to remove product from wishlist -->
                                                            <button class="btn wishlist-button wishlist_remove close_button" data-wishlist-id="{{ $wishlistItem->id }}"
                                                            data-url="{{ route('wishlist.remove') }}"
                                                            >
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <a href="{{ url('products/'.$wishlistItem->product->slug.'/'.$attributes_value)}}">
                                                            <h5 class="name">
                                                                {{ ucwords(strtolower($wishlistItem->product->title)) }}
                                                            </h5>
                                                        </a>
                                                        @if($wishlistItem->product->inventories->isNotEmpty())
                                                        @php
                                                        $inventory = $wishlistItem->product->inventories->first();
                                                        @endphp
                                                        <h5 class="price">
                                                            <span class="theme-color">
                                                                Rs. {{ $inventory->mrp  }}
                                                            </span>
                                                            <del>
                                                                Rs. {{ $inventory->offer_rate }}
                                                            </del>
                                                        </h5>
                                                        @else
                                                        <h5 class="price">
                                                            <span class="theme-color">Price not available</span>
                                                        </h5>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    
                                    @else
                                    <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12">
                                        <p>Your wishlist is empty.</p>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- User Dashboard Section End -->
@endsection
@push('scripts')

<script type="text/javascript" src="{{asset('frontend/assets/js/pages/customer.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/assets/js/pages/addwishlist.js')}}"></script>
@endpush