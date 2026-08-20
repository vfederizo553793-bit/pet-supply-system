@extends('layouts.app')

@section('content')

<h2 style="color: #546B41;">🌟 My Loyalty Points</h2>

{{-- Points Summary Card --}}
<div class="card mb-4" style="background-color: #546B41; border-color: #546B41;">
    <div class="card-body text-white">
        <div class="row text-center">
            <div class="col-md-4">
                <h6 class="text-uppercase" style="color: #DCCCAC;">Total Earned</h6>
                <h2 class="fw-bold">{{ $loyaltyPoint->points_earned }}</h2>
                <p class="small" style="color: #DCCCAC;">points</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-uppercase" style="color: #DCCCAC;">Total Redeemed</h6>
                <h2 class="fw-bold">{{ $loyaltyPoint->points_redeemed }}</h2>
                <p class="small" style="color: #DCCCAC;">points</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-uppercase" style="color: #99AD7A;">Available Balance</h6>
                <h2 class="fw-bold" style="color: #99AD7A;">{{ $loyaltyPoint->points_balance }}</h2>
                <p class="small" style="color: #99AD7A;">points = ₱{{ $loyaltyPoint->points_balance }}</p>
            </div>
        </div>
    </div>
</div>

{{-- How Points Work --}}
<div class="card mb-4" style="border-color: #DCCCAC;">
    <div class="card-body">
        <h5 style="color: #546B41;">How Loyalty Points Work</h5>
        <hr style="border-color: #DCCCAC;">
        <ul class="mb-0">
            <li>Earn <strong>1 point for every ₱20 spent</strong> on orders of ₱500 or more</li>
            <li>Earn <strong>double points</strong> on orders of ₱10,000 or more</li>
            <li>Redeem points at <strong>1 point = ₱1 discount</strong> on future orders</li>
            <li>Qualify for the <strong>Bow & Wow Club</strong> with a single purchase of ₱2,500 or more</li>
        </ul>
    </div>
</div>

{{-- Transaction History --}}
<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        <h5 style="color: #546B41;">Transaction History</h5>
        <hr style="border-color: #DCCCAC;">

        @if($transactions->isEmpty())
            <div class="text-center py-4">
                <p class="text-muted">No transactions yet. Start shopping to earn points!</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Shop Now</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background-color: #DCCCAC;">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Points</th>
                            <th>Order #</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($transaction->type === 'earn')
                                        <span class="badge bg-success">Earned</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Redeemed</span>
                                    @endif
                                </td>
                                <td class="fw-bold {{ $transaction->type === 'earn' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type === 'earn' ? '+' : '-' }}{{ $transaction->points }}
                                </td>
                                <td>
                                    @if($transaction->order_id)
                                        <a href="{{ route('orders.show', $transaction->order_id) }}"
                                            style="color: #546B41;">
                                            #{{ $transaction->order_id }}
                                        </a>
                                    @else
                                        <span class="text-muted">Manual Adjustment</span>
                                    @endif
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