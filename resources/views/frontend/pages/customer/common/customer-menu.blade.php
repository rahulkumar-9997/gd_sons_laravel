<div class="col-xxl-3 col-lg-4">
    <div class="dashboard-left-sidebar bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="close-button d-flex d-lg-none justify-content-end p-4">
            <button class="close-sidebar text-gray-400 hover:text-gray-600 text-2xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="profile-box px-3 pt-5 pb-4">
            <div class="profile-contain">
                <div class="profile-image flex justify-center">
                    <div class="relative inline-block">
                        @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->profile_img)
                            <img
                                src="{{ asset('images/customer/' .Auth::guard('customer')->user()->profile_img) }}"
                                class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover blur-up lazyload update_img"
                                alt="Customer"
                            >
                            <div class="spinner hidden"></div>
                        @else
                            <div class="w-28 h-28 rounded-full border-4 border-white shadow-lg bg-primary-teal flex items-center justify-center text-white text-4xl font-bold">
                                {{ strtoupper(substr(Auth::guard('customer')->user()->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div class="absolute bottom-1 right-1 bg-primary-navy rounded-full p-2 shadow-lg border-2 border-white hover:bg-indigo-700 transition cursor-pointer">
                            @if(Auth::guard('customer')->check())
                                @php
                                    $customerId = Auth::guard('customer')->user()->id;
                                @endphp
                                <label class="cursor-pointer text-white">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                    <input type="file" class="profileupdate hidden" data-cuid="{{$customerId}}" data-url="{{ route('upload.profile') }}">
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="profile-name text-center mt-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ Auth::guard('customer')->user()->name ?? 'User' }}</h3>
                    <h6 class="text-sm text-gray-500 mt-1">{{ Auth::guard('customer')->user()->email ?? '' }}</h6>
                    
                </div>
            </div>
        </div>
        <ul class="nav nav-pills user-nav-pills flex flex-col space-y-1 p-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('myaccount') }}" 
                   class="flex items-center gap-3 px-2 py-2 rounded-xl text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 group {{ Request::routeIs('myaccount') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : '' }}">
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ Request::routeIs('myaccount') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-700' }} transition">
                        <i data-feather="home" class="w-4 h-4"></i>
                    </span>
                    <span>Dashboard</span>
                    @if(Request::routeIs('myaccount'))
                        <span class="ml-auto w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    @endif
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <a href="{{ route('order') }}" 
                   class="flex items-center gap-3 px-2 py-2 rounded-xl text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 group {{ Request::routeIs('order') ? 'bg-primary-teal-50 text-indigo-700 font-semibold shadow-sm' : '' }}">
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ Request::routeIs('order') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-700' }} transition">
                        <i data-feather="shopping-bag" class="w-4 h-4"></i>
                    </span>
                    <span>Orders</span>
                    @if(Request::routeIs('order'))
                        <span class="ml-auto w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    @endif
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <a href="{{ route('wishlist') }}" 
                   class="flex items-center gap-3 px-2 py-2 rounded-xl text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 group {{ Request::routeIs('wishlist') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : '' }}">
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ Request::routeIs('wishlist') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-700' }} transition">
                        <i data-feather="heart" class="w-4 h-4"></i>
                    </span>
                    <span>Wishlist</span>
                    @if(Request::routeIs('wishlist'))
                        <span class="ml-auto w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    @endif
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <a href="{{ route('address') }}" 
                   class="flex items-center gap-3 px-2 py-2 rounded-xl text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 group {{ Request::routeIs('address') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : '' }}">
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ Request::routeIs('address') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-700' }} transition">
                        <i data-feather="map-pin" class="w-4 h-4"></i>
                    </span>
                    <span>Manage Addresses</span>
                    @if(Request::routeIs('address'))
                        <span class="ml-auto w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    @endif
                </a>
            </li>
            
            <!--<li class="nav-item" role="presentation">
                <a href="#" 
                   class="flex items-center gap-3 px-2 py-2 rounded-xl text-gray-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200 group {{ Request::routeIs('customer-profile') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : '' }}">
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ Request::routeIs('customer-profile') ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-indigo-100 group-hover:text-indigo-700' }} transition">
                        <i data-feather="user" class="w-4 h-4"></i>
                    </span>
                    <span>Manage Profile</span>
                    @if(Request::routeIs('customer-profile'))
                        <span class="ml-auto w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    @endif
                </a>
            </li>-->
            <li class="nav-item relative my-2">
                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
            </li>            
            <li class="nav-item" role="presentation">
                <form action="{{ route('customer.logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-3 w-full text-left px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 group-hover:bg-red-100 group-hover:text-red-600 transition">
                            <i data-feather="log-out" class="w-4 h-4"></i>
                        </span>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>