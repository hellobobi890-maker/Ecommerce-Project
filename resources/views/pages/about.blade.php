@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="fw-bold mb-4 text-center">About Us</h1>
                <div class="row align-items-center mb-5">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="https://via.placeholder.com/600x400?text=About+Us" class="img-fluid rounded shadow-sm"
                            alt="About Us">
                    </div>
                    <div class="col-md-6">
                        <p class="lead text-muted">Welcome to {{ config('app.name') }}, your number one source for all
                            things fashion.</p>
                        <p>Founded in {{ date('Y') }}, we're dedicated to providing you the very best of men's and
                            women's clothing, with an emphasis on quality, style, and customer satisfaction.</p>
                        <p>We hope you enjoy our products as much as we enjoy offering them to you. If you have any
                            questions or comments, please don't hesitate to contact us.</p>
                    </div>
                </div>

                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 py-4">
                            <div class="card-body">
                                <i class="bi bi-gem text-primary display-4 mb-3"></i>
                                <h5 class="fw-bold">Premium Quality</h5>
                                <p class="text-muted small mb-0">We source only the finest materials for our products.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 py-4">
                            <div class="card-body">
                                <i class="bi bi-truck text-primary display-4 mb-3"></i>
                                <h5 class="fw-bold">Fast Shipping</h5>
                                <p class="text-muted small mb-0">Delivery within 3-5 business days nationwide.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 py-4">
                            <div class="card-body">
                                <i class="bi bi-headset text-primary display-4 mb-3"></i>
                                <h5 class="fw-bold">24/7 Support</h5>
                                <p class="text-muted small mb-0">Our friendly support team is here to help you.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
