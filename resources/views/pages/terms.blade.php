@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">Terms & Conditions</h1>
                <p class="text-muted mb-4">Last updated: {{ date('F d, Y') }}</p>

                <div class="mb-4">
                    <h4 class="fw-bold">1. Acceptance of Terms</h4>
                    <p class="text-secondary">By accessing and using {{ config('app.name') }}, you accept and agree to be
                        bound by these Terms and Conditions. If you do not agree with any part of these terms, please do
                        not use our website or services.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">2. User Accounts</h4>
                    <p class="text-secondary">When you create an account with us, you must provide accurate and complete
                        information. You are responsible for:</p>
                    <ul class="text-secondary">
                        <li>Maintaining the confidentiality of your account credentials</li>
                        <li>All activities that occur under your account</li>
                        <li>Notifying us immediately of any unauthorized use of your account</li>
                    </ul>
                    <p class="text-secondary">We reserve the right to suspend or terminate accounts that violate these
                        terms.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">3. Products and Pricing</h4>
                    <p class="text-secondary">We strive to provide accurate product descriptions and pricing. However:</p>
                    <ul class="text-secondary">
                        <li>Product images are for illustration purposes; actual products may vary slightly</li>
                        <li>Prices are subject to change without prior notice</li>
                        <li>We reserve the right to correct any pricing errors</li>
                        <li>All prices are displayed in Pakistani Rupees (PKR)</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">4. Orders and Payment</h4>
                    <p class="text-secondary">By placing an order, you agree that:</p>
                    <ul class="text-secondary">
                        <li>You are legally capable of entering into binding contracts</li>
                        <li>All information provided is accurate and complete</li>
                        <li>We reserve the right to refuse or cancel any order for any reason</li>
                        <li>Payment must be made through our approved payment methods</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">5. Shipping and Delivery</h4>
                    <p class="text-secondary">Please refer to our <a href="{{ route('pages.shipping') }}"
                            class="text-primary">Shipping Policy</a> for detailed information about delivery times, costs,
                        and procedures.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">6. Returns and Refunds</h4>
                    <p class="text-secondary">Please refer to our <a href="{{ route('pages.return-policy') }}"
                            class="text-primary">Return Policy</a> for detailed information about returns, exchanges, and
                        refunds.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">7. Intellectual Property</h4>
                    <p class="text-secondary">All content on this website, including but not limited to text, graphics,
                        logos, images, and software, is the property of {{ config('app.name') }} and is protected by
                        copyright and other intellectual property laws. You may not:</p>
                    <ul class="text-secondary">
                        <li>Copy, reproduce, or distribute any content without permission</li>
                        <li>Use our trademarks or logos without authorization</li>
                        <li>Modify or create derivative works from our content</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">8. User Conduct</h4>
                    <p class="text-secondary">You agree not to:</p>
                    <ul class="text-secondary">
                        <li>Use the website for any illegal or unauthorized purpose</li>
                        <li>Attempt to gain unauthorized access to any part of the website</li>
                        <li>Interfere with the website's security features</li>
                        <li>Upload malicious code or content</li>
                        <li>Harass, abuse, or harm other users</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">9. Limitation of Liability</h4>
                    <p class="text-secondary">To the fullest extent permitted by law, {{ config('app.name') }} shall not be
                        liable for any indirect, incidental, special, consequential, or punitive damages arising from your
                        use of our website or services.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">10. Privacy Policy</h4>
                    <p class="text-secondary">Your privacy is important to us. Please review our <a
                            href="{{ route('pages.privacy') }}" class="text-primary">Privacy Policy</a> to understand how
                        we collect, use, and protect your personal information.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">11. Governing Law</h4>
                    <p class="text-secondary">These Terms and Conditions shall be governed by and construed in accordance
                        with the laws of Pakistan. Any disputes arising from these terms shall be subject to the exclusive
                        jurisdiction of the courts in Karachi, Pakistan.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">12. Changes to Terms</h4>
                    <p class="text-secondary">We reserve the right to modify these terms at any time. Changes will be
                        effective immediately upon posting on the website. Your continued use of the website after changes
                        constitutes acceptance of the modified terms.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">13. Contact Us</h4>
                    <p class="text-secondary">If you have any questions about these Terms & Conditions, please contact us:
                    </p>
                    <ul class="text-secondary">
                        <li>Email: support@eshop.com</li>
                        <li>Phone: +92 300 1234567</li>
                        <li>Address: 123 Fashion Street, Karachi, Pakistan, 75500</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
