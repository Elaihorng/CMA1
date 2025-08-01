 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
      <img src="{{asset('backend/dist/img/avatar4.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin CMA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      {{-- <div class="image d-flex justify-content-center">
        <img src="{{asset('backend/dist/img/avatar4.png')}}" class="img-circle elevation-2" alt="User Image" style="width: 50px; height: 50px;">
      </div> --}}
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-start">
        <div class="d-flex justify-content-between w-100">
            <!-- Username -->
            <span class="d-block text-white mb-1">ADMIN: {{ session('username') }}</span>
    
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger ms-3">Logout</button>
            </form>
        </div>
    </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{url('/dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/dashboard')}}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
             
            </ul>
          </li>
          <li class="nav-item {{ request()->is('product') || request()->is('admin/bookings') || request()->is('order') || request()->is('review') || request()->is('stocks*') || request()->is('user')? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('product') || request()->is('admin/bookings') || request()->is('order') || request()->is('review')|| request()->is('stocks') || request()->is('user')? 'active' : '' }}">
              <i class="fas fa-cog"></i>
              <p>
                Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/user')}}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                  <i class="fas fa-users"></i>
                  <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/product')}}" class="nav-link {{ request()->is('product') ? 'active' : '' }}">
                  <i class="fab fa-product-hunt"></i>
                  <p>Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/stocks')}}" class="nav-link {{ request()->is('stocks') ? 'active' : '' }}">
                  <i class="fas fa-store"></i>
                  <p>Stock In/Out</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/bookings')}}" class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                  <i class="fas fa-inbox"></i>
                  <p>MailBox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/order')}}" class="nav-link {{ request()->is('order*') ? 'active' : '' }}">
                  <i class="fas fa-store-slash"></i>
                  <p>ordered</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/review') }}" class="nav-link {{ request()->is('review*') ? 'active' : '' }}">
                    <i class="far fa-star nav-icon"></i>
                    <p>Review Product</p>
                </a>
            </li>
            
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>