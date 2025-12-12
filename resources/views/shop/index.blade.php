@extends('layouts.app')

@section('content')
    @extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
            <h1 class="fw-bold m-0">New Arrivals</h1>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Sort
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Most Popular</a></li>
                    <li><a class="dropdown-item" href="#">Best Rating</a></li>
                    <li><a class="dropdown-item" href="#">Newest</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Filters (Desktop) -->
            <aside class="col-lg-3 d-none d-lg-block">
                <h5 class="fw-bold mb-3">Categories</h5>
                <div class="list-group list-group-flush">
                    @foreach ($categories as $category)
                        <a href="#"
                            class="list-group-item list-group-item-action border-0 px-0">{{ $category->name }}</a>
                    @endforeach
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="position-relative overflow-hidden bg-light" style="height: 250px;">
                                    <img src="https://via.placeholder.com/300x400?text=Product"
                                        class="card-img-top h-100 object-cover" alt="{{ $product->name }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold mb-1">
                                        <a href="{{ route('shop.show', $product->slug) }}"
                                            class="text-decoration-none text-dark stretched-link">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    <div class="mt-auto">
                                        <p class="card-text fw-bold text-primary mb-0">
                                            ${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@endsection
