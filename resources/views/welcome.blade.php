@extends('layouts.app')

@section('content')
    <!-- Hero Slider -->
    <div id="heroCarousel" class="carousel slide mb-5">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="height: 600px;">
                <img src="https://picsum.photos/1920/600?random=100" class="d-block w-100 h-100 object-cover"
                    alt="Summer Collection" style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-25 p-5 rounded-3 animate-fade-up">
                    <h1 class="display-3 fw-bold text-white mb-3">Summer Styles Are Here</h1>
                    <p class="lead text-white opacity-90 mb-4">Discover the latest trends for the season with our exclusive
                        collection.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold rounded-pill">Shop
                        Now</a>
                </div>
            </div>
            <div class="carousel-item" style="height: 600px;">
                <img src="https://picsum.photos/1920/600?random=101" class="d-block w-100 h-100 object-cover"
                    alt="Men's Fashion" style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-25 p-5 rounded-3">
                    <h1 class="display-3 fw-bold text-white mb-3">Men's Exclusive</h1>
                    <p class="lead text-white opacity-90 mb-4">Sophisticated styles for the modern man. Elevate your
                        wardrobe.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold rounded-pill">Shop
                        Men</a>
                </div>
            </div>
            <div class="carousel-item" style="height: 600px;">
                <img src="https://picsum.photos/1920/600?random=102" class="d-block w-100 h-100 object-cover"
                    alt="Women's Fashion" style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-25 p-5 rounded-3">
                    <h1 class="display-3 fw-bold text-white mb-3">Women's Elegance</h1>
                    <p class="lead text-white opacity-90 mb-4">Unleash your inner beauty with our new premium collection.
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold rounded-pill">Shop
                        Women</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Collections Section -->
    <div class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small letter-spacing-2">Shop By Category</span>
                <h2 class="fw-bold mt-2">Collections</h2>
            </div>
            <div class="row g-4">
                @foreach ($categories as $category)
                    <div class="col-md-4">
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-decoration-none">
                            <div class="collection-card position-relative overflow-hidden rounded-4">
                                <div class="collection-img" style="height: 350px;">
                                    <img src="{{ $category->image ?? 'https://picsum.photos/400/350?random=' . $category->id }}"
                                        class="w-100 h-100 object-cover" alt="{{ $category->name }}">
                                </div>
                                <div class="collection-overlay position-absolute bottom-0 start-0 end-0 p-4">
                                    <div class="collection-content text-white">
                                        <h4 class="fw-bold mb-1">{{ $category->name }}</h4>
                                        <p class="mb-2 opacity-75 small">
                                            {{ $category->description ?? 'Explore our latest collection' }}</p>
                                        <span class="btn btn-sm btn-light rounded-pill px-3">
                                            Shop Now <i class="bi bi-arrow-right ms-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <!-- Why Choose Us Section -->
    <div class="py-5 bg-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-truck display-5 text-primary mb-3"></i>
                        <h5 class="fw-bold">Free Shipping</h5>
                        <p class="text-muted small">On all orders over PKR50</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-arrow-repeat display-5 text-primary mb-3"></i>
                        <h5 class="fw-bold">Easy Returns</h5>
                        <p class="text-muted small">30-day return policy</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-shield-lock display-5 text-primary mb-3"></i>
                        <h5 class="fw-bold">Secure Payment</h5>
                        <p class="text-muted small">100% secure payment</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <i class="bi bi-headset display-5 text-primary mb-3"></i>
                        <h5 class="fw-bold">24/7 Support</h5>
                        <p class="text-muted small">Dedicated support team</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Featured Products</h2>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4">View All</a>
            </div>
            <div class="row g-4">
                @foreach ($featuredProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product-card">
                            <!-- Badge -->
                            @if ($loop->iteration % 2 == 0)
                                <div class="badge-custom badge-hot">HOT</div>
                            @elseif($loop->iteration % 3 == 0)
                                <div class="badge-custom badge-sale">SALE</div>
                            @endif

                            <div class="image-container">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img src="{{asset($product->images[0]) ?? 'https://placehold.co/500x600?text=Product' }}"
                                        alt="{{ $product->name }}">
                                </a>
                                <div class="action-buttons">
                                    <button class="action-btn" title="Add to Cart"
                                        onclick='addToCart(event, @json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="action-btn" title="Compare">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                    <button class="action-btn" title="Quick View"
                                        onclick='openQuickView(@json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="action-btn" title="Add to Wishlist"
                                        onclick="addToWishlist(event, {{ $product->id }})">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a
                                        href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                <div class="price-section">
                                    <span class="current-price">PKR {{ number_format($product->price, 2) }}</span>
                                    <span class="original-price">PKR {{ number_format($product->price * 1.25, 2) }}</span>
                                    <span class="discount">20% Off</span>
                                </div>
                                <div class="meta-swap-container">
                                    <div class="rating">
                                        <span class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </span>
                                        <span class="review-count">({{ rand(5, 50) }})</span>
                                    </div>
                                    <div class="color-options">
                                        @if (isset($product->color_options) && is_array($product->color_options))
                                            @foreach ($product->color_options as $color)
                                                <div class="color-option" style="background-color: {{ $color }};"
                                                    title="{{ $color }}"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small">Customer Reviews</span>
                <h2 class="fw-bold mt-2">What Our Customers Say</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted mb-4">"Amazing quality products! Delivery was super fast and the customer
                            service was excellent. Will definitely shop again!"</p>
                        <div class="d-flex align-items-center gap-3 mt-auto">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; font-weight: 600;">SA</div>
                            <div>
                                <h6 class="fw-bold mb-0">Sara Ahmed</h6>
                                <small class="text-muted">Karachi</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p class="text-muted mb-4">"Best online shopping experience in Pakistan! The products are exactly
                            as shown in pictures. Highly recommended!"</p>
                        <div class="d-flex align-items-center gap-3 mt-auto">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; font-weight: 600;">AK</div>
                            <div>
                                <h6 class="fw-bold mb-0">Ali Khan</h6>
                                <small class="text-muted">Lahore</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-muted mb-4">"Great prices and even better quality! I love the variety of products
                            available. The new collection is stunning!"</p>
                        <div class="d-flex align-items-center gap-3 mt-auto">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; font-weight: 600;">FN</div>
                            <div>
                                <h6 class="fw-bold mb-0">Fatima Noor</h6>
                                <small class="text-muted">Islamabad</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Section: Trending -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase small letter-spacing-2">Don't Miss</span>
                <h2 class="fw-bold mt-2">Weekly Trends</h2>
            </div>
            <div class="row g-4">
                @foreach ($trendingProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product-card">
                            <!-- Badge -->
                            @if ($product->badge_text)
                                <div class="badge-custom badge-hot">{{ $product->badge_text }}</div>
                            @endif

                            <div class="image-container">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img src="{{ $product->images[0] ?? 'https://placehold.co/500x600?text=Product' }}"
                                        alt="{{ $product->name }}">
                                </a>
                                <div class="action-buttons">
                                    <button class="action-btn" title="Add to Cart"
                                        onclick='addToCart(event, @json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="action-btn" title="Compare">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                    <button class="action-btn" title="Quick View"
                                        onclick='openQuickView(@json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="action-btn" title="Add to Wishlist"
                                        onclick="addToWishlist(event, {{ $product->id }})">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a
                                        href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                <div class="price-section">
                                    <span class="current-price">PKR {{ number_format($product->price, 2) }}</span>
                                    <span class="original-price">PKR {{ number_format($product->price * 1.5, 2) }}</span>
                                    <span class="discount">35% Off</span>
                                </div>
                                <div class="meta-swap-container">
                                    <div class="rating">
                                        <span class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </span>
                                        <span class="review-count">({{ rand(5, 50) }})</span>
                                    </div>
                                    <div class="color-options">
                                        @if (is_array($product->color_options))
                                            @foreach ($product->color_options as $color)
                                                <div class="color-option" style="background-color: {{ $color }};"
                                                    title="{{ $color }}"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Arrivals Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="text-uppercase fw-bold letter-spacing-1 h3">Latest Arrivals</h2>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-0 px-4">View All</a>
            </div>

            <div class="row g-4">
                @foreach ($latestProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product-card">
                            <div class="badge-custom badge-new">NEW</div>

                            <div class="image-container">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img src="{{ is_array($product->images) && isset($product->images[0]) && $product->images[0] ? $product->images[0] : (is_string($product->images) && $product->images ? $product->images : 'https://placehold.co/500x600?text=Product') }}"
                                        alt="{{ $product->name }}">
                                </a>
                                <div class="action-buttons">
                                    <button class="action-btn" title="Add to Cart"
                                        onclick='addToCart(event, @json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="action-btn" title="Compare">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                    <button class="action-btn" title="Quick View"
                                        onclick='openQuickView(@json($product, JSON_HEX_APOS | JSON_HEX_QUOT))'>
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="action-btn" title="Add to Wishlist"
                                        onclick="addToWishlist(event, {{ $product->id }})">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a
                                        href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                <div class="price-section">
                                    <span class="current-price">PKR {{ number_format($product->price, 2) }}</span>
                                    @if ($product->sale_price)
                                        <span class="original-price">PKR
                                            {{ number_format($product->sale_price, 2) }}</span>
                                        <span class="discount">OFF</span>
                                    @endif
                                </div>
                                <div class="meta-swap-container">
                                    <div class="rating">
                                        <span class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                        </span>
                                        <span class="review-count">({{ rand(5, 50) }})</span>
                                    </div>
                                    <div class="color-options">
                                        @if (isset($product->color_options) && is_array($product->color_options))
                                            @foreach ($product->color_options as $color)
                                                <div class="color-option" style="background-color: {{ $color }};"
                                                    title="{{ $color }}"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <div class="py-5 bg-dark text-white position-relative" style="background: var(--gradient-hero);">
        <div class="container text-center" style="max-width: 600px;">
            <i class="bi bi-envelope-open display-4 text-white mb-3"></i>
            <h2 class="fw-bold mb-3">Subscribe to our Newsletter</h2>
            <p class="text-white-50 mb-4">Get the latest updates on new products and upcoming sales.</p>
            <form class="d-flex gap-2 justify-content-center" action="{{ route('newsletter.subscribe') }}"
                method="POST">
                @csrf
                <input type="email" name="email" class="form-control rounded-pill px-4"
                    placeholder="Your Email Address" style="max-width: 300px;">
                <button class="btn btn-light rounded-pill px-4 fw-bold" type="submit">Subscribe</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts_home')
    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="modal-body p-0">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="p-4 h-100 d-flex flex-column">
                                <div class="main-image-container mb-3 flex-grow-1 bg-light rounded-3 overflow-hidden"
                                    style="height: 400px;">
                                    <img id="qv-main-image" src="" alt="Product" class="w-100 h-100"
                                        style="object-fit: contain;">
                                </div>
                                <div class="thumbnails-container d-flex align-items-center gap-2">
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle prev-thumb"
                                        style="width: 36px; height: 36px;">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <div class="thumbnail-slider flex-grow-1 d-flex gap-2 overflow-auto"
                                        id="qv-thumbnails" style="scroll-behavior: smooth;">
                                        <!-- Thumbnails injected by JS -->
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle next-thumb"
                                        style="width: 36px; height: 36px;">
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
                                    <span class="text-muted text-decoration-line-through me-2" id="qv-old-price"></span>
                                    <span class="badge bg-success bg-opacity-10 text-success"
                                        id="qv-discount-badge"></span>
                                </div>

                                <div class="mb-4 text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span class="text-muted ms-2">(21 Reviews)</span>
                                </div>

                                <p class="text-secondary mb-4" id="qv-description">Description...</p>

                                <div id="qv-variant-sections" class="mb-4">
                                    <div id="qv-color-wrap" class="mb-3 d-none">
                                        <label class="form-label fw-bold mb-2">Color: <span
                                                id="qv-selected-color-text"></span></label>
                                        <div id="qv-colors" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                    <div id="qv-size-wrap" class="mb-3 d-none">
                                        <label class="form-label fw-bold mb-2">Size: <span
                                                id="qv-selected-size-text"></span></label>
                                        <div id="qv-sizes" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-2 mb-4 text-muted small">
                                    <div><i class="bi bi-shield-check text-success me-2"></i> 1 Year Brand Warranty</div>
                                    <div><i class="bi bi-arrow-repeat text-danger me-2"></i> 30 Day Return Policy</div>
                                    <div><i class="bi bi-cash-stack text-warning me-2"></i> Cash on Delivery available
                                    </div>
                                </div>

                                <hr class="my-4">

                                <form id="qv-add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" id="qv-product-id">
                                    <input type="hidden" name="color" id="qv-selected-color" value="">
                                    <input type="hidden" name="size" id="qv-selected-size" value="">
                                    <div class="row g-3 align-items-center mb-4">
                                        <div class="col-auto">
                                            <div class="input-group" style="width: 140px;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="decrementQv()">-</button>
                                                <input type="number" class="form-control text-center" name="quantity"
                                                    id="qv-quantity" value="1" min="1">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="incrementQv()">+</button>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                                                <i class="bi bi-cart-plus me-2"></i> Add To Cart
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-outline-secondary btn-lg"
                                                id="qv-wishlist-btn" title="Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="product-meta small text-secondary">
                                    <div class="mb-1">SKU: <span class="text-dark" id="qv-sku">BE45VGRT</span></div>
                                    <div class="mb-1">Category: <span class="text-dark"
                                            id="qv-category">Clothing</span></div>
                                    <div>Tags: <span class="text-dark">Cloth, Printed</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(event, productId) {
            event.preventDefault();
            const button = event.currentTarget;

            // --- Fly Animation Start ---
            const cartIcon = document.getElementById('cart-icon-container');
            if (cartIcon) {
                const flyer = document.createElement('div');
                flyer.style.position = 'fixed';
                flyer.style.zIndex = '9999';
                flyer.style.width = '30px';
                flyer.style.height = '30px';
                flyer.style.borderRadius = '50%';
                flyer.style.backgroundColor = 'var(--primary-color)';
                flyer.style.color = '#fff';
                flyer.style.display = 'flex';
                flyer.style.alignItems = 'center';
                flyer.style.justifyContent = 'center';
                flyer.innerHTML = '<i class="bi bi-bag-plus"></i>';
                flyer.style.transition = 'all 0.8s ease-in-out';

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

                setTimeout(() => {
                    flyer.remove();
                }, 800);
            }

            // AJAX Request
            fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        if (data.cart_count !== undefined) {
                            badge.innerText = data.cart_count;
                        } else {
                            badge.innerText = parseInt(badge.innerText) + 1;
                        }
                    }
                    showNotification('Product added to cart!', 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    const badge = document.getElementById('cart-badge');
                    if (badge) badge.innerText = parseInt(badge.innerText) + 1;
                    showNotification('Product added to cart!', 'success');
                });
        }

        function addToWishlist(event, productId) {
            event.preventDefault();
            const button = event.currentTarget;
            const icon = button.querySelector('i');

            // Show loading state
            if (icon) icon.className = 'bi bi-hourglass-split';

            fetch('{{ route('wishlist.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => {
                    if (response.status === 401) {
                        // User not logged in - redirect to login
                        showNotification('Please login to add items to wishlist!', 'error');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 1500);
                        throw new Error('Unauthenticated');
                    }
                    return response.json();
                })
                .then(data => {
                    if (icon) icon.className = 'bi bi-heart-fill';
                    button.classList.add('text-danger');
                    showNotification(data.message || 'Added to Wishlist!', 'success');
                })
                .catch(error => {
                    if (error.message !== 'Unauthenticated') {
                        console.error('Error:', error);
                        if (icon) icon.className = 'bi bi-heart';
                    }
                });
        }

        function openQuickView(product) {
            if (qvSliderInterval) {
                clearInterval(qvSliderInterval);
                qvSliderInterval = null;
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
                wishlistBtn.onclick = (e) => addToWishlist(e, product.id);
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
                if (colorsEl) {
                    colorsEl.querySelectorAll('button').forEach(b => b.classList.remove('border-dark'));
                }
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
                thumb.className =
                    `thumbnail-item border rounded overflow-hidden ${index === 0 ? 'border-primary border-2' : ''}`;
                thumb.style.cssText = 'min-width: 70px; width: 70px; height: 70px; cursor: pointer;';
                thumb.innerHTML =
                `<img src="${imgSrc}" alt="thumb" class="w-100 h-100" style="object-fit: cover;">`;
                thumb.onclick = () => {
                    window.qvCurrentIndex = index;
                    mainImage.src = imgSrc;
                    document.querySelectorAll('.thumbnail-item').forEach(el => {
                        el.classList.remove('border-primary', 'border-2');
                    });
                    thumb.classList.add('border-primary', 'border-2');
                    mainImage.style.opacity = '0.5';
                    setTimeout(() => mainImage.style.opacity = '1', 200);
                };
                thumbnailsContainer.appendChild(thumb);
            });

            // Setup Slider Arrow Events
            const qvModalEl = document.getElementById('quickViewModal');
            const prevBtn = qvModalEl?.querySelector('.prev-thumb');
            const nextBtn = qvModalEl?.querySelector('.next-thumb');
            if (prevBtn) prevBtn.onclick = () => {
                const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
                if (!thumbs.length) return;
                const nextIndex = (window.qvCurrentIndex - 1 + thumbs.length) % thumbs.length;
                thumbs[nextIndex].click();
                thumbs[nextIndex].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            };
            if (nextBtn) nextBtn.onclick = () => {
                const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
                if (!thumbs.length) return;
                const nextIndex = (window.qvCurrentIndex + 1) % thumbs.length;
                thumbs[nextIndex].click();
                thumbs[nextIndex].scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            };

            new bootstrap.Modal(qvModalEl).show();
            // NOTE: Auto-slide disabled to allow only arrow navigation
        }

        function scrollQvThumbnails(direction) {
            const container = document.getElementById('qv-thumbnails');
            if (container) {
                const scrollAmount = 90; // thumbnail width + gap
                container.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        }

        // Auto-advance slider
        let qvSliderInterval = null;

        function startQvSlider(images) {
            // Auto-slide disabled: only arrow navigation allowed
            return;
            if (images.length <= 1) return;
            qvSliderInterval = setInterval(() => {
                const thumbs = document.querySelectorAll('#qv-thumbnails .thumbnail-item');
                if (thumbs.length) {
                    const nextIndex = ((window.qvCurrentIndex ?? 0) + 1) % thumbs.length;
                    thumbs[nextIndex].click();
                }
            }, 3000);
        }

        // Clear interval when modal is closed
        document.addEventListener('DOMContentLoaded', function() {
            const qvModal = document.getElementById('quickViewModal');
            if (qvModal) {
                qvModal.addEventListener('hidden.bs.modal', function() {
                    if (qvSliderInterval) {
                        clearInterval(qvSliderInterval);
                        qvSliderInterval = null;
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
                    const productId = document.getElementById('qv-product-id').value;
                    const quantity = document.getElementById('qv-quantity').value;

                    const cartIcon = document.getElementById('cart-icon-container');
                    if (cartIcon) {
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

                    fetch('{{ route('cart.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: parseInt(quantity),
                                color: document.getElementById('qv-selected-color')?.value ||
                                    undefined,
                                size: document.getElementById('qv-selected-size')?.value ||
                                    undefined,
                            })
                        })
                        .then(response => response.json().catch(() => ({})))
                        .then(data => {
                            const badge = document.getElementById('cart-badge');
                            if (badge) {
                                badge.innerText = data.cart_count !== undefined ? data.cart_count :
                                    parseInt(badge.innerText) + parseInt(quantity);
                            }
                            showNotification('Product added to cart!', 'success');
                            setTimeout(() => {
                                bootstrap.Modal.getInstance(document.getElementById(
                                    'quickViewModal')).hide();
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const badge = document.getElementById('cart-badge');
                            if (badge) badge.innerText = parseInt(badge.innerText) + parseInt(quantity);
                            showNotification('Product added to cart!', 'success');
                        });
                });
            }
        });

        function incrementQv() {
            const el = document.getElementById('qv-quantity');
            el.value = parseInt(el.value) + 1;
        }

        function decrementQv() {
            const el = document.getElementById('qv-quantity');
            if (parseInt(el.value) > 1) el.value = parseInt(el.value) - 1;
        }
    </script>
@endsection
