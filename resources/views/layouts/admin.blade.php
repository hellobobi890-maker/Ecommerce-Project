<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4e73df;
            --dark-bg: #1a1c23;
            --light-bg: #f8f9fc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--dark-bg);
            color: #fff;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-item {
            padding: 0.5rem 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            text-decoration: none;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .page-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-shopping-bag me-2 text-primary"></i> Admin
        </div>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}"
                    class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li class="nav-item mt-auto">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link d-md-none me-3" id="sidebarToggle">
                    <i class="fas fa-bars fa-lg text-dark"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown user-dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                            style="width: 35px; height: 35px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="d-none d-md-block fw-medium">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                    class="fas fa-user me-2 text-muted"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i
                                        class="fas fa-sign-out-alt me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>
