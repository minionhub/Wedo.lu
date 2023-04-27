<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTypes = ProductType::all();
        return response()->json(['status' => 'success', 'data' => $productTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productType = new ProductType;
        $productType->fill($request->all());
        if($productType->save()) {
            return response()->json(['status' => 'success', 'productType' => $productType]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'ProjectType create failed']);
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
        $productType = ProductType::find($id);
        return response()->json(['status' => 'success', 'productType' => $productType]);
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
        $productType = ProductType::find($id);
        $productType->fill($request->all());
        if($productType->save()) {
            return response()->json(['status' => 'success', 'productType' => $productType]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'ProjectType update failed']);
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
        $productType = ProductType::find($id);
        if($productType->delete()) {
            return response()->json(['status' => 'success', 'id' => $id]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'ProjectType delete failed']);
        }
    }
}
