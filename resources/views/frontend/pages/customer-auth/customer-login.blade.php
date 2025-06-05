@extends('frontend.layouts.master')
@section('title','Login to Girdhar Das & Sons Account | Best Kitchenware Store in Varanasi')
@section('description', 'Access your account at Girdhar Das & Sons to track orders, manage your kitchenware wishlist, and enjoy exclusive offers. Secure login for a seamless shopping experience.')
@push('styles')
<style>
    .verify-box {
        /* background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px; */
        text-align: center;
    }

    .login-header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .login-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }

    .mn-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .user-details {
        font-size: 16px;
        color: #333;
        margin-right: 10px;
        margin-bottom: 0px;
    }

    .edit-phone {
        cursor: pointer;
        fill: #333;
    }

    .verify-content {
        margin-bottom: 20px;
    }

    .otp-input {
        width: 100%;
        font-size: 18px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 10px;
        outline: none;
        background-color: #fff;
    }

    .otp-input:focus {
        border-color: #ab4a25;
        box-shadow: 0 0 5px rgba(171, 74, 37, 0.5);
    }

    .verify-btn {
        background: rgb(171, 74, 37);
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        transition: background 0.3s;
    }

    .verify-btn:hover {
        background: #8e3b20;
    }

    .resend-otp {
        margin-top: 15px;
    }

    .resend-otp-text {
        font-size: 14px;
        color: #666;
    }

    .resend-btn {
        color: #ab4a25;
        cursor: pointer;
        font-size: 14px;
        text-decoration: underline;
        margin-left: 5px;
    }

    .count-down-otp {
        font-size: 14px;
        color: #666;
        margin-top: 10px;
    }

    /* Hide elements with the hideBox class */
    .hideBox {
        display: none;
    }
</style>
@endpush
@section('main-content')
<!-- <section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Log In</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="log-in-section background-image-2 section-b-space gd-shadow-top">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-lg-12">
                <div class="h1-heading">
                    <h1>
                        Log in to Your Girdhar Das & Sons Account
                    </h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mt-3">
                <div class="log-in-box">
                    <div class="login-box">
                        <div class="log-in-title">
                            <h3>Login/Sign up</h3>
                            <!-- <h4>Enter your login details</h4> -->
                        </div>

                        <div class="input-box">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" id="emailOrWhatssappNo" placeholder="Email Id Or Whatts app Number">
                                        <label for="email">Email Id Or whatsapp Number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-animation request-otp w-100 justify-content-center" type="submit" id="request-otp-button">
                                        <span>Request OTP</span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="other-log-in">
                            <h6>or</h6>
                        </div>
                        <div class="log-in-button">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="btn google-button w-100" id="google-login-button">
                                        <img src="{{asset('frontend/assets/gd-img/google.png')}}" class="blur-up lazyload"
                                            alt=""> Log In with Google
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="opt-box hideBox">
                        <div class="verify-box">
                            <h3 class="login-header">Enter OTP</h3>
                            <p class="login-description">
                                The OTP is sent on <span>Email id</span>
                            </p>
                            <div class="mn-container">
                                <p class="user-details"></p>
                                <svg class="edit-phone" fill="currentColor" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                            </div>
                            <div class="verify-content">
                                <input type="tel" autocomplete="one-time-code" class="form-control otp-input" maxlength="6">
                            </div>
                            <button class="btn btn-animation w-100 justify-content-center" id="verify-otp-button">
                                <span>Verify OTP</span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                            <div class="resend-otp">
                                <p class="resend-otp-text">Didn't Receive the OTP?</p>
                                <a class="resend-btn">Resend OTP</a>
                                <p class="count-down-otp hideBox">00:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="updateaccount hideBox">
                        <div class="log-in-title">
                            <h3>Enter Account Details</h3>
                        </div>

                        <div class="input-box">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                        <label for="name">Enter your name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control" id="update_email" placeholder="Email Id">
                                        <label for="update_email">Email Id</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="phone"
                                            placeholder="Enter Phone number"
                                            maxlength="10"
                                            name="phone"
                                            inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        <label for="phone">Enter Phone number</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-animation request-otp w-100 justify-content-center" type="submit" id="request-update-button">
                                        <span>Update</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mt-3 d-flex align-items-center">
                <div class="login-content product-section-box">
                    <div class="information-box">
                        <ul class="login-ul">
                            <li>
                                Explore great offers
                            </li>
                            <li>
                                Track your kitchenware orders
                            </li>
                            <li>
                                Manage items with ease.
                            </li>
                            <li>
                                For new and Old customers.
                            </li>
                            <li>
                                Secure and hassle-free login experience.
                            </li>
                            <li>
                                Make your shopping smarter and faster.
                            </li>
                        </ul>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    var requestOtpUrl = "{{ route('customer.request.otp') }}";
    var verifyOtpUrl = "{{ route('customer.verify.otp') }}";
    var resendOtpUrl = "{{ route('customer.resend.otp') }}";
    var updateDetailsUrl = "{{ route('customer.update.details') }}";
</script>
<script type="text/javascript" src="{{asset('frontend/assets/js/pages/login.js')}}"></script>
<script>
    $('#google-login-button').on('click', function(e) {
        e.preventDefault();
        var submitButton = $(this);
        submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Verifying...');
        var urlParams = new URLSearchParams(window.location.search);
        var redirectUrl = urlParams.get('redirect') || "{{ url()->previous() }}";
        if (!redirectUrl) {
            redirectUrl = window.location.origin;
        }
        var googleLoginUrl = @json(route('google.login'));
        window.location.href = googleLoginUrl + "?redirect=" + encodeURIComponent(redirectUrl);
    });
</script>
@endpush