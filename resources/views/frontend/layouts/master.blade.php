<!DOCTYPE html>
<html lang="en">
	<head>
		@include('frontend.layouts.headcss')
		@stack('styles')
	</head>
    <body class="bg-effect">
		@if (!Auth::guard('customer')->check())
			@include('frontend.pages.partials.Remove-push-notification-popup')
		@endif
		@include('frontend.layouts.header-menu')
		
		@yield('main-content')
	
		@include('frontend.layouts.footer')
		<!-- @include('frontend.pages.partials.cart-drawer') -->
		@include('frontend.layouts.footerjs')
		@stack('scripts')
	</body>
</html>