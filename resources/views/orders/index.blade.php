@extends('layouts.app')

@section('content')

<h2 style="color: #546B41;">📦 My Orders</h2>

@if(session('payment_notice'))
    <div class="alert alert-warning">
        {{ session('payment_notice') }}
    </div>
@endif

@if($orders->isEmpty())
    <div class="text-center py-5">
        <h4 style="color: #546B41;">You have no orders yet.</h4>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead style="background-color: #546B41; color: white;">
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Recipient</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->recipient_name }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->payment_method === 'gcash' || $order->payment_method === 'paypal')
                                GCash
                            @elseif($order->payment_method === 'cash_on_delivery')
                                Cash on Delivery
                            @else
                                {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                            @endif
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}"
                                class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection