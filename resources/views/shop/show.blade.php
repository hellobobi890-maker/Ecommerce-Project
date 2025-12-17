@extends('layouts.app')

@section('content')
    @php
        $variantStockMap = [];
        if (isset($product) && $product->relationLoaded('variants')) {
            foreach ($product->variants as $v) {
                $variantStockMap[$v->variant_key] = (int) $v->stock;
            }
        }

        // Get images
        $images = is_array($product->images) ? $product->images : [];
        if (count($images) === 0) {
            $images = ['https://placehold.co/600x800?text=Product'];
        }

        // Get recently viewed products from session
        $recentlyViewed = session('recently_viewed', []);
        $recentProducts = collect();
        if (!empty($recentlyViewed)) {
            $recentIds = array_filter($recentlyViewed, fn($id) => $id != $product->id);
            $recentIds = array_slice($recentIds, 0, 5);
            if (!empty($recentIds)) {
                $recentProducts = \App\Models\Product::whereIn('id', $recentIds)->get();
            }
        }

        // Get latest arrivals
        $latestArrivals = \App\Models\Product::where('id', '!=', $product->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Store current product in recently viewed
        $viewed = session('recently_viewed', []);
        if (!in_array($product->id, $viewed)) {
            array_unshift($viewed, $product->id);
            $viewed = array_slice($viewed, 0, 10);
            session(['recently_viewed' => $viewed]);
        }
    @endphp

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <div class="product-detail-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb small bg-white rounded-3 px-3 py-2 border">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Homepage</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Women &
                            Girl Wear</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('shop.index', ['category' => $product->category->id]) }}"
                                class="text-decoration-none">{{ $product->category->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 30) }}</li>
                </ol>
            </nav>

            <div class="row g-4 g-lg-5">
                <!-- Left Column - Product Images with Vertical Thumbnails -->
                <div class="col-lg-6">
                    <div class="product-gallery-wrapper d-flex gap-3">
                        <!-- Vertical Thumbnails -->
                        <div class="thumbnail-vertical-slider d-none d-md-flex flex-column gap-2" style="width: 80px;">
                            @foreach ($images as $index => $image)
                                <div class="thumb-item-v {{ $index === 0 ? 'active' : '' }}"
                                    onclick="changeMainImage('{{ $image }}', this)"
                                    style="width: 70px; height: 85px; cursor: pointer; border: 2px solid {{ $index === 0 ? 'var(--primary-color)' : '#e5e7eb' }}; border-radius: 8px; overflow: hidden; transition: all 0.2s;">
                                    <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-100 h-100"
                                        style="object-fit: cover;">
                                </div>
                            @endforeach
                        </div>

                        <!-- Main Image with Zoom -->
                        <div class="main-image-wrapper flex-grow-1 position-relative">
                            <div class="main-img-container bg-light rounded-3 overflow-hidden position-relative"
                                id="zoom-container" style="height: 520px;">
                                <img id="main-product-image" src="{{ $images[0] }}" alt="{{ $product->name }}"
                                    class="w-100 h-100" style="object-fit: cover; transition: opacity 0.3s;">

                                <!-- Zoom Lens (hidden by default) -->
                                <div id="zoom-lens" class="position-absolute d-none"
                                    style="width: 150px; height: 150px; border: 3px solid var(--primary-color); border-radius: 50%; cursor: crosshair; pointer-events: none;">
                                </div>
                            </div>

                            <!-- Zoom Result Window -->
                            <div id="zoom-result" class="position-absolute d-none"
                                style="width: 350px; height: 350px; background-repeat: no-repeat; border: 2px solid #ddd; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 100; top: 0; left: 105%;">
                            </div>

                            <!-- Mobile Swiper Slider -->
                            <div class="mobile-slider d-md-none">
                                <div class="swiper productSwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($images as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image }}" alt="{{ $product->name }}"
                                                    class="w-100 rounded-3" style="height: 400px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Product Details -->
                <div class="col-lg-6">
                    <div class="product-info-wrapper">
                        <!-- Brand/Category Label -->
                        @if ($product->category)
                            <span
                                class="text-muted small text-uppercase fw-semibold mb-2 d-block">{{ $product->category->name }}</span>
                        @endif

                        <!-- Product Title -->
                        <h1 class="fw-bold mb-3" style="font-size: 1.75rem;">{{ $product->name }}</h1>

                        <!-- Price & Rating Row -->
                        <div class="d-flex align-items-center gap-4 mb-3 flex-wrap">
                            <div class="price-section">
                                @if ($product->sale_price)
                                    <span class="text-muted text-decoration-line-through me-2">PKR
                                        {{ number_format($product->sale_price, 2) }}</span>
                                @endif
                                <span class="fs-4 fw-bold text-dark">PKR {{ number_format($product->price, 2) }}</span>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <div class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->average_rating))
                                            <i class="bi bi-star-fill"></i>
                                        @elseif($i - 0.5 <= $product->average_rating)
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-muted small">{{ $product->average_rating }}</span>
                            </div>

                            <!-- Stock Badge -->
                            @if (!$product->isInStock())
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->stock <= 5)
                                <span class="badge bg-warning text-dark">Only {{ $product->stock }} left!</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-2">Description</h6>
                            <p class="text-secondary mb-0" style="line-height: 1.8;">
                                {{ Str::limit($product->description, 200) }}</p>
                            @if (strlen($product->description) > 200)
                                <a href="#description-section" class="text-primary small">Read More</a>
                            @endif
                        </div>

                        <form action="{{ route('cart.store') }}" method="POST" id="product-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Color Selection -->
                            @if (is_array($product->color_options) && count($product->color_options) > 0)
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label class="fw-semibold small">Color:</label>
                                        <span id="selected-color-text"
                                            class="text-muted small">{{ $product->color_options[0] }}</span>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @php
                                            $colorMap = [
                                                'Red' => '#c0392b',
                                                'Blue' => '#2980b9',
                                                'Black' => '#2c3e50',
                                                'White' => '#ecf0f1',
                                                'Green' => '#27ae60',
                                                'Yellow' => '#f39c12',
                                                'Grey' => '#7f8c8d',
                                                'Brown' => '#8b6914',
                                                'Pink' => '#e91e63',
                                                'Navy' => '#001f3f',
                                                'Orange' => '#ff6600',
                                                'Purple' => '#9b59b6',
                                                'Khaki' => '#c3b091',
                                                'Beige' => '#f5f5dc',
                                                'RoyalGreen' => '#2e7d32',
                                            ];
                                        @endphp
                                        @foreach ($product->color_options as $index => $color)
                                            <button type="button"
                                                class="color-btn rounded-3 border-2 {{ $index === 0 ? 'active' : '' }}"
                                                style="width: 40px; height: 40px; background-color: {{ $colorMap[$color] ?? '#ccc' }}; border: 2px solid {{ $index === 0 ? '#000' : '#ddd' }};"
                                                title="{{ $color }}"
                                                onclick="selectColor(this, '{{ $color }}')">
                                                @if ($index === 0)
                                                    <i class="bi bi-check text-white"></i>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="color" id="selected-color"
                                        value="{{ $product->color_options[0] }}">
                                </div>
                            @endif

                            <!-- Size Selection -->
                            @if (is_array($product->sizes) && count($product->sizes) > 0)
                                <div class="mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="fw-semibold small">Size:</label>
                                        <a href="#" class="text-primary small text-decoration-none">Size Chart</a>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach ($product->sizes as $index => $size)
                                            <button type="button"
                                                class="btn {{ $index === 0 ? 'btn-dark' : 'btn-outline-secondary' }} size-btn px-4 py-2"
                                                style="min-width: 50px; border-radius: 8px;"
                                                onclick="selectSize(this, '{{ $size }}')">
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="size" id="selected-size"
                                        value="{{ $product->sizes[0] }}">
                                </div>
                            @endif

                            <!-- Quantity & Add to Cart -->
                            <div class="product-actions mb-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <!-- Quantity Selector -->
                                    <div class="quantity-selector d-flex align-items-center border rounded-pill overflow-hidden bg-light"
                                        style="height: 52px;">
                                        <button type="button" class="btn btn-link text-dark px-3 h-100 border-0"
                                            onclick="decrementQty()">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <input type="number" name="quantity" id="product-qty" value="1"
                                            min="1" max="{{ max(1, (int) $product->stock) }}"
                                            class="form-control border-0 text-center bg-transparent fw-bold"
                                            style="width: 50px; font-size: 1.1rem;">
                                        <button type="button" class="btn btn-link text-dark px-3 h-100 border-0"
                                            onclick="incrementQty()">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>

                                    <!-- Wishlist Button -->
                                    <button type="button"
                                        class="btn btn-outline-secondary rounded-pill d-flex align-items-center justify-content-center"
                                        onclick="addWishlist({{ $product->id }})" style="width: 52px; height: 52px;">
                                        <i class="bi bi-heart fs-5"></i>
                                    </button>
                                </div>

                                <!-- Main Action Buttons -->
                                <div class="d-flex gap-3">
                                    <button type="submit"
                                        class="btn btn-dark btn-lg flex-grow-1 py-3 rounded-pill fw-semibold"
                                        id="add-to-cart-btn">
                                        <i class="bi bi-bag me-2"></i>Add To Cart
                                    </button>
                                    <a href="{{ route('checkout.index') }}"
                                        class="btn btn-warning btn-lg px-4 py-3 rounded-pill fw-semibold">
                                        <i class="bi bi-credit-card me-2"></i>Checkout Now
                                    </a>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="border-top pt-4">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-truck fs-4 text-primary"></i>
                                            <div>
                                                <div class="fw-semibold small">Free Delivery</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">On orders over PKR
                                                    2000</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-shield-check fs-4 text-success"></i>
                                            <div>
                                                <div class="fw-semibold small">1 Year Warranty</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Brand warranty</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-arrow-repeat fs-4 text-warning"></i>
                                            <div>
                                                <div class="fw-semibold small">30 Day Returns</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Easy return policy
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-cash-stack fs-4 text-info"></i>
                                            <div>
                                                <div class="fw-semibold small">COD Available</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Cash on Delivery</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <section class="related-products-section py-5 mt-5 bg-white">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="fw-bold mb-0">Related Product</h3>
                        <a href="{{ route('shop.index', ['category' => $product->category_id ?? '']) }}"
                            class="text-primary text-decoration-none small">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="swiper relatedSwiper">
                        <div class="swiper-wrapper">
                            @foreach ($relatedProducts as $p)
                                @php
                                    $img =
                                        is_array($p->images) && count($p->images) > 0
                                            ? $p->images[0]
                                            : 'https://placehold.co/500x600?text=Product';
                                @endphp
                                <div class="swiper-slide">
                                    <div class="product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                        <div class="image-container position-relative" style="height: 280px;">
                                            <a href="{{ route('shop.show', $p->slug) }}">
                                                <img src="{{ $img }}" alt="{{ $p->name }}"
                                                    class="w-100 h-100" style="object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="product-info p-3">
                                            <p class="text-muted small mb-1">{{ $p->category->name ?? 'Fashion' }}</p>
                                            <h6 class="product-title mb-2"><a href="{{ route('shop.show', $p->slug) }}"
                                                    class="text-decoration-none text-dark">{{ Str::limit($p->name, 25) }}</a>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold">PKR {{ number_format($p->price, 0) }}</span>
                                                @if ($p->sale_price)
                                                    <span class="text-muted text-decoration-line-through small">PKR
                                                        {{ number_format($p->sale_price, 0) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Product Reviews Section -->
        <section class="reviews-section py-5 bg-light" id="description-section">
            <div class="container">
                <h3 class="fw-bold mb-4">Product Reviews</h3>

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
                    <!-- Rating Summary -->
                    <div class="col-lg-4">
                        <div class="bg-white rounded-4 p-4 h-100 shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="fw-bold" style="font-size: 3rem; line-height: 1;">
                                    {{ number_format($avg, 1) }}</div>
                                <div>
                                    <div class="text-warning mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($avg))
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i - 0.5 <= $avg)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-muted small">Of {{ $reviewsCount }} Reviews</div>
                                </div>
                            </div>

                            @foreach ([5, 4, 3, 2, 1] as $r)
                                @php
                                    $count = $ratingCounts[$r] ?? 0;
                                    $pct = $reviewsCount > 0 ? round(($count / $reviewsCount) * 100) : 0;
                                @endphp
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <div class="text-muted small" style="width: 20px;">{{ $r }}</div>
                                    <i class="bi bi-star-fill text-warning small"></i>
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div class="text-muted small" style="width: 40px; text-align: right;">
                                        {{ $count }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reviews Filter & List -->
                    <div class="col-lg-8">
                        <div class="bg-white rounded-4 p-4 shadow-sm">
                            <!-- Filter Tabs -->
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge bg-dark px-3 py-2">Excellent</span>
                                <span class="badge bg-light text-dark border px-3 py-2">With photos/video</span>
                                <span class="badge bg-light text-dark border px-3 py-2">With description</span>
                            </div>

                            @if ($reviewsCount === 0)
                                <div class="text-muted text-center py-4">No reviews yet. Be the first to review this
                                    product!</div>
                            @else
                                <div class="reviews-list">
                                    @foreach ($reviews->take(5) as $review)
                                        <div class="review-item py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <div class="d-flex gap-3">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                    style="width: 45px; height: 45px; font-weight: 700;">
                                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <div class="fw-semibold">{{ $review->user->name ?? 'User' }}
                                                            </div>
                                                            <div class="text-warning small">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="bi bi-star{{ $i <= (int) $review->rating ? '-fill' : '' }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="text-muted small">
                                                            {{ optional($review->created_at)->diffForHumans() }}</div>
                                                    </div>
                                                    <p class="text-secondary mb-0" style="line-height: 1.8;">
                                                        {{ $review->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recently Viewed Products Section -->
        @if ($recentProducts->count() > 0)
            <section class="recently-viewed-section py-5 bg-white">
                <div class="container">
                    <h3 class="fw-bold mb-4">Recently Viewed</h3>
                    <div class="swiper recentSwiper">
                        <div class="swiper-wrapper">
                            @foreach ($recentProducts as $p)
                                @php
                                    $img =
                                        is_array($p->images) && count($p->images) > 0
                                            ? $p->images[0]
                                            : 'https://placehold.co/500x600?text=Product';
                                @endphp
                                <div class="swiper-slide">
                                    <div class="product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                        <div class="image-container position-relative" style="height: 280px;">
                                            <a href="{{ route('shop.show', $p->slug) }}">
                                                <img src="{{ $img }}" alt="{{ $p->name }}"
                                                    class="w-100 h-100" style="object-fit: cover;">
                                            </a>
                                        </div>
                                        <div class="product-info p-3">
                                            <p class="text-muted small mb-1">{{ $p->category->name ?? 'Fashion' }}</p>
                                            <h6 class="product-title mb-2"><a href="{{ route('shop.show', $p->slug) }}"
                                                    class="text-decoration-none text-dark">{{ Str::limit($p->name, 25) }}</a>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold">PKR {{ number_format($p->price, 0) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Latest Arrivals Section -->
        <section class="popular-section py-5 bg-light">
            <div class="container">
                <h3 class="fw-bold mb-4">Latest Arrivals</h3>
                <div class="swiper popularSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($latestArrivals as $p)
                            @php
                                $img =
                                    is_array($p->images) && count($p->images) > 0
                                        ? $p->images[0]
                                        : 'https://placehold.co/500x600?text=Product';
                            @endphp
                            <div class="swiper-slide">
                                <div class="product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                                    <div class="image-container position-relative" style="height: 280px;">
                                        <a href="{{ route('shop.show', $p->slug) }}">
                                            <img src="{{ $img }}" alt="{{ $p->name }}"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="product-info p-3">
                                        <p class="text-muted small mb-1">{{ $p->category->name ?? 'Fashion' }}</p>
                                        <h6 class="product-title mb-2"><a href="{{ route('shop.show', $p->slug) }}"
                                                class="text-decoration-none text-dark">{{ Str::limit($p->name, 25) }}</a>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold">PKR {{ number_format($p->price, 0) }}</span>
                                            @if ($p->sale_price)
                                                <span class="text-muted text-decoration-line-through small">PKR
                                                    {{ number_format($p->sale_price, 0) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swipers
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Product Slider
            new Swiper('.productSwiper', {
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                loop: true
            });

            // Related Products Slider
            new Swiper('.relatedSwiper', {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 5
                    }
                }
            });

            // Recent Products Slider
            new Swiper('.recentSwiper', {
                slidesPerView: 2,
                spaceBetween: 20,
                breakpoints: {
                    576: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 5
                    }
                }
            });

            // Popular Products Slider
            new Swiper('.popularSwiper', {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    },
                    1200: {
                        slidesPerView: 5
                    }
                }
            });

            // Image Zoom Effect
            initZoom();
        });

        // Change main image from thumbnail
        function changeMainImage(imageSrc, thumbnail) {
            const mainImage = document.getElementById('main-product-image');
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageSrc;
                mainImage.style.opacity = '1';
            }, 150);

            // Update thumbnail borders
            document.querySelectorAll('.thumb-item-v').forEach(thumb => {
                thumb.style.borderColor = '#e5e7eb';
                thumb.classList.remove('active');
            });
            thumbnail.style.borderColor = 'var(--primary-color)';
            thumbnail.classList.add('active');

            // Update zoom background
            const zoomResult = document.getElementById('zoom-result');
            if (zoomResult) {
                zoomResult.style.backgroundImage = `url('${imageSrc}')`;
            }
        }

        // Image Zoom Function
        function initZoom() {
            const container = document.getElementById('zoom-container');
            const mainImg = document.getElementById('main-product-image');
            const lens = document.getElementById('zoom-lens');
            const result = document.getElementById('zoom-result');

            if (!container || !mainImg || !result) return;

            // Set zoom result background
            result.style.backgroundImage = `url('${mainImg.src}')`;

            container.addEventListener('mouseenter', function() {
                result.classList.remove('d-none');
            });

            container.addEventListener('mouseleave', function() {
                result.classList.add('d-none');
            });

            container.addEventListener('mousemove', function(e) {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Calculate zoom
                const zoomLevel = 2.5;
                const bgPosX = (x / rect.width) * 100;
                const bgPosY = (y / rect.height) * 100;

                result.style.backgroundSize = `${rect.width * zoomLevel}px ${rect.height * zoomLevel}px`;
                result.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
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

        // Color selection
        function selectColor(btn, color) {
            document.querySelectorAll('.color-btn').forEach(b => {
                b.style.borderColor = '#ddd';
                b.classList.remove('active');
                b.innerHTML = '';
            });
            btn.style.borderColor = '#000';
            btn.classList.add('active');
            btn.innerHTML = '<i class="bi bi-check text-white"></i>';
            document.getElementById('selected-color').value = color;
            document.getElementById('selected-color-text').textContent = color;
        }

        // Size selection
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

            fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(async (response) => {
                    const data = await response.json().catch(() => null);
                    if (!response.ok) {
                        return {
                            success: false,
                            message: (data && (data.message || data.error)) ? (data.message || data.error) :
                                'Error adding product to cart'
                        };
                    }
                    return data;
                })
                .then(data => {
                    if (data && data.success) {
                        showNotification('Product added to cart!', 'success');
                        const badge = document.getElementById('cart-badge');
                        if (badge) {
                            const currentCount = parseInt(badge.innerText) || 0;
                            badge.innerText = currentCount + parseInt(formData.get('quantity'));
                        }
                    } else {
                        showNotification((data && data.message) ? data.message : 'Error adding product to cart',
                            'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error adding product to cart', 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-bag me-2"></i>Add To Cart';
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
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(async (response) => {
                    if (response.status === 401) {
                        showNotification('Please login to add items to wishlist!', 'error');
                        setTimeout(() => window.location.href = '{{ route('login') }}', 1200);
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
            notification.className =
                `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
            document.body.appendChild(notification);

            setTimeout(() => notification.remove(), 5000);
        }
    </script>

    <style>
        /* Product Detail Page Custom Styles */
        .product-detail-page {
            background: var(--bg-light);
        }

        .thumb-item-v:hover {
            border-color: var(--primary-color) !important;
        }

        .thumb-item-v.active {
            border-color: var(--primary-color) !important;
        }

        .color-btn {
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .color-btn:hover {
            transform: scale(1.1);
        }

        .size-btn {
            transition: all 0.2s;
        }

        .size-btn:hover {
            transform: translateY(-2px);
        }

        /* Swiper Customization */
        .swiper-button-next,
        .swiper-button-prev {
            width: 40px !important;
            height: 40px !important;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 14px !important;
            font-weight: bold;
            color: #333;
        }

        /* Zoom effect cursor */
        #zoom-container {
            cursor: crosshair;
        }

        /* Review section styles */
        .reviews-list .review-item:hover {
            background: #f8fafc;
        }

        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .product-gallery-wrapper {
                flex-direction: column;
            }

            #zoom-result {
                display: none !important;
            }

            .main-img-container {
                height: 400px !important;
            }
        }

        @media (max-width: 767.98px) {
            .main-image-wrapper .d-md-none {
                display: block;
            }

            .main-image-wrapper .d-none.d-md-block,
            .main-image-wrapper .d-none.d-md-flex {
                display: none !important;
            }
        }
    </style>
@endsection

@endsection
