<div class="col-xxl-3 col-lg-4">
    <div class="dashboard-left-sidebar bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="close-button d-flex d-lg-none justify-content-end p-4">
            <button class="close-sidebar text-gray-400 hover:text-gray-600 text-2xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="profile-box p-2">
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
        <ul class="nav nav-pills user-nav-pills flex flex-col space-y-1 p-4">
            <li>
                <a href="{{ route('myaccount') }}"
                    class="flex items-center gap-3 lg:px-4 lg:py-3 sm:px-4 sm:py-3 rounded-xl transition-all duration-200 group
                    {{ Request::routeIs('myaccount')
                        ? 'bg-primary-mint text-primary-navy font-semibold border-l-4 border-primary-cyan shadow-sm'
                        : 'text-textcolor-secondary hover:bg-primary-mint hover:text-primary-navy' }}">

                    <span class="w-9 h-9 flex items-center justify-center rounded-lg transition
                    {{ Request::routeIs('myaccount')
                        ? 'bg-white text-primary-cyan'
                        : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-primary-cyan' }}">
                        <i data-feather="home" class="w-4 h-4"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('order') }}"
                    class="flex items-center gap-3 lg:px-4 lg:py-3 sm:px-4 sm:py-3 rounded-xl transition-all duration-200 group
                    {{ Request::routeIs('order')
                        ? 'bg-primary-mint text-primary-navy font-semibold border-l-4 border-primary-cyan shadow-sm'
                        : 'text-textcolor-secondary hover:bg-primary-mint hover:text-primary-navy' }}">

                    <span class="w-9 h-9 flex items-center justify-center rounded-lg transition
                    {{ Request::routeIs('order')
                        ? 'bg-white text-primary-cyan'
                        : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-primary-cyan' }}">
                        <i data-feather="shopping-bag" class="w-4 h-4"></i>
                    </span>
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wishlist') }}"
                    class="flex items-center gap-3 lg:px-4 lg:py-3 sm:px-4 sm:py-3 rounded-xl transition-all duration-200 group
                    {{ Request::routeIs('wishlist')
                        ? 'bg-primary-mint text-primary-navy font-semibold border-l-4 border-primary-cyan shadow-sm'
                        : 'text-textcolor-secondary hover:bg-primary-mint hover:text-primary-navy' }}">

                    <span class="w-9 h-9 flex items-center justify-center rounded-lg transition
                    {{ Request::routeIs('wishlist')
                        ? 'bg-white text-primary-cyan'
                        : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-primary-cyan' }}">
                        <i data-feather="heart" class="w-4 h-4"></i>
                    </span>
                    <span>Wishlist</span>
                </a>
            </li>
            <li>
                <a href="{{ route('address') }}"
                    class="flex items-center gap-3 lg:px-4 lg:py-3 sm:px-4 sm:py-3 rounded-xl transition-all duration-200 group
                    {{ Request::routeIs('address')
                        ? 'bg-primary-mint text-primary-navy font-semibold border-l-4 border-primary-cyan shadow-sm'
                        : 'text-textcolor-secondary hover:bg-primary-mint hover:text-primary-navy' }}">

                    <span class="w-9 h-9 flex items-center justify-center rounded-lg transition
                    {{ Request::routeIs('address')
                        ? 'bg-white text-primary-cyan'
                        : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-primary-cyan' }}">
                        <i data-feather="map-pin" class="w-4 h-4"></i>
                    </span>
                    <span>Manage Addresses</span>
                </a>
            </li>
            <li class="my-2">
                <div class="h-px bg-gray-200"></div>
            </li>
            <li>
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full lg:px-4 lg:py-3 sm:px-4 sm:py-3 rounded-xl text-textcolor-secondary hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">

                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 group-hover:bg-red-100 group-hover:text-red-600 transition">
                            <i data-feather="log-out" class="w-4 h-4"></i>
                        </span>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>