<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'AdminST5 | Dashboard')</title>
  
  <!-- Include Styles -->
  @include('backend.layout.stylesshop')
  
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">
</head>
<body class="@yield('body_class', 'hold-transition sidebar-mini layout-fixed')">
<div class="wrapper">

  <!-- Header -->
  @include('backend.layout.header')

  <!-- Main Content -->
  @yield('content')

  <!-- Footer -->
  @include('backend.layout.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    @include('backend.layout.leftsidebar')
    
  </aside>
  
</div>
<!-- ./wrapper -->

<!-- Include Scripts -->
@include('backend.layout.jsshop')
</body>
</html>
