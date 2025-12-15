@extends('layouts.app')

@section('content')
    <div class="checkout-page py-4">
        <div class="container">
            <!-- Step Progress Indicator -->
            <div class="step-progress mb-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="step-item completed">
                        <div class="step-circle">
                            <i class="bi bi-check"></i>
                        </div>
                        <span class="step-label">Shopping Cart</span>
                    </div>
                    <div class="step-line completed"></div>
                    <div class="step-item active">
                        <div class="step-circle">
                            <i class="bi bi-truck"></i>
                        </div>
                        <span class="step-label">Checkout</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <span class="step-label">Confirmation</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="row g-4">
                    <!-- Left Column - Forms -->
                    <div class="col-lg-7">
                        <!-- Contact Information -->
                        <div class="checkout-section bg-white rounded-4 shadow-sm mb-4 overflow-hidden">
                            <div class="section-header px-4 py-3 border-bottom d-flex align-items-center gap-3">
                                <div class="section-number">1</div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Contact Information</h5>
                                    <span class="text-muted small">Your personal details</span>
                                </div>
                            </div>
                            <div class="section-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i
                                                    class="bi bi-person text-muted"></i></span>
                                            <input type="text" class="form-control border-start-0 bg-light"
                                                value="{{ auth()->user()->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i
                                                    class="bi bi-envelope text-muted"></i></span>
                                            <input type="email" class="form-control border-start-0 bg-light"
                                                value="{{ auth()->user()->email }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="checkout-section bg-white rounded-4 shadow-sm mb-4 overflow-hidden">
                            <div class="section-header px-4 py-3 border-bottom d-flex align-items-center gap-3">
                                <div class="section-number">2</div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Shipping Address</h5>
                                    <span class="text-muted small">Where should we deliver?</span>
                                </div>
                            </div>
                            <div class="section-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Street Address <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-geo-alt text-muted"></i></span>
                                            <input type="text" name="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                placeholder="House no, Street, Area" required value="{{ old('address') }}">
                                        </div>
                                        @error('address')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">City <span
                                                class="text-danger">*</span></label>
                                        <select name="city" class="form-select @error('city') is-invalid @enderror"
                                            required>
                                            <option value="">Select City</option>
                                            <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>Karachi
                                            </option>
                                            <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore
                                            </option>
                                            <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>
                                                Islamabad</option>
                                            <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>
                                                Rawalpindi</option>
                                            <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>
                                                Faisalabad</option>
                                            <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan
                                            </option>
                                            <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>
                                                Peshawar</option>
                                            <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta
                                            </option>
                                            <option value="Other" {{ old('city') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('city')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Postal Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="postal_code"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            placeholder="e.g. 75500" required value="{{ old('postal_code') }}">
                                        @error('postal_code')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Phone Number <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i
                                                    class="bi bi-telephone text-muted"></i></span>
                                            <input type="tel" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="03XX-XXXXXXX" required value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Delivery Notes (Optional)</label>
                                        <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions for delivery...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-section bg-white rounded-4 shadow-sm overflow-hidden">
                            <div class="section-header px-4 py-3 border-bottom d-flex align-items-center gap-3">
                                <div class="section-number">3</div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Payment Method</h5>
                                    <span class="text-muted small">How would you like to pay?</span>
                                </div>
                            </div>
                            <div class="section-body p-4">
                                <div class="payment-methods">
                                    <label
                                        class="payment-method-card p-3 border rounded-3 d-flex align-items-center gap-3 mb-3"
                                        style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            value="cod" checked>
                                        <div class="payment-icon">
                                            <i class="bi bi-cash-stack fs-3 text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">Cash on Delivery (COD)</div>
                                            <div class="text-muted small">Pay when you receive your order</div>
                                        </div>
                                        <span class="badge bg-success-subtle text-success">Popular</span>
                                    </label>

                                    <label
                                        class="payment-method-card p-3 border rounded-3 d-flex align-items-center gap-3 opacity-50"
                                        style="cursor: not-allowed;">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            value="card" disabled>
                                        <div class="payment-icon">
                                            <i class="bi bi-credit-card fs-3 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">Credit/Debit Card</div>
                                            <div class="text-muted small">Visa, MasterCard, etc.</div>
                                        </div>
                                        <span class="badge bg-secondary">Coming Soon</span>
                                    </label>
                                </div>

                                <div class="alert alert-info small mt-3 mb-0 rounded-3">
                                    <i class="bi bi-info-circle me-2"></i>More payment options will be available soon!
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="col-lg-5">
                        <div class="order-summary bg-white rounded-4 shadow-sm overflow-hidden"
                            style="position: sticky; top: 100px;">
                            <div class="summary-header px-4 py-3 border-bottom bg-dark text-white">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Order Summary</h5>
                            </div>

                            <!-- Cart Items -->
                            <div class="summary-items p-4" style="max-height: 320px; overflow-y: auto;">
                                @foreach ($cart as $id => $details)
                                    <div
                                        class="summary-item d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="item-image rounded-3 overflow-hidden bg-light"
                                            style="width: 70px; height: 80px; flex-shrink: 0;">
                                            <img src="{{ $details['image'] ?? 'https://placehold.co/70x80?text=Product' }}"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                        <div class="item-details flex-grow-1">
                                            <h6 class="mb-1 small fw-semibold">{{ Str::limit($details['name'], 30) }}</h6>
                                            <div class="text-muted small">
                                                @if (isset($details['size']) && $details['size'] != 'default')
                                                    <span class="me-2">Size: {{ $details['size'] }}</span>
                                                @endif
                                                @if (isset($details['color']) && $details['color'] != 'default')
                                                    <span>Color: {{ $details['color'] }}</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small">Qty: {{ $details['quantity'] }}</div>
                                        </div>
                                        <div class="item-price text-end">
                                            <span class="fw-bold">PKR
                                                {{ number_format($details['price'] * $details['quantity'], 0) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Totals -->
                            <div class="summary-totals p-4 border-top bg-light">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold">PKR {{ number_format($subtotal, 0) }}</span>
                                </div>

                                @if ($discount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span><i class="bi bi-ticket-perforated me-1"></i>Discount</span>
                                        <span class="fw-semibold">-PKR {{ number_format($discount, 0) }}</span>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-semibold">PKR {{ number_format($shipping, 0) }}</span>
                                </div>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fs-5 fw-bold">Total</span>
                                    <span class="fs-5 fw-bold text-primary">PKR {{ number_format($total, 0) }}</span>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 rounded-pill">
                                    <i class="bi bi-lock me-2"></i>Place Order
                                </button>

                                <div class="text-center mt-3">
                                    <a href="{{ route('cart.index') }}" class="text-muted small text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i>Back to Cart
                                    </a>
                                </div>

                                <!-- Trust Badges -->
                                <div class="trust-badges mt-4 pt-4 border-top">
                                    <div class="d-flex justify-content-center gap-4">
                                        <div class="text-center">
                                            <i class="bi bi-shield-check text-success fs-4"></i>
                                            <div class="small text-muted">Secure</div>
                                        </div>
                                        <div class="text-center">
                                            <i class="bi bi-truck text-primary fs-4"></i>
                                            <div class="small text-muted">Fast Delivery</div>
                                        </div>
                                        <div class="text-center">
                                            <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                                            <div class="small text-muted">Easy Returns</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* Checkout Page Styles */
        .checkout-page {
            background: var(--bg-light);
            min-height: 80vh;
        }

        /* Step Progress */
        .step-progress {
            padding: 20px 0;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .step-item.active .step-circle {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.35);
        }

        .step-item.completed .step-circle {
            background: var(--success-color);
            color: white;
        }

        .step-label {
            margin-top: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
        }

        .step-item.active .step-label,
        .step-item.completed .step-label {
            color: var(--text-dark);
            font-weight: 600;
        }

        .step-line {
            width: 100px;
            height: 3px;
            background: #e5e7eb;
            margin: 0 10px;
            margin-bottom: 30px;
        }

        .step-line.completed {
            background: var(--success-color);
        }

        /* Section Numbers */
        .section-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Checkout Sections */
        .checkout-section {
            transition: box-shadow 0.3s ease;
        }

        .checkout-section:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
        }

        /* Form Inputs */
        .checkout-section .form-control,
        .checkout-section .form-select {
            padding: 0.75rem 1rem;
            border-radius: 10px;
        }

        .checkout-section .form-control:focus,
        .checkout-section .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .checkout-section .input-group-text {
            border-radius: 10px 0 0 10px;
        }

        .checkout-section .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        /* Payment Methods */
        .payment-method-card {
            transition: all 0.2s ease;
        }

        .payment-method-card:hover:not(.opacity-50) {
            border-color: var(--primary-color) !important;
            background: rgba(37, 99, 235, 0.02);
        }

        .payment-method-card input:checked~.payment-icon i {
            color: var(--primary-color);
        }

        /* Order Summary */
        .order-summary {
            transition: box-shadow 0.3s ease;
        }

        .order-summary:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
        }

        .summary-items::-webkit-scrollbar {
            width: 4px;
        }

        .summary-items::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 2px;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .step-line {
                width: 50px;
            }

            .step-circle {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .step-label {
                font-size: 0.75rem;
            }
        }
    </style>
@endsection
