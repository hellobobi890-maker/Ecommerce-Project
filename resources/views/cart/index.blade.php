@extends('layouts.app')

@section('content')
    <div class="cart-page py-4">
        <div class="container">
            <!-- Step Progress Indicator -->
            <div class="step-progress mb-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="step-item active">
                        <div class="step-circle">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <span class="step-label">Shopping Cart</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
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

            @if (count($cart) > 0)
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-items-container bg-white rounded-4 shadow-sm overflow-hidden">
                            <!-- Header -->
                            <div
                                class="cart-header px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1 fw-bold">Shopping Cart</h4>
                                    <span class="text-muted small">{{ count($cart) }} item(s) in your cart</span>
                                </div>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        onclick="return confirm('Clear all items from cart?')">
                                        <i class="bi bi-trash me-1"></i>Clear All
                                    </button>
                                </form>
                            </div>

                            <!-- Items List -->
                            <div class="cart-items-list">
                                @foreach ($cart as $id => $details)
                                    @php
                                        $unitPrice = (float) ($details['price'] ?? 0);
                                        $lineTotal = $unitPrice * (int) ($details['quantity'] ?? 1);
                                    @endphp
                                    <div class="cart-item p-4 border-bottom" data-item-id="{{ $id }}">
                                        <div class="row align-items-center g-3">
                                            <!-- Product Image -->
                                            <div class="col-auto">
                                                <div class="cart-item-image rounded-3 overflow-hidden bg-light"
                                                    style="width: 110px; height: 130px;">
                                                    <a href="{{ route('shop.show', $details['slug'] ?? '#') }}">
                                                        <img src="{{ $details['image'] ?? 'https://placehold.co/110x130?text=Product' }}"
                                                            alt="{{ $details['name'] }}" class="w-100 h-100"
                                                            style="object-fit: cover;">
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="col">
                                                <a href="{{ route('shop.show', $details['slug'] ?? '#') }}"
                                                    class="text-decoration-none">
                                                    <h6 class="fw-bold mb-2 text-dark">{{ $details['name'] }}</h6>
                                                </a>

                                                <div class="d-flex flex-wrap gap-2 mb-2">
                                                    @if (isset($details['size']) && $details['size'] != 'default')
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="bi bi-rulers me-1"></i>Size: {{ $details['size'] }}
                                                        </span>
                                                    @endif
                                                    @if (isset($details['color']) && $details['color'] != 'default')
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="bi bi-palette me-1"></i>Color: {{ $details['color'] }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="text-muted small" data-role="unit-price"
                                                    data-unit-price="{{ $unitPrice }}">
                                                    PKR {{ number_format($unitPrice, 2) }} each
                                                </div>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-auto">
                                                <div class="quantity-control d-flex align-items-center bg-light rounded-pill"
                                                    style="height: 44px;">
                                                    <button class="btn btn-link text-dark px-3 border-0" type="button"
                                                        onclick="updateQty(this, -1)">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </button>
                                                    <input type="number" name="quantity"
                                                        class="form-control border-0 text-center bg-transparent fw-bold"
                                                        value="{{ $details['quantity'] }}" min="1"
                                                        data-item-id="{{ $id }}"
                                                        data-unit-price="{{ $unitPrice }}" style="width: 50px;">
                                                    <button class="btn btn-link text-dark px-3 border-0" type="button"
                                                        onclick="updateQty(this, 1)">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Subtotal & Remove -->
                                            <div class="col-auto text-end" style="min-width: 120px;">
                                                <div class="fw-bold fs-5 text-dark mb-2" data-role="item-subtotal">
                                                    PKR {{ number_format($lineTotal, 2) }}
                                                </div>
                                                <form action="{{ route('cart.destroy', $id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 small"
                                                        onclick="return confirm('Remove this item?')">
                                                        <i class="bi bi-trash me-1"></i>Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Continue Shopping -->
                            <div class="p-4 bg-light">
                                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="order-summary-card bg-white rounded-4 shadow-sm overflow-hidden"
                            style="position: sticky; top: 100px;">
                            <div class="p-4 border-bottom bg-dark text-white">
                                <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Order Summary</h5>
                            </div>

                            <div class="p-4">
                                @php
                                    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                                    $shipping = 200;
                                    $discount = isset($coupon) ? $coupon['discount_amount'] : 0;
                                    $total = $subtotal - $discount + $shipping;
                                @endphp

                                <div class="summary-row d-flex justify-content-between py-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold" id="cart-subtotal">PKR
                                        {{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="summary-row d-flex justify-content-between py-2">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-semibold">PKR {{ number_format($shipping, 2) }}</span>
                                </div>

                                @if (isset($coupon))
                                    <div class="summary-row d-flex justify-content-between py-2 text-success">
                                        <span>
                                            <i class="bi bi-ticket-perforated me-1"></i>{{ $coupon['code'] }}
                                            <form action="{{ route('coupon.remove') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-1">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </span>
                                        <span class="fw-semibold">-PKR {{ number_format($discount, 2) }}</span>
                                    </div>
                                @else
                                    <!-- Coupon Code -->
                                    <div class="coupon-section py-3">
                                        <form action="{{ route('coupon.apply') }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="code"
                                                    class="form-control rounded-start-pill"
                                                    placeholder="Enter coupon code" style="text-transform: uppercase;">
                                                <button class="btn btn-dark rounded-end-pill px-4"
                                                    type="submit">Apply</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                                <hr class="my-3">

                                <div class="summary-row d-flex justify-content-between py-2">
                                    <span class="fs-5 fw-bold">Total</span>
                                    <span class="fs-5 fw-bold text-primary" id="cart-total">PKR
                                        {{ number_format($total, 2) }}</span>
                                </div>

                                <a href="{{ route('checkout.index') }}"
                                    class="btn btn-primary btn-lg w-100 fw-bold py-3 mt-3 rounded-pill">
                                    <i class="bi bi-lock me-2"></i>Proceed to Checkout
                                </a>

                                <!-- Trust Badges -->
                                <div class="trust-badges mt-4 pt-4 border-top">
                                    <div class="row g-3 text-center">
                                        <div class="col-4">
                                            <i class="bi bi-shield-check text-success fs-4 d-block mb-1"></i>
                                            <span class="small text-muted">Secure</span>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-truck text-primary fs-4 d-block mb-1"></i>
                                            <span class="small text-muted">Fast Delivery</span>
                                        </div>
                                        <div class="col-4">
                                            <i class="bi bi-arrow-repeat text-warning fs-4 d-block mb-1"></i>
                                            <span class="small text-muted">Easy Returns</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Methods -->
                                <div class="payment-methods mt-4 pt-3 border-top text-center">
                                    <span class="text-muted small d-block mb-2">We Accept</span>
                                    <div class="d-flex justify-content-center gap-3">
                                        <i class="bi bi-credit-card fs-4 text-secondary"></i>
                                        <i class="bi bi-cash-stack fs-4 text-secondary"></i>
                                        <i class="bi bi-wallet2 fs-4 text-secondary"></i>
                                        <i class="bi bi-bank fs-4 text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="empty-cart-container bg-white rounded-4 shadow-sm p-5 text-center">
                    <div class="empty-cart-icon mb-4">
                        <i class="bi bi-cart-x" style="font-size: 100px; color: #e5e7eb;"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-bag me-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateQty(btn, delta) {
            const inputGroup = btn.closest('.quantity-control');
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
                    body: JSON.stringify({
                        quantity: val
                    })
                })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));
                    return {
                        ok: response.ok,
                        data
                    };
                })
                .then(({
                    ok,
                    data
                }) => {
                    if (ok && data.success) {
                        // Update item subtotal
                        const unitPrice = parseFloat(input.dataset.unitPrice || cartItem.querySelector(
                            '[data-role="unit-price"]')?.dataset?.unitPrice || '0');
                        const newSubtotal = unitPrice * val;
                        const subtotalEl = cartItem.querySelector('[data-role="item-subtotal"]');
                        if (subtotalEl) {
                            subtotalEl.textContent = 'PKR ' + newSubtotal.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }

                        // Update totals in summary
                        document.getElementById('cart-subtotal').textContent = 'PKR ' + data.subtotal;
                        document.getElementById('cart-total').textContent = 'PKR ' + data.total;

                        const discountLine = document.querySelector('.summary-row.text-success');
                        if (discountLine && data.discount !== undefined) {
                            const discountValueEl = discountLine.querySelector('span.fw-semibold');
                            if (discountValueEl) discountValueEl.textContent = '-PKR ' + data.discount;
                        }

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
            notification.className = `notification ${type}`;
            notification.innerHTML =
                `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        /* Cart Page Styles */
        .cart-page {
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

        /* Cart Items */
        .cart-item {
            transition: background 0.2s ease;
        }

        .cart-item:hover {
            background: #f8fafc;
        }

        .cart-item:last-child {
            border-bottom: none !important;
        }

        .cart-item-image img {
            transition: transform 0.3s ease;
        }

        .cart-item:hover .cart-item-image img {
            transform: scale(1.05);
        }

        /* Quantity Control */
        .quantity-control {
            border: 1px solid #e5e7eb;
        }

        .quantity-control input {
            font-size: 1rem;
        }

        .quantity-control input:focus {
            outline: none;
            box-shadow: none;
        }

        /* Order Summary */
        .order-summary-card {
            transition: box-shadow 0.3s ease;
        }

        .order-summary-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12) !important;
        }

        /* Empty Cart */
        .empty-cart-container {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        }

        .notification.error {
            background: var(--danger-color);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
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

        @media (max-width: 767.98px) {
            .cart-item .row {
                flex-direction: column;
                text-align: center;
            }

            .cart-item .row>.col-auto {
                width: 100%;
            }

            .cart-item-image {
                margin: 0 auto;
            }

            .quantity-control {
                justify-content: center;
                margin: 1rem auto;
            }
        }
    </style>
@endsection
