@extends('frontend.layouts.master')
@section('title','Gd Sons - About Us')
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
                                About Us
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="fresh-vegetable-section section-lg-space">
    <div class="container-fluid-lg">
        <div class="row gx-xl-5 gy-xl-0 g-3">
            <div class="col-xl-6 col-12 d-flex align-items-center">
                <div class="row g-sm-4 g-2">
                    <div class="col-12">
                        <div class="fresh-image-2">
                            <div class="bg-size blur-up lazyloaded">
                                <img src="{{ asset('/frontend/assets/gd-img/about-us.jpg') }}" class="blur-up img-responsive lazyloaded w-100" alt="about us">
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-6">
                        <div class="fresh-image">
                            <div class="bg-size blur-up lazyloaded" style="background-image: url(&quot;../assets/images/inner-page/about-us/2.jpg&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat; display: block;">
                                <img src="../assets/images/inner-page/about-us/2.jpg" class="bg-img blur-up lazyloaded" alt="" style="display: none;">
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="col-xl-6 col-12">
                <div class="fresh-contain p-center-left">
                    <div>
                        <div class="review-title">
                            <!-- <h4>About Us</h4> -->
                            <h2>Girdhar DAS & Sons in Sigra Road, Varanasi</h2>
                        </div>

                        <div class="delivery-list">
                            <p class="text-content">
                            Established in the year 1939, Girdhar DAS & Sons in Sigra Road, Varanasi is a top player in the category Home Appliance Dealers-Milton in the Varanasi. This well-known establishment acts as a one-stop destination servicing customers both local and from other parts of Varanasi. Over the course of its journey, this business has established a firm foothold in it’s industry. The belief that customer satisfaction is as important as their products and services, have helped this establishment garner a vast base of customers, which continues to grow by the day. This business employs individuals that are dedicated towards their respective roles and put in a lot of effort to achieve the common vision and larger goals of the company. In the near future, this business aims to expand its line of products and services and cater to a larger client base. In Varanasi, this establishment occupies a prominent location in Sigra Road. It is an effortless task in commuting to this establishment as there are various modes of transport readily available. It is at W.h.smith School Rd, Near Sigra Petrol Pump, which makes it easy for first-time visitors in locating this establishment. It is known to provide top service in the following categories: Modular Kitchen Dealers, Home Appliance Dealers, Steel Dealers, Utensil Dealers, Electric Chimney Dealers, Crockery Dealers, Kitchen Appliance Dealers, Water Bottle Dealers-Milton.
                            </p>

                            
                        </div>
                    </div>
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
  "name": "Gd Sons - About Us",
  "description": "Learn about Girdhar Das & Sons, established in 1939 as Varanasi's premier home appliance and kitchenware dealer located in Sigra Road.",
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
        "name": "About Us",
        "item": "{{ url()->current() }}"
      }
    ]
  },
  "mainEntity": {
    "@type": "LocalBusiness",
    "name": "Girdhar Das & Sons",
    "image": "{{ asset('/frontend/assets/gd-img/about-us.jpg') }}",
    "description": "Established in 1939, Girdhar Das & Sons is Varanasi's premier home appliance and kitchenware dealer located in Sigra Road.",
    "foundingDate": "1939",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "W.H.Smith School Rd, Near Sigra Petrol Pump",
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
    "telephone": "+919935070000",
    "sameAs": [
      "https://www.instagram.com/gdsons.vns/",
      "https://www.youtube.com/@GirdharDasandSons",
      "https://www.facebook.com/gdandsons"
    ]
  }
}
</script>  
@endpush
@push('scripts')

@endpush