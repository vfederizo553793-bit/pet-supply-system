@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #546B41;">📋 Order #{{ $order->id }}</h2>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">← Back to Orders</a>
</div>

<div class="row">
    {{-- Order Info --}}
    <div class="col-md-6">
        <div class="card mb-3" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">Order Information</h5>
                <hr style="border-color: #DCCCAC;">
                <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Payment Method:</strong> {{ $paymentMethodLabel }}</p>
                @if($order->payment_method === 'gcash' || $order->payment_method === 'paypal')
                    <div class="alert alert-warning small">
                        Please send your payment to GCash number: <strong>{{ $gcashNumber }}</strong>
                    </div>
                @endif
                <p><strong>Status:</strong>
                    @php
                        $badges = [
                            'pending' => 'bg-warning text-dark',
                            'processing' => 'bg-info text-dark',
                            'shipped' => 'bg-success text-white',
                            'delivered' => 'bg-success text-white',
                            'cancelled' => 'bg-danger text-white',
                        ];
                    @endphp
                    <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    {{-- Delivery Info --}}
    <div class="col-md-6">
        <div class="card mb-3" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">Delivery Information</h5>
                <hr style="border-color: #DCCCAC;">
                <p><strong>Recipient:</strong> {{ $order->recipient_name }}</p>
                <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Contact:</strong> {{ $order->contact_number }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Order Items --}}
<div class="card mb-3" style="border-color: #DCCCAC;">
    <div class="card-body">
        <h5 style="color: #546B41;">Items Ordered</h5>
        <hr style="border-color: #DCCCAC;">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead style="background-color: #DCCCAC;">
                    <tr>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            class="rounded">
                                    @endif
                                    {{ $item->product->name }}
                                </div>
                            </td>
                            <td>₱{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Order Totals --}}
        <div class="d-flex justify-content-end">
            <div style="min-width: 250px;">
                <div class="d-flex justify-content-between mb-1">
                    <span>Shipping Fee:</span>
                    <span>₱{{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold"
                    style="color: #546B41; font-size: 1.1rem;">
                    <span>Total Amount:</span>
                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection