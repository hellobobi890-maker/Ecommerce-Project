@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>

        <h1 class="fw-bold mb-4">
            <i class="bi bi-credit-card me-2"></i>Checkout
        </h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Shipping Information -->
                <div class="col-lg-7">
                    <!-- Contact Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-person me-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control bg-light" value="{{ auth()->user()->email }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Shipping Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                           placeholder="Street address, House no." required value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select name="city" class="form-select @error('city') is-invalid @enderror" required>
                                        <option value="">Select City</option>
                                        <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                        <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                        <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                        <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
                                        <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
                                        <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan</option>
                                        <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
                                        <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta</option>
                                        <option value="Other" {{ old('city') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                           placeholder="e.g. 75500" required value="{{ old('postal_code') }}">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           placeholder="03XX-XXXXXXX" required value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Order Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2" 
                                              placeholder="Delivery instructions, landmarks, etc.">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-wallet2 me-2"></i>Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3 p-3 border rounded bg-light">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label ms-2" for="cod">
                                    <strong><i class="bi bi-cash-stack me-2"></i>Cash on Delivery (COD)</strong>
                                    <p class="text-muted small mb-0 mt-1">Pay when you receive your order</p>
                                </label>
                            </div>
                            <div class="alert alert-info small mb-0">
                                <i class="bi bi-info-circle me-2"></i>More payment options coming soon!
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <!-- Cart Items -->
                            <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                                @foreach ($cart as $id => $details)
                                    <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $details['image'] ?? 'https://placehold.co/60x60?text=Product' }}"
                                                 class="rounded" width="60" height="60" style="object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 small fw-bold">{{ Str::limit($details['name'], 30) }}</h6>
                                            @if(isset($details['size']) && $details['size'] != 'default')
                                                <small class="text-muted me-1">Size: {{ $details['size'] }}</small>
                                            @endif
                                            @if(isset($details['color']) && $details['color'] != 'default')
                                                <small class="text-muted">Color: {{ $details['color'] }}</small>
                                            @endif
                                            <div class="small text-muted">Qty: {{ $details['quantity'] }}</div>
                                        </div>
                                        <div class="text-end">
                                            <strong>PKR {{ number_format($details['price'] * $details['quantity'], 2) }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <!-- Totals -->
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>PKR {{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span><i class="bi bi-ticket-perforated me-1"></i>{{ $coupon['code'] ?? 'Discount' }}</span>
                                <span>-PKR {{ number_format($discount, 2) }}</span>
                            </div>
                            @endif

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Shipping</span>
                                <span>PKR {{ number_format($shipping, 2) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold">Total</span>
                                <span class="fs-5 fw-bold text-primary">PKR {{ number_format($total, 2) }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                <i class="bi bi-lock me-2"></i>Place Order
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('cart.index') }}" class="text-muted small">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Cart
                                </a>
                            </div>

                            <!-- Trust Badges -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
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
        </form>
    </div>
</div>
@endsection
