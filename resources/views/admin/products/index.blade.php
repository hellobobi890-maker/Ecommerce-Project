@extends('layouts.admin')

@section('page-title', 'Products')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">All Products</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Product
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted fs-7 fw-bold">Name</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Price</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Stock</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Category</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Status</th>
                            <th class="pe-4 py-3 text-uppercase text-muted fs-7 fw-bold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{ $product->name }}</td>
                                <td class="fw-bold">PKR {{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $product->stock > 10 ? 'info' : ($product->stock > 0 ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $product->stock > 10 ? 'info' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $product->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $product->is_active ? 'success' : 'secondary' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="btn btn-sm btn-light text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
