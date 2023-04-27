<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $order->paymentMethod;
            $order->address;
        }
        return response()->json(['status' => 'success', 'data' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->fill($request->all());
        if($order->save()) {
            return response()->json(['status' => 'success', 'order' => $order]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Project create failed']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $order->paymentMethod;
        $order->address;
        return response()->json(['status' => 'success', 'order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->fill($request->all());
        if($order->save()) {
            return response()->json(['status' => 'success', 'order' => $order]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Order update failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if($order->delete()) {
            return response()->json(['status' => 'success', 'id' => $id]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Order delete failed']);
        }
    }
}
