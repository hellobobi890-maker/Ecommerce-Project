@extends('layouts.admin')

@section('page-title', 'Order Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
            <p class="text-muted mb-0 small">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Orders
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Order Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase text-muted fs-7 border-0 rounded-start">Product</th>
                                    <th class="py-3 text-uppercase text-muted fs-7 border-0">Price</th>
                                    <th class="py-3 text-uppercase text-muted fs-7 border-0">Qty</th>
                                    <th class="pe-4 py-3 text-uppercase text-muted fs-7 border-0 rounded-end text-end">Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="ps-4 border-bottom-0">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-3 overflow-hidden me-3 flex-shrink-0"
                                                    style="width: 60px; height: 60px;">
                                                    @php
                                                        $img = null;
                                                        if ($item->product && is_array($item->product->images) && count($item->product->images) > 0) {
                                                            $img = $item->product->images[0];
                                                        }
                                                        $img = $img ?: 'https://placehold.co/100x100?text=Product';
                                                    @endphp
                                                    <img src="{{ $img }}"
                                                        alt="{{ $item->product->name ?? 'Product' }}"
                                                        class="w-100 h-100 object-fit-cover">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $item->product->name ?? 'Product Deleted' }}</h6>
                                                    <small
                                                        class="text-muted">{{ $item->product->category->name ?? 'Uncategorized' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">PKR {{ number_format($item->price, 2) }}</td>
                                        <td class="border-bottom-0">{{ $item->quantity }}</td>
                                        <td class="pe-4 border-bottom-0 text-end fw-bold">
                                            PKR {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="3" class="text-end py-3 fw-bold">Total Amount</td>
                                    <td class="pe-4 py-3 text-end fw-bold h5 text-primary">
                                        PKR {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="col-lg-4">
            <!-- Customer Details -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Customer Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 d-flex align-items-center">
                        <div class="avatar-circle bg-light text-primary me-3 rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; font-size: 1.2rem;">
                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">{{ $order->user->name ?? 'Guest User' }}</h6>
                            <small class="text-muted">{{ $order->user->email ?? 'No email provided' }}</small>
                        </div>
                    </div>
                    <hr class="border-light my-3">
                    <div class="mb-3">
                        <label class="text-uppercase text-muted fs-7 fw-bold mb-1">Shipping Address</label>
                        <p class="mb-0 fw-medium text-dark">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Order Status</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label fw-medium">Change Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
