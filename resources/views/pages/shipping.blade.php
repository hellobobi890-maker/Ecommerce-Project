@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-4">Shipping Policy</h1>
                <p class="text-muted mb-4">Last updated: {{ date('F d, Y') }}</p>

                <div class="mb-4">
                    <h4 class="fw-bold">1. Delivery Areas</h4>
                    <p class="text-secondary">We currently deliver to all major cities and towns across Pakistan. Our
                        delivery network covers:</p>
                    <ul class="text-secondary">
                        <li>All major cities (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Quetta)
                        </li>
                        <li>Surrounding towns and suburbs</li>
                        <li>Remote areas (may take additional time)</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">2. Delivery Timeframes</h4>
                    <p class="text-secondary">Standard delivery times are as follows:</p>
                    <ul class="text-secondary">
                        <li><strong>Major Cities:</strong> 2-3 business days</li>
                        <li><strong>Other Cities:</strong> 3-5 business days</li>
                        <li><strong>Remote Areas:</strong> 5-7 business days</li>
                    </ul>
                    <p class="text-secondary">Please note that delivery times may vary during peak seasons, sales events, or
                        due to unforeseen circumstances.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">3. Shipping Costs</h4>
                    <p class="text-secondary">Our shipping rates are as follows:</p>
                    <ul class="text-secondary">
                        <li><strong>Orders above PKR 2,000:</strong> FREE shipping nationwide</li>
                        <li><strong>Orders below PKR 2,000:</strong> PKR 200 flat rate shipping</li>
                    </ul>
                    <p class="text-secondary">Shipping costs are calculated at checkout and clearly displayed before
                        payment.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">4. Order Processing</h4>
                    <p class="text-secondary">Orders are processed within 1-2 business days after payment confirmation.
                        You will receive an email confirmation once your order has been dispatched.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">5. Order Tracking</h4>
                    <p class="text-secondary">Once your order is shipped, you will receive a tracking number via email and
                        SMS. You can use this number to track your package through our courier partner's website or by
                        logging into your account on our website.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">6. Failed Delivery Attempts</h4>
                    <p class="text-secondary">If delivery is unsuccessful due to incorrect address or unavailability:</p>
                    <ul class="text-secondary">
                        <li>Our courier will attempt delivery up to 2 times</li>
                        <li>After failed attempts, the package will be held at the nearest courier office for 5 days</li>
                        <li>Unclaimed packages will be returned to us</li>
                        <li>Re-delivery charges may apply</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">7. Cash on Delivery (COD)</h4>
                    <p class="text-secondary">We offer Cash on Delivery option for your convenience. Please have the exact
                        amount ready at the time of delivery. Our delivery personnel may not carry change.</p>
                </div>

                <div class="mb-4">
                    <h4 class="fw-bold">8. Contact Us</h4>
                    <p class="text-secondary">If you have any questions about shipping or need assistance with your order,
                        please contact us:</p>
                    <ul class="text-secondary">
                        <li>Email: support@eshop.com</li>
                        <li>Phone: +92 300 1234567</li>
                        <li>WhatsApp: +92 300 1234567</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
