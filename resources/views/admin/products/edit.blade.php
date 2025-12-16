@extends('layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">Edit Product</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <!-- Main Column (Left) -->
                            <div class="col-lg-8">
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Product Information</h6>
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Product Name</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $product->name) }}" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                            <textarea id="description" name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">Media & Variations</h6>
                                        <div class="mb-4">
                                            <!-- Main Image Section -->
                                            <h6 class="fw-bold text-dark mb-3">1. Main Image (Card)</h6>
                                            @php
                                                $mainImage =
                                                    is_array($product->images) && count($product->images) > 0
                                                        ? $product->images[0]
                                                        : null;
                                                $galleryImages =
                                                    is_array($product->images) && count($product->images) > 1
                                                        ? array_slice($product->images, 1)
                                                        : [];
                                            @endphp

                                            <div class="mb-3 p-3 bg-white rounded border">
                                                @if ($mainImage)
                                                    <div class="mb-2">
                                                        <label class="form-label small text-muted">Current Main
                                                            Image:</label>
                                                        <div>
                                                            <img src="{{ $mainImage }}" class="img-thumbnail"
                                                                style="height: 150px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                @endif
                                                <label for="main_image" class="form-label fw-bold small">Upload New Main
                                                    Image</label>
                                                <input type="file" name="main_image" id="main_image" class="form-control"
                                                    accept="image/*">
                                                <div class="form-text">Replaces the card image (and first slider image).
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <!-- Gallery Section -->
                                            <h6 class="fw-bold text-dark mb-3">2. Gallery Images (Slider)</h6>
                                            <div class="p-3 bg-white rounded border">
                                                @if (count($galleryImages) > 0)
                                                    <label class="form-label small text-muted">Current Slider
                                                        Images:</label>
                                                    <div class="row g-2 mb-3">
                                                        @foreach ($galleryImages as $img)
                                                            <div class="col-6 col-sm-4 col-md-3 position-relative">
                                                                <img src="{{ $img }}" class="img-thumbnail w-100"
                                                                    style="height: 80px; object-fit: cover;">
                                                                <div class="form-check position-absolute top-0 start-0 m-1">
                                                                    <input
                                                                        class="form-check-input bg-danger border-0 shadow-sm"
                                                                        type="checkbox" name="delete_images[]"
                                                                        value="{{ $img }}" title="Check to Delete">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="form-text text-danger mb-2"><small>Check box to remove from
                                                            slider.</small></div>
                                                @endif

                                                <label for="gallery_images" class="form-label fw-bold small">Add More to
                                                    Slider</label>
                                                <input type="file" name="gallery_images[]" id="gallery_images"
                                                    class="form-control" accept="image/*" multiple>
                                                <div class="form-text">Appends to the slider.</div>
                                            </div>
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
                                                    $selectedColors = is_array($product->color_options)
                                                        ? $product->color_options
                                                        : [];
                                                @endphp
                                                @foreach ($colors as $color)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="color_options[]" value="{{ $color }}"
                                                            id="color_{{ $color }}"
                                                            {{ in_array($color, $selectedColors) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="color_{{ $color }}">
                                                            {{ $color }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="use_variant_stock" name="use_variant_stock"
                                                value="1" {{ isset($product) && $product->relationLoaded('variants') && $product->variants->isNotEmpty() ? 'checked' : '' }}>
                                            <label class="form-check-label" for="use_variant_stock">Use variant stock (per color / size)</label>
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
                                                    $selectedSizes = is_array($product->sizes) ? $product->sizes : [];
                                                @endphp
                                                @foreach ($sizes as $size)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="sizes[]"
                                                            value="{{ $size }}" id="size_{{ $size }}"
                                                            {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="size_{{ $size }}">
                                                            {{ $size }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        @php
                                            $variantStockMap = [];
                                            if (isset($product) && $product->relationLoaded('variants')) {
                                                foreach ($product->variants as $v) {
                                                    $variantStockMap[$v->variant_key] = $v->stock;
                                                }
                                            }
                                        @endphp

                                        <div class="mt-4">
                                            <label class="form-label fw-bold small d-block">Variant Stock (Per Color / Size)</label>
                                            <div class="bg-white rounded border p-3">
                                                <div id="variant-stock-grid" class="table-responsive"></div>
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
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                name="is_active" value="1"
                                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                        <div class="form-check form-switch mb-2">
                                            <input type="hidden" name="is_featured" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_featured"
                                                name="is_featured" value="1"
                                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Product</label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input type="hidden" name="is_trending" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_trending"
                                                name="is_trending" value="1"
                                                {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_trending">Weekly Trending</label>
                                        </div>

                                        <div class="mb-3">
                                            <label for="badge_text" class="form-label fw-bold small">Badge Text</label>
                                            <input type="text" name="badge_text" id="badge_text" class="form-control"
                                                value="{{ old('badge_text', $product->badge_text) }}"
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
                                            <input type="number" name="price" id="price"
                                                value="{{ old('price', $product->price) }}" step="0.01"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label fw-bold">Sale Price (Pkr)</label>
                                            <input type="number" name="sale_price" id="sale_price"
                                                value="{{ old('sale_price', $product->sale_price) }}" step="0.01"
                                                class="form-control">
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
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sku" class="form-label fw-bold">SKU</label>
                                            <input type="text" name="sku" id="sku"
                                                value="{{ old('sku', $product->sku) }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock" class="form-label fw-bold">Stock</label>
                                            <input type="number" name="stock" id="stock"
                                                value="{{ old('stock', $product->stock) }}" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light text-muted">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update Product</button>
                        </div>
                    </form>

                    <script>
                        (function() {
                            const initialStock = @json($variantStockMap ?? []);

                            function isVariantStockEnabled() {
                                const el = document.getElementById('use_variant_stock');
                                return !!(el && el.checked);
                            }

                            function normalizeKeyPart(value) {
                                if (value === null || value === undefined) return '-';
                                const v = String(value).trim().toLowerCase();
                                return v === '' ? '-' : v;
                            }

                            function makeKey(color, size) {
                                return normalizeKeyPart(color) + '|' + normalizeKeyPart(size);
                            }

                            function getCheckedValues(name) {
                                return Array.from(document.querySelectorAll('input[name="' + name + '"]:checked')).map(i => i.value);
                            }

                            function getExistingStockMap() {
                                const map = { ...initialStock };
                                document.querySelectorAll('#variant-stock-grid input[data-variant-key]').forEach((el) => {
                                    map[el.getAttribute('data-variant-key')] = el.value;
                                });
                                return map;
                            }

                            function updateTotalStock() {
                                const stockInput = document.getElementById('stock');
                                if (!stockInput) return;

                                if (!isVariantStockEnabled()) return;

                                const inputs = document.querySelectorAll('#variant-stock-grid input[data-variant-key]');
                                if (inputs.length === 0) return;

                                let total = 0;
                                inputs.forEach((el) => {
                                    const n = parseInt(el.value || '0', 10);
                                    total += isNaN(n) ? 0 : n;
                                });
                                stockInput.value = total;
                            }

                            function rebuildGrid() {
                                const colors = getCheckedValues('color_options[]');
                                const sizes = getCheckedValues('sizes[]');
                                const grid = document.getElementById('variant-stock-grid');
                                if (!grid) return;

                                if (!isVariantStockEnabled()) {
                                    grid.innerHTML = '<div class="text-muted small">Enable variant stock to manage stock per color/size.</div>';
                                    return;
                                }

                                const previous = getExistingStockMap();
                                const useColors = colors.length > 0 ? colors : [null];
                                const useSizes = sizes.length > 0 ? sizes : [null];

                                if (colors.length === 0 && sizes.length === 0) {
                                    grid.innerHTML = '<div class="text-muted small">Select at least one color or size to manage per-variant stock.</div>';
                                    return;
                                }

                                let html = '';
                                html += '<table class="table table-sm align-middle mb-0">';
                                html += '<thead><tr><th class="text-muted small">Color \\ Size</th>';
                                useSizes.forEach((s) => {
                                    html += '<th class="text-muted small">' + (s ?? '-') + '</th>';
                                });
                                html += '</tr></thead>';
                                html += '<tbody>';
                                useColors.forEach((c) => {
                                    html += '<tr>';
                                    html += '<td class="fw-medium">' + (c ?? '-') + '</td>';
                                    useSizes.forEach((s) => {
                                        const key = makeKey(c, s);
                                        const val = previous[key] ?? '0';
                                        html += '<td style="min-width: 120px;">';
                                        html += '<input type="number" min="0" class="form-control form-control-sm" name="variant_stock[' + key + ']" value="' + String(val).replace(/"/g, '&quot;') + '" data-variant-key="' + key + '">';
                                        html += '</td>';
                                    });
                                    html += '</tr>';
                                });
                                html += '</tbody></table>';

                                grid.innerHTML = html;

                                grid.querySelectorAll('input[data-variant-key]').forEach((el) => {
                                    el.addEventListener('input', updateTotalStock);
                                });

                                updateTotalStock();
                            }

                            document.querySelectorAll('input[name="color_options[]"], input[name="sizes[]"]').forEach((el) => {
                                el.addEventListener('change', rebuildGrid);
                            });

                            const useVariantEl = document.getElementById('use_variant_stock');
                            if (useVariantEl) {
                                useVariantEl.addEventListener('change', rebuildGrid);
                            }

                            rebuildGrid();
                        })();
                    </script>
                </div>
            </div>

            <!-- Delete Section -->
            <div class="card border-0 shadow-sm rounded-4 border-danger-subtle mb-5">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger fw-bold mb-1">Delete Product</h6>
                        <p class="text-muted small mb-0">Permanently remove this product from the store.</p>
                    </div>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
