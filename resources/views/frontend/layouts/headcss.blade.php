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
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HVY0ZB7K57"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-HVY0ZB7K57');
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16456179231">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

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
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/gd-style.css')}}">
<!-- <script>
    if (!window.location.search.includes('pt=')) {
        const title = encodeURIComponent(document.title);
        const separator = window.location.search ? '&' : '?';
        const newUrl = window.location.href + separator + 'pt=' + title;
        window.history.replaceState({}, '', newUrl);
        window.location.href = newUrl;
    }
</script> -->