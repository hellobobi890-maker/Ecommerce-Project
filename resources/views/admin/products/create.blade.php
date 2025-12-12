@extends('layouts.admin')

@section('page-title', 'Create Product')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Add New Product</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Main Column (Left) -->
                            <div class="col-lg-8">
                                <!-- Info Card -->
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Product Information</h6>
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Product Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="e.g. Classic T-Shirt" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea id="description" name="description" rows="5" class="form-control"
                                                placeholder="Enter product description..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media & Variations Card -->
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Media & Variations</h6>
                                        <div class="mb-3">
                                            <label for="main_image" class="form-label fw-bold">Main Image (Card)</label>
                                            <input type="file" name="main_image" id="main_image" class="form-control"
                                                accept="image/*">
                                            <div class="form-text">This image will appear on the product card.</div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="gallery_images" class="form-label fw-bold">Gallery Images
                                                (Slider)</label>
                                            <input type="file" name="gallery_images[]" id="gallery_images"
                                                class="form-control" accept="image/*" multiple>
                                            <div class="form-text">These images will appear in the popup slider.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small d-block">Color Options</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $colors = [
                                                        'Red',
                                                        'Blue',
                                                        'Black',
                                                        'White',
                                                        'Green',
                                                        'Yellow',
                                                        'Grey',
                                                        'Brown',
                                                    ];
                                                @endphp
                                                @foreach ($colors as $color)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="color_options[]" value="{{ $color }}"
                                                            id="color_{{ $color }}">
                                                        <label class="form-check-label" for="color_{{ $color }}">
                                                            {{ $color }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold small d-block">Size Options</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @php
                                                    $sizes = [
                                                        'XS',
                                                        'S',
                                                        'M',
                                                        'L',
                                                        'XL',
                                                        'XXL',
                                                        '28',
                                                        '30',
                                                        '32',
                                                        '34',
                                                        '36',
                                                        '38',
                                                        '40',
                                                        '42',
                                                    ];
                                                @endphp
                                                @foreach ($sizes as $size)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="sizes[]"
                                                            value="{{ $size }}" id="size_{{ $size }}">
                                                        <label class="form-check-label" for="size_{{ $size }}">
                                                            {{ $size }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar Column (Right) -->
                            <div class="col-lg-4">
                                <!-- Status Card -->
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Status & Visibility</h6>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" checked>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="is_featured"
                                                name="is_featured" value="1">
                                            <label class="form-check-label" for="is_featured">Featured Product</label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_trending"
                                                name="is_trending" value="1">
                                            <label class="form-check-label" for="is_trending">Weekly Trending</label>
                                        </div>

                                        <div class="mb-3">
                                            <label for="badge_text" class="form-label fw-bold small">Badge Text</label>
                                            <input type="text" name="badge_text" id="badge_text" class="form-control"
                                                placeholder="e.g. HOT, SALE">
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Card -->
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Pricing</h6>
                                        <div class="mb-3">
                                            <label for="price" class="form-label fw-bold">Price (Pkr)</label>
                                            <input type="number" name="price" id="price" step="0.01"
                                                class="form-control" placeholder="0.00" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label fw-bold">Sale Price (Pkr)</label>
                                            <input type="number" name="sale_price" id="sale_price" step="0.01"
                                                class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <!-- Organization Card -->
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Organization</h6>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label fw-bold">Category</label>
                                            <select id="category_id" name="category_id" class="form-select" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sku" class="form-label fw-bold">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="e.g. TSHIRT-001" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock" class="form-label fw-bold">Stock Quantity</label>
                                            <input type="number" name="stock" id="stock" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light text-muted">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
