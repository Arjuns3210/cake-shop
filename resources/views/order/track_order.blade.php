@extends('layout.home')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-5 w-75" style="border-radius: 25px; background: white; border: none;">
        <div class="row align-items-center">
            <!-- Left Side: Image -->
            <div class="col-md-5 text-center">
                <img src="{{ asset('img/trackorder.png') }}" class="img-fluid" style="max-width: 90%;">
            </div>

            <!-- Right Side: Form -->
            <div class="col-md-7">
                <h2 class="font-weight-bold text-center mb-4 text-primary">🚚 Track Your Order</h2>

                <form action="{{ route('track.order') }}" method="POST">
                    @csrf
                    <div class="input-group shadow-sm rounded-lg overflow-hidden">
                        <input type="text" name="orderId" class="form-control border-0 px-4 py-2" 
                               placeholder="Enter Order ID" value="{{ request('orderId') }}" 
                               style="border-radius: 10px 0 0 10px; font-size: 16px;">
                        <button type="submit" class="btn btn-primary px-4" 
                                style="border-radius: 0 10px 10px 0; font-size: 16px;">
                            <i class="fas fa-search"></i> Track
                        </button>
                    </div>
                </form>

                <!-- Error Message -->
                @if(session('errors'))
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Order Details -->
                @if(!is_null($order))
                    <div class="mt-4 p-4 text-center rounded shadow-sm" 
                         style="background: #f8f9fa; border-left: 5px solid #28a745;">
                        <h5 class="text-success"><i class="fas fa-check-circle"></i> Order Found!</h5>
                        <p><strong><i class="fas fa-box"></i> Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong><i class="fas fa-dollar-sign"></i> Price:</strong> ${{ number_format($order->payment_amount, 2) }}</p>
                        <p><strong><i class="fas fa-user"></i> User Name:</strong> {{ $order->user->user_name }}</p>
                        <p><strong><i class="fas fa-map-marker-alt"></i> City:</strong> {{ $order->address->delivery_city }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
