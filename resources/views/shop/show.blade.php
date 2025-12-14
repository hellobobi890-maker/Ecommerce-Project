@extends('layouts.app')

@section('content')
@php
    $variantStockMap = [];
    if (isset($product) && $product->relationLoaded('variants')) {
        foreach ($product->variants as $v) {
            $variantStockMap[$v->variant_key] = (int) $v->stock;
        }
    }
@endphp

<div class="py-4 bg-white">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('shop.index', ['category' => $product->category->id]) }}" 
                           class="text-decoration-none">{{ $product->category->name }}</a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            <!-- Left Column - Product Images -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <!-- Main Image -->
                    <div class="main-image-wrapper mb-3 border-0 rounded-4 overflow-hidden bg-light" style="height: 600px;">
                        @php
                            $images = is_array($product->images) ? $product->images : [];
                            $mainImage = count($images) > 0 ? $images[0] : 'https://placehold.co/600x800?text=Product';
                        @endphp
                        <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                            class="w-100 h-100" style="object-fit: cover; transition: opacity 0.3s;">
                    </div>

                    <!-- Thumbnails -->
                    @if(count($images) > 1)
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" onclick="scrollThumbs(-1)"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div class="thumbnails-wrapper flex-grow-1 overflow-hidden">
                            <div class="d-flex gap-2" id="thumbnail-container" style="overflow-x: auto; scroll-behavior: smooth;">
                                @foreach ($images as $index => $image)
                                    <div class="thumb-item border-2 rounded-3 overflow-hidden {{ $index === 0 ? 'border-primary' : 'border-light' }}"
                                        style="min-width: 100px; width: 100px; height: 100px; cursor: pointer; transition: all 0.2s;"
                                        onclick="changeImage('{{ $image }}', this)">
                                        <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}"
                                            class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" onclick="scrollThumbs(1)"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="col-lg-6">
                <div class="ps-lg-4">
                <!-- Stock Badge -->
                @if(!$product->isInStock())
                    <span class="badge bg-danger mb-3 px-3 py-2">Out of Stock</span>
                @elseif($product->stock <= 5)
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2">Only {{ $product->stock }} left!</span>
                @endif

                <!-- Product Title -->
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

                <!-- Rating -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->average_rating))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - 0.5 <= $product->average_rating)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-muted">({{ $product->reviews_count }} Reviews)</span>
                </div>

                <!-- Price Section -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="fs-2 fw-bold">PKR {{ number_format($product->price, 2) }}</span>
                    @if ($product->sale_price)
                        <span class="text-muted text-decoration-line-through fs-5">PKR {{ number_format($product->sale_price, 2) }}</span>
                        @php
                            $discount = round((($product->sale_price - $product->price) / $product->sale_price) * 100);
                        @endphp
                        <span class="badge bg-success fs-6 px-2 py-1">{{ $discount }}% Off</span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-secondary mb-4">{{ $product->description }}</p>

                <form action="{{ route('cart.store') }}" method="POST" id="product-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Color & Size Selection -->
                    <div class="mb-4">
                        <!-- Color Selection -->
                        @if (is_array($product->color_options) && count($product->color_options) > 0)
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3">Color</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @php
                                        $colorMap = [
                                            'Red' => '#c0392b', 'Blue' => '#2980b9', 'Black' => '#2c3e50',
                                            'White' => '#ecf0f1', 'Green' => '#27ae60', 'Yellow' => '#f39c12',
                                            'Grey' => '#7f8c8d', 'Brown' => '#8b6914', 'Pink' => '#e91e63',
                                            'Navy' => '#001f3f', 'Orange' => '#ff6600', 'Purple' => '#9b59b6'
                                        ];
                                    @endphp
                                    @foreach ($product->color_options as $index => $color)
                                        <button type="button"
                                            class="color-btn rounded-circle border-2 {{ $index === 0 ? 'border-dark' : 'border-secondary' }}"
                                            style="width: 40px; height: 40px; background-color: {{ $colorMap[$color] ?? $color }};"
                                            title="{{ $color }}" onclick="selectColor(this, '{{ $color }}')">
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="color" id="selected-color" value="{{ $product->color_options[0] }}">
                            </div>
                        @endif

                        <!-- Size Selection -->
                        @if (is_array($product->sizes) && count($product->sizes) > 0)
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3">Size</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($product->sizes as $index => $size)
                                        <button type="button"
                                            class="btn {{ $index === 0 ? 'btn-dark' : 'btn-outline-secondary' }} size-btn px-4 py-2"
                                            onclick="selectSize(this, '{{ $size }}')">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="size" id="selected-size" value="{{ $product->sizes[0] }}">
                            </div>
                        @endif
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="d-flex gap-3 align-items-center mb-4">
                        <div class="d-flex align-items-center border rounded">
                            <button type="button" class="btn btn-link text-dark px-3 py-2" onclick="decrementQty()">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" name="quantity" id="product-qty" value="1" min="1" max="{{ max(1, (int) $product->stock) }}" 
                                   class="form-control border-0 text-center" style="width: 60px;">
                            <button type="button" class="btn btn-link text-dark px-3 py-2" onclick="incrementQty()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-dark flex-grow-1 py-3" id="add-to-cart-btn">
                            <i class="bi bi-bag me-2"></i>Add to Cart
                        </button>
                    </div>

                    <!-- Wishlist Button -->
                    <button type="button" class="btn btn-outline-dark w-100 py-3 mb-4" onclick="addWishlist({{ $product->id }})">
                        <i class="bi bi-heart me-2"></i>Add to Wishlist
                    </button>

                    <!-- Features -->
                    <div class="border-top pt-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-truck fs-5 text-primary"></i>
                            <div>
                                <div class="fw-semibold">Free Delivery</div>
                                <div class="text-muted small">On orders over PKR 1000</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i class="bi bi-shield-check fs-5 text-success"></i>
                            <div>
                                <div class="fw-semibold">1 Year Warranty</div>
                                <div class="text-muted small">Brand warranty included</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-arrow-repeat fs-5 text-warning"></i>
                            <div>
                                <div class="fw-semibold">30 Day Returns</div>
                                <div class="text-muted small">Easy return policy</div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5 border-top">
        <h3 class="fw-bold mb-4">Description</h3>
        <div class="row">
            <div class="col-lg-8">
                <p class="text-secondary mb-0" style="line-height: 1.9;">{{ $product->description }}</p>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5 border-top">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0">Product Reviews</h3>
        </div>

        @php
            $reviews = $product->approvedReviews ?? collect();
            $reviewsCount = $reviews->count();
            $avg = (float) ($product->average_rating ?? 0);
            $ratingCounts = [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ];
        @endphp

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="border rounded-4 p-4 h-100">
                    <div class="d-flex align-items-end gap-3 mb-3">
                        <div class="fw-bold" style="font-size: 44px; line-height: 1;">{{ number_format($avg, 1) }}</div>
                        <div class="text-muted">/ 5</div>
                    </div>
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($avg))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - 0.5 <= $avg)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-muted mb-4">Based on {{ $reviewsCount }} reviews</div>

                    @foreach([5,4,3,2,1] as $r)
                        @php
                            $count = $ratingCounts[$r] ?? 0;
                            $pct = $reviewsCount > 0 ? round(($count / $reviewsCount) * 100) : 0;
                        @endphp
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="text-muted" style="width: 28px;">{{ $r }}</div>
                            <div class="progress flex-grow-1" style="height: 8px;">
                                <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $pct }}%"></div>
                            </div>
                            <div class="text-muted" style="width: 36px; text-align: right;">{{ $count }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-8">
                <div class="border rounded-4 p-4">
                    @if($reviewsCount === 0)
                        <div class="text-muted">No reviews yet.</div>
                    @else
                        <div class="d-flex flex-column gap-4">
                            @foreach($reviews->take(6) as $review)
                                <div class="d-flex gap-3">
                                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; font-weight: 700;">
                                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div>
                                                <div class="fw-semibold">{{ $review->user->name ?? 'User' }}</div>
                                                <div class="text-warning small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= (int) $review->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="text-muted small">{{ optional($review->created_at)->diffForHumans() }}</div>
                                        </div>
                                        <div class="text-secondary mt-2" style="line-height: 1.8;">{{ $review->comment }}</div>
                                    </div>
                                </div>
                                <div class="border-top"></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h3 class="fw-bold mb-4">People also view</h3>
            <div class="row g-4">
                @foreach($relatedProducts->take(4) as $p)
                    @php
                        $img = is_array($p->images) && count($p->images) > 0 ? $p->images[0] : 'https://placehold.co/500x600?text=Product';
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product-card h-100">
                            <div class="image-container">
                                <a href="{{ route('shop.show', $p->slug) }}">
                                    <img src="{{ $img }}" alt="{{ $p->name }}">
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ route('shop.show', $p->slug) }}">{{ $p->name }}</a></h3>
                                <div class="price-section">
                                    <span class="current-price">PKR {{ number_format($p->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
// Image gallery functions
function changeImage(imageSrc, thumbnail) {
    const mainImage = document.getElementById('main-product-image');
    mainImage.style.opacity = '0';
    setTimeout(() => {
        mainImage.src = imageSrc;
        mainImage.style.opacity = '1';
    }, 200);
    
    // Update thumbnail borders
    document.querySelectorAll('.thumb-item').forEach(thumb => {
        thumb.classList.remove('border-primary');
        thumb.classList.add('border-light');
    });
    thumbnail.classList.remove('border-light');
    thumbnail.classList.add('border-primary');
}

function scrollThumbs(direction) {
    const container = document.getElementById('thumbnail-container');
    const scrollAmount = 110;
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}

// Quantity controls
function incrementQty() {
    const qtyInput = document.getElementById('product-qty');
    if (!qtyInput) return;
    const max = parseInt(qtyInput.max || '10', 10);
    const current = parseInt(qtyInput.value || '1', 10);
    if (current < max) qtyInput.value = current + 1;
}

function decrementQty() {
    const qtyInput = document.getElementById('product-qty');
    if (qtyInput.value > 1) {
        qtyInput.value = parseInt(qtyInput.value) - 1;
    }
}

// Color/Size selection
function selectColor(btn, color) {
    document.querySelectorAll('.color-btn').forEach(b => {
        b.classList.remove('border-dark');
        b.classList.add('border-secondary');
    });
    btn.classList.remove('border-secondary');
    btn.classList.add('border-dark');
    document.getElementById('selected-color').value = color;
}

function selectSize(btn, size) {
    document.querySelectorAll('.size-btn').forEach(b => {
        b.classList.remove('btn-dark');
        b.classList.add('btn-outline-secondary');
    });
    btn.classList.remove('btn-outline-secondary');
    btn.classList.add('btn-dark');
    document.getElementById('selected-size').value = size;
}

// Add to Cart AJAX
document.getElementById('product-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const submitBtn = document.getElementById('add-to-cart-btn');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Adding...';
    
    fetch('{{ route("cart.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product added to cart!', 'success');
            // Update cart badge
            const badge = document.getElementById('cart-badge');
            if (badge) {
                const currentCount = parseInt(badge.innerText) || 0;
                badge.innerText = currentCount + parseInt(formData.get('quantity'));
            }
        } else {
            showNotification(data.message || 'Error adding product to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding product to cart', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-bag me-2"></i>Add to Cart';
    });
});

// Wishlist function
function addWishlist(productId) {
    fetch('{{ route('wishlist.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(async (response) => {
        if (response.status === 401) {
            showNotification('Please login to add items to wishlist!', 'error');
            setTimeout(() => window.location.href = '{{ route("login") }}', 1200);
            return null;
        }
        return response.json().catch(() => ({}));
    })
    .then(data => {
        if (!data) return;
        if (data.success === false) {
            showNotification(data.message || 'Error adding to wishlist', 'error');
            return;
        }
        showNotification(data.message || 'Product added to wishlist!', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to wishlist', 'error');
    });
}

// Notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
@endsection
