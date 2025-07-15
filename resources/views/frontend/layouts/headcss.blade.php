@yield('meta')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">
<link rel="canonical" href="{{ url()->current() }}" />
<meta name="base-url" content="{{ url('/') }}">
<meta name="author" content="GD Sons">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{asset('frontend/assets/gd-img/fav-icon.png')}}" type="image/x-icon">
<title>@yield('title')</title>
<!-- Global site tag (gtag.js) - Google Analytics and Ads -->
<!-- Google tag (gtag.js) -->
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
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/bootstrap.css')}}">
<!-- (if use animation than this link uncomment) <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.min.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/bulk-style.css')}}">
<!-- (if use animation than this link uncomment) <link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/animate.css')}}"> -->
<link rel="preload" as="style" href="{{asset('frontend/assets/css/style.css')}}?v={{ time() }}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/style.css')}}?v={{ time() }}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/gd-style.css')}}?v={{ time() }}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/cart-drawer.css')}}">
@if (!isset($_SERVER['HTTP_USER_AGENT']) || !preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
<style>
    .desktop-menu-st{opacity:0;visibility:hidden;transition:transform .3s ease-in-out,opacity .3s}header .header-nav .header-nav-left .category-dropdown.desktop-menu-st.show,header .onhover-category-list .onhover-category-box.show{opacity:1;visibility:visible}.desktop-menu-st::-webkit-scrollbar,.onhover-category-box::-webkit-scrollbar{width:6px}.desktop-menu-st::-webkit-scrollbar-thumb,.onhover-category-box::-webkit-scrollbar-thumb{background-color:rgba(0,0,0,.2);border-radius:3px}header .header-nav .header-nav-left .category-dropdown.desktop-menu-st{position:fixed;left:0;top:0;width:350px;height:100vh;background:#fff;box-shadow:2px 2px 6px rgba(0,0,0,.17),4px 4px 10px rgba(0,0,0,.1);z-index:1050;overflow-y:scroll;overflow-x:hidden;border-radius:unset;opacity:0}.onhover-category-box{opacity:0;visibility:hidden;transition:opacity .3s,transform .3s}header .onhover-category-list .onhover-category-box{position:fixed;left:333px;top:0;width:600px;max-width:calc(100vw - 350px);height:100vh;background:#fff;box-shadow:2px 2px 6px rgba(0,0,0,.17),4px 4px 10px rgba(0,0,0,.1);padding:20px;overflow-y:auto}
</style>
@endif