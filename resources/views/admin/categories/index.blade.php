@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">All Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Add Category
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted fs-7 fw-bold">Name</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Slug</th>
                            <th class="py-3 text-uppercase text-muted fs-7 fw-bold">Status</th>
                            <th class="pe-4 py-3 text-uppercase text-muted fs-7 fw-bold text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{ $category->name }}</td>
                                <td class="text-muted">{{ $category->slug }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill bg-{{ $category->is_active ? 'success' : 'danger' }} bg-opacity-10 text-{{ $category->is_active ? 'success' : 'danger' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-sm btn-light text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
