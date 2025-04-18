@extends('frontend.layouts.master')
@section('title','Gd Sons - Privacy Policy')
@section('description', '')
<!-- @section('keywords', 'Laravel Ecommerce') -->

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

                            <li class="breadcrumb-item active">
                                Privacy Policy
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="privacy-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row justify-content-md-center">
            <div class="col-lg-8">
                <div class="privacy-policy-container">
                    <div class="policy-container">
                        <div class="policy-header">
                            <h1 class="mb-2">Privacy Policy</h1>
                            <p class="text-muted"><strong>Effective Date:</strong> 18/04/2025</p>
                        </div>
                        <p class="highlight">
                            At <strong>Girdhar Das & Sons</strong>, your privacy is important to us. This Privacy Policy explains how we collect, use, share, and protect your personal information when you visit or make a purchase from our website <a href="https://www.gdsons.co.in/" target="_blank">gdsons.co.in</a>.
                        </p>

                        <div class="main-privacy">
                            <div class="mb-3">
                                <h2>Information We Collect</h2>
                                <ul class="custom-list">
                                    <li><strong>Personal Information:</strong> Name, address, phone number, email address, payment information.</li>
                                    <li><strong>Order Information:</strong> Products purchased, payment method, billing and shipping address.</li>
                                    <li><strong>Device Information:</strong> IP address, browser type, time zone, pages visited, cookies.</li>
                                    <li><strong>Communication Information:</strong> Emails, messages, or communication you send to us.</li>
                                </ul>
                            </div>
                            <div class="mb-3">
                                <h2>How We Use Your Information</h2>
                                <ul  class="custom-list">
                                    <li>Process and fulfill your orders.</li>
                                    <li>Communicate with you about your purchase, shipping, and support requests.</li>
                                    <li>Improve our website, services, and product offerings.</li>
                                    <li>Prevent fraudulent transactions and protect against unauthorized activity.</li>
                                    <li>Send updates, offers, and promotions (if you opt in).</li>
                                </ul>
                            </div>
                            <div class="mb-3">
                                <h2>Sharing Your Information</h2>
                                <p>We do not sell or rent your information. We may share it with:</p>
                                <ul class="custom-list">
                                    <li><strong>Service Providers:</strong> For payment processing, shipping, and analytics.</li>
                                    <li><strong>Legal Authorities:</strong> If required by law or regulation.</li>
                                </ul>
                            </div>
                            <div class="mb-3">
                                <h2>Cookies and Tracking</h2>
                                <p>We use cookies to:</p>
                                <ul class="custom-list">
                                    <li>Remember your preferences.</li>
                                    <li>Analyze site traffic and usage.</li>
                                    <li>Provide a better shopping experience.</li>
                                </ul>
                                <p>You can manage cookies through your browser settings.</p>
                            </div>
                            <div class="mb-3">
                                <h2> Your Rights</h2>
                                <p>You have the right to:</p>
                                <ul class="custom-list">
                                    <li>Access or update your personal information.</li>
                                    <li>Request data deletion.</li>
                                    <li>Unsubscribe from promotional emails.</li>
                                </ul>
                                <p>To exercise these rights, contact us at: <a href="mailto:akshat.gd@gmail.com">akshat.gd@gmail.com</a></p>
                            </div>
                            <div class="mb-3">
                                <h2>Data Security</h2>
                                <p>We use secure technologies like SSL and encrypted gateways to protect your data. However, no system is completely immune from risk.</p>
                            </div>
                            <div class="mb-3">
                                <h2>Children’s Privacy</h2>
                                <p>Our services are not intended for individuals under 13. We do not knowingly collect their information.</p>
                            </div>
                            <div class="mb-3">
                                <h2>Changes to Policy</h2>
                                <p>We may update this policy from time to time. Changes will be posted on this page with a revised date.</p>
                            </div>
                            <div class="mb-3">
                                <h2>Contact Us</h2>
                                <address class="p-address">
                                    <h3 class="mb-2">Girdhar Das & Sons</h3>
                                        <h4 class="mb-2">W.H.Smith School Road, Sigra, Varanasi, Uttar Pradesh, India<h4>
                                        <p>
                                            <strong>Email:</strong>
                                            <a href="mailto:akshat.gd@gmail.com">akshat.gd@gmail.com</a>
                                        </p>
                                        <p>
                                            <strong>Phone:</strong>
                                            <a href="tel:+918318894257"> +91 - 83188 94257</a>
                                        </p>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')

@endpush