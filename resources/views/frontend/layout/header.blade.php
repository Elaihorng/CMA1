
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->


<!-- Topbar Start -->
<div class="container-fluid bg-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                <small>23st, Phnom Penh,Toul Tompong blvd Cambodia</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center py-3">
                <small class="far fa-clock text-primary me-2"></small>
                <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <small class="fa fa-phone-alt text-primary me-2"></small>
                <small>+012 345 6789</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center">
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                <div class="h-100 d-inline-flex align-items-center">
                    <div class="info">
                        @if (session('username'))
                            <a href="#" class="d-block" id="toggleProfile">{{ session('username') }}</a> <!-- Profile link -->
                            
                            <!-- Sidebar Profile Panel -->
                            <div id="profileSidebar" class="profile-sidebar">
                                <div class="profile-content p-3 d-flex flex-column" style="height: 100%;">
                            
                                    <!-- Close Button -->
                                    <button id="closeProfile" class="btn btn-sm btn-danger align-self-end">×</button>
                            
                                    <!-- Profile Image -->
                                    <div class="text-center mt-4">
                                        <img class="profile-user-img img-fluid img-circle"
                                             src={{ asset('backend/dist/img/avatar.png') }}
                                             alt="User profile picture"
                                             style="width: 80px; height: 80px;">
                                    </div>
                            
                                    <!-- Profile Name -->
                                    <h4 class="profile-username text-center mt-2">username: {{ session('username') }}</h4>
                                    <p class="text-muted text-center">CMA'S customer</p>
                            
                                    <!-- Links Section: History and My Booking on the same row -->
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="{{ url('/orders') }}" class="d-block">
                                            History
                                        </a>
                            
                                        <!-- My Booking Link (if exists) -->
                                        @php
                                            $latestBooking = Auth::user()->bookings()->latest()->first();
                                        @endphp
                                        @if($latestBooking)
                                            <a href="{{ route('booking.show', $latestBooking->id) }}" class="d-block">
                                                My Booking
                                            </a>
                                        @endif
                                    </div>
                            
                                    <!-- Logout Button -->
                                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                        @else
                            <a href="{{ route('login') }}" class="d-block">Guest</a>
                        @endif
                    </div>
                    
                </div>
                
                
            
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{url('/')}}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary">
            {{-- <i class="fa fa-car me-3"></i>CTM --}}
            <img src="{{ asset('/img/Logo-CMA2-01.png') }}" alt="CTM Logo" class="logo me-3" style="max-width: 80px; height: auto;">
            CMA
        </h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{url('/')}}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{url('/about')}}" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">About Us</a>
            <a href="{{url('/services')}}" class="nav-item nav-link {{ request()->is('services') ? 'active' : '' }}">Services</a>
            <a href="{{url('/products')}}" class="nav-item nav-link {{ request()->is('products') ? 'active' : '' }}">Products</a>
            <a href="{{url('/booking')}}" class="nav-item nav-link {{ request()->is('booking') ? 'active' : '' }}">Booking</a>
            <a href="{{url('/contact')}}" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            
        </div>
        
        <a href="{{ url('/cart') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
            Cart<i class="fas fa-cart-plus ms-3"></i> <span id="cart-count" class="badge">{{ session()->get('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
            
        </a>
        
        
        
    </div>
</nav>
<script>
    document.getElementById("toggleProfile").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("profileSidebar").classList.add("active");
    });

    document.getElementById("closeProfile").addEventListener("click", function() {
        document.getElementById("profileSidebar").classList.remove("active");
    });
</script>

<!-- Navbar End -->