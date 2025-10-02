<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FixIt') }}</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-wrench brand-image"></i>
            <span class="brand-text font-weight-light">FixIt</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('service-requests.index') }}" class="nav-link {{ request()->routeIs('service-requests.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Service Requests</p>
                        </a>
                    </li>

                    @if(Auth::user()->role === 'User')
                    <li class="nav-item">
                        <a href="{{ route('service-requests.create') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>New Request</p>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->isAdmin() || Auth::user()->isTechnician())
                    <li class="nav-item">
                        <a href="{{ route('work-orders.index') }}" class="nav-link {{ request()->routeIs('work-orders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Work Orders</p>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('technicians.index') }}" class="nav-link {{ request()->routeIs('technicians.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-hard-hat"></i>
                            <p>Technicians</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="#">FixIt</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>