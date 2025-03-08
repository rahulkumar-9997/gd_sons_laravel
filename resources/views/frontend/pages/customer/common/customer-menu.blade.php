<div class="col-xxl-3 col-lg-4">
    <div class="dashboard-left-sidebar">
        <div class="close-button d-flex d-lg-none">
            <button class="close-sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="profile-box">
            <div class="cover-image">
                <img
                    src="{{ asset('frontend/assets/images/inner-page/cover-img.jpg') }}"
                    class="img-fluid blur-up lazyload"
                    alt="Default Image">
            </div>
            <div class="profile-contain">
                <div class="profile-image">
                    <div class="position-relative">

                        @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->profile_img)
                        <img
                            src="{{ asset('images/customer/' .Auth::guard('customer')->user()->profile_img) }}"
                            class="blur-up lazyload update_img"
                            alt="Customer Image">
                        <div class="spinner"></div>
                        @else
                        <img
                            src="{{ asset('frontend/assets/images/inner-page/user/1.jpg') }}"
                            class="blur-up lazyload update_img"
                            alt="Default Image">
                        <div class="spinner"></div>
                        @endif

                        <div class="cover-icon">
                            @if(Auth::guard('customer')->check())
                            @php
                            $customerId = Auth::guard('customer')->user()->id;
                            @endphp
                            <i class="fa-solid fa-pen" style="position: relative;">
                                <input type="file" class="profileupdate" data-cuid="{{$customerId}}" data-url="{{ route('upload.profile') }}">
                            </i>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="profile-name">
                    <h3>{{ Auth::guard('customer')->user()->name }}</h3>
                    <h6 class="text-content">{{ Auth::guard('customer')->user()->email }}</h6>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('myaccount') }}" class="nav-link {{ Request::routeIs('myaccount') ? 'active' : '' }}">
                    <i data-feather="home"></i> DashBoard
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('order') }}" class="nav-link {{ Request::routeIs('order') ? 'active' : '' }}">
                    <i data-feather="shopping-bag"></i> Order
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('wishlist') }}" class="nav-link {{ Request::routeIs('wishlist') ? 'active' : '' }}">
                    <i data-feather="heart"></i> Wishlist
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('address') }}" class="nav-link {{ Request::routeIs('address') ? 'active' : '' }}">
                    <i data-feather="map-pin"></i> Manage Addresses
                </a>
            </li>
            
            <li class="nav-item" role="presentation">
                <!-- {{ route('customer-profile') }} -->
                <a href="#" class="nav-link {{ Request::routeIs('customer-profile') ? 'active' : '' }}">
                    <i data-feather="user"></i> Manage Profile
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <form action="{{ route('customer.logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button class="nav-link" id="pills-security-tab" type="submit" role="tab">
                        <i data-feather="shield"></i> Logout
                    </button>
                </form>
            </li>

        </ul>
    </div>
</div>