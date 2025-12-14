@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Coupons Management</h2>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Coupon
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">Code</th>
                        <th class="py-3">Discount</th>
                        <th class="py-3">Min Order</th>
                        <th class="py-3">Usage</th>
                        <th class="py-3">Valid Until</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td class="py-3 px-4">
                                <code class="bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                            </td>
                            <td class="py-3">
                                @if($coupon->discount_type == 'percentage')
                                    {{ $coupon->discount_value }}%
                                @else
                                    PKR {{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </td>
                            <td class="py-3">
                                @if($coupon->min_order_amount)
                                    PKR {{ number_format($coupon->min_order_amount, 2) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                {{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}
                            </td>
                            <td class="py-3">
                                @if($coupon->valid_until)
                                    {{ $coupon->valid_until->format('d M, Y') }}
                                @else
                                    <span class="text-muted">No Expiry</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($coupon->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3 text-end px-4">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Kya aap sure hain? Coupon delete ho jayega.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Koi coupon nahi mila
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $coupons->links() }}
</div>
@endsection
