@extends('layouts.app')

@section('content')

{{-- Hero Banner --}}
<div class="p-5 mb-4 rounded-3 text-center" style="background-color: #DCCCAC;">
    <h1 style="color: #546B41; font-weight: bold;">🐾 Welcome to Bow & Wow</h1>
    <p class="lead" style="color: #546B41;">Philippines' first all-natural pet store — now online!</p>
    <a href="#products" class="btn btn-primary btn-lg">Shop Now</a>
</div>

{{-- Search and Filter --}}
<div class="card mb-4" style="border-color: #DCCCAC;">
    <div class="card-body">
        <form method="GET" action="{{ route('home') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Search products..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="pet_type" class="form-select">
                    <option value="">All Pets</option>
                    <option value="dog" {{ request('pet_type') == 'dog' ? 'selected' : '' }}>🐶 Woof (Dogs)</option>
                    <option value="cat" {{ request('pet_type') == 'cat' ? 'selected' : '' }}>🐱 Meow (Cats)</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

{{-- Products Grid --}}
<div id="products">
    @if($products->isEmpty())
        <div class="text-center py-5">
            <h4 style="color: #546B41;">No products found.</h4>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <div class="card h-100" style="border-color: #DCCCAC;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="card-img-top" alt="{{ $product->name }}"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center"
                                style="height: 200px; background-color: #DCCCAC;">
                                <span style="font-size: 3rem;">🐾</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title" style="color: #546B41;">{{ $product->name }}</h6>
                            <p class="card-text text-muted small">{{ $product->category->name }}</p>
                            <p class="fw-bold" style="color: #546B41;">₱{{ number_format($product->price, 2) }}</p>
                            <p class="small text-muted">Stock: {{ $product->stock }}</p>
                        </div>
                        <div class="card-footer" style="background-color: #FFF8EC; border-color: #DCCCAC;">
                            <a href="{{ route('products.show', $product) }}"
                                class="btn btn-primary btn-sm w-100 mb-1">View Details</a>
                            @auth
                                @if(auth()->user()->isCustomer())
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="btn btn-outline-primary btn-sm w-100">Add to Cart</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection