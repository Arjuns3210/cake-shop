<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\MessageHelper;
use App\Models\Cart;
use App\Models\Cake;
use App\Models\AddressBook;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = session::get('Uid');
        $data['cart_items'] = Cart::with('cake')->where('user_id',$user_id)->get();

        $data['count'] = $data['cart_items']->sum('cake_quentity');
        $data['cartP'] = $data['cart_items']->sum('cake_price'); 

        return view('cart/index_cart',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function validateCartRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'cake_massage' => 'required'
        ])->errors();
    }
    public function addToCart(Request $request)
    {
        $message = new MessageHelper();
        $msg_data = array();
        $user_id = session::get('Uid');

        $validationErrors = $this->validateCartRequest($request);
        
        if (count($validationErrors)) {
            $message->errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        // $cart = Cart::sum('cake_quentity');

        $ipAddress = request()->ip();

        $query = Cart::where('cake_id', $request->cake_id)
                    ->where('cake_weight', $request->cake_weight);

        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('device_id', $ipAddress);
        }
        $check = $query->first();

        if ($check) {
            // If the item exists, increment the quantity and price
            $check->increment('cake_quentity', $request->cake_quentity);
            $check->increment('cake_price', (float)$request->cake_price);
            $data = $check;
        } else {
            // If the cart item does not exist, create a new record
            $data = new Cart;
            $data->cake_quentity = $request->cake_quentity;
            $data->cake_price = $request->cake_price;
            $data->user_id = $user_id ?: null;  // Set `user_id` if available, otherwise `null`
            // $data->device_id = !$user_id ? $ipAddress : null;  // Set `device_id` if `user_id` is not present
            $data->cake_id = $request->cake_id;
        }

        // Set other fields
        $data->device_id =  $ipAddress;  // Set `device_id` if `user_id` is not present
        $data->cake_massage = $request->cake_massage;
        $data->cake_weight = $request->cake_weight;
        $data->img_name = $request->img_name;
        $data->location = $request->location;

        // Save the data (either updated or newly created)
        $data->save();

        $cartCount = session()->get('cart', 0) + 1; // Get current count and increment
        session()->put('cart', $cartCount);
        session()->save();

        $message->successMessage('Added To Cart', $msg_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {

        $user_id = session('Uid');
        $data['cart_items'] = Cart::with('cake')->where('user_id',$user_id)->get();
        $data['cartP'] = $data['cart_items']->sum('cake_price'); 

        $data['user'] = User::with('addressBooks')->find($user_id);

        if ($data['user']) {
            $data['address'] = $data['user']->addressBooks; // You have the addresses from eager loading

            return view('cart.checkout', $data);
        } else {
            return view('cart.checkout');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function updateCart( $id,$val,$price)
    {
        $msg_data = array();
        $message = new MessageHelper();

        \Log::info("heu");
        $cart=Cart::find($id);
        $cart->cake_price=$price;
        $cart->cake_quentity=$val;

        $cart->save();

        $totalCartQuantity = Cart::where('user_id', session()->get('Uid'))->sum('cake_quentity');

        session()->put('cart', $totalCartQuantity);
        session()->save();
        $message->successMessage('quantity updated', $msg_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function deleteCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        $totalCartQuantity = Cart::where('user_id', session()->get('Uid'))->sum('cake_quentity');

        session()->put('cart', $totalCartQuantity);
        session()->save();
        return response()->json(['success' => 'cart deleted']);
    }
}
