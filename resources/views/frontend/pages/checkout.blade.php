@extends('frontend.layouts.master')
@section('title','GD Sons - Checkout')
@section('description', 'GD Sons - Checkout')
@section('keywords', 'GD Sons - Checkout')

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
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Checkout section Start -->
<section class="checkout-section-2 section-b-space">
    <div class="container-fluid-lg">
        <div class="checkout-form-container">
            @include('frontend.pages.partials.ajax-checkout-form', ['customer_address' => $customer_address])
        </div>
    </div>
</section>
<!-- Checkout section End -->
<!---ADD NEW ADDRESS MODAL -->
<div class="modal fade theme-modal" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="render-data">

            </div>
        </div>
    </div>
</div>
<!-- Add address modal box end -->
@endsection
@push('scripts')
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script> -->
<script src="{{asset('frontend/assets/js/lusqsztk.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/add-new-address.js')}}"></script>
<script src="{{asset('frontend/assets/js/pages/checkout-form-submit.js')}}"></script>
@endpush