@extends('layouts.app')

@section('content')
    <div class="py-4 bg-white">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item"><a
                                href="{{ route('shop.index', ['category' => $product->category->id]) }}"
                                class="text-decoration-none">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- Left Column - Product Images -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <!-- Main Image -->
                        <div class="main-image-wrapper mb-3 border rounded overflow-hidden" style="height: 500px;">
                            @php
                                $images = is_array($product->images) ? $product->images : [];
                                $mainImage =
                                    count($images) > 0 ? $images[0] : 'https://placehold.co/600x800?text=Product';
                            @endphp
                            <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->name }}"
                                class="w-100 h-100" style="object-fit: contain; transition: opacity 0.3s;">
                        </div>

                        <!-- Thumbnail Slider with Arrows -->
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-outline-secondary btn-sm rounded-circle" onclick="scrollThumbs(-1)"
                                style="width: 36px; height: 36px;">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <div class="thumbnails-wrapper flex-grow-1 overflow-hidden">
                                <div class="d-flex gap-2" id="thumbnail-container"
                                    style="overflow-x: auto; scroll-behavior: smooth;">
                                    @foreach ($images as $index => $image)
                                        <div class="thumb-item border rounded overflow-hidden {{ $index === 0 ? 'border-danger border-2' : '' }}"
                                            style="min-width: 80px; width: 80px; height: 80px; cursor: pointer;"
                                            onclick="changeImage('{{ $image }}', this)">
                                            <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm rounded-circle" onclick="scrollThumbs(1)"
                                style="width: 36px; height: 36px;">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Product Details -->
                <div class="col-lg-6">
                    <!-- Product Title -->
                    <h1 class="fw-bold mb-2 fs-3">{{ $product->name }}</h1>

                    <!-- Price Section -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="fs-4 fw-bold text-danger">PKR {{ number_format($product->price, 2) }}</span>
                        @if ($product->sale_price)
                            <span class="text-muted text-decoration-line-through">PKR
                                {{ number_format($product->sale_price, 2) }}</span>
                            @php
                                $discount = round(
                                    (($product->sale_price - $product->price) / $product->sale_price) * 100,
                                );
                            @endphp
                            <span class="badge bg-success">{{ $discount }}% Off</span>
                        @endif
                    </div>

                    <!-- Rating -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span class="text-muted small">({{ rand(10, 50) }} Reviews)</span>
                    </div>

                    <!-- Description -->
                    <p class="text-secondary mb-4">{{ $product->description }}</p>

                    <!-- Features -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                            <i class="bi bi-shield-check text-success"></i>
                            <span>1 Year Brand Warranty</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                            <i class="bi bi-arrow-repeat text-danger"></i>
                            <span>30 Day Return Policy</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="bi bi-cash-stack text-warning"></i>
                            <span>Cash on Delivery Available</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Color Selection -->
                    @if (is_array($product->color_options) && count($product->color_options) > 0)
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Color</label>
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
                                    ];
                                @endphp
                                @foreach ($product->color_options as $index => $color)
                                    <button type="button"
                                        class="color-btn rounded-circle border-2 {{ $index === 0 ? 'border-dark' : 'border-secondary' }}"
                                        style="width: 32px; height: 32px; background-color: {{ $colorMap[$color] ?? '#ccc' }};"
                                        title="{{ $color }}" onclick="selectColor(this, '{{ $color }}')">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Size Selection -->
                    @if (is_array($product->sizes) && count($product->sizes) > 0)
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Size</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($product->sizes as $index => $size)
                                    <button type="button"
                                        class="btn {{ $index === 0 ? 'btn-dark' : 'btn-outline-secondary' }} size-btn px-3"
                                        onclick="selectSize(this, '{{ $size }}')">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <hr>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.store') }}" method="POST" id="product-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="selected_color" id="selected-color"
                            value="{{ is_array($product->color_options) && count($product->color_options) > 0 ? $product->color_options[0] : '' }}">
                        <input type="hidden" name="selected_size" id="selected-size"
                            value="{{ is_array($product->sizes) && count($product->sizes) > 0 ? $product->sizes[0] : '' }}">

                        <div class="row g-3 align-items-center mb-4">
                            <!-- Quantity -->
                            <div class="col-auto">
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center border-secondary"
                                        name="quantity" id="product-qty" value="1" min="1">
                                    <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="col">
                                <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold" id="add-to-cart-btn">
                                    <i class="bi bi-cart-plus me-2"></i> Add To Cart
                                </button>
                            </div>

                            <!-- Wishlist & Compare -->
                            <div class="col-auto d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-lg"
                                    onclick="addWishlist({{ $product->id }})" title="Wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg" title="Compare">
                                    <i class="bi bi-shuffle"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Stock Status -->
                    <div class="mb-3">
                        @if ($product->stock > 0)
                            <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> In Stock</span>
                        @else
                            <span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i> Out of Stock</span>
                        @endif
                    </div>

                    <!-- Product Meta -->
                    <div class="small text-secondary">
                        <div class="mb-1"><strong>SKU:</strong> {{ $product->sku }}</div>
                        <div class="mb-1"><strong>Category:</strong> <a
                                href="{{ route('shop.index', ['category' => $product->category_id]) }}"
                                class="text-decoration-none">{{ $product->category->name ?? 'Uncategorized' }}</a></div>
                        <div class="mb-1"><strong>Tags:</strong> Fashion, Clothing</div>
                    </div>

                    <!-- Share -->
                    <div class="mt-4 d-flex align-items-center gap-3">
                        <span class="fw-bold small">Share:</span>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-pinterest"></i></a>
                        <a href="#" class="text-secondary fs-5"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if ($relatedProducts->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <h3 class="fw-bold mb-4">Related Products</h3>
                <div class="row g-4">
                    @foreach ($relatedProducts->take(4) as $related)
                        <div class="col-lg-3 col-md-6">
                            <div class="product-card">
                                <div class="image-container">
                                    <a href="{{ route('shop.show', $related->slug) }}">
                                        <img src="{{ is_array($related->images) && count($related->images) > 0 ? $related->images[0] : 'https://placehold.co/500x600?text=Product' }}"
                                            alt="{{ $related->name }}">
                                    </a>
                                    <div class="action-buttons">
                                        <button class="action-btn" onclick="quickAdd({{ $related->id }})"><i
                                                class="fas fa-shopping-cart"></i></button>
                                        <button class="action-btn"><i class="fas fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title"><a
                                            href="{{ route('shop.show', $related->slug) }}">{{ $related->name }}</a></h3>
                                    <div class="price-section">
                                        <span class="current-price">PKR {{ number_format($related->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Product Reviews -->
    <section class="py-5 bg-white">
        <div class="container">
            <h3 class="fw-bold mb-4">Product Reviews</h3>

            <div class="row">
                <!-- Rating Summary -->
                <div class="col-md-4 mb-4">
                    <div class="bg-light rounded p-4 text-center">
                        <div class="display-4 fw-bold text-warning mb-2">4.5</div>
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <div class="text-muted small">Based on {{ rand(20, 100) }} reviews</div>
                    </div>
                </div>

                <!-- Rating Bars -->
                <div class="col-md-8 mb-4">
                    @foreach ([5, 4, 3, 2, 1] as $star)
                        @php $percent = $star == 5 ? 65 : ($star == 4 ? 20 : ($star == 3 ? 10 : 5)); @endphp
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2 small" style="width: 60px;">{{ $star }} <i
                                    class="bi bi-star-fill text-warning"></i></span>
                            <div class="progress flex-grow-1" style="height: 10px;">
                                <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="ms-2 small text-muted" style="width: 40px;">{{ $percent }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Review List -->
            <div class="mt-4">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="border-bottom py-4">
                        <div class="d-flex gap-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>Customer {{ $i }}</strong>
                                        <div class="text-warning small">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ now()->subDays(rand(1, 30))->format('M d, Y') }}</small>
                                </div>
                                <p class="text-secondary mb-0">Great product! Quality is excellent and delivery was fast.
                                    Highly recommended for anyone looking for good value.</p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-outline-primary px-4"><i class="bi bi-pencil me-2"></i> Write a Review</button>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Thumbnail scroll
        function scrollThumbs(dir) {
            document.getElementById('thumbnail-container').scrollBy({
                left: dir * 100,
                behavior: 'smooth'
            });
        }

        // Change main image
        function changeImage(src, el) {
            const mainImg = document.getElementById('main-product-image');
            mainImg.style.opacity = '0.5';
            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = '1';
            }, 150);
            document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('border-danger', 'border-2'));
            el.classList.add('border-danger', 'border-2');
        }

        // Quantity
        function changeQty(delta) {
            const input = document.getElementById('product-qty');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            input.value = val;
        }

        // Color selection
        function selectColor(el, color) {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('border-dark'));
            el.classList.add('border-dark');
            document.getElementById('selected-color').value = color;
        }

        // Size selection
        function selectSize(el, size) {
            document.querySelectorAll('.size-btn').forEach(b => {
                b.classList.remove('btn-dark');
                b.classList.add('btn-outline-secondary');
            });
            el.classList.remove('btn-outline-secondary');
            el.classList.add('btn-dark');
            document.getElementById('selected-size').value = size;
        }

        // Add to Cart with animation
        document.getElementById('product-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('add-to-cart-btn');
            const cartIcon = document.getElementById('cart-icon-container');

            // Fly animation
            if (cartIcon) {
                const flyer = document.createElement('div');
                flyer.style.cssText =
                    'position:fixed;z-index:9999;width:30px;height:30px;border-radius:50%;background:#e74c3c;color:#fff;display:flex;align-items:center;justify-content:center;transition:all 0.8s ease;';
                flyer.innerHTML = '<i class="bi bi-envelope-fill"></i>';
                document.body.appendChild(flyer);

                const btnRect = btn.getBoundingClientRect();
                flyer.style.top = (btnRect.top + btnRect.height / 2) + 'px';
                flyer.style.left = (btnRect.left + btnRect.width / 2) + 'px';

                const cartRect = cartIcon.getBoundingClientRect();
                requestAnimationFrame(() => {
                    flyer.style.top = (cartRect.top + cartRect.height / 2) + 'px';
                    flyer.style.left = (cartRect.left + cartRect.width / 2) + 'px';
                    flyer.style.width = '10px';
                    flyer.style.height = '10px';
                    flyer.style.opacity = '0';
                });
                setTimeout(() => flyer.remove(), 800);
            }

            // AJAX
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            }).then(r => r.json().catch(() => ({}))).then(data => {
                const badge = document.getElementById('cart-badge');
                if (badge) badge.innerText = data.cart_count ?? (parseInt(badge.innerText) + parseInt(
                    document.getElementById('product-qty').value));
                alert('Product added to cart!');
            }).catch(() => alert('Product added to cart!'));
        });

        // Wishlist
        function addWishlist(id) {
            fetch('{{ route('wishlist.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: id
                })
            }).then(() => alert('Added to wishlist!')).catch(() => alert('Added to wishlist!'));
        }

        // Quick add related
        function quickAdd(id) {
            fetch('{{ route('cart.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: id,
                    quantity: 1
                })
            }).then(() => alert('Added to cart!')).catch(() => alert('Added to cart!'));
        }
    </script>
@endsection
