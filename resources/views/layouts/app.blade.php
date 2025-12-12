<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Top Bar -->
    <div class="bg-dark text-white py-2 small">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-truck me-2"></i> Free shipping on orders over $50
            </div>
            <div class="d-none d-md-flex gap-3">
                <a href="{{ route('pages.about') }}" class="text-white text-decoration-none hover-opacity">About Us</a>
                <a href="{{ route('pages.contact') }}" class="text-white text-decoration-none hover-opacity">Contact
                    Us</a>
                <a href="#" class="text-white text-decoration-none hover-opacity">FAQ</a>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand (Left on mobile, Center on Desktop technically but we stick to left for standard ecommerce or update to center split) -->
            <!-- Let's go with a modern Layout: Logo Left, Links Center, Actions Right -->
            <a class="navbar-brand fw-bold text-uppercase fs-4 d-flex align-items-center" href="{{ route('home') }}">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-bag-check-fill"></i>
                </div>
                <span>{{ config('app.name', 'E-Shop') }}</span>
            </a>

            <!-- Mobile Cart/Profile (Visible on Mobile Only) -->
            <div class="d-flex d-lg-none gap-3">
                <a href="{{ route('cart.index') }}" class="position-relative text-dark">
                    <i class="bi bi-cart3 fs-4"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light p-1">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium text-uppercase">
                    <li class="nav-item px-2">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active text-primary' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link {{ request()->routeIs('shop.index') ? 'active text-primary' : '' }}"
                            href="{{ route('shop.index') }}">Shop</a>
                    </li>
                    <li class="nav-item dropdown px-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu shadow border-0 mt-3">
                            <li><a class="dropdown-item" href="#">Men</a></li>
                            <li><a class="dropdown-item" href="#">Women</a></li>
                            <li><a class="dropdown-item" href="#">Accessories</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('shop.index') }}">All Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown px-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown">Pages</a>
                        <ul class="dropdown-menu shadow border-0 mt-3">
                            <li><a class="dropdown-item" href="{{ route('pages.about') }}">About Us</a></li>
                            <li><a class="dropdown-item" href="{{ route('pages.contact') }}">Contact Us</a></li>
                            <li><a class="dropdown-item" href="{{ route('pages.privacy') }}">Privacy Policy</a></li>
                            <li><a class="dropdown-item" href="{{ route('pages.return-policy') }}">Return Policy</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#searchCollapse">
                        <i class="bi bi-search fs-5"></i>
                    </button>

                    <a href="{{ route('wishlist.index') }}" class="btn btn-link text-dark p-0 position-relative">
                        <i class="bi bi-heart fs-5"></i>
                    </a>

                    <a href="{{ route('cart.index') }}" class="btn btn-link text-dark p-0 position-relative"
                        id="cart-icon-container">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="cart-badge">
                            {{ count(session('cart', [])) }}
                        </span>
                    </a>

                    @auth
                        <div class="dropdown">
                            <a href="#"
                                class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-4"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li>
                                    <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                            class="bi bi-gear me-2"></i>Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i
                                                class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 btn-sm fw-bold">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Overlay Form -->
    <div class="collapse bg-light border-bottom p-3 position-absolute start-0 end-0 z-3" id="searchCollapse"
        style="top: 100%;">
        <div class="container">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search products..."
                    aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 mt-auto border-top border-secondary">
        <div class="container pb-5">
            <div class="row g-4 justify-content-between">
                <!-- Brand & About -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-bag-check-fill text-primary me-2 fs-4"></i>
                        <span class="letter-spacing-1">{{ config('app.name') }}</span>
                    </h5>
                    <p class="text-secondary mb-4" style="line-height: 1.8;">
                        Experience the best in fashion with our curated collection of premium products.
                        We bring style and comfort to your doorstep.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i
                                class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i
                                class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i
                                class="bi bi-twitter"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="text-white text-uppercase fw-bold mb-4 letter-spacing-1">Shop</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('shop.index') }}"
                                class="text-secondary text-decoration-none hover-white transition-all">All Products</a>
                        </li>
                        <li><a href="#"
                                class="text-secondary text-decoration-none hover-white transition-all">Featured</a>
                        </li>
                        <li><a href="#"
                                class="text-secondary text-decoration-none hover-white transition-all">New Arrivals</a>
                        </li>
                        <li><a href="#"
                                class="text-secondary text-decoration-none hover-white transition-all">Discounts</a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="text-white text-uppercase fw-bold mb-4 letter-spacing-1">Support</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('pages.contact') }}"
                                class="text-secondary text-decoration-none hover-white transition-all">Contact Us</a>
                        </li>
                        <li><a href="{{ route('pages.about') }}"
                                class="text-secondary text-decoration-none hover-white transition-all">About Us</a>
                        </li>
                        <li><a href="#"
                                class="text-secondary text-decoration-none hover-white transition-all">FAQ</a></li>
                        <li><a href="{{ route('pages.privacy') }}"
                                class="text-secondary text-decoration-none hover-white transition-all">Privacy
                                Policy</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white text-uppercase fw-bold mb-4 letter-spacing-1">Stay Updated</h6>
                    <p class="text-secondary small mb-3">Subscribe to our newsletter for the latest updates and
                        exclusive offers.</p>
                    <form action="#" class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control bg-transparent border-secondary text-white"
                                placeholder="Email address">
                            <button class="btn btn-primary px-3" type="button"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                    <div class="text-secondary small">
                        <i class="bi bi-shield-check me-1"></i> Secure Payments
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-top border-secondary py-3 bg-black bg-opacity-25">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <div class="text-secondary small">
                            &copy; {{ date('Y') }} <span
                                class="text-white fw-bold">{{ config('app.name') }}</span>. All rights reserved.
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="payment-methods opacity-50 grayscale-hover transition-all">
                            <i class="bi bi-credit-card mx-1 fs-5"></i>
                            <i class="bi bi-paypal mx-1 fs-5"></i>
                            <i class="bi bi-wallet2 mx-1 fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
