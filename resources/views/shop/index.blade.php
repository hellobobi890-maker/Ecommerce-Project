@extends('layouts.app')

@section('content')
<div class="py-5 bg-light">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="filters-sidebar">
                    <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                        <!-- Category Filter -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-grid me-2 text-primary"></i>Categories
                                </h6>
                                <div class="d-flex flex-column gap-2">
                                    @foreach($categories as $category)
                                        <div class="form-check d-flex align-items-center justify-content-between">
                                            <div>
                                                <input class="form-check-input" type="radio" name="category" 
                                                       value="{{ $category->id }}" id="cat{{ $category->id }}"
                                                       {{ request('category') == $category->id ? 'checked' : '' }}
                                                       onchange="this.form.submit()">
                                                <label class="form-check-label" for="cat{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                            <span class="badge bg-light text-dark">{{ $category->products_count ?? $category->products()->count() }}</span>
                                        </div>
                                    @endforeach
                                    @if(request('category'))
                                        <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-danger mt-2">
                                            <i class="bi bi-x-circle me-1"></i>Clear Category
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-currency-rupee me-2 text-primary"></i>Price Range
                                </h6>
                                <div class="price-range-slider mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">PKR <span id="minPriceDisplay">{{ request('min_price', 0) }}</span></span>
                                        <span class="text-muted small">PKR <span id="maxPriceDisplay">{{ request('max_price', 50000) }}</span></span>
                                    </div>
                                    <div class="range-slider-container position-relative" style="height: 40px;">
                                        <div class="slider-track"></div>
                                        <div class="slider-range" id="sliderRange"></div>
                                        <input type="range" id="minPriceSlider" name="min_price" 
                                               min="0" max="50000" step="500" value="{{ request('min_price', 0) }}"
                                               class="slider-thumb thumb-left">
                                        <input type="range" id="maxPriceSlider" name="max_price" 
                                               min="0" max="50000" step="500" value="{{ request('max_price', 50000) }}"
                                               class="slider-thumb thumb-right">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                                    <i class="bi bi-funnel me-1"></i>Apply Price Filter
                                </button>
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-rulers me-2 text-primary"></i>Size
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($availableSizes as $size)
                                        @php 
                                            $data = $sizeData[$size] ?? ['count' => 0, 'in_stock' => 0];
                                            $isSoldOut = $data['in_stock'] == 0;
                                        @endphp
                                        <a href="{{ $isSoldOut ? '#' : route('shop.index', array_merge(request()->query(), ['size' => $size])) }}" 
                                           class="btn btn-sm {{ request('size') == $size ? 'btn-primary' : ($isSoldOut ? 'btn-outline-secondary opacity-50' : 'btn-outline-secondary') }}"
                                           @if($isSoldOut) aria-disabled="true" onclick="return false" style="text-decoration: line-through; pointer-events: none;" @endif>
                                            {{ $size }}
                                            @if($isSoldOut)
                                                <span class="d-block" style="font-size: 0.6rem; margin-top: -2px;">Sold Out</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                                @if(request('size'))
                                    <a href="{{ route('shop.index', array_merge(request()->except('size'))) }}" class="btn btn-sm btn-outline-danger mt-3 w-100">
                                        <i class="bi bi-x-circle me-1"></i>Clear Size
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-palette me-2 text-primary"></i>Color
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @php
                                        $colorMap = [
                                            'Black' => '#1a1a1a', 'White' => '#f8f9fa', 'Red' => '#dc3545',
                                            'Blue' => '#0d6efd', 'Green' => '#198754', 'Brown' => '#8b6914',
                                            'Grey' => '#6c757d', 'Navy' => '#001f3f', 'Pink' => '#e91e63', 'Yellow' => '#ffc107'
                                        ];
                                    @endphp
                                    @foreach($availableColors as $color)
                                        @php
                                            $data = $colorData[$color] ?? ['count' => 0, 'in_stock' => 0];
                                            $isSoldOut = $data['in_stock'] == 0;
                                            $colorHex = $colorMap[$color] ?? $color;
                                        @endphp
                                        <a href="{{ $isSoldOut ? '#' : route('shop.index', array_merge(request()->query(), ['color' => $color])) }}"
                                           class="color-filter-btn d-flex flex-column align-items-center text-decoration-none {{ request('color') == $color ? 'selected' : ($isSoldOut ? 'opacity-50' : '') }}"
                                           title="{{ $color }}"
                                           @if($isSoldOut) aria-disabled="true" onclick="return false" style="text-decoration: line-through; pointer-events: none;" @endif>
                                            <div class="color-circle {{ request('color') == $color ? 'ring-primary' : '' }}"
                                                 style="background-color: {{ $colorHex }}; {{ $color == 'White' ? 'border: 1px solid #dee2e6;' : '' }}">
                                                @if(request('color') == $color)
                                                    <i class="bi bi-check2 {{ $color == 'White' ? 'text-dark' : 'text-white' }}"></i>
                                                @endif
                                            </div>
                                            @if($isSoldOut)
                                                <span class="d-block text-muted" style="font-size: 0.6rem; margin-top: -2px;">Sold Out</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                                @if(request('color'))
                                    <a href="{{ route('shop.index', array_merge(request()->except('color'))) }}" class="btn btn-sm btn-outline-danger mt-3 w-100">
                                        <i class="bi bi-x-circle me-1"></i>Clear Color
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Filter -->
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="in_stock" value="1" 
                                           id="inStock" {{ request('in_stock') ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label fw-medium" for="inStock">
                                        <i class="bi bi-box-seam me-1 text-success"></i>In Stock Only
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Top Bar -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <div class="text-muted">
                        Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> 
                        of <strong>{{ $products->total() }}</strong> products
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <select name="sort" class="form-select shop-sort-select"
                                onchange="window.location.href = '{{ route('shop.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value}).toString()">
                            <option value="">Sort By</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters -->
                @if(request()->anyFilled(['category', 'size', 'color', 'min_price', 'max_price', 'in_stock']))
                    <div class="mb-4">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="text-muted small">Active Filters:</span>
                            @if(request('category'))
                                <span class="badge bg-primary rounded-pill">
                                    Category: {{ $categories->find(request('category'))->name ?? 'Unknown' }}
                                    <a href="{{ route('shop.index', request()->except('category')) }}" class="text-white ms-1">&times;</a>
                                </span>
                            @endif
                            @if(request('size'))
                                <span class="badge bg-info rounded-pill">
                                    Size: {{ request('size') }}
                                    <a href="{{ route('shop.index', request()->except('size')) }}" class="text-white ms-1">&times;</a>
                                </span>
                            @endif
                            @if(request('color'))
                                <span class="badge bg-secondary rounded-pill">
                                    Color: {{ request('color') }}
                                    <a href="{{ route('shop.index', request()->except('color')) }}" class="text-white ms-1">&times;</a>
                                </span>
                            @endif
                            <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-x-lg me-1"></i>Clear All
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="product-card">
                                    <!-- Badge -->
                                    @if(!$product->isInStock())
                                        <div class="badge-custom badge-stock">OUT OF STOCK</div>
                                    @elseif($product->created_at->diffInDays() < 7)
                                        <div class="badge-custom badge-new">NEW</div>
                                    @endif

                                    <div class="image-container">
                                        <a href="{{ route('shop.show', $product->slug) }}">
                                            @php
                                                $productImage = is_array($product->images) && count($product->images) > 0 
                                                    ? $product->images[0] 
                                                    : 'https://placehold.co/500x600?text=Product';
                                            @endphp
                                            <img src="{{ $productImage }}" alt="{{ $product->name }}">
                                        </a>
                                        <div class="action-buttons">
                                            <button class="action-btn" title="Add to Cart" onclick='addToCart(event, @json($product, JSON_HEX_APOS | JSON_HEX_QUOT))' {{ !$product->isInStock() ? 'disabled' : '' }}>
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                            <button class="action-btn" title="Quick View" onclick='openQuickView(@json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="action-btn" title="Add to Wishlist" onclick="addToWishlist(event, {{ $product->id }})">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-title">
                                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="price-section">
                                            <span class="current-price">PKR {{ number_format($product->price, 2) }}</span>
                                            @if($product->sale_price && $product->sale_price > $product->price)
                                                <span class="original-price">PKR {{ number_format($product->sale_price, 2) }}</span>
                                                @php $discountPercent = round((($product->sale_price - $product->price) / $product->sale_price) * 100); @endphp
                                                <span class="discount">{{ $discountPercent }}% Off</span>
                                            @endif
                                        </div>
                                        <div class="meta-swap-container">
                                            <div class="rating">
                                                <span class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($product->average_rating))
                                                            <i class="bi bi-star-fill"></i>
                                                        @elseif($i - 0.5 <= $product->average_rating)
                                                            <i class="bi bi-star-half"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                                <span class="review-count">({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                            <div class="color-options">
                                                @if(is_array($product->color_options))
                                                    @foreach(array_slice($product->color_options, 0, 4) as $color)
                                                        @php
                                                            $colorHex = $colorMap[$color] ?? $color;
                                                        @endphp
                                                        <div class="color-option" style="background-color: {{ $colorHex }};" title="{{ $color }}"></div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-search display-1 text-muted"></i>
                        <h4 class="mt-3 fw-bold">Koi Product Nahi Mila</h4>
                        <p class="text-muted">Is filter mein koi product available nahi hai.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>Sab Products Dekhein
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Price Range Slider Styles */
.range-slider-container {
    position: relative;
}
.slider-track {
    position: absolute;
    width: 100%;
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    top: 50%;
    transform: translateY(-50%);
}
.slider-range {
    position: absolute;
    height: 6px;
    background: var(--primary-color);
    border-radius: 3px;
    top: 50%;
    transform: translateY(-50%);
}
.slider-thumb {
    position: absolute;
    width: 100%;
    height: 6px;
    background: transparent;
    pointer-events: none;
    -webkit-appearance: none;
    appearance: none;
    top: 50%;
    transform: translateY(-50%);
}
.slider-thumb::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary-color);
    cursor: pointer;
    pointer-events: all;
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
    border: 3px solid white;
    transition: transform 0.2s;
}
.slider-thumb::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}
.slider-thumb::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary-color);
    cursor: pointer;
    pointer-events: all;
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
    border: 3px solid white;
}

/* Color Filter Styles */
.color-filter-btn {
    transition: transform 0.2s;
}
.color-filter-btn:hover {
    transform: scale(1.1);
}
.color-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.color-circle.ring-primary {
    box-shadow: 0 0 0 3px var(--primary-color);
}
</style>
@endsection

@section('scripts')
<script>
// Price Range Slider Logic
const minSlider = document.getElementById('minPriceSlider');
const maxSlider = document.getElementById('maxPriceSlider');
const minDisplay = document.getElementById('minPriceDisplay');
const maxDisplay = document.getElementById('maxPriceDisplay');
const sliderRange = document.getElementById('sliderRange');

function updateSlider() {
    let minVal = parseInt(minSlider.value);
    let maxVal = parseInt(maxSlider.value);
    
    if (minVal > maxVal) {
        [minVal, maxVal] = [maxVal, minVal];
    }
    
    minDisplay.textContent = minVal.toLocaleString();
    maxDisplay.textContent = maxVal.toLocaleString();
    
    const minPercent = (minVal / 50000) * 100;
    const maxPercent = (maxVal / 50000) * 100;
    
    sliderRange.style.left = minPercent + '%';
    sliderRange.style.width = (maxPercent - minPercent) + '%';
}

if (minSlider && maxSlider) {
    minSlider.addEventListener('input', updateSlider);
    maxSlider.addEventListener('input', updateSlider);
    updateSlider();
}

const HAS_GLOBAL_QV = !!window.__GLOBAL_QV__;
if (!HAS_GLOBAL_QV) {

// Add to Cart
function addToCartLocal(event, product) {
    event.preventDefault();
    const button = event.currentTarget;
    
    const cartIcon = document.getElementById('cart-icon-container');
    if (cartIcon) {
        const flyer = document.createElement('div');
        flyer.style.cssText = 'position:fixed;z-index:9999;width:30px;height:30px;border-radius:50%;background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;transition:all 0.8s ease-in-out;';
        flyer.innerHTML = '<i class="bi bi-bag-plus"></i>';
        document.body.appendChild(flyer);
        
        const buttonRect = button.getBoundingClientRect();
        flyer.style.top = (buttonRect.top + buttonRect.height / 2) + 'px';
        flyer.style.left = (buttonRect.left + buttonRect.width / 2) + 'px';
        
        const cartRect = cartIcon.getBoundingClientRect();
        requestAnimationFrame(() => {
            flyer.style.top = (cartRect.top + cartRect.height / 2) + 'px';
            flyer.style.left = (cartRect.left + cartRect.width / 2) + 'px';
            flyer.style.width = '10px';
            flyer.style.height = '10px';
            flyer.style.opacity = '0.5';
        });
        setTimeout(() => flyer.remove(), 800);
    }
    
    const productId = (product && typeof product === 'object') ? product.id : product;
    const defaultColor = (product && Array.isArray(product.color_options) && product.color_options.length) ? product.color_options[0] : undefined;
    const defaultSize = (product && Array.isArray(product.sizes) && product.sizes.length) ? product.sizes[0] : undefined;

    fetch('{{ route('cart.store', [], false) }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: 1, color: defaultColor, size: defaultSize })
    })
    .then(async (response) => {
        const data = await response.json().catch(() => ({}));
        return { ok: response.ok, data };
    })
    .then(({ ok, data }) => {
        const badge = document.getElementById('cart-badge');
        if (!ok || (data && data.success === false)) {
            showNotification((data && data.message) ? data.message : 'Unable to add to cart.', 'error');
            return;
        }
        if (badge) badge.innerText = data.cart_count ?? parseInt(badge.innerText) + 1;
        showNotification(data.message || 'Product cart mein add ho gaya!', 'success');
    })
    .catch(() => {
        showNotification('Unable to add to cart.', 'error');
    });
}

function addToWishlistLocal(event, productId) {
    event.preventDefault();
    fetch('{{ route('wishlist.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(async (response) => {
        if (response.status === 401) {
            showNotification('Please login to add items to wishlist!', 'error');
            setTimeout(() => window.location.href = '{{ route("login") }}', 1200);
            return;
        }
        const data = await response.json().catch(() => ({}));
        showNotification(data.message || 'Wishlist mein add ho gaya!', 'success');
    })
    .catch(() => showNotification('Wishlist mein add ho gaya!', 'success'));
}

function openQuickViewLocal(product) {
    if (typeof bootstrap === 'undefined' || !document.getElementById('quickViewModal')) {
        window.location.href = '/product/' + product.slug;
        return;
    }

    if (window.qvSliderInterval) {
        clearInterval(window.qvSliderInterval);
        window.qvSliderInterval = null;
    }

    document.getElementById('qv-title').innerText = product.name;
    document.getElementById('qv-price').innerText = 'PKR ' + parseFloat(product.price).toFixed(2);
    document.getElementById('qv-description').innerText = product.description || '';
    document.getElementById('qv-product-id').value = product.id;

    const wishlistBtn = document.getElementById('qv-wishlist-btn');
    if (wishlistBtn) {
        const icon = wishlistBtn.querySelector('i');
        if (icon) icon.className = 'bi bi-heart';
        wishlistBtn.classList.remove('text-danger');
        wishlistBtn.onclick = (e) => addToWishlistLocal(e, product.id);
    }

    const colorWrap = document.getElementById('qv-color-wrap');
    const sizeWrap = document.getElementById('qv-size-wrap');
    const colorsEl = document.getElementById('qv-colors');
    const sizesEl = document.getElementById('qv-sizes');
    const selectedColorInput = document.getElementById('qv-selected-color');
    const selectedSizeInput = document.getElementById('qv-selected-size');
    const selectedColorText = document.getElementById('qv-selected-color-text');
    const selectedSizeText = document.getElementById('qv-selected-size-text');

    if (colorsEl) colorsEl.innerHTML = '';
    if (sizesEl) sizesEl.innerHTML = '';

    const productColors = Array.isArray(product.color_options) ? product.color_options : [];
    const productSizes = Array.isArray(product.sizes) ? product.sizes : [];

    function selectQvColor(value, btn) {
        if (selectedColorInput) selectedColorInput.value = value || '';
        if (selectedColorText) selectedColorText.innerText = value || '';
        if (colorsEl) colorsEl.querySelectorAll('button').forEach(b => b.classList.remove('border-dark'));
        if (btn) btn.classList.add('border-dark');
    }

    function selectQvSize(value, btn) {
        if (selectedSizeInput) selectedSizeInput.value = value || '';
        if (selectedSizeText) selectedSizeText.innerText = value || '';
        if (sizesEl) {
            sizesEl.querySelectorAll('button').forEach(b => {
                b.classList.remove('btn-dark');
                b.classList.add('btn-outline-secondary');
            });
        }
        if (btn) {
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-dark');
        }
    }

    if (productColors.length > 0 && colorWrap && colorsEl) {
        colorWrap.classList.remove('d-none');
        productColors.forEach((c, idx) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'btn btn-outline-secondary rounded-pill px-3 py-1 border-2';
            b.innerText = c;
            b.onclick = () => selectQvColor(c, b);
            colorsEl.appendChild(b);
            if (idx === 0) selectQvColor(c, b);
        });
    } else if (colorWrap) {
        colorWrap.classList.add('d-none');
        if (selectedColorInput) selectedColorInput.value = '';
        if (selectedColorText) selectedColorText.innerText = '';
    }

    if (productSizes.length > 0 && sizeWrap && sizesEl) {
        sizeWrap.classList.remove('d-none');
        productSizes.forEach((s, idx) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'btn btn-outline-secondary rounded-pill px-3 py-1';
            b.innerText = s;
            b.onclick = () => selectQvSize(s, b);
            sizesEl.appendChild(b);
            if (idx === 0) selectQvSize(s, b);
        });
    } else if (sizeWrap) {
        sizeWrap.classList.add('d-none');
        if (selectedSizeInput) selectedSizeInput.value = '';
        if (selectedSizeText) selectedSizeText.innerText = '';
    }

    const mainImage = document.getElementById('qv-main-image');
    const thumbnailsContainer = document.getElementById('qv-thumbnails');
    thumbnailsContainer.innerHTML = '';

    let images = [];
    if (Array.isArray(product.images) && product.images.length > 0) {
        images = [...product.images];
    } else if (typeof product.images === 'string') {
        try {
            const parsed = JSON.parse(product.images);
            if (Array.isArray(parsed)) images = parsed;
            else images = [product.images];
        } catch (e) {
            images = [product.images];
        }
    } else {
        images = ['https://placehold.co/600x800?text=Product'];
    }

    if (images.length === 1 && images[0]) {
        images.push(images[0]);
        images.push(images[0]);
    }

    if (images.length > 0) mainImage.src = images[0];

    window.qvImages = images;
    window.qvCurrentIndex = 0;

    images.forEach((imgSrc, index) => {
        const thumb = document.createElement('div');
        thumb.className = `thumbnail-item border rounded overflow-hidden ${index === 0 ? 'border-primary border-2' : ''}`;
        thumb.style.cssText = 'min-width: 70px; width: 70px; height: 70px; cursor: pointer;';
        thumb.innerHTML = `<img src="${imgSrc}" alt="thumb" class="w-100 h-100" style="object-fit: cover;">`;
        thumb.onclick = () => {
            window.qvCurrentIndex = index;
            mainImage.src = imgSrc;
            document.querySelectorAll('#qv-thumbnails .thumbnail-item').forEach(el => {
                el.classList.remove('border-primary', 'border-2');
            });
            thumb.classList.add('border-primary', 'border-2');
            mainImage.style.opacity = '0.5';
            setTimeout(() => mainImage.style.opacity = '1', 200);
        };
        thumbnailsContainer.appendChild(thumb);
    });

    const qvModalEl = document.getElementById('quickViewModal');
    const prevBtn = qvModalEl?.querySelector('.prev-thumb');
    const nextBtn = qvModalEl?.querySelector('.next-thumb');
    if (prevBtn) prevBtn.onclick = () => {
        const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
        if (!thumbs.length) return;
        const nextIndex = (window.qvCurrentIndex - 1 + thumbs.length) % thumbs.length;
        thumbs[nextIndex].click();
        thumbs[nextIndex].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    };
    if (nextBtn) nextBtn.onclick = () => {
        const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
        if (!thumbs.length) return;
        const nextIndex = (window.qvCurrentIndex + 1) % thumbs.length;
        thumbs[nextIndex].click();
        thumbs[nextIndex].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    };

    new bootstrap.Modal(qvModalEl).show();
    startQvSlider(images);
}

// Delegate to global helpers if present (ensures consistent behavior across pages)
window.addToCart = window.addToCart || function(e, p) { return addToCartLocal(e, p); };
window.addToWishlist = window.addToWishlist || function(e, id) { return addToWishlistLocal(e, id); };
window.openQuickView = window.openQuickView || function(p) { return openQuickViewLocal(p); };

function scrollQvThumbnails(direction) {
    const container = document.getElementById('qv-thumbnails');
    if (container) {
        const scrollAmount = 90;
        container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }
}

function startQvSlider(images) {
    if (!Array.isArray(images) || images.length <= 1) return;
    window.qvSliderInterval = setInterval(() => {
        const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
        if (thumbs.length) {
            const nextIndex = ((window.qvCurrentIndex ?? 0) + 1) % thumbs.length;
            thumbs[nextIndex].click();
        }
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const qvModal = document.getElementById('quickViewModal');
    if (qvModal) {
        qvModal.addEventListener('hidden.bs.modal', function() {
            if (window.qvSliderInterval) {
                clearInterval(window.qvSliderInterval);
                window.qvSliderInterval = null;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const qvForm = document.getElementById('qv-add-to-cart-form');
    if (qvForm) {
        qvForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = qvForm.querySelector('button[type="submit"]');
            const productId = document.getElementById('qv-product-id')?.value;
            const quantity = document.getElementById('qv-quantity')?.value;
            const color = document.getElementById('qv-selected-color')?.value || undefined;
            const size = document.getElementById('qv-selected-size')?.value || undefined;

            const cartIcon = document.getElementById('cart-icon-container');
            if (cartIcon && button) {
                const flyer = document.createElement('div');
                flyer.style.cssText =
                    'position:fixed;z-index:10000;width:30px;height:30px;border-radius:50%;background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;transition:all 0.8s ease-in-out;';
                flyer.innerHTML = '<i class="bi bi-bag-plus"></i>';
                document.body.appendChild(flyer);

                const buttonRect = button.getBoundingClientRect();
                flyer.style.top = (buttonRect.top + buttonRect.height / 2) + 'px';
                flyer.style.left = (buttonRect.left + buttonRect.width / 2) + 'px';

                const cartRect = cartIcon.getBoundingClientRect();
                requestAnimationFrame(() => {
                    flyer.style.top = (cartRect.top + cartRect.height / 2) + 'px';
                    flyer.style.left = (cartRect.left + cartRect.width / 2) + 'px';
                    flyer.style.width = '10px';
                    flyer.style.height = '10px';
                    flyer.style.opacity = '0.5';
                });
                setTimeout(() => flyer.remove(), 800);
            }

            fetch('{{ route('cart.store', [], false) }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity || '1', 10),
                    color: color,
                    size: size
                })
            })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                return { ok: response.ok, data };
            })
            .then(({ ok, data }) => {
                if (!ok || (data && data.success === false)) {
                    showNotification((data && data.message) ? data.message : 'Unable to add to cart.', 'error');
                    return;
                }

                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.cart_count !== undefined ? data.cart_count : (parseInt(badge.innerText) + parseInt(quantity || '1', 10));
                }
                showNotification(data.message || 'Product added to cart!', 'success');
                setTimeout(() => {
                    const instance = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                    if (instance) instance.hide();
                }, 900);
            })
            .catch(() => {
                showNotification('Unable to add to cart.', 'error');
            });
        });
    }
});

function incrementQv() {
    const el = document.getElementById('qv-quantity');
    if (!el) return;
    el.value = parseInt(el.value || '1', 10) + 1;
}

function decrementQv() {
    const el = document.getElementById('qv-quantity');
    if (!el) return;
    const n = parseInt(el.value || '1', 10);
    if (n > 1) el.value = n - 1;
}

}
</script>

@if(false)
<!-- Quick View Modal (if not in layout) -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="p-4 h-100 d-flex flex-column">
                            <div class="main-image-container mb-3 flex-grow-1 bg-light rounded-3 overflow-hidden" style="height: 400px;">
                                <img id="qv-main-image" src="" alt="Product" class="w-100 h-100" style="object-fit: contain;">
                            </div>
                            <div class="thumbnails-container d-flex align-items-center gap-2">
                                <button class="btn btn-outline-secondary btn-sm rounded-circle prev-thumb" style="width: 36px; height: 36px;">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <div class="thumbnail-slider flex-grow-1 d-flex gap-2 overflow-auto" id="qv-thumbnails" style="scroll-behavior: smooth;"></div>
                                <button class="btn btn-outline-secondary btn-sm rounded-circle next-thumb" style="width: 36px; height: 36px;">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <h2 class="fw-bold mb-2" id="qv-title">Product Name</h2>
                            <div class="mb-3">
                                <span class="fs-3 fw-bold text-primary me-2" id="qv-price">PKR0.00</span>
                            </div>
                            <p class="text-secondary mb-4" id="qv-description">Description...</p>

                            <div id="qv-variant-sections" class="mb-4">
                                <div id="qv-color-wrap" class="mb-3 d-none">
                                    <label class="form-label fw-bold mb-2">Color: <span id="qv-selected-color-text"></span></label>
                                    <div id="qv-colors" class="d-flex gap-2 flex-wrap"></div>
                                </div>
                                <div id="qv-size-wrap" class="mb-3 d-none">
                                    <label class="form-label fw-bold mb-2">Size: <span id="qv-selected-size-text"></span></label>
                                    <div id="qv-sizes" class="d-flex gap-2 flex-wrap"></div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <form id="qv-add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" id="qv-product-id">
                                <input type="hidden" name="color" id="qv-selected-color" value="">
                                <input type="hidden" name="size" id="qv-selected-size" value="">
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-auto">
                                        <div class="input-group" style="width: 140px;">
                                            <button class="btn btn-outline-secondary" type="button" onclick="decrementQv()">-</button>
                                            <input type="number" class="form-control text-center" name="quantity" id="qv-quantity" value="1" min="1">
                                            <button class="btn btn-outline-secondary" type="button" onclick="incrementQv()">+</button>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                            <i class="bi bi-cart-plus me-2"></i> Add To Cart
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-secondary btn-lg" id="qv-wishlist-btn" title="Wishlist">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
