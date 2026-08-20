@extends('layouts.admin')

@section('content')

<h2 style="color: #546B41;">📦 All Orders</h2>
<hr style="border-color: #DCCCAC;">

<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        @if($orders->isEmpty())
            <div class="text-center py-4">
                <p class="text-muted">No orders yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background-color: #DCCCAC;">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Recipient</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $badges = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-dark',
                                    'shipped' => 'bg-success text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                ];
                            @endphp
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
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
                                    <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form method="POST"
                                        action="{{ route('admin.orders.status', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <button type="submit"
                                                class="btn btn-sm btn-primary">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection