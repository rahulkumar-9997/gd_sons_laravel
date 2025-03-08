
<meta charset="utf-8" />
@yield('meta')
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="A fully responsive premium admin dashboard template" />
<meta name="author" content="Techzaa" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script> window.Laravel = { csrfToken: 'csrf_token() ' } </script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="base-url" content="{{URL::to('/')}}">

<!-- App favicon -->
<link rel="shortcut icon" href="{{asset('backend/assets/fav-icon.png')}}">

<!-- Vendor css (Require in all Page) -->
<link href="{{asset('backend/assets/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Icons css (Require in all Page) -->
<link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

<!-- App css (Require in all Page) -->
<link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Theme Config js (Require in all Page) -->
<script src="{{asset('backend/assets/js/config.js')}}"></script>
<!-- @yeild('morecss') -->
 