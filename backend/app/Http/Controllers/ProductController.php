<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json(['status' => 'success', 'data' => $products]);
    }

    public function getBySlug($slug) {
        $product = Product::where('slug', $slug)->get();

        if (count($product) > 0)
            return response()->json(['status' => 'success', 'data' => $product]);
        else
            return response()->json(['status' => 'failure', 'error' => 'No product with such slug exists']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->fill($request->all());
        if($product->save()) {
            return response()->json(['status' => 'success', 'product' => $product]);
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
        $product = Product::find($id);
        return response()->json(['status' => 'success', 'product' => $product]);
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
        $product = Product::find($id);
        $product->fill($request->all());
        if($product->save()) {
            return response()->json(['status' => 'success', 'product' => $product]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Product update failed']);
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
        $product = Product::find($id);
        if($product->delete()) {
            return response()->json(['status' => 'success', 'id' => $id]);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Product delete failed']);
        }
    }
}
