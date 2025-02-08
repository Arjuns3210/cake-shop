<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trackOrder()
    {
        return view('order/track_order',['order' => null]);
    }

    public function trackOrderId(Request $request)
    {
        $request->validate([
            'orderId' => 'required|numeric|exists:orders,id',
        ]);

        $order = Order::with('user', 'address')->where('id', $request->orderId)->first();

        return view('order.track_order', compact('order'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function placeOrder(Request $request)
    {
        $user_id = session('Uid');
        $request->validate([
            'payment_type' => 'required|in:cod,online',
        ]);
        $payment_amount = Cart::where('user_id', $user_id)->sum('cake_price');
        
        // Create order
        $order = new Order();
        $order->user_id = $user_id;
        $order->address_id = $request->address_id;
        $order->payment_amount = $payment_amount;
        $order->payment_type = $request->payment_type;
        $order->status = ($request->payment_type == 'cod') ? 'Pending' : 'Processing';

        $order->save();

        $cartItems = Cart::where('user_id', $user_id)->get();
        foreach ($cartItems as $item) {
            $OrderItem = OrderItem::create([
                'order_id'      => $order->id,
                'cake_id'    => $item->cake_id,
                'quantity'      => $item->cake_quentity,
                'payment_amount' => $payment_amount,
            ]);
        }

        // Clear cart after order
        Cart::where('user_id', $user_id)->delete();
        $totalCartQuantity = Cart::where('user_id', session()->get('Uid'))->sum('cake_quentity');

        session()->put('cart', $totalCartQuantity);
        session()->save();



        // Redirect based on payment type
        if ($request->payment_type == 'online') {
            return redirect()->route('payment.process', ['order_id' => $order->id]);
        } else {
            return redirect()->route('order.confirmation', ['order_id' => $order->id])->with('success', 'Order placed successfully!');
        }
    }

    public function confirmation(Request $request)
    {
        $data['order']= Order::with('address')->where('id', $request->order_id)->get();

        return view('order.confirmation',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
