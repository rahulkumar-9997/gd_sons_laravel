
<meta charset="utf-8" />
@yield('meta')
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Gd Sons Admin Login" />
<meta name="author" content="Techzaa" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<script> window.Laravel = { csrfToken: 'csrf_token() ' } </script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="base-url" content="{{URL::to('/')}}">
<link rel="shortcut icon" href="{{asset('backend/assets/fav-icon.png')}}">
<link href="{{asset('backend/assets/css/vendor.min.css')}}?v={{ env('ASSET_VERSION', '1.0.0') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('backend/assets/css/app.min.css')}}?v={{ env('ASSET_VERSION', '1.0.0') }}" rel="stylesheet" type="text/css" />
<script src="{{asset('backend/assets/js/config.js')}}?v={{ env('ASSET_VERSION', '1.0.0') }}"></script>
 