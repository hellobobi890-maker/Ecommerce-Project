@extends('layouts.app')

@section('content')
    <div class="about-page">
        <!-- Hero Section -->
        <div class="about-hero position-relative py-5" style="background: var(--gradient-hero);">
            <div class="container py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-white">
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 fw-semibold">About Us</span>
                        <h1 class="display-5 fw-bold mb-4">Who We Are</h1>
                        <p class="lead mb-4 opacity-90">
                            Welcome to {{ config('app.name') }}, your number one source for all things fashion.
                            We're dedicated to providing you the very best of men's and women's clothing.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('shop.index') }}"
                                class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="bi bi-shop me-2"></i>Shop Now
                            </a>
                            <a href="{{ route('pages.contact') }}"
                                class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                Contact Us
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&h=400&fit=crop"
                            alt="About Us" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story Section -->
        <div class="py-5 bg-white">
            <div class="container py-4">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?w=500&h=400&fit=crop"
                            alt="Our Story" class="img-fluid rounded-4 shadow">
                    </div>
                    <div class="col-lg-6">
                        <span class="text-primary fw-bold text-uppercase small">Our Story</span>
                        <h2 class="fw-bold mt-2 mb-4">Founded in 2025</h2>
                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            We started with a simple idea: to provide high-quality, stylish clothing at affordable prices.
                            Our journey began in Karachi, Pakistan, and has since grown to serve customers across the
                            nation.
                        </p>
                        <p class="text-muted mb-4" style="line-height: 1.8;">
                            With an emphasis on quality, style, and customer satisfaction, we've built a loyal community
                            of fashion enthusiasts who trust us for their wardrobe needs.
                        </p>
                        <div class="row g-4 mt-3">
                            <div class="col-6">
                                <div class="border-start border-4 border-primary ps-3">
                                    <h3 class="fw-bold mb-0 text-primary">10K+</h3>
                                    <p class="text-muted small mb-0">Happy Customers</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border-start border-4 border-primary ps-3">
                                    <h3 class="fw-bold mb-0 text-primary">500+</h3>
                                    <p class="text-muted small mb-0">Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="py-5 bg-light">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="text-primary fw-bold text-uppercase small">Why Choose Us</span>
                    <h2 class="fw-bold mt-2">Our Commitment to You</h2>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                            <div class="feature-icon mx-auto mb-4">
                                <i class="bi bi-gem"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Premium Quality</h5>
                            <p class="text-muted small mb-0">
                                We source only the finest materials for our products. Every piece goes through quality
                                checks.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                            <div class="feature-icon mx-auto mb-4">
                                <i class="bi bi-truck"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Fast Shipping</h5>
                            <p class="text-muted small mb-0">
                                Delivery within 3-5 business days nationwide. Free shipping on orders over PKR 2000.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4">
                            <div class="feature-icon mx-auto mb-4">
                                <i class="bi bi-headset"></i>
                            </div>
                            <h5 class="fw-bold mb-3">24/7 Support</h5>
                            <p class="text-muted small mb-0">
                                Our friendly support team is here to help you anytime. Reach out via chat or call.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Values -->
        <div class="py-5 bg-white">
            <div class="container py-4">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 order-lg-2">
                        <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=500&h=400&fit=crop"
                            alt="Our Values" class="img-fluid rounded-4 shadow">
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <span class="text-primary fw-bold text-uppercase small">Our Values</span>
                        <h2 class="fw-bold mt-2 mb-4">What Drives Us</h2>
                        <div class="d-flex gap-3 mb-4">
                            <div class="value-icon">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Customer First</h6>
                                <p class="text-muted small mb-0">Your satisfaction is our top priority. We go above and
                                    beyond.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <div class="value-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Trust & Transparency</h6>
                                <p class="text-muted small mb-0">Honest pricing, genuine products, no hidden fees.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="value-icon">
                                <i class="bi bi-recycle"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Sustainability</h6>
                                <p class="text-muted small mb-0">We're committed to eco-friendly practices and minimal
                                    waste.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-5" style="background: var(--gradient-dark);">
            <div class="container py-4 text-center text-white">
                <h2 class="fw-bold mb-3">Ready to Explore?</h2>
                <p class="opacity-75 mb-4 mx-auto" style="max-width: 500px;">
                    Discover our amazing collection and find your perfect style today!
                </p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-semibold">
                    <i class="bi bi-bag-heart me-2"></i>Start Shopping
                </a>
            </div>
        </div>
    </div>

    <style>
        .about-hero {
            min-height: 500px;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
        }

        .value-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            background: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }
    </style>
@endsection
