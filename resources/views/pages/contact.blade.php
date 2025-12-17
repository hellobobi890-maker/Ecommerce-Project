@extends('layouts.app')

@section('content')
    <div class="contact-page py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-white rounded-3 px-3 py-2 border">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small">Get In Touch</span>
                <h1 class="fw-bold mt-2 mb-3">Contact Us</h1>
                <p class="text-muted mx-auto" style="max-width: 600px;">Koi sawal hai? Hum se rabta karein! Humari team 24/7
                    aap ki madad ke liye taiyar hai.</p>
            </div>

            <div class="row g-4 g-lg-5">
                <!-- Contact Info Cards -->
                <div class="col-lg-5">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                        <h5 class="fw-bold mb-4">Contact Information</h5>

                        <!-- Address -->
                        <div class="contact-info-item d-flex align-items-start gap-3 mb-4">
                            <div class="contact-icon-box">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Address</h6>
                                <p class="text-muted small mb-0">123 Fashion Street,<br>Karachi, Pakistan, 75500</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="contact-info-item d-flex align-items-start gap-3 mb-4">
                            <div class="contact-icon-box">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="text-muted small mb-0">support@eshop.com<br>info@eshop.com</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="contact-info-item d-flex align-items-start gap-3 mb-4">
                            <div class="contact-icon-box">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Phone</h6>
                                <p class="text-muted small mb-0">+92 300 1234567<br>+92 21 1234567</p>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="contact-info-item d-flex align-items-start gap-3 mb-4">
                            <div class="contact-icon-box">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Working Hours</h6>
                                <p class="text-muted small mb-0">Mon - Sat: 10AM - 8PM<br>Sunday: Closed</p>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-bold mb-3">Follow Us</h6>
                            <div class="d-flex gap-2">
                                <a href="#" class="social-link-btn facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="social-link-btn instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#" class="social-link-btn whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="#" class="social-link-btn twitter">
                                    <i class="bi bi-twitter-x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                        <h5 class="fw-bold mb-4">Send us a Message</h5>

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold small">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                        id="name" placeholder="Aap ka naam" required value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold small">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                        id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label fw-semibold small">Subject</label>
                                    <input type="text" name="subject"
                                        class="form-control form-control-lg rounded-3 @error('subject') is-invalid @enderror"
                                        id="subject" placeholder="Message ka subject" value="{{ old('subject') }}">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold small">Message <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control form-control-lg rounded-3 @error('message') is-invalid @enderror"
                                        id="message" rows="5" placeholder="Aap ka message..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-semibold">
                                        <i class="bi bi-send-fill me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Map Section (Optional) -->
            <div class="mt-5">
                <div class="bg-white rounded-4 shadow-sm overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.0661619012594!2d67.0291!3d24.8607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjTCsDUxJzM4LjUiTiA2N8KwMDEnNDQuOCJF!5e0!3m2!1sen!2s!4v1702000000000!5m2!1sen!2s"
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <style>
        .contact-page {
            background: var(--bg-light);
        }

        .contact-icon-box {
            width: 50px;
            height: 50px;
            min-width: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .social-link-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link-btn.facebook {
            background: #1877f2;
            color: white;
        }

        .social-link-btn.instagram {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: white;
        }

        .social-link-btn.whatsapp {
            background: #25d366;
            color: white;
        }

        .social-link-btn.twitter {
            background: #000;
            color: white;
        }

        .social-link-btn:hover {
            transform: translateY(-3px);
            opacity: 0.9;
            color: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
    </style>
@endsection
