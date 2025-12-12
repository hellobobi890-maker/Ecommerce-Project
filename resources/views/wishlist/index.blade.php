@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="fw-bold mb-4">My Wishlist</h1>

        @if ($wishlists->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlists as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->images[0] ?? 'https://via.placeholder.com/80' }}"
                                            alt="{{ $item->product->name }}" class="img-thumbnail me-3"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                <a href="{{ route('shop.show', $item->product->slug) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-bold">${{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    @if ($item->product->stock > 0)
                                        <span class="badge bg-success">In Stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>

                                        <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-heart display-1 text-muted mb-3"></i>
                <h3 class="fw-bold">Your wishlist is empty</h3>
                <p class="text-muted">Start adding items you love to your wishlist!</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        @endif
    </div>
@endsection
