@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="font-weight-bold text-dark mb-0">{{ __('Dashboard') }}</h2>
            </div>
        </div>

        <div class="row g-4">
            <!-- Welcome Card -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="h5 card-title text-dark">Welcome, {{ auth()->user()->name }}!</h3>
                        <p class="card-text text-muted small">You can view your recent orders and manage your account here.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h3 class="h5 card-title text-dark mb-0">Order History</h3>
                    </div>
                    <div class="card-body p-4">
                        @if ($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3 ps-3">Order ID</th>
                                            <th class="py-3">Date</th>
                                            <th class="py-3">Total</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3">Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="ps-3 fw-bold">#{{ $order->order_number }}</td>
                                                <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} text-dark bg-opacity-25 text-opacity-100">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="small text-muted">
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($order->items as $item)
                                                            <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-3">You have no recent orders.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary">Start Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="h5 card-title text-dark mb-1">Account Settings</h3>
                            <p class="card-text text-muted small mb-0">Manage your profile information and password.</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
