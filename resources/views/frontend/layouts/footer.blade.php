<!--Sticky user-->
@if (Auth::guard('customer')->check() && isset($groupCategory->groupCategory))
   @php
      $groupNames ='';
      $customer = $groupCategory->name;
      $groupNames = $groupCategory->customerGroup->name;
   @endphp
   <div class="sticky-user">
      <div class="user-name">
         <a href="{{ route('myaccount') }}">
            <h5>
                  {!! $customer !!} 
                  
                  @if($groupNames)
                     <span> - {{ $groupNames }}</span>
                  @endif
            </h5>
         </a>
      </div>
   </div>
@endif
<!--Sticky user-->

<!--sticky footer--->
<div class="floating-buttons shake1">
    <a href="https://wa.me/918318894257?text=Hello,+I+am+interested+in+learning+more+about+your+Services" 
       class="float-btn whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="tel:+918318894257" 
       class="float-btn messenger" target="_blank">
        <i class="fa fa-solid fa-phone" style="font-size: 20px;"></i>
    </a>
</div>

<!--sticky footer--->

<!-- Footer Section Start -->
<footer class="section-t-space footer-botom-footer">
   <div class="container-fluid-lg">
      <div class="service-section">
         <div class="row g-3">
            <div class="col-12">
               <div class="service-contain">
                  <div class="service-box">
                     <div class="service-image">
                        <img src="{{asset('frontend/assets/gd-img/footer-img/trust-since.png')}}" class="blur-up lazyload" alt="">
                     </div>

                     <div class="service-detail">
                        <h5>Trusted Since 1970</h5>
                     </div>
                  </div>

                  <div class="service-box">
                     <div class="service-image">
                        <img src="{{asset('frontend/assets/gd-img/footer-img/shop-smart-cook-better.png')}}" class="blur-up lazyload" alt="Shop Smart, Cook Better">
                     </div>

                     <div class="service-detail">
                        <h5>Shop Smart, Cook Better</h5>
                     </div>
                  </div>

                  <div class="service-box">
                     <div class="service-image">
                        <img src="{{asset('frontend/assets/gd-img/footer-img/your-kitchen-partner.png')}}" class="blur-up lazyload" alt="Your Kitchen Partner">
                     </div>

                     <div class="service-detail">
                        <h5>Your Kitchen Partner </h5>
                     </div>
                  </div>

                  <div class="service-box">
                     <div class="service-image">
                        <img src="{{asset('frontend/assets/gd-img/footer-img/save-more-on-bulk-orders.png')}}" class="blur-up lazyload" alt="Save More on Bulk Orders">
                     </div>

                     <div class="service-detail">
                        <h5>Save More on Bulk Orders</h5>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="main-footer section-b-space section-t-space">
         <div class="row g-md-4 g-3">
            <div class="col-lg-12 col-sm-12 pt-0">
               <div class="footer-log-section text-center">
                  <img src="{{asset('frontend/assets/gd-img/footer-img/gd-footer-logo.png')}}" class="blur-up lazyload" alt="Save More on Bulk Orders">
               </div>
            </div>
            <!-- <div class="col-xl-3 col-lg-4 col-sm-6">
               <div class="footer-logo">
                  <div class="theme-logo">
                     <a href="index.html">
                        <img src="{{asset('frontend/assets/images/logo/1.png')}}" class="blur-up lazyload" alt="">
                     </a>
                  </div>

                  <div class="footer-logo-contain">
                     <p>We are a friendly bar serving a variety of cocktails, wines and beers. Our bar is a
                        perfect place for a couple.</p>

                     <ul class="address">
                        <li>
                           <i data-feather="home"></i>
                           <a href="javascript:void(0)">1418 Riverwood Drive, CA 96052, US</a>
                        </li>
                        <li>
                           <i data-feather="mail"></i>
                           <a href="javascript:void(0)">support@fastkart.com</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div> -->
            @if (isset($category_for_footer) && $category_for_footer->isNotEmpty())
            <div class="col-xl-3 col-lg-3 col-sm-3">
               <div class="footer-title">
                  <h4>Categories</h4>
               </div>

               <div class="footer-contain">
                  <ul>
                     @foreach ($category_for_footer as $category)
                     <li>
                        <a href="{{ url('categories/'.$category->slug)}}" class="text-content">{{$category->title}}</a>
                     </li>
                     @endforeach
                  </ul>
               </div>
            </div>
            @endif
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 footer-blog-category-section">
               <!--<div class="footer-title">
                  <h4>Blog</h4>
               </div>-->
               <div class="footer-contain footer-contain-blog">
                  <div class="row">
                     @if (isset($blog_for_footer) && $blog_for_footer->isNotEmpty())
                     @php
                     $loop_counter = 0;
                     @endphp

                     @foreach ($blog_for_footer->chunk(3) as $blog_chunk)
                     <div class="row">
                        @foreach ($blog_chunk as $blog_category)
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                           <div class="footer-title">
                              <h4 class="footer-blog-category">
                                 <a style="color: #222;" href="{{ route('blog.list', ['slug' => $blog_category->slug]) }}">{{ $blog_category->title }}</a>
                              </h4>
                           </div>
                           <div class="footer-contain-old" style="margin-top: 8px; margin-bottom:8px;">
                              <ul>
                                 @foreach ($blog_category->blogs as $blog)
                                 <li>
                                    <a href="{{ route('blog.details', ['slug' => $blog->slug]) }}" class="text-content">{{ $blog->title }}</a>
                                 </li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                        @endforeach

                        @if ($blog_chunk->count() < 2)
                           <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                     </div>
                     @endif
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>

         <div class="col-xl-3 col-lg-3 col-sm-3">
            <div class="footer-title">
               <h4>Contact Us</h4>
            </div>

            <div class="footer-contact">
               <ul>
                  <li>
                     <div class="footer-number">
                        <i data-feather="phone"></i>
                        <div class="contact-number">
                           <h6 class="text-content">Hotline 24/7 :</h6>
                           <h5>
                              <a href="tel:+91-8318894257">+91 - 83188 94257</a>
                           </h5>
                        </div>
                     </div>
                  </li>

                  <li>
                     <div class="footer-number">
                        <i data-feather="mail"></i>
                        <div class="contact-number">
                           <h6 class="text-content">Email Address :</h6>
                           <h5>
                              <a href="mailto:akshat.gd@gmail.com">akshat.gd@gmail.com</a>
                           </h5>
                        </div>
                     </div>
                  </li>
                  <li>
                     <div class="footer-number">
                        <i data-feather="map-pin"></i>
                        <div class="contact-number">
                           <h6 class="text-content"> Address :</h6>
                           <h5>
                              W.H.Smith School Road, Sigra, Varanasi
                           </h5>
                        </div>
                     </div>
                  </li>


               </ul>
            </div>
         </div>
      </div>
   </div>

   <div class="sub-footer section-small-space footer-bottom-section">
      <div class="reserve">
         <h6 class="text-content copyright"><a>gdsons.co.in</a> © {{ date('Y') }} All rights reserved.</h6>
      </div>
      <div class="social-link">
         <!-- <h6 class="text-content">Stay connected :</h6> -->
         <ul>

            <li>
               <a href="https://www.instagram.com/gdsons.vns/" target="_blank">
                  <i class="fa-brands fa-instagram"></i>
               </a>
            </li>
            <li>
               <a href="https://www.youtube.com/@GirdharDasandSons" target="_blank">
                  <i class="fa-brands fa-youtube"></i>
               </a>
            </li>
            <li>
               <a href="https://www.facebook.com/gdandsons" target="_blank">
                  <i class="fa-brands fa-facebook-f"></i>
               </a>
            </li>
         </ul>
      </div>
   </div>
   </div>
</footer>
<div id="loader" class="loader-wrapper" style="display: none;">
   <span class="site-loader"> </span>
   <h3 class="loader-content"> Loading . . . </h3>
</div>
<!--Quick View modal--->
<div class="modal fade theme-modal view-modal" id="QuickModalView" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
      <div class="modal-content">
         <div class="modal-header p-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>
         <div class="render-data">

         </div>
      </div>
   </div>
</div>
<!--Quick View modal--->
<!--enquiry modal code-->
<div class="modal location-modal fade theme-modal" id="commoanModal" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
           
            <button type="button" class="btn-close" data-bs-dismiss="modal">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>
         <div class="modal-body">
            <div class="modal-render-data">

            </div>
         </div>
      </div>
   </div>
</div>
<!-- Location Modal End -->
<!--enquiry modal code-->