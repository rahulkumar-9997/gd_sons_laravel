<!-- Header Start -->
@php
$query = request()->get('query');
$search_value = !empty($query) ? $query : '';
@endphp
<header class="pb-md-2 pb-0 mobile-header">
   <div class="header-top d-lg-block d-none">
      <div class="container-fluid-lg">
         <div class="row">
            <div class="col-lg-6 col-md-6 d-xxl-block d-sm-none">
               <div class="top-left-header">
                  <!-- <i class="iconly-Location icli text-white"></i> -->
                  <h4 class="text-white">Varanasi's Largest Kitchen Store – Everything for Your Kitchen!</h4>
               </div>
            </div>
            <!-- <div class="col-xxl-4 col-lg-9 d-lg-block d-none">
               <div class="header-offer">
                  <div class="notification-slider">
                     <div>
                        <div class="timer-notification">
                           <h6>
                              <strong class="me-1">Welcome to Girdas & Sons!</strong>Wrap new offers/gift every single day on Weekends. <strong class="ms-1">New Coupon Code: Fast024 </strong>
                           </h6>
                        </div>
                     </div>
                     <div>
                        <div class="timer-notification">
                           <h6>Something you love is now on sale! <a href="" class="text-white">Buy Now !</a>
                           </h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div> -->
            <div class="col-lg-6 col-md-6 d-lg-block d-sm-none">
               <ul class="about-list right-nav-about header-social-links">
                  <li class="light-bg">
                     <a href="https://www.facebook.com/gdandsons" target="_blank" class="footer-link-color" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                     </a>
                  </li>
                  <li class="light-bg">
                     <a href="https://www.youtube.com/@GirdharDasandSons" target="_blank" class="footer-link-color" title="Youtube">
                        <i class="fab fa-youtube"></i>
                     </a>
                  </li>

                  <li class="light-bg">
                     <a href="https://www.instagram.com/gdsons.vns/" target="_blank" class="footer-link-color" title="Instagram">
                        <i class="fab fa-instagram"></i>
                     </a>
                  </li>

               </ul>

            </div>
         </div>
      </div>
   </div>
   <div class="top-nav top-header sticky-header pa-main-header">
      <div class="container-fluid-lg">
         <div class="row">
            <div class="col-12">
               <div class="navbar-top">
                  <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                     <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                     </span>
                  </button>
                  <a href="{{URL::to('')}}" class="web-logo nav-logo gd-logo">
                     <!--<img src="{{asset('frontend/assets/images/logo/1.png')}}" class="img-fluid blur-up lazyload" alt="">-->
                     Girdhar Das <span>& Sons</span>
                  </a>
                  <div class="middle-box">
                     <!--<div class="location-box">
                        <button class="btn location-button" data-bs-toggle="modal" data-bs-target="#locationModal">
                           <span class="location-arrow">
                              <i data-feather="map-pin"></i>
                           </span>
                           <span class="locat-name">Your Location</span>
                           <i class="fa-solid fa-angle-down"></i>
                        </button>
                     </div>-->
                     <div class="search-box">

                        <form id="search-form" action="{{route('search')}}" method="get" autocomplete="off">

                           <div class="input-group">
                              <input type="search" id="search-input" class="form-control" placeholder="Search for Products" value="{{$search_value}}">
                              <!-- <button class="btn" type="button" id="button-addon2">
                                 <i data-feather="search"></i>
                              </button> -->
                              <ul class="suggestions-list suggestions"></ul>
                           </div>
                        </form>

                     </div>
                  </div>
                  <div class="rightside-box">
                     <div class="search-full">
                        <div class="input-group">
                           <span class="input-group-text">
                              <i data-feather="search" class="font-light"></i>
                           </span>
                           <input type="text" class="form-control search-type" placeholder="Search here..">
                           <span class="input-group-text close-search">
                              <i data-feather="x" class="font-light"></i>
                           </span>
                        </div>
                     </div>
                     <ul class="right-side-menu">
                        <li class="right-side">
                           <div class="delivery-login-box">
                              <div class="delivery-icon">
                                 <div class="search-box">
                                    <i data-feather="search"></i>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <li class="right-side">
                           <a href="{{route('contact-us')}}" class="delivery-login-box">
                              <div class="delivery-icon">
                                 <i data-feather="phone-call"></i>
                              </div>
                              <div class="delivery-detail">
                                 <h6>24/7 Delivery</h6>
                                 <h5>+91 888 104 2340</h5>
                              </div>
                           </a>
                        </li>
                        <li class="right-side">
                           <a href="{{route('wishlist')}}" class="btn p-0 position-relative header-wishlist">
                              <i data-feather="heart"></i>
                           </a>
                        </li>
                        <li class="right-side" id="cartItem">
                             <div class="onhover-dropdown header-badge">
                                 <button type="button" class="btn p-0 position-relative header-wishlist js-cart-drawer-open">
                                    <i data-feather="shopping-cart"></i>
                                    <span class="position-absolute countCartDisplay top-0 start-100 translate-middle badge">
                                          {{ session('cart_count', 0) }}
                                    </span>
                                 </button>
                              </div>
                        </li>
                        <li class="right-side onhover-dropdown">
                           <div class="delivery-login-box">
                              @if (auth()->guard('customer')->check())
                              <a href="{{ route('myaccount') }}">
                                 <div class="delivery-icon">
                                    <i data-feather="user"></i>
                                    <span class="position-absolute bottom-0 start-100 translate-middle badge customer-login-display-name">
                                    {{ Auth::guard('customer')->user()->name }}
                                    </span>
                                 </div>
                              </a>
                              @else
                              <a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}">
                                 <div class="delivery-icon">
                                    <i data-feather="user"></i>
                                 </div>
                              </a>
                              @endif
                           </div>
                           <!--<div class="onhover-div onhover-div-login">
                              <ul class="user-box-name">
                                 <li class="product-box-contain">
                                    <i></i>
                                    <a href="login.html">Log In</a>
                                 </li>
                                 <li class="product-box-contain">
                                    <a href="sign-up.html">Register</a>
                                 </li>
                                 <li class="product-box-contain">
                                    <a href="forgot.html">Forgot Password</a>
                                 </li>
                              </ul>
                           </div>-->
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid-lg mobile-menu-bar">
      <div class="row">
         <div class="col-12">
            <div class="header-nav">
               <div class="header-nav-left">
                  <button class="dropdown-category">
                     <i data-feather="align-left"></i>
                     <span>All Categories</span>
                  </button>
                  <div class="category-dropdown">
                     <div class="category-title">
                        <h5>Categories</h5>
                        <button type="button" class="btn p-0 close-button text-content">
                           <i class="fa-solid fa-xmark"></i>
                        </button>
                     </div>
                     <ul class="category-list">
                        @if(!empty($categoriesWithMappedAttributesAndValues))
                        @foreach($categoriesWithMappedAttributesAndValues as $category)
                        <li class="onhover-category-list">
                           <a href="javascript:void(0)" class="category-name">
                              @if($category['category-image'] && file_exists(public_path('images/category/icon/' . $category['category-image'])))
                              <img src="{{ asset('images/category/icon/' . $category['category-image']) }}" alt="{{ $category['title'] }}" style="object-fit: cover;">
                              @else
                              <img src="{{ asset('images/meats.svg') }}" alt="{{ $category['title'] }}">
                              @endif
                              <h6>{{ $category['title'] }}</h6>
                              <i class="fa-solid fa-angle-right"></i>
                           </a>
                           @if(!empty($category['attributes']))

                           <div class="onhover-category-box">
                              <a href="{{ url('categories/'.$category['category-slug'])}}" class="btn btn-md mt-1 mb-3 theme-bg-color text-white ">
                                 All {{ $category['title'] }}
                              </a>
                              <div class="col-lg-12">
                                 <div class="row">
                                    @php
                                    $sr_no = 1;
                                    @endphp
                                    @foreach($category['attributes'] as $attribute)
                                    <div class="list-{{$sr_no}} col-lg-4">
                                       <div class="category-title-box">
                                          <h5>{{ $attribute['title'] }}</h5>
                                       </div>
                                       <ul>
                                          @foreach($attribute['values'] as $value)
                                          <li>
                                             <a href="{{ url('kitchen-catalog/' . $category['category-slug'] . '/' . $attribute['slug'] . '/' . $value['slug']) }}">
                                                {{ $value['name'] }}
                                             </a>
                                          </li>
                                          @endforeach
                                       </ul>
                                    </div>
                                    @php
                                    $sr_no++;
                                    @endphp
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                           @endif
                        </li>
                        @endforeach
                        @else
                        <li>No categories available</li>
                        @endif

                     </ul>
                  </div>
               </div>
               <div class="header-nav-middle">
                  <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                     <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                        <div class="offcanvas-header navbar-shadow mobile-menu-section">
                           <h5>
                              <a href="{{URL::to('')}}" class="web-logo nav-logo gd-logo">
                                 Girdhar Das <span>& Sons</span>
                              </a>
                           </h5>
                           <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body canvasbody-mobile">
                           <ul class="navbar-nav">
                              <li class="nav-item for-mobile-display mobile-category" style="margin-bottom: 20px;">
                                 <a class="nav-link mobile-link" href="javascript:void(0)" style="padding: 10px 9px 10px;
                                 border-radius: 10px;
                                 border: 1px solid #d6091a;">
                                    All Products
                                 </a>
                              </li>
                              @if ($blogCategories->isNotEmpty())
                              @foreach ($blogCategories as $blog_category)
                              <li class="nav-item dropdown">
                                 <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown">
                                    {{ $blog_category->title }}
                                 </a>
                                 <ul class="dropdown-menu">
                                    @foreach ($blog_category->blogs as $blog)
                                    <li>
                                       <a class="dropdown-item" href="{{ route('blog.details', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a>
                                    </li>
                                    @endforeach
                                 </ul>
                              </li>

                              @endforeach
                              @endif

                              <li class="nav-item for-mobile-display">
                                 <a class="nav-link mobile-link" href="{{route('about-us')}}">
                                    About Us
                                 </a>
                              </li>
                              <li class="nav-item for-mobile-display">
                                 <a class="nav-link mobile-link" href="{{route('contact-us')}}">
                                    Contact Us
                                 </a>
                              </li>

                           </ul>
                           <div class="social-icons-container mobile-menu-social">
                              <ul class="social-icons-list">
                                 <li class="social-item">
                                    <a href="https://www.facebook.com/gdandsons" target="_blank" title="Facebook" class="social-link">
                                       <i class="fab fa-facebook-f"></i>
                                    </a>
                                 </li>
                                 <li class="social-item">
                                    <a href="https://www.youtube.com/@GirdharDasandSons" target="_blank" title="YouTube" class="social-link">
                                       <i class="fab fa-youtube"></i>
                                    </a>
                                 </li>
                                 <li class="social-item">
                                    <a href="https://www.instagram.com/gdsons.vns/" target="_blank" title="Instagram" class="social-link">
                                       <i class="fab fa-instagram"></i>
                                    </a>
                                 </li>
                              </ul>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="header-nav-right">
                  <a class="btn deal-button" href="https://wa.me/919935070000?text=Hello,+I+am+interested+in+learning+more+about+your+Services">
                     <i class="fab fa-whatsapp"></i>
                     <!-- <span>Deal Today</span> -->
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid-lg">
      <div class="mobile_search_bar">
         <div class="search-input-col flex flex--align-center">
            <form class="js-search-form custom-search l-fill-width l-relative" action="{{route('search')}}" method="get" autocomplete="off" id="search-mobile-form">
               <div class="input-group-mobile">
                  <input type="text" id="search-input-mobile" class="q" name="query" placeholder="Search" value="{{$search_value}}">
                  <ul class="suggestions-list suggestions"></ul>
                  <!-- <button type="submit" class="button-search"><i class="fa fa-search"></i></button> -->
               </div>
            </form>
         </div>
      </div>
   </div>
</header>
<!-- Header End -->

<!-- mobile fix menu start -->
<div class="mobile-menu d-md-none d-block mobile-cart">
   <ul>
      <li class="active">
         <a href="{{URL::to('')}}">
            <i class="iconly-Home icli"></i>
            <span>Home</span>
         </a>
      </li>

      <li class="mobile-category">
         <a href="javascript:void(0)">
            <i class="iconly-Category icli js-link"></i>
            <span>All Products</span>
         </a>
      </li>

      <!-- <li>
         <a href="javascript:void(0);" class="search-box">
            <i class="iconly-Search icli"></i>
            <span>Search</span>
         </a>
      </li> -->

      <li>
         <a href="{{route('wishlist')}}">
            <i class="iconly-Heart icli"></i>
            <span>My Wish</span>
         </a>
      </li>

      <li>
         <a href="{{route('cart')}}">
            <i class="iconly-Bag-2 icli fly-cate"></i>
            <span>Cart</span>
         </a>
      </li>
   </ul>
</div>
<!-- mobile fix menu end -->
<script>
   let searchSuggestionUrl = "{{ route('search.suggestions') }}";
</script>