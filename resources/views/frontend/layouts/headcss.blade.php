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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HVY0ZB7K57');
  gtag('config', 'AW-16456179231');

</script>
<link href="https://fonts.googleapis.com/css2?family=Russo+One|Pacifico|Kaushan+Script|Exo+2|Public+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">
<link id="rtl-link" rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/bootstrap.css')}}">
<!-- <link rel="stylesheet" href="{{asset('frontend/assets/css/all.min.css')}}"> -->
<link rel="stylesheet" href="{{asset('frontend/assets/css/animate.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/bulk-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/style.css')}}?v={{ time() }}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/gd-style.css')}}?v={{ time() }}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/cart-drawer.css')}}">
@if (!isset($_SERVER['HTTP_USER_AGENT']) || !preg_match('/(android|iphone|ipod|mobile)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
  <style>
    .desktop-menu-st {
      /* transform: translateX(-100%); */
      opacity: 0;
      visibility: hidden;
      transition: transform 0.3s ease-in-out, opacity 0.3s ease;
  }

  /* Sidebar when shown */
  header .header-nav .header-nav-left .category-dropdown.desktop-menu-st.show {
      /* transform: translateX(0); */
      opacity: 1;
      visibility: visible;
  }

  /* Sidebar container styling */
  header .header-nav .header-nav-left .category-dropdown.desktop-menu-st {
      position: fixed;
      left: 0;
      top: 0;
      width: 350px;
      height: 100vh;
      background: white;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      z-index: 1050;
      overflow-y: scroll;
      overflow-x: hidden;
      border-radius: unset;
      opacity: 0;
  }

  /* Submenu base styles */
  .onhover-category-box {
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
  }

  /* Submenu when shown */
  header .onhover-category-list .onhover-category-box.show {
      opacity: 1;
      visibility: visible;
  }

  /* Submenu position and layout */
  header .onhover-category-list .onhover-category-box {
      position: fixed;
      left: 333px;
      top: 0;
      width: 600px;
      max-width: calc(100vw - 350px);
      height: 100vh;
      background: white;
      box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
      padding: 20px;
      overflow-y: auto;
  }
  </style>
@endif
