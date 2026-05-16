   @include('frontend.pages.partials.cart-drawer', [
   'cartItems' => $cartItems,
   'cart_count' => $cart_count,
   ])

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
   <div class="floating-buttons shake1">
      <a href="https://wa.me/919935070000?text=Hello,+I+visited+your+official+website.+Please+give+me+a+call." class="float-btn whatsapp" target="_blank" aria-label="whatsapp">
         <i class="fab fa-whatsapp"></i>
      </a>
      <a href="tel:+919935070000" class="float-btn bg-primary-teal" target="_blank" aria-label="mobile">
         <i class="fa fa-solid fa-phone" style="font-size: 20px;"></i>
      </a>
   </div>

   <footer class="section-t-space footer-botom-footer">
      <div class="trust-wrap w-full">
         <div class="trust-inner grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 overflow-hidden border border-white/5 bg-primary-navy py-2 lg:py-0">
            <div class="trust-item group relative flex items-center justify-center gap-4 lg:px-6 lg:py-6 px-2 py-3 cursor-default transition-all duration-300 hover:bg-white/[0.035]">
               <div class="absolute right-0 top-[18%] h-[64%] w-px bg-white/10 hidden md:block"></div>
               <div class="flex items-center">
                  <div class="icon-box flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border border-white/10 bg-white/[0.07] transition-all duration-300">
                     <svg class="icon-svg transition-all duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                     </svg>
                  </div>
                  <div class="ml-3">
                     <div class="text-white font-semibold lg:text-[17px] text-[15px] leading-snug tracking-wide mb-1">
                        Free Delivery
                     </div>
                     <span class="text-white lg:text-[15px] text-[12px] font-medium">
                        On orders above ₹10,000
                     </span>
                  </div>
               </div>
            </div>

            <div class="trust-item group relative flex items-center justify-center gap-4 lg:px-6 lg:py-6 px-2 py-3 cursor-default transition-all duration-300 hover:bg-white/[0.035]">
               <div class="absolute right-0 top-[18%] h-[64%] w-px bg-white/10 hidden md:block"></div>
               <div class="flex items-center">
                  <div class="icon-box flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border border-white/10 bg-white/[0.07] transition-all duration-300">
                     <svg class="icon-svg transition-all duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                     </svg>
                  </div>
                  <div class="ml-3">
                     <div class="text-white font-semibold lg:text-[17px] text-[15px] leading-snug tracking-wide mb-1">
                        7 Days Easy Returns
                     </div>
                     <span class="text-white lg:text-[15px] text-[12px] font-medium">
                        Hassle free returns
                     </span>
                  </div>
               </div>
            </div>

            <div class="trust-item group relative flex items-center justify-center gap-4 lg:px-6 lg:py-6 px-2 py-3 cursor-default transition-all duration-300 hover:bg-white/[0.035]">
               <div class="absolute right-0 top-[18%] h-[64%] w-px bg-white/10 hidden md:block"></div>
               <div class="flex items-center">
                  <div class="icon-box flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border border-white/10 bg-white/[0.07] transition-all duration-300">
                     <svg class="icon-svg transition-all duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                        <path d="M9 12l2 2l4 -4" />
                     </svg>
                  </div>
                  <div class="ml-3">
                     <div class="text-white font-semibold lg:text-[17px] text-[15px] leading-snug tracking-wide mb-1">
                        Secure Payments
                     </div>
                     <span class="text-white lg:text-[15px] text-[12px] font-medium">
                        100% secure payments
                     </span>
                  </div>
               </div>
            </div>

            <div class="trust-item group relative flex items-center justify-center gap-4 lg:px-6 lg:py-6 px-2 py-3 cursor-default transition-all duration-300 hover:bg-white/[0.035]">
               <div class="flex items-center">
                  <div class="icon-box flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border border-white/10 bg-white/[0.07] transition-all duration-300">
                     <svg class="icon-svg transition-all duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 14v-3a8 8 0 1 1 16 0v3" />
                        <path d="M18 19c0 1.657 -2.686 3 -6 3" />
                        <path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z" />
                        <path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z" />
                     </svg>
                  </div>
                  <div class="ml-3">
                     <div class="text-white font-semibold lg:text-[17px] text-[15px] leading-snug tracking-wide mb-1">
                        Dedicated Support
                     </div>
                     <span class="text-white lg:text-[15px] text-[12px] font-medium">
                        We are here for you ?
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container-fluid-lg">
         <div class="px-1 lg:px-1 pt-10 pb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr_1.45fr] gap-4 lg:gap-8">
               <div class="animate-col-1 brand-logo">
                  <a href="{{ url('/') }}" class="block mb-3 group hover:!text-primary-navy" style="font-family: 'Playfair Display', serif;">
                     <span class="text-primary-navy lg:text-[30px] text-[24px] font-bold leading-[1.15] tracking-wide transition-colors hover:!text-primary-navy">
                        Girdhar Das
                        <span class="text-primary-teal">&</span> Sons
                     </span>
                  </a>
                  <div class="w-12 h-[2.5px] rounded-full mb-4 bg-gradient-to-r from-primary-teal to-primary-navy"></div>
                  <p class="text-primary-navy text-[15px] leading-[1.75] mb-3">
                     Trusted kitchen store in Varanasi<br />since 1970.
                  </p>
                  <span class="inline-flex items-center gap-1.5 bg-primary-navy/100 border border-[#c8922a]/25
                     text-[#ffff] text-[11px] font-medium px-3 py-1 rounded-full mb-6 tracking-wide">
                     <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3a12 12 0 0 0 8.5 3 12 12 0 0 1-8.5 15A12 12 0 0 1 3.5 6 12 12 0 0 0 12 3z" />
                        <path d="m9 12 2 2 4-4" />
                     </svg>
                     Since 1970 · Trusted Quality
                  </span>
                  <div class="flex items-center gap-3 flex-wrap">
                     <a href="https://www.facebook.com/gdandsons"
                        target="_blank"
                        aria-label="Facebook"
                        class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg"
                           width="18"
                           height="18"
                           fill="currentColor"
                           viewBox="0 0 24 24">
                           <path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.19 2.23.19v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"/>
                        </svg>
                     </a>
                     <a href="https://www.instagram.com/gdsons.vns/"
                        target="_blank"
                        aria-label="Instagram"
                        class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                           width="18"
                           height="18"
                           fill="currentColor"
                           viewBox="0 0 24 24">

                           <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 2h8.5A3.75 3.75 0 0 1 20 7.75v8.5A3.75 3.75 0 0 1 16.25 20h-8.5A3.75 3.75 0 0 1 4 16.25v-8.5A3.75 3.75 0 0 1 7.75 4zm8.75 1a1 1 0 1 0 0 2a1 1 0 0 0 0-2zM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6a3 3 0 0 1 0-6z"/>
                        </svg>
                     </a>                     
                     <a href="https://www.youtube.com/@GirdharDasandSons"
                        target="_blank"
                        aria-label="YouTube"
                        class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg"
                           width="18"
                           height="18"
                           fill="currentColor"
                           viewBox="0 0 24 24">
                           <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2A31.7 31.7 0 0 0 0 12a31.7 31.7 0 0 0 .5 5.8a3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.7 31.7 0 0 0 24 12a31.7 31.7 0 0 0-.5-5.8zM9.75 15.5v-7L16 12l-6.25 3.5z"/>
                        </svg>
                     </a>
                     <a href="https://wa.me/919935070000?text=Hello,+I+visited+your+official+website.+Please+give+me+a+call."
                        target="_blank"
                        aria-label="WhatsApp"
                        class="group flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-primary-teal text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-navy hover:shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                           width="18"
                           height="18"
                           fill="currentColor"
                           viewBox="0 0 24 24">

                           <path d="M20.52 3.48A11.8 11.8 0 0 0 12.04 0C5.4 0 .02 5.38.02 12c0 2.1.55 4.15 1.6 5.96L0 24l6.2-1.62A11.94 11.94 0 0 0 12.04 24c6.63 0 12-5.38 12-12c0-3.2-1.25-6.22-3.52-8.52zM12.04 21.8c-1.8 0-3.55-.48-5.08-1.4l-.36-.21-3.68.96.98-3.59-.24-.37a9.77 9.77 0 0 1-1.5-5.19c0-5.4 4.4-9.8 9.82-9.8c2.62 0 5.08 1.02 6.93 2.87a9.75 9.75 0 0 1 2.88 6.93c0 5.41-4.4 9.8-9.83 9.8zm5.39-7.35c-.3-.15-1.77-.87-2.04-.97c-.27-.1-.47-.15-.67.15c-.2.3-.77.97-.95 1.17c-.17.2-.35.22-.64.07c-.3-.15-1.25-.46-2.38-1.47c-.88-.79-1.48-1.76-1.65-2.06c-.17-.3-.02-.46.13-.61c.13-.13.3-.35.45-.52c.15-.18.2-.3.3-.5c.1-.2.05-.37-.03-.52c-.07-.15-.67-1.61-.91-2.2c-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.08-.79.38c-.27.3-1.04 1.01-1.04 2.47c0 1.46 1.06 2.87 1.21 3.07c.15.2 2.1 3.2 5.08 4.49c.71.31 1.27.49 1.7.63c.71.22 1.36.19 1.87.11c.57-.08 1.77-.72 2.02-1.42c.25-.69.25-1.28.18-1.41c-.08-.13-.28-.2-.58-.35z"/>
                        </svg>
                     </a>
                  </div>
               </div>
               @if (isset($category_for_footer) && $category_for_footer->isNotEmpty())
                  @php
                     $chunks = $category_for_footer->chunk(10);
                  @endphp
                  @foreach ($chunks as $chunk)
                     <div class="animate-col-2 f-category-area {{ !$loop->first ? 'pt-[0px] sm:pt-[70px] class-added' : '' }}">
                        @if ($loop->first)
                           <div class="col-head mb-3 text-[18px] font-bold">
                              Categories
                           </div>
                           <div class="w-12 h-[2.5px] rounded-full mb-4 bg-gradient-to-r from-primary-teal to-primary-navy"></div>
                        @endif
                        <ul class="space-y-0.5">
                           @foreach ($chunk as $category)
                           <li>
                              <a href="{{ url('categories/'.$category->slug)}}" class="nav-link !text-primary-navy text-[15px]">{{$category->title}}</a>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  @endforeach               
               @endif

               <div class="animate-col-2 f-customer-services">
                  <div class="col-head mb-3 text-[18px] font-bold">Useful Links</div>
                  <div class="w-12 h-[2.5px] rounded-full mb-4 bg-gradient-to-r from-primary-teal to-primary-navy"></div>
                  <ul class="space-y-0.5">
                     <li><a href="{{ route('logincustomer') }}?redirect={{ url()->current() }}" class="nav-link !text-primary-navy text-[15px]">Login</a></li>
                     <li><a href="{{ route('blogs') }}" class="nav-link !text-primary-navy text-[15px]">Blogs</a></li>
                     <li><a href="{{ route('about-us') }}" class="nav-link !text-primary-navy text-[15px]">About Us</a></li>
                     <li><a href="{{ route('contact-us') }}" class="nav-link !text-primary-navy text-[15px]">Contact Us</a></li>
                     <li>
                        <a href="{{ route('flash.sale')}}" class="nav-link !text-primary-navy text-[15px]">
                        Flash Sale
                        <span class="bg-red-800 text-white text-[10px] font-medium px-2 py-0.5 rounded-full border border-red-500/20">Live</span>
                        </a>
                     </li>
                     <li><a href="{{ route('terms-of-use') }}" class="nav-link !text-primary-navy text-[15px]">Shipping Policy</a></li>
                     <li><a href="{{ route('terms-of-use') }}#returns-and-cancellations" class="nav-link !text-primary-navy text-[15px]">Return & Refund</a></li>
                     <li><a href="{{ route('terms-of-use') }}#returns-and-cancellations" class="nav-link !text-primary-navy text-[15px]">Terms of Use</a></li>
                     <li><a href="{{ route('privacy-policy') }}" class="nav-link !text-primary-navy text-[15px]">Privacy Policy</a></li>
                     
                  </ul>
               </div>               
               <div class="animate-col-5 f-contact-us">
                  <div class="col-head mb-3 text-[18px] font-bold">Contact Us</div>
                  <div class="w-12 h-[2.5px] rounded-full mb-4 bg-gradient-to-r from-primary-teal to-primary-navy"></div>
                  <div class="space-y-2">
                     <div class="flex items-start gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-primary-teal border border-[#c8922a]/20
                        flex items-center justify-center flex-shrink-0 mt-0.5
                        group-hover:bg-primary-navy transition-colors text-white">
                           <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                              <circle cx="12" cy="10" r="3" />
                           </svg>
                        </div>
                        <p class="text-slate2 !text-primary-navy text-[15px] pt-1">
                           W.H. Smith School Road,<br />Sigra, Varanasi – 221010
                        </p>
                     </div>
                     <div class="flex items-start gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-primary-teal border border-[#c8922a]/20
                        flex items-center justify-center flex-shrink-0 mt-0.5
                        group-hover:bg-primary-navy transition-colors text-white">
                           <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.5 2 2 0 0 1 3.6 1.34h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                           </svg>
                        </div>
                        <div class="pt-1">
                           <a href="tel:+919935070000" class="text-slate2 hover:text-primary-navy !text-primary-navy text-[15px]">+91 - 9935070000</a>
                           <a href="tel:+918318894257" class="text-slate2 hover:text-primary-navy !text-primary-navy text-[15px] block leading-6 transition-colors">+91 - 8318894257</a>
                        </div>
                     </div>

                     <!-- Email -->
                     <div class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-primary-teal border border-[#c8922a]/20
                        flex items-center justify-center flex-shrink-0 mt-0.5
                        group-hover:bg-primary-navy transition-colors text-white">
                           <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                              <polyline points="22,6 12,13 2,6" />
                           </svg>
                        </div>
                        <div class="pt-1">
                           <a href="mailto:akshat@gdsons.co.in" class="text-slate2 hover:text-primary-navy !text-primary-navy text-[15px]">
                              akshat@gdsons.co.in
                           </a>
                           <a href="mailto:gdsons.vns@gmail.com" class="text-slate2 hover:text-primary-navy !text-primary-navy text-[15px] block leading-6 transition-colors">
                              gdsons.vns@gmail.com
                           </a>
                        </div>
                     </div>
                     <div class="flex items-start gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-primary-teal border border-[#c8922a]/20
                        flex items-center justify-center flex-shrink-0 mt-0.5
                        group-hover:bg-primary-navy transition-colors text-white">
                           <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <circle cx="12" cy="12" r="10" />
                              <polyline points="12 6 12 12 16 14" />
                           </svg>
                        </div>
                        <div class="pt-1">
                           <p class="hover:text-primary-navy !text-primary-navy text-[15px] mb-0">Mon – Sat: 9:00 AM – 8:00 PM</p>
                           <p class="hover:text-primary-navy !text-primary-navy text-[15px]">Sunday: 10:00 AM – 6:00 PM</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="border-t bg-gray-100">
            <div class="px-3 lg:px-10 py-2 flex flex-col md:flex-row items-center justify-between gap-4">
               <p class="text-slate2 text-xs text-primary-navy order-last md:order-first tracking-wide mb-0">
                  © {{ date('Y') }} Girdhar Das &amp; Sons. All Rights Reserved.
               </p>
               <div class="flex items-center flex-wrap justify-center text-xs">
                  <a href="{{ route('privacy-policy') }}" class="blink px-3 py-1 text-primary-navy">Privacy Policy</a>
                  <span class="text-primary-teal select-none">|</span>
                  <a href="{{ route('terms-of-use') }}" class="blink px-3 py-1 text-primary-navy">Terms of Use</a>
                  <span class="text-primary-teal select-none">|</span>
                  <a href="{{ route('terms-of-use') }}#returns-and-cancellations" class="blink px-3 py-1 text-primary-navy">Return / Refund</a>
               </div>
               <div class="flex items-center gap-2 flex-wrap justify-center">
                  <div class="pay tracking-widest text-primary-navy">VISA</div>
                  <div class="pay px-2">
                     <svg viewBox="0 0 38 24" width="38" height="24">
                        <circle cx="14" cy="12" r="10" fill="#EB001B" opacity=".9" />
                        <circle cx="24" cy="12" r="10" fill="#F79E1B" opacity=".9" />
                        <path d="M19 4.8a10 10 0 0 1 0 14.4A10 10 0 0 1 19 4.8z" fill="#FF5F00" />
                     </svg>
                  </div>
                  <div class="pay text-primary-navy">RuPay</div>
                  <div class="pay text-primary-navy">
                     UPI
                  </div>
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
      <div class="modal-dialog modal-dialog-centered">
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