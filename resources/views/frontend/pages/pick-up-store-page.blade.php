@extends('frontend.layouts.master')
@section('title','GD Sons - Your Shopping Cart')
@section('description', 'GD Sons - Your Shopping Cart')
@section('keywords', 'GD Sons - Your Shopping Cart')

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
                            <li class="breadcrumb-item active">Pick Up Store</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Cart Section Start -->
<section class="checkout-section-2 section-b-space">
    <div class="container-fluid-lg">
        <form action="{{route('checkout.submit')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="checkoutFormSubmit">
            @csrf
            <input type="hidden" name="pick_up_status" value="pick_up_store">
            <div class="row g-sm-5 g-3">
                <div class="col-xxl-7 col-lg-7 col-md-7">
                    <div class="left-sidebar-checkout">
                        <div class="checkout-detail-box">
                            <ul>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json" trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a" class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Payment Option</h4>
                                        </div>
                                        <div class="payment-option-msg">
                                            <p>
                                                You can Book this Order by your Name by making a Payment to any of the UPI options provided below.
                                            </p>
                                            <p>
                                                Once you make the payment, we will verify the same and notify it to you.
                                            </p>
                                        </div>
                                        <div class="checkout-detail">
                                            <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingOne">
                                                        <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="gpay">
                                                                    <input class="form-check-input mt-0" type="radio" name="payment_type" id="gpay" value="Pay to GPay ID of Girdhar Das and Sons">
                                                                    Pay to GPay ID of Girdhar Das and Sons
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="row g-2">
                                                                You will get 'Girdhar Das & Sons' Official GPay ID after clicking on 'Place Order'.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingTwo">
                                                        <div class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="paytm">
                                                                    <input class="form-check-input mt-0" type="radio" name="payment_type" id="paytm" value="Pay to PayTM ID of Girdhar Das and Sons">
                                                                    Pay to PayTM ID of Girdhar Das and Sons
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="row g-2">
                                                            You will get 'Girdhar Das & Sons' Official PayTM ID after clicking on 'Place Order'.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="continue-shopping-btn">
                        <a href="{{ route('checkout') }}" class="cntshop">
                            <i class="fa fa-caret-left"></i>Go to Home Delivery
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="right-side-summery-box">
                        <div class="summery-box-2">
                            <div class="summery-header">
                                <h3>Order Summary</h3>
                            </div>
                            <ul class="summery-contain">
                                @php
                                $subtotal = 0;
                                $totalDiscount = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                @php
                                $mrp = $cart->product->inventories->first() ? $cart->product->inventories->first()->mrp : 0;
                                $final_offer_rate = $cart->product->offer_rate ?? 0;
                                $purchase_rate = $cart->product->purchase_rate ?? 0;
                                $group_categoty_percentage = 1;
                                $offer_rate_display ='';
                                if ($groupCategory) {
                                $group_categoty_percentage = (float) ($groupCategory->groupCategory->group_category_percentage ?? 0);

                                if ($group_categoty_percentage > 0) {
                                    $offer_rate = $cart->product->offer_rate ?? 0;
                                    $percent_discount = 100 / $group_categoty_percentage;
                                    $final_offer_rate = $purchase_rate + ($offer_rate - $purchase_rate) * $percent_discount / 100;
                                    $final_offer_rate = floor($final_offer_rate);
                                    $offer_rate_display = '<p><span>Regular offer price</span><del class="text-content"> Rs. ' . number_format($offer_rate, 2) . '</del></p>';
                                } else {
                                $group_categoty_percentage = 1;
                                }
                                }

                                $original_price = $final_offer_rate;
                                $profit_a = $final_offer_rate - $purchase_rate;
                                $additional_offer = $profit_a * (10 - $group_categoty_percentage) / 100;
                                $final_offer_rate = max(0, $final_offer_rate - $additional_offer);

                                $discount_amount = ($original_price - $final_offer_rate) * $cart->quantity;
                                $totalDiscount += $discount_amount;
                                $totalPrice = $original_price * $cart->quantity;
                                $subtotal += $totalPrice;
                                @endphp

                                <input type="hidden" name="product_id[]" value="{{ $cart->product->id }}">
                                <input type="hidden" name="cart_quantity[]" value="{{ $cart->quantity }}">
                                <input type="hidden" name="cart_offer_rate[]" value="{{ $final_offer_rate }}">
                                <input type="hidden" name="total_price[]" value="{{ $totalPrice-$discount_amount }}">

                                <li>
                                    @if ($cart->product->images->first())
                                    <img src="{{ asset('images/product/thumb/' . $cart->product->images->first()->image_path) }}"
                                        class="img-fluid blur-up lazyloaded checkout-image"
                                        alt="{{ $cart->product->name }}" loading="lazy">
                                    @else
                                    <img src="{{ asset('images/default.png') }}"
                                        class="img-fluid blur-up lazyloaded checkout-image"
                                        alt="Default Image" loading="lazy">
                                    @endif
                                    <table class="pickupTable">
                                        <tr>
                                            <td>
                                                {{ ucwords(strtolower($cart->product->title)) }}
                                            </td>
                                            <td class="lsttd"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                    <strong>M.R.P.</strong> <del>Rs. {{ number_format($mrp, 2) }}</del>
                                                </p>
                                            </td>
                                            <td class="lsttd"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                Rs. {{ number_format($original_price, 2) }} x {{ $cart->quantity }}  
                                                </p>
                                            </td>
                                            <td class="lsttd">
                                                <del>
                                                    Rs. {{ number_format((($original_price*$cart->quantity)), 2) }}
                                                </del>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p><span class="text-danger">Additional Offer</span> Rs. {{ $discount_amount }}</p>
                                            </td>
                                            <td  class="lsttd">
                                                <p>
                                                Rs. {{ number_format((($original_price*$cart->quantity)-$discount_amount), 2) }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                        
                                        <!-- <p>
                                            <span>
                                                <del>
                                                    Rs. {{ number_format($original_price, 2) }} 
                                                </del>
                                            </span>
                                        </p> -->
                                        <!-- <p>
                                            Rs. {{ $final_offer_rate }} x {{ $cart->quantity }}
                                        </p>
                                        {!! $offer_rate_display !!}
                                        
                                        <p><span class="text-danger">Additional Offer</span> Rs. {{ $discount_amount }}</p> -->
                                    <!-- <h4 class="price">
                                        <p>
                                        Rs. {{ number_format((($original_price*$cart->quantity)-$discount_amount), 2) }}
                                        </p>
                                        <p>
                                        Rs. {{ number_format((($original_price*$cart->quantity)-$discount_amount), 2) }}
                                        </p>
                                    </h4> -->
                                </li>
                                @endforeach
                            </ul>

                            <ul class="summery-total">
                                <li>
                                    <h4>Subtotal</h4>
                                    <h4 class="price">Rs. {{ number_format($subtotal, 2) }}</h4>
                                </li>

                                <li>
                                    <h4>Discount</h4>
                                    <h4 class="price">Rs. {{ number_format($totalDiscount, 2) }}</h4>
                                </li>

                                <li class="list-total">
                                    <h4>Total (Rs.)</h4>
                                    <h4 class="price">
                                        Rs.
                                        @php $total = $subtotal; @endphp
                                        {{ number_format(($total-$totalDiscount), 2) }}
                                        <input type="hidden" name="grand_total_amount" value="{{ $total }}">
                                    </h4>
                                </li>
                            </ul>

                        </div>
                        <button type="submit" class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Cart Section End -->
@endsection
@push('scripts')
<script src="{{asset('frontend/assets/js/lusqsztk.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/checkout-form-submit.js')}}"></script>
@endpush