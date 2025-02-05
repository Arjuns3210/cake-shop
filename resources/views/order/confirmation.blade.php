@extends('layout.home')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h2>Thank You for Your Order!</h2>
            <p>Your order has been placed successfully.</p>
            <hr>
            <h4>Order Summary</h4>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total Price:</strong> ₹{{ $order->total_price }}</p>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_type) }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
