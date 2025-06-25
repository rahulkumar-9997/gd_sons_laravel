@extends('frontend.layouts.master')
@section('title','Contact Us | Girdhar Das & Sons – Best Kitchenware Store in Varanasi')
@section('description', 'Have a question or need assistance? Contact Girdhar Das & Sons, the best retail shop in Varanasi for kitchenware. Call, email, or visit us — we’re here to help!')
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
                                Contact Us
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-box-section">
    <div class="container-fluid-lg">
        <div class="row g-lg-5 g-3">
            <div class="col-lg-6">
                <div class="left-sidebar-box">
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="contact-title">
                                <h3>Get in Touch with Girdhar Das & Sons</h3>
                            </div>

                            <div class="contact-detail">
                                <div class="row g-4">
                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Phone</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>
                                                    <a href="tel:+918318894257">+91 -8318894257</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Email</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>
                                                    <a href="mailto:akshat.gd@gmail.com">akshat.gd@gmail.com</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-12 col-lg-12 col-sm-12">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Address</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>W.H.Smith School Road, Sigra, Varanasi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-lg-12 col-sm-12">
                                        <div class="contact-detail-box1">
                                            <a href="{{route('about-us')}}" class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">
                                                Read more about Girdhar Das and Sons
                                            </a>
                                            
                                        </div>                                          
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14427.266304698423!2d82.988604!3d25.310366!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e2dfedadc2c7f%3A0x39b7ab6d0a627287!2sGirdhar%20Das%20%26%20Sons%20-%20Kitchenware%20%26%20Dinnerware!5e0!3m2!1sen!2sin!4v1681237820627!5m2!1sen!2sin" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contactus-contect">
                    <p>
                        We’re always happy to hear from you! Whether you need help with an order, have a question about our kitchenware products, or want to learn more about our great offers, the Girdhar Das & Sons team is here to assist. Reach out via phone, email, or drop by our Varanasi store — we promise quick and friendly support every time.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="contact-us-form-section contact-box-section">
    <div class="contact-us-form">
        <div class="container-fluid-lg">
            <div class="row g-lg-5 g-3">
                <div class="col-lg-12">
                    <div class="title d-xxl-none d-block">
                        <h2>Contact Us</h2>
                    </div>
                    <form action="{{route('contact-us.submit')}}" class="contact-us" id="contact-us-form">
                        @csrf
                        <div class="right-sidebar-box">
                            <div class="row">
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="name" class="form-label">Name</label>
                                        <div class="custom-input">
                                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="custom-input">
                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="custom-input">
                                            <input type="tel" class="form-control" id="phone" placeholder="Enter Your Phone Number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);" name="phone" id="phone">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="message" class="form-label">Message</label>
                                        <div class="custom-textarea">
                                            <textarea class="form-control" id="message" placeholder="Enter Your Message" rows="3" name="message"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-animation btn-md fw-bold ms-auto" type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Contact Us | Girdhar Das & Sons – Best Kitchenware Store in Varanasi",
  "description": "Have a question or need assistance? Contact Girdhar Das & Sons, the best retail shop in Varanasi for kitchenware. Call, email, or visit us — we're here to help!",
  "url": "{{ url()->current() }}",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{ url('/') }}"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Contact Us",
        "item": "{{ url()->current() }}"
      }
    ]
  },
  "mainEntity": {
    "@type": "LocalBusiness",
    "name": "Girdhar Das & Sons",
    "image": "{{ asset('frontend/assets/gd-img/fav-icon.png') }}",
    "description": "Best Kitchenware Store in Varanasi offering premium quality products at competitive prices.",
    "telephone": "+919935070000",
    "email": "akshat.gd@gmail.com",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "W.H.Smith School Road, Sigra",
      "addressLocality": "Varanasi",
      "addressRegion": "Uttar Pradesh",
      "postalCode": "221010",
      "addressCountry": "IN"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "25.310366",
      "longitude": "82.988604"
    },
    "openingHoursSpecification": {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
      ],
      "opens": "10:00",
      "closes": "20:00"
    },
    "sameAs": [
      "https://www.instagram.com/gdsons.vns/",
      "https://www.youtube.com/@GirdharDasandSons",
      "https://www.facebook.com/gdandsons"
    ],
    "potentialAction": {
      "@type": "ContactPoint",
      "contactType": "customer service",
      "availableLanguage": ["English", "Hindi"],
      "url": "{{ url()->current() }}"
    }
  }
}
</script>
    
@endpush
@push('scripts')
<script>
    $(document).off('submit', '#contact-us-form').on('submit', '#contact-us-form', function (event) {
    event.preventDefault();
    var form = $(this);
    var submitButton = form.find('button[type="submit"]');
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');

    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            submitButton.prop('disabled', false);
            submitButton.html('Send Message');
            if (response.status === 'success') {
                showNotificationAll("success", "", response.message);
                form[0].reset();
            }
        },
        error: function(xhr, status, error) {
            submitButton.prop('disabled', false);
            submitButton.html('Send Message');
            var errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function(key, value) {
                    var errorElement = $('#' + key + '_error');
                    if (errorElement.length) {
                        errorElement.text(value[0]);
                    }
                    var inputField = $('#' + key);
                    inputField.addClass('is-invalid');
                    inputField.after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                });
            }
        }
    });
});

</script>
@endpush