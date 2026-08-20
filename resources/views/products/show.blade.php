@extends('layouts.app')

@section('content')

<div class="row">
    {{-- Product Image --}}
    <div class="col-md-5">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="img-fluid rounded" style="width: 100%; object-fit: cover;">
        @else
            <div class="d-flex align-items-center justify-content-center rounded"
                style="height: 400px; background-color: #DCCCAC;">
                <span style="font-size: 5rem;">🐾</span>
            </div>
        @endif
    </div>

    {{-- Product Details --}}
    <div class="col-md-7">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #546B41;">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}?category_id={{ $product->category->id }}" style="color: #546B41;">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <h2 style="color: #546B41;">{{ $product->name }}</h2>
        <p class="text-muted">{{ $product->category->name }} —
            {{ $product->category->pet_type == 'dog' ? '🐶 Woof' : '🐱 Meow' }}
        </p>
        <h3 class="fw-bold" style="color: #546B41;">₱{{ number_format($product->price, 2) }}</h3>

        <p>{{ $product->description }}</p>

        @if($product->stock > 0)
            <p class="text-success">✅ In Stock ({{ $product->stock }} available)</p>
        @else
            <p class="text-danger">❌ Out of Stock</p>
        @endif

        @auth
            @if(auth()->user()->isCustomer() && $product->stock > 0)
                {{-- Add to Cart --}}
                <form method="POST" action="{{ route('cart.add') }}" class="mb-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex gap-2 align-items-center mb-2">
                        <label>Quantity:</label>
                        <input type="number" name="quantity" value="1"
                            min="1" max="{{ $product->stock }}"
                            class="form-control" style="width: 80px;">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">🛒 Add to Cart</button>
                </form>

                {{-- Add to Wishlist --}}
                <form method="POST" action="{{ route('wishlist.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-outline-primary w-100">❤️ Add to Wishlist</button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login to Purchase</a>
        @endauth

        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Back to Shop</a>
        </div>
    </div>
</div>

@endsection