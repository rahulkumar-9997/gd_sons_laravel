<!-- ========== App Menu Start ========== -->
<div class="main-nav">
   <!-- Sidebar Logo -->
   <div class="logo-box">
      <a href="{{route('dashboard')}}" class="logo-dark">
      <img src="{{asset('backend/assets/fav-icon.png')}}" class="logo-sm" alt="logo sm">
      <img src="{{asset('backend/assets/fav-icon.png')}}" class="logo-lg" alt="logo dark">
      </a>
      <a href="{{route('dashboard')}}" class="logo-light" style="text-align: center;">
      <img src="{{asset('backend/assets/fav-icon.png')}}" class="logo-sm" alt="logo sm">
      <img src="{{asset('backend/assets/logo.png')}}" style="width: 121px; height: 45px;" class="logo-lg" alt="logo light">
      </a>
   </div>
   <!-- Menu Toggle Button (sm-hover) -->
   <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
      <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
   </button>
   <div class="scrollbar" data-simplebar>
      <ul class="navbar-nav" id="navbar-nav">
      <!-- <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebarProducts_user" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts_user">
               <span class="nav-icon">
                  <iconify-icon icon=""></iconify-icon>
               </span>
               <span class="nav-text"> Manage User </span>
            </a>
            <div class="collapse" id="sidebarProducts_user">
               <ul class="nav sub-navbar-nav">
                 
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="User">User</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="User">Role</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="User">Permissions</a>
                     </li>
                 
               </ul>
            </div>
         </li> -->
         @foreach($menus as $menu)
            @if($menu->children->isEmpty())
               <li class="nav-item">
                  <a class="nav-link" href="{{ url($menu->url) }} ">
                     <span class="nav-icon">
                        <iconify-icon icon="{{ $menu->icon }}"></iconify-icon>
                     </span>
                     <span class="nav-text">  {{ $menu->name }} </span>
                  </a>
               </li>
            @else
            <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarProducts_{{ $menu->id }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts_{{ $menu->id }}">
                  <span class="nav-icon">
                     <iconify-icon icon="{{ $menu->icon }}"></iconify-icon>
                  </span>
                  <span class="nav-text"> {{ $menu->name }} </span>
               </a>
               <div class="collapse" id="sidebarProducts_{{ $menu->id }}">
                  <ul class="nav sub-navbar-nav">
                     @foreach($menu->children as $child)
                        <li class="sub-nav-item">
                           <a class="sub-nav-link" href="{{ url($child->url) }}">{{ $child->name }}</a>
                        </li>
                     @endforeach
                  </ul>
               </div>
            </li>
            @endif
         @endforeach
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebarProducts_user" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts_user">
               <span class="nav-icon">
                  <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text"> Manage Customer </span>
            </a>
            <div class="collapse" id="sidebarProducts_user">
               <ul class="nav sub-navbar-nav">
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-customer') }}">Customer List</a>
                     </li>
                     
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-group-category') }}">Manage Group Category</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-group') }}">Manage Group</a>
                     </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebarProducts_orders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts_orders">
               <span class="nav-icon">
                  <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Manage Orders </span>
            </a>
            <div class="collapse" id="sidebarProducts_orders">
               <ul class="nav sub-navbar-nav">
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('order-list') }}">Order</a>
                     </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebarProducts_blogs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts_blogs">
               <span class="nav-icon">
                  <iconify-icon icon="solar:gift-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Manage Blogs </span>
            </a>
            <div class="collapse" id="sidebarProducts_blogs">
               <ul class="nav sub-navbar-nav">
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-blog-category.index') }}">Blog Category</a>
                     </li>
                    
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-blog.index') }}">Blog</a>
                     </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebar_banner" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_banner">
               <span class="nav-icon">
                  <iconify-icon icon="solar:checklist-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Manage Home Section </span>
            </a>
            <div class="collapse" id="sidebar_banner">
               <ul class="nav sub-navbar-nav">
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-banner.index') }}">Banner</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-primary-category.index') }}">Primary Category</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-video.index') }}">Home Video</a>
                     </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebar_whatsapp" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_whatsapp">
               <span class="nav-icon">
                  <iconify-icon icon="solar:chat-round-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Manage Whatsapp </span>
            </a>
            <div class="collapse" id="sidebar_whatsapp">
               <ul class="nav sub-navbar-nav">
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-whatsapp-conversation.index') }}">
                           Make Conversation to Whatsapp
                        </a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-whatsapp.index') }}">
                           Single Whats App
                        </a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('manage-group-whatsapp.index') }}">Group Whats App</a>
                     </li>
                     <li class="sub-nav-item">
                        <a class="sub-nav-link" href="{{ route('social-media-track-list') }}">
                           Social Media Track List
                        </a>
                     </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link menu-arrow" href="#sidebar_landing_page" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_landing_page">
               <span class="nav-icon">
                  <iconify-icon icon="solar:gift-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Manage Landing Page </span>
            </a>
            <div class="collapse" id="sidebar_landing_page">
               <ul class="nav sub-navbar-nav">
                  <li class="sub-nav-item">
                     <a class="sub-nav-link" href="{{ route('manage-landing-page.index') }}">Landing Page</a>
                  </li>
               </ul>
            </div>
         </li>
         
         
         
         <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('manage-customer') }} ">
               <span class="nav-icon">
                  <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">  Manage Customer </span>
            </a>
         </li> -->
      </ul>
   </div>
</div>
<!-- ========== App Menu End ========== -->