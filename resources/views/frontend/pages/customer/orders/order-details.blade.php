@extends('frontend.layouts.master')
@section('title','Order Details - GD Sons')
@section('description', 'Order Details - GD Sons')
@section('keywords', 'Order Details - GD Sons')
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
                            <li class="breadcrumb-item active">Order Details</li>
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
                                    <h2>My Orders Details</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <!-- <svg class="icon-width bg-gray">
                                            <use xlink:href="{{asset('images/leaf.svg#leaf')}}"></use>
                                        </svg> -->
                                    </span>
                                </div>
                                @if($order && $order->orderLines->isNotEmpty())
                                <div class="order-contain">
                                    <div class="order-box dashboard-bg-box">
                                        <div class="order-container">
                                            <div class="order-icon">
                                                <i data-feather="box"></i>
                                            </div>

                                            <div class="order-detail">
                                                <h4>Order Status: <span>{{ $order->orderStatus->status_name ?? 'Pending' }}</span>
                                                <span class="success-bg">
                                                    {{ $order->order_id }}
                                                </span>
                                            </h4>
                                                <h6 class="text-content">{{ $order->orderStatus->description ?? 'No additional details available.' }}</h6>
                                                
                                            </div>
                                        </div>

                                        @foreach($order->orderLines as $orderLine)
                                            @php
                                                $attributes_value ='na';
                                                    if($orderLine->product->ProductAttributesValues->isNotEmpty()){
                                                    $attributes_value = $orderLine->product->ProductAttributesValues->first()->attributeValue->slug;
                                                }
                                            @endphp
                                        <div class="product-order-detail">
                                            <a href="{{ url('products/'.$orderLine->product->slug.'/'. $attributes_value) }}" class="order-image">
                                                <div class="order-details-img">
                                                    @if($orderLine->product->images->first())
                                                    <img src="{{ asset('images/product/thumb/' . $orderLine->product->images->first()->image_path) }}"
                                                        class="blur-up lazyload" alt="{{ $orderLine->product->title }}">
                                                    @else
                                                    <img src="{{ asset('images/default.png') }}" class="blur-up lazyload" alt="Default Image">
                                                    @endif
                                                </div>
                                            </a>

                                            <div class="order-wrap">
                                                <a href="{{ url('products/'.$orderLine->product->slug.'/'. $attributes_value) }}">
                                                    <h3>{{ ucwords(strtolower($orderLine->product->title)) }}</h3>
                                                </a>
                                                <p class="text-content">{{ Str::words($orderLine->product->description ?? 'No description available.', 20, '...') }}</p>
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
                                                    <li>
                                                        <div class="size-box">
                                                            <h6 class="text-content">Total Price: </h6>
                                                            <h5>Rs. {{ number_format($orderLine->quantity * $orderLine->price, 2) }}</h5>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                                <div class="summery-box address-box">
                                                    <div class="summery-header d-block">
                                                        <h3>Shipping Address</h3>
                                                    </div>

                                                    <ul class="summery-contain pb-0 border-bottom-0">
                                                        <li class="d-block">
                                                            <h4>
                                                            {{ $order->shippingAddress->full_name }}
                                                            </h4>
                                                            <h4 class="mt-2">
                                                            {{ $order->shippingAddress->phone_number }}
                                                            </h4>
                                                            <h4 class="mt-2">{{ $order->shippingAddress->full_address }}</h4>
                                                            @if($order->shippingAddress->apartment )
                                                                <h4 class="mt-2">{{ $order->shippingAddress->apartment }}</h4>
                                                            @endif
                                                            <h4 class="mt-2">{{ $order->shippingAddress->city_name }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->pin_code }}</h4>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>

                                                
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                @if($order->billingAddress)
                                                    <div class="summery-box address-box">
                                                        <div class="summery-header d-block">
                                                            <h3>Billing Address</h3>
                                                        </div>

                                                        <ul class="summery-contain pb-0 border-bottom-0">
                                                            <li class="d-block">
                                                            <h4>
                                                            {{ $order->billingAddress->full_name }}
                                                            </h4>
                                                            <h4 class="mt-2">
                                                            {{ $order->billingAddress->phone_number }}
                                                            </h4>
                                                                <h4 class="mt-2">{{ $order->billingAddress->full_address }}</h4>
                                                                @if($order->billingAddress->apartment)
                                                                    <h4 class="mt-2">{{ $order->billingAddress->full_address }}</h4>
                                                                @endif
                                                                <h4 class="mt-2">{{ $order->billingAddress->city_name }}, {{ $order->billingAddress->state }} {{ $order->billingAddress->pin_code }}</h4>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="order-totals-container">
                                                    <table class="table">
                                                        @if($order->shiprocketCourier)
                                                        <tr>
                                                            <th>
                                                                <span>Delivery Charges:</span>
                                                            </th>
                                                            <td>
                                                                <span>Rs. {{ $order->shiprocketCourier->courier_shipping_rate }}</span>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <tr class="OrderTotals-total">
                                                            <th>
                                                                <span>Total</span>
                                                                :
                                                            </th>
                                                            <td>
                                                                <span class="price-font-order">
                                                                    Rs. 
                                                                    {{ number_format($order->grand_total_amount, 2) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @else
                                <div class="order-box dashboard-bg-box">
                                    <h4>No Orders Found</h4>
                                    <p class="text-content">This order has no items.</p>
                                </div>
                                @endif




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