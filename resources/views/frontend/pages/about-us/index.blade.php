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
    <div class="container-fluid-lg max-w-5xl mx-auto">
        <div class="container mx-auto">
            <div class="flex flex-col gap-4 lg:gap-4 xl:gap-4">
                <div class="w-full">
                    <div class="flex flex-col gap-4 sm:gap-6">
                        <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                            <div class="bg-size blur-up lazyloaded">
                                <img src="{{ asset('/frontend/assets/gd-img/about-us.jpg') }}"
                                class="blur-up img-responsive lazyloaded w-full object-cover hover:scale-105 transition-transform duration-700 w-100"
                                alt="about us">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="space-y-6 md:space-y-8">
                        <div>
                            <h1 class="text-[22px] lg:text-[26px] font-bold text-gray-800 leading-tight">
                                Girdhar Das & Sons
                            </h1>
                            <h2 class="text-lg md:text-xl text-teal-600 font-semibold mt-2">
                                Trusted Kitchen Store in Varanasi, Now Serving You Online
                            </h2>
                        </div>
                        <div class="bg-teal-50 rounded-2xl p-4 md:p-3 border-l-4 border-teal-500">
                            <p>
                                Building a kitchen is not just about buying products—it's about choosing things that make your everyday life easier. Today, whether you prefer visiting a store or exploring options online, what matters most is trust, clarity, and the right guidance.
                            </p>
                            <p>
                                At Girdhar Das & Sons, we bring that experience to you both in-store and through our website. Known across Varanasi through strong word of mouth, we have become a name people rely on when it comes to kitchen appliances, cookware, and everyday essentials. 
                            </p>
                            <p>
                                With years of experience and deep understanding of customer needs, we are now making it easier for you to explore and shop from us, no matter where you are. 
                            </p>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 border-l-4 border-teal-500 pl-3 mb-3">
                                    Who We Are ?
                                </h3>
                                <p>
                                    Girdhar Das & Sons is not just a business—it is a part of the everyday lives of many families in Varanasi. Being one of the well-known and long-standing kitchen stores in the city, our journey has been built on trust, relationships, and consistency. 
                                </p>
                                <p>
                                    Over the years, customers have connected with us not just for products, but for the comfort of knowing they are buying from someone who understands their needs. That connection has grown stronger with time, making us a familiar and dependable name in households across the city. 
                                </p>
                                <p>
                                    Today, while we continue to serve customers in-store, we are also expanding our reach through our website, so more people can experience the same trust and reliability. 
                                </p>
                            </div>
                            <div>
                                <h4 class="text-xl md:text-2xl font-bold text-gray-800 border-l-4 border-teal-500 pl-3 mb-3">
                                    What We Do ?
                                </h4>
                                <p>
                                    At Girdhar Das & Sons, we bring together everything you need for a well-functioning kitchen. From modern appliances that make cooking faster to cookware and essentials used every day, our range is designed to cover real, practical needs. 
                                </p>
                                <p>
                                    You will find products like gas stoves, electric cooktops, chimneys, oven toaster grillers, kettles, and toasters that make cooking more efficient. Along with this, we offer cookware such as pressure cookers, non-stick and stainless steel utensils that are suitable for regular Indian cooking. 
                                </p>
                                <p>
                                    Our collection also includes mixer grinders and juicers for easy food preparation, along with storage items like jars, containers, bottles, and tiffins that help keep your kitchen organized. For serving and dining, we offer cups, mugs, dinner sets, and everyday essentials that fit naturally into your daily routine. 
                                </p>
                                <p>
                                    We don’t focus on unnecessary variety—we focus on keeping products that are useful, reliable, and worth buying. 
                                </p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 py-2">
                                <div class="bg-white rounded-xl p-3 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 group hover:border-teal-200 text-center">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-teal-600 transition-colors duration-300 mx-auto">
                                        <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-primary-teal mb-2">Understanding Your Needs</h4>
                                    <p class="text-[18px] text-gray-600">Right suggestions based on your usage, budget, and requirements.</p>
                                </div>

                                <div class="bg-white rounded-xl p-3 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 group hover:border-teal-200 text-center">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-teal-600 transition-colors duration-300 mx-auto">
                                        <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-primary-teal mb-2">Ongoing Support</h4>
                                    <p class="text-[18px] text-gray-600">Support continues even after your purchase.</p>
                                </div>

                                <div class="bg-white rounded-xl p-3 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 group hover:border-teal-200 text-center">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-teal-600 transition-colors duration-300 mx-auto">
                                        <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-primary-teal mb-2">Fair Pricing</h4>
                                    <p class="text-[18px] text-gray-600">Clear, reasonable, and honest pricing</p>
                                </div>

                                <div class="bg-white rounded-xl p-3 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 group hover:border-teal-200 text-center">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-teal-600 transition-colors duration-300 mx-auto">
                                        <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-bold text-primary-teal mb-2">Trust & Reliability</h4>
                                    <p class="text-[18px] text-gray-600">Decades of consistent service and customer trust</p>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-xl md:text-2xl font-bold text-gray-800 border-l-4 border-teal-500 pl-3 mb-3">
                                    Why Customers Prefer Girdhar Das & Sons ?
                                </h5>
                                <p>
                                    Over time, we have noticed that customers return to us not just for products, but for the overall experience. They know they can depend on us for consistency, clarity, and reliability. We focus on doing the basics right—offering useful products, maintaining quality, and ensuring a smooth buying experience. 
                                </p>
                                <p>
                                    Instead of over-promising, we deliver what customers actually expect. This honest approach is what makes us a preferred choice for many households in Varanasi.  
                                </p>
                            </div>
                            <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-4 md:p-4 text-white">
                                <h5 class="text-xl font-bold mb-2 text-white">
                                    Growing Beyond Varanasi, Staying Rooted in Trust 
                                </h5>
                                <p class="text-white">
                                    While our roots are deeply connected to Varanasi, we are gradually reaching more customers through our online presence. The idea is simple—to make our products and trusted service available to people beyond the city, without changing what we stand for. 
                                </p>
                                <p class="text-white">
                                    Even as we grow, our focus remains the same: 
                                </p>
                                <strong class="text-[16px]">
                                    honest advice, reliable products, and long-term customer trust. 
                                </strong>
                            </div>
                            <div class="border-t-2 border-teal-100 pt-4">
                                <h6 class="text-xl md:text-2xl font-bold text-gray-800 border-l-4 border-teal-500 pl-3 mb-3">
                                    Explore Products That Make Everyday Life Easier 
                                </h6>
                                <p class="text-gray-700 font-medium text-lg leading-relaxed">
                                    If you are looking for a place where you can find reliable kitchen appliances, durable cookware, and practical kitchen essentials, Girdhar Das & Sons is here for you. Whether you choose to explore online or visit us in person, you can expect a simple, comfortable, and dependable shopping experience. 
                                </p>
                            </div>                            
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
            "itemListElement": [{
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