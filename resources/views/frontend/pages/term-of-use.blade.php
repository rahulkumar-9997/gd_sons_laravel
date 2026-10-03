@extends('frontend.layouts.master')
@section('title','Gd Sons - Terms Of Use')
@section('description', 'Terms & Conditions of Girdhar Das & Sons (gdsons.co.in): orders, free shipping across India, delivery timelines, returns, refunds and cancellations.')
<!-- @section('keywords', 'Laravel Ecommerce') -->

@section('main-content')
<style>
    .privacy-policy-container ul.terms-list,
    .privacy-policy-container ul.terms-list ul {
        list-style: disc outside !important;
        padding-left: 1.6rem !important;
        margin: 0 0 .6rem 0 !important;
    }
    .privacy-policy-container ul.terms-list ul {
        list-style: circle outside !important;
        margin: .4rem 0 .2rem 0 !important;
    }
    .privacy-policy-container ul.terms-list li {
        display: list-item !important;
        position: static !important;
        padding-left: .3rem !important;
        margin-bottom: .4rem !important;
        line-height: 1.65;
    }
    .privacy-policy-container ul.terms-list li::before,
    .privacy-policy-container ul.terms-list li::after {
        content: none !important;
        display: none !important;
    }
    .privacy-policy-container ul.terms-list li::marker {
        color: var(--theme-color, #0da487);
    }
</style>
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
                                Terms & Conditions
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
                            <p class="text-muted"><strong>Effective Date:</strong> 17/04/2025 &nbsp;|&nbsp; <strong>Last Updated:</strong> 03/10/2026</p>
                        </div>

                        <p class="highlight">
                            By accessing or using <a href="https://www.gdsons.co.in/" target="_blank">gdsons.co.in</a>, you agree to be bound by these Terms & Conditions. Please read them carefully before placing any order with <strong>Girdhar Das & Sons</strong>.
                        </p>

                        <div class="main-privacy">
                            <div class="mb-3">
                                <h2>1. General</h2>
                                <ul class="terms-list" >
                                    <li>This website is operated by Girdhar Das & Sons, Varanasi, Uttar Pradesh.</li>
                                    <li>We reserve the right to update or modify these terms at any time without notice.</li>
                                    <li>Continued use of the website implies acceptance of the updated terms.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>2. Products and Pricing</h2>
                                <ul class="terms-list" >
                                    <li>All products are subject to availability.</li>
                                    <li>Descriptions and images aim to be accurate but may vary slightly.</li>
                                    <li>Prices are in INR and include applicable taxes unless specified.</li>
                                    <li>Prices displayed on the website include shipping, as we offer free shipping on all products.</li>
                                    <li>We may change prices or discontinue items without prior notice.</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>3. Orders and Payment</h2>
                                <ul class="terms-list" >
                                    <li>Orders can be placed securely online.</li>
                                    <li>Accepted payment methods: UPI, credit/debit cards, net banking, wallets.</li>
                                    <li>Full payment is required at the time of purchase.</li>
                                    <li>An order confirmation email will be sent upon successful placement.</li>
                                </ul>
                            </div>

                            <div class="mb-3" id="shipping-and-delivery">
                                <h2>4. Shipping & Delivery</h2>
                                <ul class="terms-list" >
                                    <li>We offer <strong>FREE shipping on all products, across India.</strong></li>
                                    <li>No shipping charges are applied at checkout.</li>
                                    <li>Orders are processed within 1–2 business days after confirmation.</li>
                                    <li>We use <strong>Shiprocket and its logistics partners</strong> to ensure reliable and timely delivery across India.</li>
                                </ul>

                                <h3 class="mb-2 mt-3">Estimated Delivery Timelines</h3>
                                <ul class="terms-list" >
                                    <li><strong>Metro Cities:</strong> 2–4 business days</li>
                                    <li><strong>Non-Metro Cities/Towns:</strong> 3–7 business days</li>
                                    <li><strong>Remote Areas:</strong> 5–10 business days</li>
                                    <li>Once shipped, customers will receive a <strong>tracking link via SMS/Email/WhatsApp.</strong></li>
                                </ul>

                                <h3 class="mb-2 mt-3">Important Notes</h3>
                                <ul class="terms-list" >
                                    <li>Delivery timelines may vary due to:
                                        <ul>
                                            <li>Courier delays</li>
                                            <li>Weather conditions</li>
                                            <li>Public holidays</li>
                                        </ul>
                                    </li>
                                    <li>In case of delivery failure due to incorrect address or unavailability, re-shipping charges may apply.</li>
                                </ul>
                            </div>

                            <div class="return-cancell" id="returns-and-cancellations">
                                <div class="mb-3">
                                    <h2>5. Returns & Replacements</h2>

                                    <h3 class="mb-2 mt-3">Return Window</h3>
                                    <ul class="terms-list" >
                                        <li>A return request must be raised through our <a href="#contact-us">Customer Care</a> within <strong>3 days of the order being delivered.</strong></li>
                                        <li>We recommend reporting the issue as early as possible, ideally within 48 hours of delivery, for faster resolution.</li>
                                    </ul>

                                    <h3 class="mb-2 mt-3">Eligibility for Returns</h3>
                                    <p class="mb-2">Returns are accepted <strong>only</strong> in the following cases:</p>
                                    <ul class="terms-list" >
                                        <li>Product damaged in transit</li>
                                        <li>Defective product</li>
                                        <li>Incorrect item delivered</li>
                                    </ul>
                                    <p class="mt-2">Valid <strong>photographs or videos</strong> showing the damage, defect or incorrect item must be provided with the request. Returns for any other reason, including change of mind, are not accepted.</p>

                                    <h3 class="mb-2 mt-3">Return Conditions</h3>
                                    <ul class="terms-list" >
                                        <li>Product must be unused</li>
                                        <li>Product must be packed properly in its <strong>original packaging</strong></li>
                                        <li>All accessories, tags and the invoice must be included</li>
                                    </ul>

                                    <h3 class="mb-2 mt-3">Return Process</h3>
                                    <ul class="terms-list" >
                                        <li>To initiate a return, contact Customer Care with:
                                            <ul>
                                                <li>Order ID</li>
                                                <li>Product photographs/videos</li>
                                                <li>Description of the issue</li>
                                            </ul>
                                        </li>
                                        <li>Our team will verify the request within <strong>24–48 hours.</strong></li>
                                        <li>Once the request is approved, a <strong>pickup request will be generated</strong> for the item.</li>
                                        <li>The item must be properly packed in its original packaging and handed over at the time of pickup.</li>
                                        <li>On receipt, the item is inspected before the refund is processed (see Refund Policy).</li>
                                    </ul>

                                    <h3 class="mb-2 mt-3">Non-Returnable Cases</h3>
                                    <ul class="terms-list" >
                                        <li>Used products</li>
                                        <li>Physical damage not reported within 3 days of delivery</li>
                                        <li>Requests without valid photographs or videos</li>
                                        <li>Missing or improper original packaging, or missing accessories</li>
                                        <li>Products marked as non-returnable (if applicable)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="return-cancell">
                                <div class="mb-3">
                                    <h2>6. Refund Policy</h2>

                                    <h3 class="mb-2 mt-3">Refund for Cancelled Orders</h3>
                                    <ul class="terms-list" >
                                        <li>Orders cancelled before dispatch will be refunded within <strong>24–48 hours.</strong></li>
                                    </ul>

                                    <h3 class="mb-2 mt-3">Refund for Returned Orders</h3>
                                    <ul class="terms-list" >
                                        <li>Refunds are initiated within <strong>2–5 business days</strong> after:
                                            <ul>
                                                <li>The product is received by us</li>
                                                <li>Inspection is completed and approved</li>
                                            </ul>
                                        </li>
                                        <li>A refund will be issued <strong>only if no further damage is found</strong> other than what was reported in the return request.</li>
                                        <li>If additional damage is found during inspection, we reserve the right to reject the refund.</li>
                                    </ul>

                                    <h3 class="mb-2 mt-3">Refund Mode</h3>
                                    <ul class="terms-list" >
                                        <li>Original payment method (UPI, card, net banking, wallet)</li>
                                        <li>For COD orders: refund via <strong>bank transfer or UPI.</strong></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h2>7. Order Cancellation</h2>
                                <ul class="terms-list" >
                                    <li>Orders can be cancelled <strong>before dispatch only.</strong></li>
                                    <li>Once shipped, orders cannot be cancelled (return policy applies).</li>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h2>8. Additional Information</h2>
                                <ul class="terms-list" >
                                    <li>Customers must provide accurate shipping details.</li>
                                    <li>We reserve the right to reject returns that do not meet policy conditions.</li>
                                    <li>Policies may be updated without prior notice.</li>
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

                            <div class="mb-3" id="contact-us">
                                <h2>11. Contact Us (Customer Care)</h2>
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