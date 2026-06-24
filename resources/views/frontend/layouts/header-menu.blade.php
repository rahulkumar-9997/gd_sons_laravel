<!-- Header Start -->
@php
$query = request()->get('query');
$search_value = !empty($query) ? $query : '';
@endphp
<header class="pb-md-2 pb-0 mobile-header">
   <div class="header-top d-lg-block d-none">
      <div class="container-fluid-lg">
         <div class="row">
            <div class="col-lg-6 col-md-6 d-xxl-block d-sm-none varanasi-top">
               <div class="top-left-header">
                  <!-- <i class="iconly-Location icli text-white"></i> -->
                  <h4 class="text-white">Genuine products. All across India. 55 years of honest service!</h4>
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
                  <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#primaryMenu" aria-label="Menu">
                     <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars"></i>
                     </span>
                  </button>
                  <a href="{{ url('/') }}" class="web-logo nav-logo gd-logo">
                     <!--<img src="{{asset('frontend/assets/images/logo/1.png')}}" class="img-fluid blur-up lazyload" alt="">-->
                     Girdhar Das <span class="and"> & </span><span class="sons"> Sons</span>
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
                        @include('frontend.layouts.component.header-cart-count', [
                           'cart_count' => count(session()->get('cart', []))
                        ])
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
                              <a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}" aria-label="Login to your account">
                                 <div class="delivery-icon">
                                    <i data-feather="user"></i>
                                 </div>
                              </a>
                              @endif
                           </div>
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
                  <button class="dropdown-category" data-open-categories aria-label="All Categories">
                     <i data-feather="align-left"></i>
                     <span>All Categories</span>
                  </button>                  
                  <div id="mobileDrawerBackdrop" class="pointer-events-none fixed inset-0 z-50 bg-black/40 opacity-0 transition-opacity duration-300 ease-out backdrop-blur-sm"></div>
                  <aside id="mobileDrawer" class="fixed inset-y-0 left-0 z-50 w-[85%] max-w-sm -translate-x-full overflow-y-auto bg-white shadow-2xl transition-transform duration-300 ease-out will-change-transform">
                        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white/95 px-[1.25rem] py-[1rem] backdrop-blur-sm">
                           <a href="{{ url('/') }}" class="font-display text-[22px] font-semibold text-ink" style="font-family: 'Playfair Display', serif;">
                              Girdhar Das <span class="text-brand-600">&amp;</span> Sons
                           </a>
                           <button type="button" data-drawer-close aria-label="Close menu" class="group flex h-9 w-9 items-center justify-center rounded-full text-ink-soft transition hover:bg-brand-50 hover:text-brand-600">
                              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M6 18L18 6M6 6l12 12" />
                              </svg>
                           </button>
                        </div>
                        <div class="flex-1 overflow-y-auto px-[0.75rem] py-[1rem]">
                           <nav>                              
                              <div id="mobileCategoryAccordion">
                                 @if(!empty($categoriesWithMappedAttributesAndValues))
                                 <h6 data-cat-list-label class="px-[0.5rem] pb-[0.5rem] text-[14px] font-semibold uppercase tracking-wider text-ink-soft/70">Browse Categories</h6>
                                 <div id="mobileCategoryList" class="space-y-0.5 mb-[10px]">
                                    @foreach($categoriesWithMappedAttributesAndValues as $category)
                                       <button type="button" data-mcat-open="m-cat-detail-{{ $loop->index }}" 
                                          aria-label="View {{ $category['title'] }} subcategories" 
                                          class="group flex w-full items-center justify-between rounded-lg px-[0.50rem] py-[0.50rem] text-left text-sm font-medium text-ink transition hover:bg-brand-50">
                                          <span class="flex items-center gap-3">
                                             @if($category['category-image'] && file_exists(public_path('images/category/icon/' . $category['category-image'])))
                                                <img src="{{ asset('images/category/icon/' . $category['category-image']) }}" 
                                                   class="h-8 w-8 rounded-lg border border-gray-100 object-cover" 
                                                   alt="{{ $category['title'] }}">
                                             @else
                                                <div class="flex h-8 w-8 rounded-full border-4 border-white shadow-lg bg-primary-teal items-center justify-center text-white text-[12px] font-bold">
                                                {{ strtoupper(substr($category['title'], 0, 1)) }}
                                                </div>
                                             @endif
                                             <span class="text-[17px] text-[#333]">{{ $category['title'] }}</span>
                                          </span>
                                          <svg class="h-4 w-4 shrink-0 text-ink-soft/50 transition group-hover:translate-x-0.5 group-hover:text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                          </svg>
                                       </button>
                                    @endforeach
                                 </div>
                                 @foreach($categoriesWithMappedAttributesAndValues as $category)
                                    <div id="m-cat-detail-{{ $loop->index }}" class="mobile-category-detail hidden animate-slide-in">
                                       <button type="button" 
                                          data-mcat-back 
                                          aria-label="Back to all categories" 
                                          class="flex w-full items-center gap-2 px-[0.75rem] py-[1rem] text-[17px] font-medium text-ink-soft transition hover:text-brand-600">
                                          <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                          </svg>
                                          Back to all Categories
                                       </button>
                                       <div class="px-[0.75rem] pb-[1rem]">
                                          <a href="{{ url('categories/'.$category['category-slug']) }}" 
                                             class="mb-3 inline-flex items-center gap-1 text-[16px] text-primary-teal transition hover:text-primary-navy">
                                             View All {{ $category['title'] }}
                                             <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                             </svg>
                                          </a>
                                          @if(!empty($category['attributes']))
                                             @foreach($category['attributes'] as $attribute)
                                                <div class="mb-3">
                                                   <div class="text-[17px] font-semibold tracking-wider text-ink-soft/70">{{ $attribute['title'] }}</div>
                                                   <div class="">
                                                      @foreach($attribute['values'] as $value)
                                                         <a href="{{ url('kitchen-catalog/' . $category['category-slug'] . '/' . $attribute['slug'] . '/' . $value['slug']) }}" class="block items-center px-[0.600rem] py-[0.5rem] text-[16px] text-[#4a5568] hover:text-[#4a5568]">{{ ucwords(strtolower($value['name'])) }}
                                                         </a>
                                                      @endforeach
                                                   </div>
                                                </div>
                                             @endforeach
                                          @else
                                             <p class="text-sm text-ink-soft/70">Browse the full {{ $category['title'] }} range.</p>
                                          @endif
                                       </div>
                                    </div>
                                 @endforeach
                                 @else
                                 <p class="px-3 py-4 text-sm text-ink-soft/70">No categories available</p>
                                 @endif
                              </div>
                              <a href="{{ route('flash.sale') }}" class="group flex items-center justify-between text-primary-teal rounded-3xl bg-white border border-slate-100 p-3 shadow-[0_8px_10px_rgb(0,0,0,0.08)] transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                                 <span class="flex items-center gap-2">
                                 <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                                 Flash Sale
                                 </span>
                                 <span class="rounded-full bg-amber-400/20 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 backdrop-blur-sm">Limited</span>
                              </a>
                              @if ($blogCategories->isNotEmpty())
                                 <div class="mt-[1rem] border-t border-gray-100 pt-[1rem]">
                                    @foreach ($blogCategories as $blog_category)
                                       <div class="border-b border-gray-100 last:border-0">
                                          <button type="button" 
                                             data-accordion-trigger 
                                             aria-expanded="false" 
                                             aria-controls="m-blog-{{ $loop->index }}" 
                                             class="flex w-full items-center justify-between px-2 py-3 text-sm font-medium text-ink transition hover:text-brand-600">
                                             <span class="text-[17px] text-[#333]">{{ $blog_category->title }}</span>
                                             <svg data-chevron class="h-4 w-4 shrink-0 text-ink-soft/50 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                             </svg>
                                          </button>
                                          <div id="m-blog-{{ $loop->index }}" class="hidden px-2 pb-3">
                                          @foreach ($blog_category->blogs as $blog)
                                             <a href="{{ route('blog.details', ['slug' => $blog->slug]) }}" 
                                                class="block items-center px-[0.600rem] py-[0.5rem] text-[16px] text-[#4a5568] hover:text-[#4a5568]">
                                                {{ $blog->title }}
                                             </a>
                                          @endforeach
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                              @endif
                              <button type="button" class="requestProductBtn mt-4 flex w-full items-center justify-center gap-2 rounded-xl border border-brand-200 bg-brand-50 px-[1rem] py-[0.75rem] text-[17px] hover:shadow-sm"
                              data-url="{{ route('request.product.enquiry.form') }}"
                              data-title="Request a Product or Item"
                              data-pageurl="{{ url()->current() }}"
                              data-size="md">
                                 <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                 <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-linecap="round"/>
                                 </svg>
                                 Request a Product
                              </button>
                           </nav>
                        </div>
                        <div class="sticky bottom-0 z-10 border-t border-gray-100 bg-white/95 px-[1rem] py-[1rem] backdrop-blur-sm">
                           <div class="flex items-center gap-1.5 justify-between">
                              <a href="https://www.facebook.com/gdandsons" target="_blank" aria-label="Facebook" class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.19 2.23.19v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"></path>
                                 </svg>
                              </a>
                              <a href="https://www.instagram.com/gdsons.vns/" target="_blank" aria-label="Instagram" class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">

                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">

                                    <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 2h8.5A3.75 3.75 0 0 1 20 7.75v8.5A3.75 3.75 0 0 1 16.25 20h-8.5A3.75 3.75 0 0 1 4 16.25v-8.5A3.75 3.75 0 0 1 7.75 4zm8.75 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6a3 3 0 0 1 0-6z"></path>
                                 </svg>
                              </a>                     
                              <a href="https://www.youtube.com/@GirdharDasandSons" target="_blank" aria-label="YouTube" class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2A31.7 31.7 0 0 0 0 12a31.7 31.7 0 0 0 .5 5.8a3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.7 31.7 0 0 0 24 12a31.7 31.7 0 0 0-.5-5.8zM9.75 15.5v-7L16 12l-6.25 3.5z"></path>
                                 </svg>
                              </a>
                              <a href="https://wa.me/919935070000?text=Hello,+I+visited+your+official+website.+Please+give+me+a+call." target="_blank" aria-label="WhatsApp" class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">

                                 <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">

                                    <path d="M20.52 3.48A11.8 11.8 0 0 0 12.04 0C5.4 0 .02 5.38.02 12c0 2.1.55 4.15 1.6 5.96L0 24l6.2-1.62A11.94 11.94 0 0 0 12.04 24c6.63 0 12-5.38 12-12c0-3.2-1.25-6.22-3.52-8.52zM12.04 21.8c-1.8 0-3.55-.48-5.08-1.4l-.36-.21-3.68.96.98-3.59-.24-.37a9.77 9.77 0 0 1-1.5-5.19c0-5.4 4.4-9.8 9.82-9.8c2.62 0 5.08 1.02 6.93 2.87a9.75 9.75 0 0 1 2.88 6.93c0 5.41-4.4 9.8-9.83 9.8zm5.39-7.35c-.3-.15-1.77-.87-2.04-.97c-.27-.1-.47-.15-.67.15c-.2.3-.77.97-.95 1.17c-.17.2-.35.22-.64.07c-.3-.15-1.25-.46-2.38-1.47c-.88-.79-1.48-1.76-1.65-2.06c-.17-.3-.02-.46.13-.61c.13-.13.3-.35.45-.52c.15-.18.2-.3.3-.5c.1-.2.05-.37-.03-.52c-.07-.15-.67-1.61-.91-2.2c-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.38c-.27.3-1.04 1.01-1.04 2.47c0 1.46 1.06 2.87 1.21 3.07c.15.2 2.1 3.2 5.08 4.49c.71.31 1.27.49 1.7.63c.71.22 1.36.19 1.87.11c.57-.08 1.77-.72 2.02-1.42c.25-.69.25-1.28.18-1.41c-.08-.13-.28-.2-.58-.35z"></path>
                                 </svg>
                              </a>
                           </div>
                        </div>
                  </aside>
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
                           <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas" aria-label="canvas"></button>
                        </div>
                        <div class="offcanvas-body canvasbody-mobile">
                           <ul class="navbar-nav">
                              
                              <li class="nav-item for-mobile-display mobile-category" data-open-categories style="margin-bottom: 20px;">
                                 <a class="nav-link mobile-link all-product-mobile" href="javascript:void(0)">
                                    All Products
                                 </a>
                              </li>
                              <li class="mobile-flash-sale">
                                 <a href="{{ route('flash.sale')}}" class="flash-sale-button">
                                    Flash Sale <small>Only Limited Time</small>
                                 </a>
                              </li>
                              @if ($blogCategories->isNotEmpty())
                              @foreach ($blogCategories as $blog_category)
                              <li class="nav-item dropdown">
                                 <a class="nav-link nav-other dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown">
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
                                 <a class="nav-link nav-other mobile-link" href="{{route('about-us')}}">
                                    About Us
                                 </a>
                              </li>
                              <li class="nav-item for-mobile-display">
                                 <a class="nav-link nav-other mobile-link" href="{{route('contact-us')}}">
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
                  <!-- <a class="btn deal-button" href="https://wa.me/919935070000?text=Hello,+I+am+interested+in+learning+more+about+your+Services">
                     <i class="fab fa-whatsapp"></i>
                  </a> -->
                  <button 
                  class="btn deal-button requestProductBtn"
                  href="javascript:void(0)"
                  data-url="{{ route('request.product.enquiry.form') }}"
                  data-title="Request a Product or Item"
                  data-pageurl="{{url()->current()}}"
                  data-size="md"
                  aria-label="need something"
                  >
                     Need Something ?
                  </button>
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

      <li class="mobile-category" data-open-categories>
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
         <a href="javascript:void(0);" class="js-cart-drawer-open">
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