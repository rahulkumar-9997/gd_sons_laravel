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
<script src="{{asset('frontend/assets/js/pages/update-cart.js')}}"></script>
@endpush