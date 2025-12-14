@extends('layouts.app')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Contact Us</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="fw-bold mb-2 text-center">Contact Us</h1>
            <p class="text-muted text-center mb-5">Koi sawal hai? Hum se rabta karein!</p>

            <div class="row g-5">
                <!-- Contact Info -->
                <div class="col-md-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                <i class="bi bi-geo-alt fs-4"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Address</h6>
                            <p class="text-muted small mb-0">123 Fashion Street,<br>Karachi, Pakistan, 75500</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                <i class="bi bi-envelope fs-4"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-muted small mb-0">support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                <i class="bi bi-telephone fs-4"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Phone</h6>
                            <p class="text-muted small mb-0">+92 300 1234567</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                <i class="bi bi-clock fs-4"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">Working Hours</h6>
                            <p class="text-muted small mb-0">Mon - Sat: 10AM - 8PM</p>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3">Follow Us</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 40px; height: 40px;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 40px; height: 40px;">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success rounded-circle" style="width: 40px; height: 40px;">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info rounded-circle" style="width: 40px; height: 40px;">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Send us a Message</h5>
                            
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" placeholder="Aap ka naam" required value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                                               id="subject" placeholder="Message ka subject" value="{{ old('subject') }}">
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                                  id="message" rows="5" placeholder="Aap ka message..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-send me-2"></i>Send Message
                                        </button>
                                    </div>
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
