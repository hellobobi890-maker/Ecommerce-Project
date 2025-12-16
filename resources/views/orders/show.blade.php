@extends('layouts.app')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Order Details</h5>
                        <span class="text-muted">{{ $order->order_number }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0">
                                @php
                                    $image = $item->product && is_array($item->product->images) && count($item->product->images) > 0 
                                        ? $item->product->images[0] 
                                        : 'https://placehold.co/80x80?text=Product';
                                @endphp
                                <img src="{{ $image }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $item->product->name ?? 'Product Deleted' }}</h6>
                                @if($item->size && $item->size != 'default')
                                    <small class="text-muted me-2">Size: {{ $item->size }}</small>
                                @endif
                                @if($item->color && $item->color != 'default')
                                    <small class="text-muted">Color: {{ $item->color }}</small>
                                @endif
                                <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-end">
                                <strong>PKR {{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </div>
                        </div>

                        @if($order->status === 'delivered' && ($item->product_id ?? null) && !(isset($reviewedProductIds) && in_array($item->product_id, $reviewedProductIds)))
                            <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <form action="{{ route('reviews.store') }}" method="POST" class="row g-2 align-items-end">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <div class="col-12 col-md-3">
                                        <label class="form-label small text-muted">Rating</label>
                                        <select name="rating" class="form-select form-select-sm" required>
                                            <option value="5">5</option>
                                            <option value="4">4</option>
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <label class="form-label small text-muted">Comment</label>
                                        <input type="text" name="comment" class="form-control form-control-sm" placeholder="Optional">
                                    </div>
                                    <div class="col-12 col-md-2 d-grid">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Leave Review</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Order Tracking -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2"></i>Order Tracking</h5>
                </div>
                <div class="card-body">
                    <div class="order-tracking">
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                            if($order->status == 'cancelled') $currentIndex = -1;
                        @endphp
                        
                        @if($order->status == 'cancelled')
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle me-2"></i>Order Cancelled ho gaya hai.
                            </div>
                        @else
                            <div class="d-flex justify-content-between position-relative tracking-steps">
                                <div class="tracking-line" style="position: absolute; top: 20px; left: 10%; right: 10%; height: 4px; background: #e9ecef; z-index: 0;">
                                    <div style="width: {{ $currentIndex >= 0 ? ($currentIndex / 3) * 100 : 0 }}%; height: 100%; background: var(--primary-color, #0d6efd);"></div>
                                </div>
                                
                                @foreach($statuses as $index => $status)
                                    <div class="text-center position-relative" style="z-index: 1;">
                                        <div class="tracking-step rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                             style="width: 40px; height: 40px; background: {{ $index <= $currentIndex ? 'var(--primary-color, #0d6efd)' : '#e9ecef' }}; color: {{ $index <= $currentIndex ? 'white' : '#999' }};">
                                            @if($index <= $currentIndex)
                                                <i class="bi bi-check"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                        <small class="{{ $index <= $currentIndex ? 'fw-bold' : 'text-muted' }}">
                                            {{ ucfirst($status) }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Order Date</span>
                        <span>{{ $order->created_at->format('d M, Y h:i A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status</span>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            ];
                            $color = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Payment</span>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Payment Method</span>
                        <span>{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-5 text-primary">PKR {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2"></i>Shipping Address</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->full_name ?? $order->user->name ?? auth()->user()->name }}</strong></p>
                    @if(($order->email ?? null) || ($order->user->email ?? null))
                        <p class="mb-1 text-muted">{{ $order->email ?? $order->user->email }}</p>
                    @endif
                    <p class="mb-1 text-muted">{{ $order->shipping_address }}</p>
                    @if($order->phone)
                        <p class="mb-0 text-muted"><i class="bi bi-telephone me-2"></i>{{ $order->phone }}</p>
                    @endif
                </div>
            </div>

            @if($order->notes)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-sticky me-2"></i>Order Notes</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                    <i class="bi bi-arrow-left me-2"></i>Back to Orders
                </a>
                @if($order->status === 'delivered')
                    <form action="{{ route('orders.reorder', $order->order_number) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-repeat me-2"></i>Re-order
                        </button>
                    </form>
                @endif
                <a href="{{ route('shop.index') }}" class="btn btn-primary w-100">
                    <i class="bi bi-bag me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
