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
                            <li class="breadcrumb-item active">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container-fluid-lg">
        @if (isset($carts) && $carts->isNotEmpty())
            <div class="row g-sm-5 g-3 cart-items-container">
                @include('frontend.pages.partials.ajax-cart', ['carts' => $carts, 'specialOffers' => $specialOffers])
            </div>
        @endif
    </div>
</section>
<!-- Cart Section End -->
@endsection
@push('scripts')
<script src="https://checkout.razorpay.com/v1/magic-checkout.js"></script>
<script src="{{asset('frontend/assets/js/pages/update-cart.js')}}"></script>
<script>
        document.getElementById('rzp-button1').onclick = function(e) {
            fetch('/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: 1000 // Your amount in rupees
                })
            })
            .then(response => response.json())
            .then(order => {
                var options = {
                    "key": "{{ config('services.razorpay.key') }}",
                    "order_id": order.id,
                    "amount": order.amount,
                    "currency": order.currency,
                    "name": "GD Sons",
                    "description": "Test Transaction",
                    "image": "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
                    "handler": function (response) {
                        // Handle success
                        window.location.href = '/payment-success?' + 
                            'razorpay_payment_id=' + response.razorpay_payment_id + 
                            '&razorpay_order_id=' + response.razorpay_order_id + 
                            '&razorpay_signature=' + response.razorpay_signature;
                    },
                    "prefill": {
                        "name": "Customer Name",
                        "email": "customer@example.com",
                        "contact": "9999999999"
                    },
                    "notes": {
                        "address": "Customer Address"
                    },
                    "theme": {
                        "color": "#f8471d"
                    }
                };
                
                var rzp = new Razorpay(options);
                rzp.open();
                e.preventDefault();
            });
        }
    </script>
@endpush