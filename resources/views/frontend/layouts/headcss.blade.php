	@yield('meta')
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags(trim($__env->yieldContent('description'))), 160, '') }}">
	<meta name="keywords" content="@yield('keywords')">
	<meta property="og:locale" content="en_IN">
	<meta name="language" content="English">
	@if(View::hasSection('canonical'))
		@yield('canonical')
	@else
		<link rel="canonical" href="{{ strtok(url()->current(), '?') }}" />
	@endif
	@if(View::hasSection('robots'))
		@yield('robots')
	@else
		@if(request()->has('filter') || request()->has('sort') || request()->has('page'))
			<meta name="robots" content="noindex, follow">
		@else
			<meta name="robots" content="index, follow">
		@endif
	@endif
	<meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
	<meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('description')))">
	<meta property="og:image" content="@yield('og_image', asset('frontend/assets/gd-img/default-og-image.jpg'))">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:type" content="@yield('og_type', 'website')">
	<meta property="og:url" content="{{ strtok(url()->current(), '?') }}">
	<meta property="og:site_name" content="Girdhar Das & Sons">	

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="@yield('og_title', trim($__env->yieldContent('title')))">
	<meta name="twitter:description" content="@yield('og_description', trim($__env->yieldContent('description')))">
	<meta name="twitter:image" content="@yield('og_image', asset('frontend/assets/gd-img/default-og-image.jpg'))">

	<meta name="base-url" content="{{ url('/') }}">
	<meta name="author" content="GD Sons">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="product-enquiry-route" content="{{ route('request.product.enquiry.form') }}">

	<link rel="icon" href="{{asset('frontend/assets/gd-img/fav-icon.png')}}" type="image/x-icon">
	<title>@yield('title')</title>
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HVY0ZB7K57"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-HVY0ZB7K57');
		gtag('config', 'AW-16456179231');
	</script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="preconnect" href="https://www.googletagmanager.com">
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,600;1,400&display=swap"rel="stylesheet">
	<link href="{{ mix('css/app.css') }}?v={{ env('ASSET_VERSION', '1.0.0') }}" rel="stylesheet">
	<link rel="preload" href="{{asset('frontend/assets/css/vendors/bootstrap.css')}}" as="style"
		onload="this.onload=null;this.rel='stylesheet'">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/bulk-style.css')}}">
	<link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}?v={{ env('ASSET_VERSION', '1.0.0') }}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/gd-style.css')}}?v={{ env('ASSET_VERSION', '1.0.0') }}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/cart-drawer.css')}}?v={{ env('ASSET_VERSION', '1.0.0') }}">

	@if (!isset($_SERVER['HTTP_USER_AGENT']) || !preg_match('/(android|iphone|ipod|mobile)/i',
	strtolower($_SERVER['HTTP_USER_AGENT'])))
	<style>
		.desktop-menu-st {opacity: 0;visibility: hidden;transition: transform .3s ease-in-out, opacity .3s }header .header-nav .header-nav-left .category-dropdown.desktop-menu-st.show, header .onhover-category-list .onhover-category-box.show {opacity: 1;visibility: visible }.desktop-menu-st::-webkit-scrollbar, .onhover-category-box::-webkit-scrollbar {width: 6px }.desktop-menu-st::-webkit-scrollbar-thumb, .onhover-category-box::-webkit-scrollbar-thumb {background-color: rgba(0, 0, 0, .2);border-radius: 3px }header .header-nav .header-nav-left .category-dropdown.desktop-menu-st {position: fixed;left: 0;top: 0;width: 350px;height: 100vh;background: #fff;box-shadow: 2px 2px 6px rgba(0, 0, 0, .17), 4px 4px 10px rgba(0, 0, 0, .1);z-index: 1050;overflow-y: scroll;overflow-x: hidden;border-radius: unset;opacity: 0 }.onhover-category-box {opacity: 0;visibility: hidden;transition: opacity .3s, transform .3s }header .onhover-category-list .onhover-category-box {position: fixed;left: 333px;top: 0;width: 600px;max-width: calc(100vw - 350px);height: 100vh;background: #fff;box-shadow: 2px 2px 6px rgba(0, 0, 0, .17), 4px 4px 10px rgba(0, 0, 0, .1);padding: 20px;overflow-y: auto }.trust-inner.py-2 {padding: 0px !important;}.f-category-area .nav-link, .f-customer-services .nav-link, .useful-link .nav-link {padding: .2rem 0.5rem;}.f-category-area ul li, .f-customer-services ul li {display: block;}
	</style>
	@endif