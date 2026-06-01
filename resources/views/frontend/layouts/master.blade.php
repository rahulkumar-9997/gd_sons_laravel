<!DOCTYPE html>
<html lang="en">
	<head>
		@include('frontend.layouts.headcss')
		@stack('styles')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": ["Store", "Organization"],
            "name": "Girdhar Das & Sons",
            "alternateName": "GD Sons",
            "url": "https://www.gdsons.co.in",
            "logo": "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            "image": "https://www.gdsons.co.in/public/frontend/assets/gd-img/fav-icon.png",
            "description": "Trusted kitchen store in Varanasi since 1970. Genuine products including pressure cookers, cookware, air fryers, mixer grinders, and kitchenware from top brands.",
            "foundingDate": "1970",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "W.H. Smith School Road, Sigra",
                "addressLocality": "Varanasi",
                "addressRegion": "Uttar Pradesh",
                "postalCode": "221010",
                "addressCountry": "IN"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "25.3176",
                "longitude": "82.9739"
            },
            "telephone": "+919935070000",
            "email": "akshat@gdsons.co.in",
            "priceRange": "₹₹",
            "currenciesAccepted": "INR",
            "paymentAccepted": "Cash, UPI, Credit Card, Debit Card, Net Banking",
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
                "opens": "11:00",
                "closes": "20:30"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Sunday"],
                "opens": "12:00",
                "closes": "16:00"
            }
        ],
            "sameAs": [
                "https://www.facebook.com/gdandsons",
                "https://www.instagram.com/gdsons.vns/",
                "https://www.youtube.com/@GirdharDasandSons"
            ],
            "hasMap": "https://maps.google.com/?q=Girdhar+Das+and+Sons+Sigra+Varanasi",
            "servesCuisine": null,
        "areaServed": [
            {
                "@type": "City",
                "name": "Varanasi",
                "sameAs": "https://en.wikipedia.org/wiki/Varanasi"
            },
            {
                "@type": "State",
                "name": "Uttar Pradesh"
            },
            {
                "@type": "Country",
                "name": "India"
            }
        ]
        }
        </script>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Girdhar Das & Sons",
            "alternateName": "GD Sons",
            "url": "https://www.gdsons.co.in",
            "description": "Trusted kitchen store in Varanasi since 1970. Shop pressure cookers, cookware, air fryers, mixer grinders and kitchenware from top brands online.",
            "inLanguage": "en-IN",
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://www.gdsons.co.in/search?query={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        }
        </script>
	</head>
    <body class="bg-effect">		
		@include('frontend.layouts.header-menu')		
		@yield('main-content')	
		@include('frontend.layouts.footer')
		<!-- @include('frontend.pages.partials.cart-drawer') -->
		@stack('schema')
		@include('frontend.layouts.footerjs')
		@stack('scripts')	
	</body>
</html>