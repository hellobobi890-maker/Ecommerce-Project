@extends('layouts.app')

@section('content')
    <div class="bg-light py-5">
        <div class="container">
            <h1 class="fw-bold mb-4">Shopping Cart</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (count($cart) > 0)
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="mb-0 fw-bold">Cart Items ({{ count($cart) }})</h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach ($cart as $id => $details)
                                    <div class="cart-item border-bottom p-4">
                                        <div class="row align-items-center">
                                            <!-- Product Image -->
                                            <div class="col-md-2 col-3">
                                                <div class="rounded overflow-hidden" style="height: 100px; width: 100px;">
                                                    <img src="{{ $details['image'] ?? 'https://placehold.co/100x100?text=Product' }}"
                                                        alt="{{ $details['name'] }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="col-md-4 col-9">
                                                <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                                <p class="text-muted small mb-0">SKU: {{ $details['sku'] ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-2 col-6 mt-3 mt-md-0">
                                                <form action="{{ route('cart.update', $id) }}" method="POST"
                                                    class="quantity-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateQty(this, -1)">-</button>
                                                        <input type="number" name="quantity"
                                                            class="form-control text-center"
                                                            value="{{ $details['quantity'] }}" min="1"
                                                            onchange="this.form.submit()">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="updateQty(this, 1)">+</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-2 col-3 mt-3 mt-md-0 text-end text-md-center">
                                                <span class="fw-bold text-danger">PKR
                                                    {{ number_format($details['price'], 2) }}</span>
                                            </div>

                                            <!-- Subtotal & Remove -->
                                            <div class="col-md-2 col-3 mt-3 mt-md-0 text-end">
                                                <div class="fw-bold mb-2">PKR
                                                    {{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                                <form action="{{ route('cart.destroy', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Remove this item?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer bg-white border-0 p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                                    </a>
                                    <form action="{{ route('cart.destroy', array_key_first($cart)) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="mb-0 fw-bold">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                                    $shipping = 200; // PKR
                                    $total = $subtotal + $shipping;
                                @endphp

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-bold">PKR {{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-bold">PKR {{ number_format($shipping, 2) }}</span>
                                </div>

                                <!-- Coupon Code -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Coupon Code">
                                        <button class="btn btn-outline-secondary">Apply</button>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fs-5 fw-bold">Total</span>
                                    <span class="fs-5 fw-bold text-danger">PKR {{ number_format($total, 2) }}</span>
                                </div>

                                <a href="{{ route('checkout.index') }}" class="btn btn-danger btn-lg w-100 fw-bold">
                                    <i class="bi bi-lock me-2"></i> Proceed to Checkout
                                </a>

                                <!-- Payment Icons -->
                                <div class="text-center mt-4">
                                    <p class="text-muted small mb-2">We Accept</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <i class="bi bi-credit-card fs-4 text-secondary"></i>
                                        <i class="bi bi-paypal fs-4 text-secondary"></i>
                                        <i class="bi bi-cash fs-4 text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Secure Checkout -->
                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <i class="bi bi-shield-check text-success fs-4"></i>
                                    <div>
                                        <strong>Secure Checkout</strong>
                                        <p class="text-muted small mb-0">Your data is protected</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-truck text-primary fs-4"></i>
                                    <div>
                                        <strong>Fast Delivery</strong>
                                        <p class="text-muted small mb-0">2-5 business days</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x text-muted" style="font-size: 80px;"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Your Cart is Empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-danger btn-lg px-5">
                        <i class="bi bi-bag me-2"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateQty(btn, delta) {
            const input = btn.closest('.input-group').querySelector('input');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            input.value = val;
            input.form.submit();
        }
    </script>
@endsection
