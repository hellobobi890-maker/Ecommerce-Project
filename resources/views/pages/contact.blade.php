@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-5 text-center">Contact Us</h1>

                <div class="row g-5">
                    <div class="col-md-5">
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                    <i class="bi bi-geo-alt fs-4"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">Address</h5>
                                <p class="text-muted small mb-0">123 Fashion Street, Creative City, 54000</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                    <i class="bi bi-envelope fs-4"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">Email</h5>
                                <p class="text-muted small mb-0">support@example.com</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                    <i class="bi bi-telephone fs-4"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold mb-1">Phone</h5>
                                <p class="text-muted small mb-0">+92 300 1234567</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Your Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="name@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="4" placeholder="How can we help you?"></textarea>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
