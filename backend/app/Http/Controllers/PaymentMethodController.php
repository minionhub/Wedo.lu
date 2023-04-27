<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return response()->json(['status' => 'success', 'data' => $paymentMethods]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentMethod = new PaymentMethod;
        $paymentMethod->fill($request->all());
        if($paymentMethod->save()) {
            return response()->json(['status' => 'success', 'paymentMethod' => $paymentMethod]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'PaymentMethod create failed']);
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
        $paymentMethod = PaymentMethod::find($id);
        return response()->json(['status' => 'success', 'paymentMethod' => $paymentMethod]);
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
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->fill($request->all());
        if($paymentMethod->save()) {
            return response()->json(['status' => 'success', 'paymentMethod' => $paymentMethod]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'PaymentMethod update failed']);
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
        $paymentMethod = PaymentMethod::find($id);
        if($paymentMethod->delete()) {
            return response()->json(['status' => 'success', 'id' => $id]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'PaymentMethod delete failed']);
        }
    }
}
