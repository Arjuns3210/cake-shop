@extends('layout.home')

@section('content')
<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .btn-primary:hover {
        transform: scale(1.05);
    }
</style>
<div class="container">
    @if($cart_items->isEmpty())
        <!-- If the cart is empty, show this message -->
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('img/empty.png') }}" alt="Empty Cart" 
                     style="width: 100%; max-width: 300px; animation: bounce 2s infinite;">
                <h2 style="color: #333; font-family: 'Poppins', sans-serif; font-weight: bold; margin-top: 20px;">
                    Oh no! Your cart is feeling lonely 😔
                </h2>
                <p style="color: #666; font-size: 16px;">
                    Let's fill it up with delicious treats! <br> Discover exciting products and deals just for you.
                </p>
                <a href="{{ url('/') }}" class="btn btn-primary" 
                   style="background: linear-gradient(to right, #ff7e5f, #feb47b); border: none; 
                          padding: 14px 28px; font-size: 18px; border-radius: 10px; font-weight: bold;
                          transition: transform 0.2s;">
                    🛒 Start Shopping
                </a>
            </div>
        </div>


    @else
        <!-- If the cart is not empty, show the cart details -->
        <div class="row mt-4 mb-3" style="width: 100%; font-size: 18px; color: #0a818d; font-family: emoji; margin-left: 60px;">
            My Cart ({{$count}} item)
        </div>
        <div class="row" style="justify-content: center; margin: auto; width: 100%;">
            <div class="col-sm-7">
                @foreach($cart_items as $key=>$cart)
                    <div class="cartList">
                        <div>
                            <img src="{{ url('public/images/' . json_decode($cart->cake->img_name)[0]) }}" class="cartImg">
                        </div>
                        <div>
                            <ul class="cartListing">
                                <li>
                                    <a href="{{url('buy/'.$cart->cake->cake_url)}}" class="no-decoration">
                                        {{$cart->cake->cake_name}}
                                    </a>
                                </li>
                                <li>₹<span id="cakePrice{{$cart->id}}">{{$cart->cake_price}}</span></li>
                                <li>{{$cart->cake_weight}}</li>
                                <li style="display: flex;">
                                    Quantity
                                    @if($cart->cake_quentity > 1)
                                        <button class="fa fa-minus sub" style="border: none; background: none;" id="sub{{$cart->id}}" onclick="changeQty('sub', {{$cart->id}})"></button>
                                    @else
                                        <span style="padding-right: 26px !important;"></span>
                                    @endif
                                    <input type="text" value="{{$cart->cake_quentity}}" readonly class="cartInput" id="qty{{$cart->id}}" name="cake_quentity" onload="on({{$cart->id}})">
                                    @if($cart->cake_quentity < 10)
                                        <button class="fa fa-plus add" style="border: none; background: none;" id="add{{$cart->id}}" onclick="changeQty('add', {{$cart->id}})"></button>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="" style="width: 100%; text-align: right;">
                            <a data-url="deleteCart/{{$cart->id}}" class="delete-data"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-sm-4">
                <div class="p-4" style="border: 2px solid hsla(0, 0%, 72.5%, .42); border-radius: 20px;">
                    <span>Order summary</span>
                    <div>
                        <div class="grandTotal">Sub Total
                            <strong>₹{{$cartP}}</strong>
                        </div>
                        <div class="grandTotal">Grand Total
                            <small style="color: red; margin-right: 60px; margin-top: 8px; font-size: 9px;">2 % GST</small>
                            <strong>₹{{(2/100 * $cartP) + $cartP}}</strong>
                        </div>
                    </div>
                    <div>
                        <a href="{{url('checkout')}}" class="btn btn-primary mt-3 w-100">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
	
        <!-- Suggested Products Section -->
        <div class="row mt-5">
            <h3 class="text-center" style="color: #333;">✨ Recommended for You ✨</h3>
            <div class="card-description">
				<div class="card1">
					<img class="card-img-top" src="{{ url('img/blackforest.png') }}" alt="Card image" style="width:100%">
					<div class="card-body">
						<h4 class="card-title">Blackforest</h4>
						<p class="card-text">The All Time Favourite</p>
					</div>
				</div>
				<div class="card1">
					<img class="card-img-top" src="{{ url('img/pineapple.png') }}" alt="Card image" style="width:100%">
					<div class="card-body">
						<h4 class="card-title">Pineapple Cake</h4>
						<p class="card-text">Evergreen One</p>
					</div>
				</div>
				<div class="card1">
					<img class="card-img-top" src="{{ url('img/butterscotch.png') }}" alt="Card image" style="width:100%">
					<div class="card-body">
						<h4 class="card-title">Butterscotch</h4>
						<p class="card-text">For Candy Fans</p>
					</div>
				</div>
				<div class=   "card1">
					<img class="card-img-top" src="{{ url('img/kit_kat.png') }}" alt="Card image" style="width:100%">
					<div class="card-body">
						<h4 class="card-title">Kit Kat</h4>
						<p class="card-text">Crunchiness Overloaded</p>
					</div>
				</div>
			</div>
        </div>
</div>
@endsection
