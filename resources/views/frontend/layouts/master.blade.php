<!DOCTYPE html>
<html lang="en">
	<head>
		@include('frontend.layouts.headcss')
		@stack('styles')
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