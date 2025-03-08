<!DOCTYPE html>
<html lang="en">
    <head>
        @include('backend.layouts.head')
        @stack('styles')
    </head>
    <body class="theme-3">
        <div class="wrapper">
            @include('backend.layouts.header')
            @include('backend.layouts.sidebar')
            <div class="page-content">
                @yield('main-content')
                @include('backend.layouts.footer')
            </div>
        </div>
        @include('backend.layouts.footer-js')
        
        @stack('scripts')
        <script src="{{asset('backend/assets/js/common-ajax.js')}}" type="text/javascript"></script>
    </body>
</html>