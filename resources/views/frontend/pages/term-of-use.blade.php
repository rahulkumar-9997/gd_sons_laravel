@extends('frontend.layouts.master')
@section('title','Gd Sons - Terms Of Use')
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
                            <h1 class="mb-2">Terms & Conditions</h1>
                            <p class="text-muted"><strong>Effective Date:</strong> 17/04/2025</p>
                        </div>

                        <p class="highlight">
                            By accessing or using <a href="https://www.gdsons.co.in/" target="_blank">gdsons.co.in</a>, you agree to be bound by these Terms & Conditions. Please read them carefully before placing any order with <strong>Girdhar Das & Sons</strong>.
                        </p>

                        <div class="main-privacy">
                            <div class="mb-3">
                                <h2>1. General</h2>
                                <ul class="custom-list">
                                    <li>This website is operated by Girdhar Das & Sons, Varanasi, Uttar Pradesh.</li>
                                    <li>We reserve the right to update or modify these terms at any time without notice.</li>
                                    <li>Continued use of the website implies acceptance of the updated terms.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>2. Products and Pricing</h2>
                                <ul class="custom-list">
                                    <li>All products are subject to availability.</li>
                                    <li>Descriptions and images aim to be accurate but may vary slightly.</li>
                                    <li>Prices are in INR and include applicable taxes unless specified.</li>
                                    <li>We may change prices or discontinue items without prior notice.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>3. Orders and Payment</h2>
                                <ul class="custom-list">
                                    <li>Orders can be placed securely online.</li>
                                    <li>Accepted payment methods: UPI, credit/debit cards, net banking, wallets.</li>
                                    <li>Full payment is required at the time of purchase.</li>
                                    <li>An order confirmation email will be sent upon successful placement.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>4. Shipping and Delivery</h2>
                                <ul class="custom-list">
                                    <li>Delivery is limited to a 100 km radius of Varanasi, Uttar Pradesh.</li>
                                    <li>Orders from outside the delivery zone will be cancelled and refunded if paid.</li>
                                    <li>Delivery is via local partners or our in-house team.</li>
                                    <li>Estimated delivery: 3 to 7 business days within the service area.</li>
                                    <li>Shipping charges, if applicable, are displayed at checkout.</li>
                                    <li>Delivery timelines may vary due to external factors.</li>
                                </ul>
                            </div>
                            <div class="return-cancell" id="returns-and-cancellations">
                                <div class="mb-3">
                                    <h2>5. Returns and Cancellations</h2>
                                    <ul class="custom-list">
                                        <li>Returns accepted within 7 days for eligible customers within 100 km of Varanasi.</li>
                                        <li>Only damaged, defective, or incorrect items qualify for return.</li>
                                        <li>Items must be unused, in original packaging, and include all accessories.</li>
                                        <li>To return, contact us with your order number, item photos, and issue description.</li>
                                        <li>No returns for orders beyond 7 days or outside the 100 km radius.</li>
                                        <li>Cancellations allowed only before shipping.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="return-cancell" id="returns-and-cancellations">
                                <div class="mb-3">
                                    <h2>6. Refund Timelines</h2>
                                    <ul class="custom-list">
                                        <li>Refund for Cancelled Orders: If your order is cancelled, the refund will be processed within 24-48 hours of cancellation confirmation.</li>
                                        <li>Refund for Returned Orders: For returned items, the refund will be initiated within 24-48 hours after the product is received at our warehouse and approved upon inspection.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h2>7. Warranty and Liability</h2>
                                <ul class="custom-list">
                                    <li>Some items may include manufacturer warranties (details on product page).</li>
                                    <li>We are not responsible for issues due to misuse or improper installation.</li>
                                    <li>We are not liable for delays or damages from third-party delivery services.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>8. User Responsibilities</h2>
                                <ul class="custom-list">
                                    <li>Provide accurate personal and payment details.</li>
                                    <li>Do not engage in fraudulent or illegal website use.</li>
                                    <li>Respect intellectual property owned or licensed by Girdhar Das & Sons.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>9. Privacy Policy</h2>
                                <p>Your use of the website is also governed by our <a href="{{ route('privacy-policy') }}">Privacy Policy</a>.</p>
                            </div>

                            <div class="mb-3">
                                <h2>10. Governing Law</h2>
                                <p>These Terms & Conditions are governed by Indian law with jurisdiction in Varanasi, Uttar Pradesh.</p>
                            </div>

                            <div class="mb-3">
                                <h2>11. Contact Us</h2>
                                <address class="p-address">
                                    <h3 class="mb-2">Girdhar Das & Sons</h3>
                                    <h4 class="mb-2">W.H.Smith School Road, Sigra, Varanasi, Uttar Pradesh, India</h4>
                                    <p><strong>Email:</strong> <a href="mailto:akshat.gd@gmail.com">akshat.gd@gmail.com</a></p>
                                    <p><strong>Phone:</strong> <a href="tel:+918318894257">+91 83188 94257</a></p>
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
<script>
    $(window).on('load', function () {
        const hash = window.location.hash;
        if (hash) {
            const $target = $(hash);
            if ($target.length) {
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 100
                    }, 600);
                }, 200);
            }
        }
    });
</script>
@endpush