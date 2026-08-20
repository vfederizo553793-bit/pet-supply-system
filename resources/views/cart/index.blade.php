@extends('layouts.app')

@section('content')

<h2 style="color: #546B41;">🛒 My Cart</h2>

@if($cartItems->isEmpty())
    <div class="text-center py-5">
        <h4 style="color: #546B41;">Your cart is empty.</h4>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
@else
    <div class="row">
        {{-- Cart Items --}}
        <div class="col-md-8">
            @foreach($cartItems as $item)
                <div class="card mb-3" style="border-color: #DCCCAC;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            {{-- Product Image --}}
                            <div class="col-md-2">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        class="img-fluid rounded" alt="{{ $item->product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                        style="height: 70px; background-color: #DCCCAC;">
                                        <span>🐾</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="col-md-4">
                                <h6 style="color: #546B41;">{{ $item->product->name }}</h6>
                                <p class="text-muted small mb-0">{{ $item->product->category->name }}</p>
                                <p class="fw-bold mb-0" style="color: #546B41;">
                                    ₱{{ number_format($item->product->price, 2) }}
                                </p>
                            </div>

                            {{-- Quantity Update --}}
                            <div class="col-md-3">
                                <form method="POST" action="{{ route('cart.update', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <input type="number" name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1" max="{{ $item->product->stock }}"
                                            class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Item Total --}}
                            <div class="col-md-2 text-center">
                                <p class="fw-bold" style="color: #546B41;">
                                    ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                </p>
                            </div>

                            {{-- Remove --}}
                            <div class="col-md-1 text-center">
                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">✕</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <div class="col-md-4">
            <div class="card" style="border-color: #DCCCAC;">
                <div class="card-body">
                    <h5 style="color: #546B41;">Order Summary</h5>
                    <hr style="border-color: #DCCCAC;">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span class="fw-bold">₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Fee</span>
                        <span class="text-muted small">Calculated at checkout</span>
                    </div>
                    <hr style="border-color: #DCCCAC;">
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 mt-2">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection