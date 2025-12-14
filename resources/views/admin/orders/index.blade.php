@extends('layouts.admin')

@section('page-title', 'Orders')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="mb-0 fw-bold">Recent Orders</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted fs-7 fw-bold">Order Number</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Products</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Customer</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Date</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Status</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Total</th>
                            <th class="pe-4 py-3 text-uppercase text-muted fs-7 fw-bold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">#{{ $order->order_number }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $thumbs = $order->items->take(3);
                                            $extraCount = max(0, $order->items->count() - 3);
                                        @endphp
                                        @foreach ($thumbs as $item)
                                            @php
                                                $img = null;
                                                if ($item->product && is_array($item->product->images) && count($item->product->images) > 0) {
                                                    $img = $item->product->images[0];
                                                }
                                                $img = $img ?: 'https://placehold.co/40x40?text=Img';
                                            @endphp
                                            <img src="{{ $img }}" class="rounded-2 border me-1" style="width: 40px; height: 40px; object-fit: cover;" alt="Product">
                                        @endforeach

                                        @if ($extraCount > 0)
                                            <span class="small text-muted ms-1">+{{ $extraCount }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2 rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <span>{{ $order->user->name ?? 'Guest User' }}</span>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($order->status) {
                                            'completed', 'delivered' => 'success',
                                            'processed', 'processing', 'shipped' => 'info',
                                            'cancelled' => 'danger',
                                            default => 'warning',
                                        };
                                    @endphp
                                    <span
                                        class="badge rounded-pill bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-light text-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
