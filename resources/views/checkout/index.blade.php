@extends('layouts.app')

@section('content')

<h2 style="color: #546B41;">🧾 Checkout</h2>

<div class="row">
    {{-- Checkout Form --}}
    <div class="col-md-7">
        <div class="card mb-3" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">Delivery Information</h5>
                <hr style="border-color: #DCCCAC;">

                <form method="POST" action="{{ route('orders.store') }}" id="checkoutForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Recipient Name</label>
                        <input type="text" name="recipient_name" class="form-control"
                            value="{{ auth()->user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Address (Davao City only)</label>
                        <textarea name="delivery_address" class="form-control"
                            rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delivery Area (for shipping fee)</label>
                        <select name="area" class="form-select" id="areaSelect" required>
                            <option value="">Select area...</option>
                            <option value="50">Poblacion / Downtown Davao — ₱50</option>
                            <option value="80">Buhangin / Agdao / Lanang — ₱80</option>
                            <option value="100">Toril / Calinan / Baguio District — ₱100</option>
                            <option value="150">Tugbok / Marilog / Paquibato — ₱150</option>
                        </select>
                        <input type="hidden" name="shipping_fee" id="shippingFeeInput" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" id="paymentMethodSelect" required>
                            <option value="gcash">GCash</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                    </div>

                    <div class="alert alert-warning small d-none" id="gcashNotice">
                        Send payment to GCash number: <strong>{{ $gcashNumber }}</strong>
                    </div>

                    {{-- Loyalty Points Redemption --}}
                    @if($loyaltyPoints && $loyaltyPoints->points_balance > 0)
                        <div class="card mb-3" style="background-color: #546B41; border-color: #546B41;">
                            <div class="card-body text-white">
                                <h6>🌟 Redeem Loyalty Points</h6>
                                <p class="mb-1">Available Balance:
                                    <strong>{{ $loyaltyPoints->points_balance }} points
                                    (₱{{ $loyaltyPoints->points_balance }} discount)</strong>
                                </p>
                                <div class="input-group">
                                    <input type="number" name="redeem_points"
                                        class="form-control" placeholder="Enter points to redeem"
                                        min="0" max="{{ $loyaltyPoints->points_balance }}" value="0">
                                    <span class="input-group-text">pts</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="redeem_points" value="0">
                    @endif

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Order Summary --}}
    <div class="col-md-5">
        <div class="card" style="border-color: #DCCCAC;">
            <div class="card-body">
                <h5 style="color: #546B41;">Order Summary</h5>
                <hr style="border-color: #DCCCAC;">

                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">{{ $item->product->name }}
                            <span class="text-muted">x{{ $item->quantity }}</span>
                        </span>
                        <span class="small fw-bold">
                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </span>
                    </div>
                @endforeach

                <hr style="border-color: #DCCCAC;">

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-bold">₱{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping Fee</span>
                    <span class="fw-bold" id="shippingFeeDisplay">₱0.00</span>
                </div>

                @if($subtotal >= 3500)
                    <div class="alert alert-success small py-1">
                        🎉 You qualify for free shipping!
                    </div>
                @endif

                <hr style="border-color: #DCCCAC;">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold" style="color: #546B41;" id="totalDisplay">
                        ₱{{ number_format($subtotal, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const subtotal = Number("{{ $subtotal }}");
    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    const gcashNotice = document.getElementById('gcashNotice');

    function toggleGcashNotice() {
        if (!paymentMethodSelect || !gcashNotice) {
            return;
        }

        if (paymentMethodSelect.value === 'gcash') {
            gcashNotice.classList.remove('d-none');
        } else {
            gcashNotice.classList.add('d-none');
        }
    }

    toggleGcashNotice();

    if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', toggleGcashNotice);
    }

    document.getElementById('areaSelect').addEventListener('change', function() {
        let fee = parseInt(this.value) || 0;

        // Free shipping for orders PHP 3,500 and above
        if (subtotal >= 3500) {
            fee = 0;
        }

        document.getElementById('shippingFeeInput').value = fee;
        document.getElementById('shippingFeeDisplay').textContent = '₱' + fee.toFixed(2);
        document.getElementById('totalDisplay').textContent = '₱' + (subtotal + fee).toFixed(2);
    });
</script>
@endpush