@extends('frontend.layouts.master')
@section('title','GD Sons - Account Login')
@section('description', 'GD Sons - Account Login')
@section('keywords', 'GD Sons - Account Login')
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
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="log-in-box">
                    <div class="opt-box hideBox">
                        <!-- @if (Session::has('whatsapp_otp'))
                            <div class="alert alert-info">OTP: {{ Session::get('whatsapp_otp')['otp'] }}</div>
                        @endif -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('wp.verify.otp') }}" method="POST">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ request()->get('redirect_to') }}">
                            <div class="verify-box">
                                <h3 class="login-header">Enter OTP</h3>
                                <p class="login-description">
                                    OTP is sent on your Whatapp No.
                                </p>
                                <div class="verify-content">
                                    <input type="tel" name="otp" class="form-control otp-input" maxlength="6">
                                    @if ($errors->has('otp'))
                                        <div class="text-danger">{{ $errors->first('otp') }}</div>
                                    @endif
                                </div>
                                <button class="btn btn-animation w-100 justify-content-center" id="verify-otp-button">
                                    <span>Verify OTP</span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <!--<div class="resend-otp">
                                    <p class="resend-otp-text">Didn't Receive the OTP?</p>
                                    <a class="resend-btn">Resend OTP</a>
                                    <p class="count-down-otp hideBox">00:00</p>
                                </div>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
   
    
</script>
@endpush