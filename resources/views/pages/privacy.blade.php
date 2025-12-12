@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">Privacy Policy</h1>
                <p class="text-muted mb-4">Last updated: {{ date('F d, Y') }}</p>

                <div class="mb-4">
                    <h4 class="fw-bold">1. Information We Collect</h4>
                    <p class="text-secondary">We collect information you provide directly to us, such as when you create an
                        account, make a purchase, or contact us for support.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">2. How We Use Your Information</h4>
                    <p class="text-secondary">We use the information we collect to process your orders, communicate with
                        you, and improve our services.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">3. Data Security</h4>
                    <p class="text-secondary">We implement appropriate security measures to protect your personal
                        information.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">4. Contact Us</h4>
                    <p class="text-secondary">If you have any questions about this Privacy Policy, please contact us at
                        support@example.com.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
