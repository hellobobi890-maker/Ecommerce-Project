@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Edit Category</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="form-control" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Image URL</label>
                            <input type="url" name="image" id="image" value="{{ old('image', $category->image) }}"
                                class="form-control">
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <input type="hidden" name="is_active" value="0"> <!-- Fallback -->
                                <label class="form-check-label fw-medium" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Delete Button (Trigger Modal or direct form) - doing direct form here for simplicity but outside main form -->
                            <div></div> <!-- Spacer -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-light text-muted">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Section -->
            <div class="card border-0 shadow-sm rounded-4 border-danger-subtle">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger fw-bold mb-1">Delete Category</h6>
                        <p class="text-muted small mb-0">Once deleted, this category cannot be recovered.</p>
                    </div>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
