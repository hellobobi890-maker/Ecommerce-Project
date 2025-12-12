@extends('layouts.admin')

@section('page-title', 'Create Category')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Add New Category</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="e.g. Men's Clothing" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea id="description" name="description" rows="4" class="form-control"
                                placeholder="Enter category description..."></textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Image URL</label>
                            <input type="url" name="image" id="image" class="form-control"
                                placeholder="https://example.com/image.jpg">
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" checked>
                                <label class="form-check-label fw-medium" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light text-muted">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
