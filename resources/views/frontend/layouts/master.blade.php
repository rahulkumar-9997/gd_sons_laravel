<!DOCTYPE html>
<html lang="en">
	<head>
		@include('frontend.layouts.headcss')
		@stack('styles')
	</head>
    <body class="bg-effect">
		<!-- Loader Start -->
		<!-- <div class="fullpage-loader">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div> -->
    	<!-- Loader End -->
		<!-- @include('frontend.layouts.header-top') -->
		@include('frontend.layouts.header-menu')
		
		@yield('main-content')
	
		@include('frontend.layouts.footer')
		@include('frontend.layouts.footerjs')
		@stack('scripts')
	</body>
</html>