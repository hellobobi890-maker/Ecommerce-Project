@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                            <i class="fas fa-dollar-sign fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">+12% <i class="fas fa-arrow-up"></i></span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1">Total Revenue</h6>
                    <h3 class="fw-bold mb-0 text-dark">PKR {{ number_format($totalRevenue, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                            <i class="fas fa-shopping-bag fa-lg"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger">-2% <i class="fas fa-arrow-down"></i></span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                            <i class="fas fa-box-open fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">+5% <i class="fas fa-arrow-up"></i></span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1">Total Products</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-purple bg-opacity-10 text-purple rounded-3 p-3 text-secondary">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">+8% <i class="fas fa-arrow-up"></i></span>
                    </div>
                    <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1">Total Customers</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted fs-7 fw-bold">Order ID</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Customer</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Total</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Status</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Date</th>
                            <th class="pe-4 py-3 text-uppercase text-muted fs-7 fw-bold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $order->order_number }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle text-center d-flex justify-content-center align-items-center me-2"
                                            style="width: 30px; height: 30px;">
                                            {{ substr(($order->full_name ?? $order->user->name) ?? 'G', 0, 1) }}
                                        </div>
                                        <span>{{ $order->full_name ?? $order->user->name ?? 'Guest User' }}</span>
                                    </div>
                                </td>
                                <td class="fw-bold">PKR {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} text-dark bg-opacity-25 text-opacity-100">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-light text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No recent orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
