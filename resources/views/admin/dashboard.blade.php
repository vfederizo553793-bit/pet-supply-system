@extends('layouts.admin')

@section('content')

<h2 style="color: #546B41;">📊 Admin Dashboard</h2>
<hr style="border-color: #DCCCAC;">

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #546B41;">
            <div class="card-body">
                <h6 class="card-title">Total Sales</h6>
                <h3 class="fw-bold">₱{{ number_format($totalSales, 2) }}</h3>
                <p class="small mb-0">From delivered orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #99AD7A;">
            <div class="card-body">
                <h6 class="card-title">Total Orders</h6>
                <h3 class="fw-bold">{{ $totalOrders }}</h3>
                <p class="small mb-0">All time</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="background-color: #DCCCAC;">
            <div class="card-body">
                <h6 class="card-title" style="color: #546B41;">Total Products</h6>
                <h3 class="fw-bold" style="color: #546B41;">{{ $totalProducts }}</h3>
                <p class="small mb-0" style="color: #546B41;">Active & archived</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="background-color: #FFF8EC; border-color: #DCCCAC;">
            <div class="card-body">
                <h6 class="card-title" style="color: #546B41;">Total Customers</h6>
                <h3 class="fw-bold" style="color: #546B41;">{{ $totalCustomers }}</h3>
                <p class="small mb-0" style="color: #546B41;">Registered accounts</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Recent Orders --}}
    <div class="col-md-8">
        <div class="card" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">Recent Orders</h5>
                <hr style="border-color: #DCCCAC;">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead style="background-color: #DCCCAC;">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
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
                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders') }}"
                                            class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Low Stock Alerts --}}
    <div class="col-md-4">
        <div class="card" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">⚠️ Low Stock Alerts</h5>
                <hr style="border-color: #DCCCAC;">
                @if($lowStockProducts->isEmpty())
                    <p class="text-muted text-center">No low stock products.</p>
                @else
                    @foreach($lowStockProducts as $product)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">{{ $product->name }}</span>
                            <span class="badge bg-danger">{{ $product->stock }} left</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection