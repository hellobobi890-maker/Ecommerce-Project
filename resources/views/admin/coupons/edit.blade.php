@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Coupons
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Edit Coupon: {{ $coupon->code }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control text-uppercase @error('code') is-invalid @enderror" 
                           value="{{ old('code', $coupon->code) }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" required>
                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (PKR)</option>
                    </select>
                    @error('discount_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" step="0.01" class="form-control @error('discount_value') is-invalid @enderror" 
                           value="{{ old('discount_value', $coupon->discount_value) }}" required>
                    @error('discount_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Minimum Order Amount</label>
                    <input type="number" name="min_order_amount" step="0.01" class="form-control @error('min_order_amount') is-invalid @enderror" 
                           value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                    @error('min_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Maximum Uses</label>
                    <input type="number" name="max_uses" class="form-control @error('max_uses') is-invalid @enderror" 
                           value="{{ old('max_uses', $coupon->max_uses) }}" placeholder="Leave empty for unlimited">
                    <small class="text-muted">Currently used: {{ $coupon->used_count }} times</small>
                    @error('max_uses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Valid From</label>
                    <input type="datetime-local" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" 
                           value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d\TH:i')) }}">
                    @error('valid_from')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Valid Until</label>
                    <input type="datetime-local" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror" 
                           value="{{ old('valid_until', $coupon->valid_until?->format('Y-m-d\TH:i')) }}">
                    @error('valid_until')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                               {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Coupon
                        </label>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-2"></i>Update Coupon
            </button>
        </form>
    </div>
</div>
@endsection
