@extends('layout.home')

<!-- Background Blur and Disable Clicks -->
<style>
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(10px);
        z-index: 5;
    }

    .container {
        pointer-events: none; /* Disable clicks everywhere */
    }

    .btn {
        pointer-events: auto !important; /* Enable clicks only on the button */
    }
</style>
@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg rounded-lg p-4" style="max-width: 600px; background: linear-gradient(135deg, #f8f9fa, #ffffff); position: relative; z-index: 10;">
        <div class="card-body text-center">
            <!-- Success Icon -->
            <div class="mb-3">
                <img src="{{ asset('images/success.png') }}" alt="Order Success" style="width: 80px;">
            </div>

            <h2 class="text-success font-weight-bold">🎉 Thank You for Your Order! 🎉</h2>
            <p class="text-muted">Your order has been placed successfully.</p>
            <hr>

            <!-- Order Summary -->
            <div class="text-left">
                <h4 class="text-dark">Order Summary</h4>
                <p><strong>🆔 Order ID:</strong> #{{ $order[0]->id }}</p>
                <p><strong>💰 Total Price:</strong> ₹{{ $order[0]->payment_amount }}</p>
                <p><strong>💳 Payment Method:</strong> {{ strtoupper($order[0]->payment_type) }}</p>
                <p><strong>📍 Delivery Address:</strong> {{ $order[0]->address->delivery_address }}</p>
            </div>

            <!-- Continue Shopping Button -->
            <a href="{{ url('/') }}" class="btn btn-success btn-lg mt-3 px-4 py-2"
               style="border-radius: 30px; font-weight: bold; transition: 0.3s ease-in-out;"
               onmouseover="this.style.transform='scale(1.05)';"
               onmouseout="this.style.transform='scale(1)';">
               🛍️ Continue Shopping
            </a>
        </div>
    </div>
</div>

@endsection
