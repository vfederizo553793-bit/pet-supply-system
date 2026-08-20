@extends('layouts.app')

@section('content')

<h2 style="color: #546B41;">❤️ My Wishlist</h2>

@if($wishlistItems->isEmpty())
    <div class="text-center py-5">
        <h4 style="color: #546B41;">Your wishlist is empty.</h4>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Products</a>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($wishlistItems as $item)
            <div class="col">
                <div class="card h-100" style="border-color: #DCCCAC;">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                            class="card-img-top" alt="{{ $item->product->name }}"
                            style="height: 200px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center"
                            style="height: 200px; background-color: #DCCCAC;">
                            <span style="font-size: 3rem;">🐾</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title" style="color: #546B41;">{{ $item->product->name }}</h6>
                        <p class="text-muted small">{{ $item->product->category->name }}</p>
                        <p class="fw-bold" style="color: #546B41;">
                            ₱{{ number_format($item->product->price, 2) }}
                        </p>
                        @if($item->product->stock > 0)
                            <p class="text-success small">✅ In Stock</p>
                        @else
                            <p class="text-danger small">❌ Out of Stock</p>
                        @endif
                    </div>
                    <div class="card-footer" style="background-color: #FFF8EC; border-color: #DCCCAC;">
                        <a href="{{ route('products.show', $item->product) }}"
                            class="btn btn-primary btn-sm w-100 mb-1">View Product</a>

                        @if($item->product->stock > 0)
                            <form method="POST" action="{{ route('cart.add') }}" class="mb-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="btn btn-outline-primary btn-sm w-100">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('wishlist.remove', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-outline-danger btn-sm w-100">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection