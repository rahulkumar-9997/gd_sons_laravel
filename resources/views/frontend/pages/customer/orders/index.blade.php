@extends('frontend.layouts.master')
@section('title','GD Sons - Order')
@section('description', 'GD Sons - Order')
@section('keywords', 'GD Sons - Order')
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
                        <div class="tab-pane fade show active" id="pills-order" role="tabpanel">
                            <div class="dashboard-order">
                                <div class="title">
                                    <h2>My Orders</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        
                                    </span>
                                </div>

                                <div class="order-contain">
                                    @if($order->isNotEmpty())
                                        @foreach($order as $orderItem)
                                        <a href="{{ route('order.details', encrypt($orderItem->id)) }}" style="width: 100%;">
                                            <div class="order-box dashboard-bg-box">
                                                <div class="order-container">
                                                    <div class="order-icon">
                                                        <i data-feather="box"></i>
                                                    </div>

                                                    <div class="order-detail">
                                                        <h4 style="color:#212529">
                                                            Order Status:
                                                            <span>
                                                                {{ $orderItem->orderStatus->status ?? 'Pending' }}
                                                            </span>
                                                            <span class="success-bg">
                                                                {{ $orderItem->order_id }}
                                                            </span>
                                                            @if($orderItem->pick_up_status =='pick_up_store')
                                                                <span class="success-warning">
                                                                    Please Item Pickup Our Shop.
                                                                </span>
                                                            @endif
                                                        </h4>
                                                        
                                                        <h6 class="text-content">
                                                            {{ $orderItem->orderStatus->description ?? 'No additional details available.' }}
                                                        </h6>
                                                        <h5 class="order-date" style="padding: 2px 0 2px 0;">
                                                            {{ $orderItem->created_at->translatedFormat('d F Y') }}
                                                        </h5>
                                                        <p class="text-content" style="margin-bottom: 0px;">
                                                            <strong>Total Items in Order:</strong> {{ $orderItem->orderLines->count() }}
                                                        </p>
                                                    </div>
                                                </div>

                                                @php
                                                $orderLine = $orderItem->orderLines->first();
                                                @endphp

                                                @if($orderLine)
                                                <div class="product-order-detail">
                                                    <div class="order-image">
                                                        <div class="order-details-img">
                                                            @if($orderLine->product->images->first())
                                                            <img src="{{ asset('images/product/thumb/' . $orderLine->product->images->first()->image_path) }}"
                                                                class="blur-up lazyload" alt="{{ $orderLine->product->name }}">
                                                            @else
                                                            <img src="{{ asset('images/default.png') }}"
                                                                class="blur-up lazyload" alt="Default Image">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="order-wrap">
                                                        <div>
                                                            <h3>
                                                                {{ ucwords(strtolower($orderLine->product->title)) }}
                                                            </h3>
                                                        </div>
                                                        <p class="text-content">
                                                            {{ Str::words($orderLine->product->description ?? 'No description available.', 200, '...') }}
                                                        </p>
                                                        <ul class="product-size">
                                                            <li>
                                                                <div class="size-box">
                                                                    <h6 class="text-content">Price: </h6>
                                                                    <h5>Rs. {{ number_format($orderLine->price, 2) }}</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="size-box">
                                                                    <h6 class="text-content">Quantity: </h6>
                                                                    <h5>{{ $orderLine->quantity }}</h5>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </a>
                                        @endforeach
                                    @else
                                    <div class="order-box dashboard-bg-box">
                                        <h4>No Orders Found</h4>
                                        <p class="text-content">You have no orders placed at the moment.</p>
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
@endpush