@extends('frontend.layouts.master')
@section('title','GD Sons - Myaccount')
@section('description', 'Myaccount')
@section('keywords', 'Myaccount')
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
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
                            <li class="breadcrumb-item active">My Account</li>
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
                        <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel">
                            <div class="dashboard-home">
                                <div class="title">
                                    <h2>My Dashboard</h2>
                                    <span class="title-leaf">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('images/leaf.svg#leaf')}}"></use>
                                        </svg>
                                    </span>
                                </div>

                                <div class="dashboard-user-name">
                                    <h6 class="text-content">Hello, <b class="text-title">{{ Auth::guard('customer')->user()->name }}</b></h6>
                                    <p class="text-content">From your My Account Dashboard you have the ability to
                                        view a snapshot of your recent account activity and update your account
                                        information. Select a link below to view or edit information.</p>
                                </div>

                                <div class="total-box">
                                    <div class="row g-sm-4 g-3">
                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <a href="{{route('order')}}">
                                                <div class="total-contain">
                                                    <img src="{{asset('images/order.svg')}}"
                                                        class="img-1 blur-up lazyload" alt="">
                                                    <img src="{{asset('images/order.svg')}}" class="blur-up lazyload"
                                                        alt="">
                                                    <div class="total-detail">
                                                        <h5>Total Order</h5>
                                                        <h3>{{$ordercount}}</h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <a href="{{route('wishlist')}}">
                                                <div class="total-contain">
                                                    <img src="{{asset('images/pending.svg')}}"
                                                        class="img-1 blur-up lazyload" alt="">
                                                    <img src="{{asset('images/pending.svg')}}" class="blur-up lazyload"
                                                        alt="">
                                                    <div class="total-detail">
                                                        <h5>Total Cancell Order</h5>
                                                        <h3>0</h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                            <a href="{{route('wishlist')}}">
                                                <div class="total-contain">
                                                    <img src="{{asset('images/wishlist.svg')}}"
                                                        class="img-1 blur-up lazyload" alt="">
                                                    <img src="{{asset('images/wishlist.svg')}}"
                                                        class="blur-up lazyload" alt="">
                                                    <div class="total-detail">
                                                        <h5>Total Wishlist</h5>
                                                        <h3>{{$wishlistcount}}</h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
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
@endpush