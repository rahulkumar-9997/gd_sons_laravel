<header class="topbar">
   <div class="container-fluid">
      <div class="navbar-header">
         <div class="d-flex align-items-center">
            <!-- Menu Toggle Button -->
            <div class="topbar-item">
               <button type="button" class="button-toggle-menu me-2">
                  <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
               </button>
            </div>
            <div class="topbar-item">
               <h4 class="fw-bold topbar-button pe-none mb-0 d-flex align-items-center">
                  @php
                     $hour = now()->hour;
                     if ($hour >= 5 && $hour < 12) {
                        $greeting = 'Good Morning';
                        $icon = 'solar:sun-fog-bold-duotone';
                        $color = 'warning';
                        $emoji = '🌅';
                     } elseif ($hour >= 12 && $hour < 17) {
                        $greeting = 'Good Afternoon';
                        $icon = 'solar:sun-2-bold-duotone';
                        $color = 'warning';
                        $emoji = '☀️';
                     } elseif ($hour >= 17 && $hour < 21) {
                        $greeting = 'Good Evening';
                        $icon = 'solar:cloud-sun-2-bold-duotone';
                        $color = 'info';
                        $emoji = '🌆';
                     } else {
                        $greeting = 'Good Night';
                        $icon = 'solar:moon-stars-bold-duotone';
                        $color = 'primary';
                        $emoji = '🌙';
                     }
                  @endphp
                  <span class="badge bg-warning text-white px-3 py-2 me-3 rounded-pill">
                     <i class="bx bx-bell me-1"></i> {{ now()->format('l') }}
                  </span>
                  <div class="d-flex align-items-center bg-light px-3 py-2 rounded-3">
                     <iconify-icon icon="{{ $icon }}" class="fs-26 me-2 text-{{ $color }}"></iconify-icon>
                     <span class="fw-semibold text-dark">{{ $greeting }},</span>
                     <span class="fw-bold text-success mx-1">{{ auth()->user()->name ?? 'Guest' }}</span>
                     <span class="ms-2">{{ $emoji }}</span>
                  </div>
                  <span class="badge bg-orange text-white px-3 py-2 ms-3 rounded-pill"  id="live-time">
                     <i class="bx bx-time me-1"></i> {{ now()->format('h:i A') }}
                  </span>
               </h4>
            </div>
         </div>
         <div class="d-flex align-items-center gap-1">
            <a class="btn btn-outline-info" href="{{route('show.tables')}}">Database</a>
            <a class="btn btn-outline-purple" href="{{route('clear-cache')}}">Clear cache</a>
            <!-- Notification -->
            <!-- <div class="dropdown topbar-item">
               <button type="button" class="topbar-button position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <iconify-icon icon="solar:bell-bing-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                  <span class="position-absolute topbar-badge fs-10 translate-middle badge bg-danger rounded-pill">3<span class="visually-hidden">unread messages</span></span>
               </button>
               <div class="dropdown-menu py-0 dropdown-lg dropdown-menu-end" aria-labelledby="page-header-notifications-dropdown">
                  <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                     <div class="row align-items-center">
                        <div class="col">
                           <h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
                        </div>
                        <div class="col-auto">
                           <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                           <small>Clear All</small>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div data-simplebar style="max-height: 280px;">
                     <a href="javascript:void(0);" class="dropdown-item py-3 border-bottom text-wrap">
                        <div class="d-flex">
                           <div class="flex-shrink-0">
                              <img src="" class="img-fluid me-2 avatar-sm rounded-circle" alt="avatar-1" />
                           </div>
                           <div class="flex-grow-1">
                              <p class="mb-0"><span class="fw-medium">Josephine Thompson </span>commented on admin panel <span>" Wow 😍! this admin looks good and awesome design"</span></p>
                           </div>
                        </div>
                     </a>                     
                  </div>
                  <div class="text-center py-3">
                     <a href="javascript:void(0);" class="btn btn-primary btn-sm">View All Notification <i class="bx bx-right-arrow-alt ms-1"></i></a>
                  </div>
               </div>
            </div>
            -->
            
            <!-- User -->
            <div class="dropdown topbar-item">
               <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="d-flex align-items-center">
                     
                  @php
                     $user = Auth::user();
                  @endphp

                  @if($user->profile_img)
                     <img
                        src="{{ asset('profile-images/'.Auth::user()->profile_img) }}"
                        alt="{{ $user->name }}"
                        class="rounded-circle"
                        width="32"
                        height="32"
                        style="object-fit: cover;"
                     >
                  @else
                     <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=#ffff&background=#790000"
                        alt="{{ $user->name }}"
                        class="rounded-circle"
                        width="32"
                        height="32"
                        style="object-fit: cover;"
                     >
                  @endif
                  
               </span>
               
               </a>
               <div class="dropdown-menu dropdown-menu-end">
                  <!-- item-->
                  <h6 class="dropdown-header">
                     Welcome {{auth()->user()->name ?? ''}}!
                  </h6>
                  <a class="dropdown-item" href="{{route('profile')}}">
                  <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span class="align-middle">Profile</span>
                  </a>
                  <div class="dropdown-divider my-1"></div>
                  <a class="dropdown-item text-danger" href="{{route('logout')}}">
                  <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle">Logout</span>
                  </a>
               </div>
            </div>
            
            </form>
         </div>
      </div>
   </div>
</header>

@push('scripts')
<script>
    function updateTime() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM'; 
        hours = hours % 12;
        hours = hours ? hours : 12; 
        const formattedMinutes = minutes.toString().padStart(2, '0');
        const formattedSeconds = seconds.toString().padStart(2, '0');
        
        const timeString = `${hours}:${formattedMinutes}:${formattedSeconds} ${ampm}`;
        
        document.getElementById('live-time').innerHTML = `<i class="bx bx-time me-1"></i> ${timeString}`;
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
@endpush