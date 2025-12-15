<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts - Outfit (Modern & Clean) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        :root {
            /* Modern Vibrant Theme - Coral & Purple */
            --primary-color: #f97316;
            --primary-dark: #ea580c;
            --primary-light: #fb923c;
            --secondary-color: #1e1b4b;
            --accent-color: #8b5cf6;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #fbbf24;
            --info-color: #06b6d4;

            /* Neutral Colors */
            --text-dark: #1e1b4b;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --bg-light: #faf5ff;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;

            /* Vibrant Gradients */
            --gradient-primary: linear-gradient(135deg, #f97316 0%, #ec4899 50%, #8b5cf6 100%);
            --gradient-dark: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            --gradient-hero: linear-gradient(135deg, #f97316 0%, #ec4899 50%, #8b5cf6 100%);
        }

        * {
            font-family: 'Outfit', sans-serif !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
        }

        /* Override Bootstrap Primary */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        /* Header Container */
        .header-wrapper {
            background: #0b1220;
            box-shadow: 0 10px 40px rgba(2, 6, 23, 0.25);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Top Bar */
        .top-bar {
            background: rgba(255, 255, 255, 0.04);
            font-size: 0.85rem;
            font-weight: 400;
        }

        .top-bar a:hover {
            color: var(--primary-light) !important;
        }

        /* Main Header */
        .main-header {
            background: transparent;
            transition: all 0.3s ease;
        }

        .header-wrapper.sticky-top .main-header {
            backdrop-filter: saturate(180%) blur(10px);
        }

        /* Logo */
        .brand-logo {
            font-weight: 800;
            font-size: 1.75rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-logo .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);
        }

        .brand-logo .logo-text {
            color: #ffffff;
        }

        .brand-logo .logo-text span {
            color: var(--primary-color);
        }

        /* Nav Links */
        .nav-link-custom {
            font-weight: 500;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.92) !important;
            padding: 0.75rem 1.25rem !important;
            position: relative;
            transition: color 0.3s ease;
            border-radius: 8px;
            text-decoration: none;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--primary-color) !important;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Search Box */
        .search-box-wrapper {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .search-box-wrapper input {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 14px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.92);
        }

        .search-box-wrapper input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 59, 107, 0.22);
            background: rgba(255, 255, 255, 0.10);
        }

        .search-box-wrapper .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.70);
        }

        .search-box-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.65);
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            z-index: 1050;
            display: none;
            margin-top: 0.5rem;
            overflow: hidden;
            max-height: 400px;
            overflow-y: auto;
        }

        .search-suggestions.show {
            display: block;
        }

        .search-suggestion-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: background 0.2s;
            text-decoration: none;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
        }

        .search-suggestion-item:last-child {
            border-bottom: none;
        }

        .search-suggestion-item:hover {
            background: var(--bg-light);
        }

        .search-suggestion-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Action Icons */
        .header-action {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.92);
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            border: none;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.25);
        }

        .header-action:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.05);
        }

        .header-action .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
            padding: 0.25rem 0.45rem;
            background: var(--danger-color);
            border: 2px solid white;
        }

        /* User Dropdown */
        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.92);
            transition: all 0.3s ease;
        }

        .user-dropdown-btn:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Footer */
        .footer-section {
            background: var(--gradient-dark);
        }

        .footer-title {
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            padding: 0.25rem 0;
        }

        .footer-link:hover {
            color: var(--primary-light);
            padding-left: 8px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
            color: white;
        }

        /* Notification Toast */
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Alert Custom */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            border-radius: 12px;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .dropdown-item:hover {
            background: var(--bg-light);
        }

        .mobile-search-toggle {
            display: none;
        }

        @media (max-width: 991.98px) {
            .mobile-search-toggle {
                display: inline-flex;
            }

            .mobile-search-bar {
                padding: 0.75rem 0;
                border-top: 1px solid var(--border-color);
                background: var(--bg-white);
            }

            .mobile-search-bar .search-box-wrapper {
                max-width: 100%;
            }
        }

        .qv-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .qv-rating {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #f59e0b;
        }

        .qv-thumb-arrow {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.12);
            box-shadow: 0 10px 22px rgba(2, 6, 23, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.15s ease, background 0.15s ease, color 0.15s ease;
        }

        .qv-thumb-arrow:hover {
            transform: translateY(-1px);
            background: var(--primary-color);
            color: #fff;
            border-color: transparent;
        }

        @media (max-width: 575.98px) {
            #quickViewModal .qv-meta-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            #quickViewModal #qv-add-to-cart-form .d-flex.flex-nowrap {
                gap: 10px !important;
            }

            #quickViewModal #qv-add-to-cart-form .btn.btn-primary {
                font-size: 0.95rem;
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Header Wrapper -->
    <div class="header-wrapper sticky-top">
        <!-- Top Bar -->
        <div class="top-bar text-white py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4">
                    <span><i class="bi bi-truck me-2"></i>Free Delivery on PKR 2000+</span>
                    <span class="d-none d-lg-inline"><i class="bi bi-telephone me-2"></i>+92 300 1234567</span>
                </div>
                <div class="d-none d-md-flex gap-4">
                    <a href="{{ route('pages.about') }}" class="text-white text-decoration-none">About</a>
                    <a href="{{ route('pages.contact') }}" class="text-white text-decoration-none">Contact</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="text-white text-decoration-none">Track Order</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <header class="main-header">
            <div class="container py-3">
                <div class="d-flex align-items-center justify-content-between gap-4">
                    <!-- Logo -->
                    <a class="brand-logo" href="{{ route('home') }}">
                        <div class="logo-icon">
                            <i class="bi bi-bag-heart-fill"></i>
                        </div>
                        <div class="logo-text d-none d-sm-block">
                            {{ config('app.name', 'E') }}<span>Shop</span>
                        </div>
                    </a>

                    <!-- Search (Desktop) -->
                    <div class="search-box-wrapper d-none d-lg-block">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="searchInput" placeholder="Search products..." autocomplete="off">
                        <div class="search-suggestions" id="searchSuggestions"></div>
                    </div>

                    <!-- Navigation (Desktop) -->
                    <nav class="d-none d-xl-flex align-items-center gap-1">
                        <a href="{{ route('home') }}"
                            class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('shop.index') }}"
                            class="nav-link-custom {{ request()->routeIs('shop.*') && !request('category') ? 'active' : '' }}">Shop</a>
                        @php
                            $womenCat = \App\Models\Category::where('slug', 'women')->first();
                            $menCat = \App\Models\Category::where('slug', 'men')->first();
                        @endphp
                        <a href="{{ route('shop.index', ['category' => $womenCat->id ?? 2]) }}"
                            class="nav-link-custom {{ request('category') == ($womenCat->id ?? 2) ? 'active' : '' }}">Women</a>
                        <a href="{{ route('shop.index', ['category' => $menCat->id ?? 1]) }}"
                            class="nav-link-custom {{ request('category') == ($menCat->id ?? 1) ? 'active' : '' }}">Men</a>
                        <a href="{{ route('pages.contact') }}" class="nav-link-custom">Contact</a>
                    </nav>

                    <!-- Actions -->
                    <div class="d-flex align-items-center gap-2">
                        <button class="header-action mobile-search-toggle" type="button" data-bs-toggle="collapse"
                            data-bs-target="#mobileSearchCollapse" aria-controls="mobileSearchCollapse"
                            aria-expanded="false" title="Search">
                            <i class="bi bi-search fs-5"></i>
                        </button>

                        <a href="{{ route('wishlist.index') }}" class="header-action d-none d-md-flex"
                            title="Wishlist">
                            <i class="bi bi-heart fs-5"></i>
                        </a>

                        <a href="{{ route('cart.index') }}" class="header-action" id="cart-icon-container"
                            title="Cart">
                            <i class="bi bi-bag fs-5"></i>
                            @php
                                $cartCount = 0;
                                foreach (session('cart', []) as $item) {
                                    $cartCount += $item['quantity'] ?? 1;
                                }
                            @endphp
                            <span class="badge rounded-pill" id="cart-badge">{{ $cartCount }}</span>
                        </a>

                        @auth
                            <div class="dropdown">
                                <a href="#" class="user-dropdown-btn dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="user-avatar-small">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                    <span
                                        class="d-none d-lg-inline fw-medium">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-2">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                                class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i
                                                class="bi bi-box-seam me-2"></i>My Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                                class="bi bi-gear me-2"></i>Settings</a></li>
                                    @if (Auth::user()->isAdmin())
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-primary"
                                                href="{{ route('admin.dashboard') }}"><i
                                                    class="bi bi-shield-check me-2"></i>Admin Panel</a></li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i
                                                    class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-primary rounded-pill px-4 py-2 d-none d-md-inline-flex">
                                <i class="bi bi-person me-2"></i>Login
                            </a>
                            <a href="{{ route('login') }}" class="header-action d-md-none">
                                <i class="bi bi-person fs-5"></i>
                            </a>
                        @endauth

                        <!-- Mobile Menu Toggle -->
                        <button class="header-action d-xl-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#mobileMenu">
                            <i class="bi bi-list fs-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="collapse" id="mobileSearchCollapse">
            <div class="container mobile-search-bar">
                <div class="search-box-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="searchInputMobile" placeholder="Search products..."
                        autocomplete="off">
                    <div class="search-suggestions" id="searchSuggestionsMobile"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <!-- Mobile Nav -->
            <nav class="nav flex-column gap-2">
                <a href="{{ route('home') }}"
                    class="nav-link px-3 py-2 rounded {{ request()->routeIs('home') ? 'bg-primary text-white' : '' }}">
                    <i class="bi bi-house me-2"></i>Home
                </a>
                <a href="{{ route('shop.index') }}"
                    class="nav-link px-3 py-2 rounded {{ request()->routeIs('shop.*') && !request('category') ? 'bg-primary text-white' : '' }}">
                    <i class="bi bi-grid me-2"></i>Shop
                </a>
                <a href="{{ route('shop.index', ['category' => $womenCat->id ?? 2]) }}"
                    class="nav-link px-3 py-2 rounded {{ request('category') == ($womenCat->id ?? 2) ? 'bg-primary text-white' : '' }}">
                    <i class="bi bi-gender-female me-2"></i>Women
                </a>
                <a href="{{ route('shop.index', ['category' => $menCat->id ?? 1]) }}"
                    class="nav-link px-3 py-2 rounded {{ request('category') == ($menCat->id ?? 1) ? 'bg-primary text-white' : '' }}">
                    <i class="bi bi-gender-male me-2"></i>Men
                </a>
                <a href="{{ route('wishlist.index') }}" class="nav-link px-3 py-2 rounded">
                    <i class="bi bi-heart me-2"></i>Wishlist
                </a>
                <a href="{{ route('pages.about') }}" class="nav-link px-3 py-2 rounded">
                    <i class="bi bi-info-circle me-2"></i>About Us
                </a>
                <a href="{{ route('pages.contact') }}" class="nav-link px-3 py-2 rounded">
                    <i class="bi bi-envelope me-2"></i>Contact
                </a>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-section text-white pt-5 mt-auto">
        <div class="container pb-5">
            <div class="row g-4 g-lg-5">
                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <a class="brand-logo mb-3 d-inline-flex" href="{{ route('home') }}">
                        <div class="logo-icon">
                            <i class="bi bi-bag-heart-fill"></i>
                        </div>
                        <div class="logo-text">
                            <span class="text-white">{{ config('app.name') }}</span>
                        </div>
                    </a>
                    <p class="text-white-50 mb-4" style="line-height: 1.8;">
                        Premium quality products at best prices. Your satisfaction is our priority!
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Shop Links -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">Shop</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('shop.index') }}" class="footer-link">All Products</a></li>
                        <li><a href="{{ route('shop.index', ['sort' => 'newest']) }}" class="footer-link">New
                                Arrivals</a></li>
                        <li><a href="{{ route('shop.index') }}" class="footer-link">Featured</a></li>
                        <li><a href="{{ route('shop.index') }}" class="footer-link">Best Sellers</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">Support</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('pages.contact') }}" class="footer-link">Contact Us</a></li>
                        <li><a href="{{ route('pages.about') }}" class="footer-link">About Us</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="footer-link">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.return-policy') }}" class="footer-link">Returns</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-title">Newsletter</h6>
                    <p class="text-white-50 small mb-3">Get updates on new products and offers.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletterForm">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email"
                                class="form-control bg-white bg-opacity-10 border-0 text-white"
                                placeholder="Your email" required style="padding: 0.75rem 1rem;">
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-top border-white border-opacity-10 py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <span class="text-white-50 small">
                            &copy; {{ date('Y') }} <strong class="text-white">{{ config('app.name') }}</strong>.
                            All rights reserved.
                        </span>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3 text-white-50">
                            <i class="bi bi-credit-card fs-4"></i>
                            <i class="bi bi-cash-stack fs-4"></i>
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="p-3 h-100 d-flex flex-column">
                                <div class="main-image-container mb-3 flex-grow-1 bg-light rounded-3 overflow-hidden position-relative"
                                    style="height: 520px;" id="qv-zoom-container">
                                    <img id="qv-main-image" src="" alt="Product" class="w-100 h-100"
                                        style="object-fit: cover; cursor: zoom-in;">
                                    <!-- Zoom Result Window - positioned as overlay inside container -->
                                    <div id="qv-zoom-result" class="position-absolute d-none"
                                        style="width: 250px; height: 250px; background-repeat: no-repeat; border: 3px solid var(--primary-color); border-radius: 12px; box-shadow: 0 15px 50px rgba(0,0,0,0.35); z-index: 100; top: 10px; right: 10px; background-color: white;">
                                    </div>
                                </div>
                                <div class="thumbnails-container d-flex align-items-center gap-2">
                                    <button class="btn qv-thumb-arrow prev-thumb" type="button">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <div class="thumbnail-slider flex-grow-1 d-flex gap-2 overflow-auto"
                                        id="qv-thumbnails" style="scroll-behavior: smooth;"></div>
                                    <button class="btn qv-thumb-arrow next-thumb" type="button">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-4">
                                <h2 class="fw-bold mb-2" id="qv-title">Product</h2>

                                <div class="qv-meta-row">
                                    <div>
                                        <span class="fs-3 fw-bold text-primary me-2" id="qv-price">PKR0.00</span>
                                        <span class="text-muted text-decoration-line-through"
                                            id="qv-old-price"></span>
                                        <span class="ms-2 badge bg-success bg-opacity-10 text-success"
                                            id="qv-discount-badge"></span>
                                    </div>
                                    <div class="qv-rating">
                                        <span class="d-inline-flex">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </span>
                                        <span class="text-muted" style="font-size: 0.9rem;">(21)</span>
                                    </div>
                                </div>

                                <p class="text-secondary mb-4" id="qv-description"></p>

                                <div class="d-flex flex-column gap-2 mb-4 text-muted small">
                                    <div><i class="bi bi-shield-check text-success me-2"></i> 1 Year Brand Warranty
                                    </div>
                                    <div><i class="bi bi-arrow-repeat text-danger me-2"></i> 30 Day Return Policy</div>
                                    <div><i class="bi bi-cash-stack text-warning me-2"></i> Cash on Delivery available
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div id="qv-color-wrap" class="mb-3 d-none">
                                        <label class="form-label fw-semibold mb-2">Color: <span
                                                id="qv-selected-color-text"></span></label>
                                        <div id="qv-colors" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                    <div id="qv-size-wrap" class="mb-3 d-none">
                                        <label class="form-label fw-semibold mb-2">Size: <span
                                                id="qv-selected-size-text"></span></label>
                                        <div id="qv-sizes" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <form id="qv-add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" id="qv-product-id">
                                    <input type="hidden" name="color" id="qv-selected-color" value="">
                                    <input type="hidden" name="size" id="qv-selected-size" value="">

                                    <div class="d-flex flex-nowrap align-items-center gap-3">
                                        <div class="d-flex align-items-center border rounded-pill overflow-hidden"
                                            style="height: 44px; min-width: 150px;">
                                            <button class="btn btn-link text-dark px-3" type="button"
                                                onclick="decrementQv()"><i class="bi bi-dash"></i></button>
                                            <input type="number" class="form-control border-0 text-center"
                                                name="quantity" id="qv-quantity" value="1" min="1"
                                                style="width: 64px;">
                                            <button class="btn btn-link text-dark px-3" type="button"
                                                onclick="incrementQv()"><i class="bi bi-plus"></i></button>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg fw-bold flex-grow-1"
                                            style="height: 44px; white-space: nowrap;">
                                            <i class="bi bi-cart-plus me-2"></i> Add To Cart
                                        </button>

                                        <button type="button" class="btn btn-outline-secondary" id="qv-wishlist-btn"
                                            title="Wishlist"
                                            style="height: 44px; width: 44px; border-radius: 999px; flex: 0 0 auto;">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.__GLOBAL_QV__ = true;

        // Search Suggestions
        function initSearchSuggestions(inputEl, suggestionsEl) {
            if (!inputEl || !suggestionsEl) return;
            let timeout = null;

            inputEl.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    suggestionsEl.classList.remove('show');
                    return;
                }

                timeout = setTimeout(() => {
                    fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > 0) {
                                suggestionsEl.innerHTML = data.map(item => `
                                    <a href="${item.url}" class="search-suggestion-item">
                                        <img src="${item.image}" alt="${item.name}">
                                        <div>
                                            <div class="fw-medium">${item.name}</div>
                                            <small class="text-primary fw-bold">PKR ${item.price}</small>
                                        </div>
                                    </a>
                                `).join('');
                                suggestionsEl.classList.add('show');
                            } else {
                                suggestionsEl.innerHTML =
                                    '<div class="p-3 text-muted text-center">No products found</div>';
                                suggestionsEl.classList.add('show');
                            }
                        });
                }, 300);
            });

            inputEl.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    window.location.href = `{{ route('search') }}?q=${encodeURIComponent(this.value)}`;
                }
            });

            document.addEventListener('click', function(e) {
                if (!inputEl.contains(e.target) && !suggestionsEl.contains(e.target)) {
                    suggestionsEl.classList.remove('show');
                }
            });
        }

        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');
        initSearchSuggestions(searchInput, searchSuggestions);

        const searchInputMobile = document.getElementById('searchInputMobile');
        const searchSuggestionsMobile = document.getElementById('searchSuggestionsMobile');
        initSearchSuggestions(searchInputMobile, searchSuggestionsMobile);

        // Newsletter Form
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        showNotification(data.message || 'Subscribed!', data.success ? 'success' : 'error');
                        if (data.success) this.reset();
                    })
                    .catch(() => {
                        showNotification('Successfully subscribed!', 'success');
                        this.reset();
                    });
            });
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = 'notification';
            if (type === 'error') notification.style.background = 'var(--danger-color)';
            notification.innerHTML =
                `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        window.addToCart = window.addToCart || function(event, product) {
            if (event && typeof event.preventDefault === 'function') event.preventDefault();
            const productId = (product && typeof product === 'object') ? product.id : product;
            const defaultColor = (product && Array.isArray(product.color_options) && product.color_options.length) ?
                product.color_options[0] : undefined;
            const defaultSize = (product && Array.isArray(product.sizes) && product.sizes.length) ? product.sizes[0] :
                undefined;

            fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1,
                        color: defaultColor,
                        size: defaultSize
                    })
                })
                .then(r => r.json().catch(() => ({})))
                .then(data => {
                    if (data && data.success === false) {
                        showNotification(data.message || 'Unable to add to cart.', 'error');
                        return;
                    }
                    const badge = document.getElementById('cart-badge');
                    if (badge) badge.innerText = data.cart_count !== undefined ? data.cart_count : (parseInt(badge
                        .innerText || '0', 10) + 1);
                    showNotification(data.message || 'Product added to cart!', 'success');
                })
                .catch(() => showNotification('Unable to add to cart.', 'error'));
        };

        window.addToWishlist = window.addToWishlist || function(event, productId) {
            if (event && typeof event.preventDefault === 'function') event.preventDefault();

            fetch('{{ route('wishlist.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(async (response) => {
                    if (response.status === 401) {
                        showNotification('Please login to add items to wishlist!', 'error');
                        setTimeout(() => window.location.href = '{{ route('login') }}', 1200);
                        return null;
                    }
                    return response.json().catch(() => ({}));
                })
                .then(data => {
                    if (!data) return;
                    if (data.success === false) {
                        showNotification(data.message || 'Error adding to wishlist', 'error');
                        return;
                    }
                    showNotification(data.message || 'Added to wishlist!', 'success');
                })
                .catch(() => showNotification('Added to wishlist!', 'success'));
        };

        window.incrementQv = function() {
            const el = document.getElementById('qv-quantity');
            if (!el) return;
            el.value = parseInt(el.value || '1', 10) + 1;
        };

        window.decrementQv = function() {
            const el = document.getElementById('qv-quantity');
            if (!el) return;
            const n = parseInt(el.value || '1', 10);
            if (n > 1) el.value = n - 1;
        };

        window.openQuickView = function(product) {
            const qvModalEl = document.getElementById('quickViewModal');
            if (!qvModalEl || typeof bootstrap === 'undefined') {
                if (product?.slug) window.location.href = '/product/' + product.slug;
                return;
            }

            const titleEl = document.getElementById('qv-title');
            const priceEl = document.getElementById('qv-price');
            const descEl = document.getElementById('qv-description');
            const productIdEl = document.getElementById('qv-product-id');
            if (titleEl) titleEl.innerText = product?.name || '';
            if (priceEl) priceEl.innerText = 'PKR ' + parseFloat(product?.price || 0).toFixed(2);
            if (descEl) descEl.innerText = product?.description || '';
            if (productIdEl) productIdEl.value = product?.id || '';

            const wishlistBtn = document.getElementById('qv-wishlist-btn');
            if (wishlistBtn) wishlistBtn.onclick = (e) => window.addToWishlist(e, product?.id);

            const colorWrap = document.getElementById('qv-color-wrap');
            const sizeWrap = document.getElementById('qv-size-wrap');
            const colorsEl = document.getElementById('qv-colors');
            const sizesEl = document.getElementById('qv-sizes');
            const selectedColorInput = document.getElementById('qv-selected-color');
            const selectedSizeInput = document.getElementById('qv-selected-size');
            const selectedColorText = document.getElementById('qv-selected-color-text');
            const selectedSizeText = document.getElementById('qv-selected-size-text');
            if (colorsEl) colorsEl.innerHTML = '';
            if (sizesEl) sizesEl.innerHTML = '';

            const productColors = Array.isArray(product?.color_options) ? product.color_options : [];
            const productSizes = Array.isArray(product?.sizes) ? product.sizes : [];

            function selectQvColor(value, btn) {
                if (selectedColorInput) selectedColorInput.value = value || '';
                if (selectedColorText) selectedColorText.innerText = value || '';
                if (colorsEl) colorsEl.querySelectorAll('button').forEach(b => {
                    b.classList.remove('border-dark');
                    b.style.boxShadow = '';
                });
                if (btn) {
                    btn.classList.add('border-dark');
                    btn.style.boxShadow = '0 0 0 2px rgba(0,0,0,0.25)';
                }
            }

            function selectQvSize(value, btn) {
                if (selectedSizeInput) selectedSizeInput.value = value || '';
                if (selectedSizeText) selectedSizeText.innerText = value || '';
                if (sizesEl) {
                    sizesEl.querySelectorAll('button').forEach(b => {
                        b.classList.remove('btn-dark');
                        b.classList.add('btn-outline-secondary');
                    });
                }
                if (btn) {
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-dark');
                }
            }

            if (productColors.length > 0 && colorWrap && colorsEl) {
                colorWrap.classList.remove('d-none');
                productColors.forEach((c, idx) => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'btn p-0 rounded-circle border border-2';
                    b.style.width = '22px';
                    b.style.height = '22px';
                    b.style.background = c;
                    b.style.boxShadow = 'inset 0 0 0 1px rgba(0,0,0,0.08)';
                    b.title = c;
                    b.onclick = () => selectQvColor(c, b);
                    colorsEl.appendChild(b);
                    if (idx === 0) selectQvColor(c, b);
                });
            } else if (colorWrap) {
                colorWrap.classList.add('d-none');
                if (selectedColorInput) selectedColorInput.value = '';
                if (selectedColorText) selectedColorText.innerText = '';
            }

            if (productSizes.length > 0 && sizeWrap && sizesEl) {
                sizeWrap.classList.remove('d-none');
                productSizes.forEach((s, idx) => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'btn btn-outline-secondary rounded-pill px-2 py-0';
                    b.style.fontSize = '0.8rem';
                    b.innerText = s;
                    b.onclick = () => selectQvSize(s, b);
                    sizesEl.appendChild(b);
                    if (idx === 0) selectQvSize(s, b);
                });
            } else if (sizeWrap) {
                sizeWrap.classList.add('d-none');
                if (selectedSizeInput) selectedSizeInput.value = '';
                if (selectedSizeText) selectedSizeText.innerText = '';
            }

            const mainImage = document.getElementById('qv-main-image');
            const thumbnailsContainer = document.getElementById('qv-thumbnails');
            if (thumbnailsContainer) thumbnailsContainer.innerHTML = '';

            let images = [];
            if (Array.isArray(product?.images) && product.images.length > 0) {
                images = [...product.images];
            } else if (typeof product?.images === 'string') {
                try {
                    const parsed = JSON.parse(product.images);
                    images = Array.isArray(parsed) ? parsed : [product.images];
                } catch (e) {
                    images = [product.images];
                }
            } else {
                images = ['https://placehold.co/600x800?text=Product'];
            }

            if (images.length === 1 && images[0]) {
                images.push(images[0]);
                images.push(images[0]);
            }

            window.qvCurrentIndex = 0;
            if (mainImage && images.length > 0) mainImage.src = images[0];

            if (thumbnailsContainer) {
                images.forEach((imgSrc, index) => {
                    const thumb = document.createElement('div');
                    thumb.className =
                        `thumbnail-item border rounded overflow-hidden ${index === 0 ? 'border-primary border-2' : ''}`;
                    thumb.style.cssText = 'min-width: 70px; width: 70px; height: 70px; cursor: pointer;';
                    thumb.innerHTML =
                        `<img src="${imgSrc}" alt="thumb" class="w-100 h-100" style="object-fit: cover;">`;
                    thumb.onclick = () => {
                        window.qvCurrentIndex = index;
                        if (mainImage) mainImage.src = imgSrc;
                        document.querySelectorAll('#qv-thumbnails .thumbnail-item').forEach(el => {
                            el.classList.remove('border-primary', 'border-2');
                        });
                        thumb.classList.add('border-primary', 'border-2');
                        if (mainImage) {
                            mainImage.style.opacity = '0.5';
                            setTimeout(() => mainImage.style.opacity = '1', 200);
                        }
                        // Reinitialize zoom for new image
                        setTimeout(() => initQvZoom(), 250);
                    };
                    thumbnailsContainer.appendChild(thumb);
                });
            }

            const prevBtn = qvModalEl.querySelector('.prev-thumb');
            const nextBtn = qvModalEl.querySelector('.next-thumb');
            if (prevBtn) prevBtn.onclick = () => {
                const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
                if (!thumbs.length) return;
                const nextIndex = (window.qvCurrentIndex - 1 + thumbs.length) % thumbs.length;
                thumbs[nextIndex].click();
                thumbs[nextIndex].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            };
            if (nextBtn) nextBtn.onclick = () => {
                const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
                if (!thumbs.length) return;
                const nextIndex = (window.qvCurrentIndex + 1) % thumbs.length;
                thumbs[nextIndex].click();
                thumbs[nextIndex].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            };

            const qvQty = document.getElementById('qv-quantity');
            if (qvQty) qvQty.value = 1;

            new bootstrap.Modal(qvModalEl).show();

            // Initialize Zoom Effect for Quick View
            setTimeout(() => initQvZoom(), 300);
        };

        // Quick View Zoom Function
        function initQvZoom() {
            const container = document.getElementById('qv-zoom-container');
            const mainImg = document.getElementById('qv-main-image');
            const result = document.getElementById('qv-zoom-result');

            if (!container || !mainImg || !result) return;

            // Set zoom result background
            result.style.backgroundImage = `url('${mainImg.src}')`;

            // Remove existing listeners
            container.onmouseenter = null;
            container.onmouseleave = null;
            container.onmousemove = null;

            container.onmouseenter = function() {
                result.classList.remove('d-none');
                result.style.backgroundImage = `url('${mainImg.src}')`;
            };

            container.onmouseleave = function() {
                result.classList.add('d-none');
            };

            container.onmousemove = function(e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Calculate zoom
                const zoomLevel = 2.5;
                const bgPosX = (x / rect.width) * 100;
                const bgPosY = (y / rect.height) * 100;

                result.style.backgroundSize = `${rect.width * zoomLevel}px ${rect.height * zoomLevel}px`;
                result.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            const qvForm = document.getElementById('qv-add-to-cart-form');
            if (!qvForm) return;

            qvForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const productId = document.getElementById('qv-product-id')?.value;
                const quantity = document.getElementById('qv-quantity')?.value;
                const color = document.getElementById('qv-selected-color')?.value || undefined;
                const size = document.getElementById('qv-selected-size')?.value || undefined;

                fetch('{{ route('cart.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: parseInt(quantity || '1', 10),
                            color: color,
                            size: size
                        })
                    })
                    .then(r => r.json().catch(() => ({})))
                    .then(data => {
                        if (data && data.success === false) {
                            showNotification(data.message || 'Unable to add to cart.', 'error');
                            return;
                        }
                        const badge = document.getElementById('cart-badge');
                        if (badge) badge.innerText = data.cart_count !== undefined ? data
                            .cart_count : (
                                parseInt(badge.innerText || '0', 10) + parseInt(quantity || '1', 10)
                            );
                        showNotification(data.message || 'Product added to cart!', 'success');

                        const instance = bootstrap.Modal.getInstance(document.getElementById(
                            'quickViewModal'));
                        if (instance) instance.hide();
                    })
                    .catch(() => showNotification('Unable to add to cart.', 'error'));
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
