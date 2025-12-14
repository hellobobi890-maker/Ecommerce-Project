@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Shopping Cart</li>
            </ol>
        </nav>

        <h1 class="fw-bold mb-4">
            <i class="bi bi-bag me-2"></i>Shopping Cart
        </h1>

        @if (count($cart) > 0)
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Cart Items ({{ count($cart) }})</h5>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Cart clear karna chahte hain?')">
                                    <i class="bi bi-trash me-1"></i>Clear All
                                </button>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            @foreach ($cart as $id => $details)
                                @php
                                    $unitPrice = (float) ($details['price'] ?? 0);
                                    $lineTotal = $unitPrice * (int) ($details['quantity'] ?? 1);
                                @endphp
                                <div class="cart-item border-bottom p-4" data-item-id="{{ $id }}">
                                    <div class="d-flex gap-3 align-items-start align-items-md-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-3 overflow-hidden bg-light" style="height: 90px; width: 90px;">
                                                <a href="{{ route('shop.show', $details['slug'] ?? '#') }}">
                                                    <img src="{{ $details['image'] ?? 'https://placehold.co/100x100?text=Product' }}"
                                                        alt="{{ $details['name'] }}" class="w-100 h-100" style="object-fit: cover;">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between gap-3">
                                                <div>
                                                    <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                                    <div class="d-flex flex-wrap gap-2 mb-1">
                                                        @if(isset($details['size']) && $details['size'] != 'default')
                                                            <span class="badge bg-white text-dark border">Size: {{ $details['size'] }}</span>
                                                        @endif
                                                        @if(isset($details['color']) && $details['color'] != 'default')
                                                            <span class="badge bg-white text-dark border">Color: {{ $details['color'] }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-muted small" data-role="unit-price" data-unit-price="{{ $unitPrice }}">
                                                        Unit Price: PKR {{ number_format($unitPrice, 2) }}
                                                    </div>
                                                </div>

                                                <form action="{{ route('cart.destroy', $id) }}" method="POST" class="d-none d-md-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Yeh item remove karna chahte hain?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-3">
                                                <div class="input-group input-group-sm" style="width: 120px;">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQty(this, -1)">−</button>
                                                    <input type="number" name="quantity" class="form-control text-center"
                                                        value="{{ $details['quantity'] }}" min="1" data-item-id="{{ $id }}" data-unit-price="{{ $unitPrice }}">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQty(this, 1)">+</button>
                                                </div>

                                                <div class="text-end">
                                                    <div class="fw-bold fs-5 text-primary mb-1" data-role="item-subtotal">
                                                        PKR {{ number_format($lineTotal, 2) }}
                                                    </div>
                                                    <form action="{{ route('cart.destroy', $id) }}" method="POST" class="d-md-none">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Yeh item remove karna chahte hain?')">
                                                            <i class="bi bi-trash"></i> Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer bg-white border-0 p-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
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
                                $shipping = 200;
                                $discount = isset($coupon) ? $coupon['discount_amount'] : 0;
                                $total = $subtotal - $discount + $shipping;
                            @endphp

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-bold" id="cart-subtotal">PKR {{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Shipping</span>
                                <span class="fw-bold">PKR {{ number_format($shipping, 2) }}</span>
                            </div>

                            @if(isset($coupon))
                                <div class="d-flex justify-content-between mb-3 text-success">
                                    <span>
                                        <i class="bi bi-ticket-perforated me-1"></i>
                                        {{ $coupon['code'] }}
                                        <form action="{{ route('coupon.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-1">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    </span>
                                    <span class="fw-bold">-PKR {{ number_format($discount, 2) }}</span>
                                </div>
                            @else
                                <!-- Coupon Code -->
                                <div class="mb-3">
                                    <form action="{{ route('coupon.apply') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="code" class="form-control" 
                                                   placeholder="Coupon Code" style="text-transform: uppercase;">
                                            <button class="btn btn-outline-primary" type="submit">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold">Total</span>
                                <span class="fs-5 fw-bold text-primary" id="cart-total">PKR {{ number_format($total, 2) }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 fw-bold">
                                <i class="bi bi-lock me-2"></i>Proceed to Checkout
                            </a>

                            <!-- Payment Icons -->
                            <div class="text-center mt-4">
                                <p class="text-muted small mb-2">We Accept</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <i class="bi bi-credit-card fs-4 text-secondary"></i>
                                    <i class="bi bi-cash-stack fs-4 text-secondary"></i>
                                    <i class="bi bi-wallet2 fs-4 text-secondary"></i>
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
                                    <p class="text-muted small mb-0">Aap ka data safe hai</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <i class="bi bi-truck text-primary fs-4"></i>
                                <div>
                                    <strong>Fast Delivery</strong>
                                    <p class="text-muted small mb-0">2-5 business days</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                                <div>
                                    <strong>Easy Returns</strong>
                                    <p class="text-muted small mb-0">30 days return policy</p>
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
                <h3 class="fw-bold mb-3">Aap ka cart khali hai</h3>
                <p class="text-muted mb-4">Lagta hai aap ne abhi tak koi item add nahi kiya.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-bag me-2"></i>Shopping Karein
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateQty(btn, delta) {
        const inputGroup = btn.closest('.input-group');
        const input = inputGroup.querySelector('input');
        const cartItem = btn.closest('.cart-item');
        const itemId = input.dataset.itemId;
        
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        input.value = val;
        
        // Disable buttons during request
        const buttons = inputGroup.querySelectorAll('button');
        buttons.forEach(b => b.disabled = true);
        input.disabled = true;
        
        // AJAX request
        fetch(`/cart/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: val })
        })
        .then(async (response) => {
            const data = await response.json().catch(() => ({}));
            return { ok: response.ok, data };
        })
        .then(({ ok, data }) => {
            if (ok && data.success) {
                // Update item subtotal
                const unitPrice = parseFloat(input.dataset.unitPrice || cartItem.querySelector('[data-role="unit-price"]')?.dataset?.unitPrice || '0');
                const newSubtotal = unitPrice * val;
                const subtotalEl = cartItem.querySelector('[data-role="item-subtotal"]');
                if (subtotalEl) {
                    subtotalEl.textContent = 'PKR ' + newSubtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
                
                // Update totals in summary
                document.getElementById('cart-subtotal').textContent = 'PKR ' + data.subtotal;
                document.getElementById('cart-total').textContent = 'PKR ' + data.total;
                
                // Update cart badge
                const badge = document.getElementById('cart-badge');
                if (badge && data.cart_count !== undefined) {
                    badge.textContent = data.cart_count;
                }
                
                showNotification('Cart updated!', 'success');
            } else {
                showNotification(data.message || 'Error updating cart', 'error');
                input.value = val - delta; // Revert
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating cart', 'error');
        })
        .finally(() => {
            buttons.forEach(b => b.disabled = false);
            input.disabled = false;
        });
    }
    
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.style.cssText = 'position:fixed;top:100px;right:20px;background:var(--primary-color);color:white;padding:1rem 1.5rem;border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.2);z-index:10000;animation:slideIn 0.3s ease;font-weight:500;';
        if (type === 'error') notification.style.background = 'var(--danger-color)';
        notification.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
<style>
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
</style>
@endsection
