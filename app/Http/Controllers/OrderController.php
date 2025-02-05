<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        return view('order/track_order');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function placeOrder(Request $request)
    {
        // Validate request
        $request->validate([
            'payment_type' => 'required|in:cod,online',
        ]);

        // Create order
        $order = new Order();
        $order->user_id = $request->id;
        $order->total_price = Cart::where('user_id', $request->id)->sum('cake_price');
        $order->payment_type = $request->payment_type;
        $order->status = ($request->payment_type == 'cod') ? 'Pending' : 'Processing';
        $order->save();

        // Clear cart after order
        Cart::where('user_id', $user->id)->delete();

        // Redirect based on payment type
        if ($request->payment_type == 'online') {
            return redirect()->route('payment.process', ['order_id' => $order->id]);
        } else {
            return redirect()->route('order.confirmation')->with('success', 'Order placed successfully!');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderSave(Request $request)
    {
        \Log::info("inside of save order");
       $order = new order();
       $order->fname=$request->firstName;
       $order->lname=$request->lastName;
       $order->payment_amount=$request->payment_amount;
       // $order->payment_type=$request->payment_type;
       $order->email=$request->email;
       $order->address=$request->address;
       $order->country=$request->country;
       $order->state=$request->state;
       $order->zip=$request->zip;
       $order->sameAdd=$request->sameAdd;
       $order->saveInfo=$request->saveInfo;
       $order->save();
       return "order complate";
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
