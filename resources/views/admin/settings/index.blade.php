@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Settings</h4>
                <p class="text-muted small mb-0">Manage your store settings</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-truck me-2 text-primary"></i>Shipping Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Shipping Fee (PKR)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">PKR</span>
                                    <input type="number" name="shipping_fee"
                                        class="form-control border-start-0 @error('shipping_fee') is-invalid @enderror"
                                        value="{{ old('shipping_fee', $shippingFee) }}" min="0" max="10000"
                                        step="1">
                                </div>
                                @error('shipping_fee')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Set to <strong>0</strong> for Free Shipping.
                                </div>
                            </div>

                            <div class="bg-light rounded-3 p-3 mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-lightbulb text-warning fs-4"></i>
                                    </div>
                                    <div class="small">
                                        <strong>Quick Options:</strong>
                                        <div class="mt-1 d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="setShipping(0)">Free Shipping</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="setShipping(100)">PKR 100</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="setShipping(200)">PKR 200</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="setShipping(300)">PKR 300</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg px-4 rounded-pill">
                                <i class="bi bi-check-circle me-2"></i>Save Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-dark text-white border-0 py-3 px-4 rounded-top-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-eye me-2"></i>Preview: Order Summary</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">PKR 2,500</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-semibold" id="preview-shipping">
                                @if ($shippingFee == 0)
                                    <span class="text-success">FREE</span>
                                @else
                                    PKR {{ number_format($shippingFee, 0) }}
                                @endif
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary" id="preview-total">PKR
                                {{ number_format(2500 + $shippingFee, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setShipping(amount) {
            document.querySelector('input[name="shipping_fee"]').value = amount;
            // Update preview
            const shippingEl = document.getElementById('preview-shipping');
            const totalEl = document.getElementById('preview-total');

            if (amount === 0) {
                shippingEl.innerHTML = '<span class="text-success">FREE</span>';
            } else {
                shippingEl.innerHTML = 'PKR ' + amount.toLocaleString();
            }
            totalEl.innerHTML = 'PKR ' + (2500 + amount).toLocaleString();
        }
    </script>
@endsection
