@extends('layouts.admin')

@section('content')

<h2 style="color: #546B41;">👥 Customers</h2>
<hr style="border-color: #DCCCAC;">

<div class="card" style="border-color: #DCCCAC;">
    <div class="card-body">
        @if($customers->isEmpty())
            <div class="text-center py-4">
                <p class="text-muted">No customers registered yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead style="background-color: #DCCCAC;">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Points Earned</th>
                            <th>Points Redeemed</th>
                            <th>Points Balance</th>
                            <th>Adjust Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->loyaltyPoint->points_earned ?? 0 }}</td>
                                <td>{{ $customer->loyaltyPoint->points_redeemed ?? 0 }}</td>
                                <td>
                                    <span class="badge"
                                        style="background-color: #546B41;">
                                        {{ $customer->loyaltyPoint->points_balance ?? 0 }} pts
                                    </span>
                                </td>
                                <td>
                                    <form method="POST"
                                        action="{{ route('admin.points.adjust', $customer) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex gap-1">
                                            <select name="type" class="form-select form-select-sm">
                                                <option value="earn">Earn</option>
                                                <option value="redeem">Redeem</option>
                                            </select>
                                            <input type="number" name="points"
                                                class="form-control form-control-sm"
                                                min="1" placeholder="pts"
                                                style="width: 70px;">
                                            <button type="submit"
                                                class="btn btn-sm btn-primary">Apply</button>
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