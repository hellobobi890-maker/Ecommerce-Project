@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Orders</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    <i class="bi bi-box-seam me-2"></i>My Orders
                </h2>
            </div>

            @if($orders->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4">Order ID</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Payment</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3 text-end px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="py-3 px-4">
                                                <strong class="text-primary">{{ $order->order_number }}</strong>
                                            </td>
                                            <td class="py-3">{{ $order->created_at->format('d M, Y') }}</td>
                                            <td class="py-3">
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
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 fw-bold">PKR {{ number_format($order->total_amount, 2) }}</td>
                                            <td class="py-3 text-end px-4">
                                                <a href="{{ route('orders.show', $order->order_number) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted"></i>
                    <h4 class="mt-3">Koi order nahi mila</h4>
                    <p class="text-muted mb-4">Aap ne abhi tak koi order nahi kiya.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">
                        <i class="bi bi-bag me-2"></i>Shopping Karein
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
