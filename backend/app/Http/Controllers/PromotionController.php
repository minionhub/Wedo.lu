<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    /**
     * Display lists of all promotions.
     *
     * @return PromotionResource
     */
    public function index()
    {
        $promotions = Promotion::paginate(20);
        return response()->json(['status' => 'success', 'data' => $promotions], 200);
    }

    /**
     * Display lists of promotions by user id.
     *
     * @param  int  $id
     * @return PromotionResource
     */
    public function promotionsByUserId($id)
    {
        $promotions = Promotion::where('user_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $promotions], 200);
    }

    /**
     * Display lists of promotions by company id.
     *
     * @param  int  $id
     * @return PromotionResource
     */
    public function promotionsByCompanyId($id)
    {
        $promotions = Promotion::where('company_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $promotions], 200);
    }

    /**
     * Display the specified promotion by id.
     *
     * @param  int  $id
     * @return PromotionResource
     */
    public function promotionById($id)
    {
        $promotion = Promotion::findOrFail($id);
        return response()->json(['status' => 'success', 'promotion' => $promotion], 200);
    }

    /**
     * Display the specified promotion by slug.
     *
     * @param  string  $slug
     * @return PromotionResource
     */
    public function promotionBySlug($slug)
    {
        $promotion = Promotion::where('slug', $slug)->first();
        if($promotion !== null)
            return response()->json(['status' => 'success', 'promotion' => $promotion], 200);
        return response()->json(['status' => 'failure', 'error' => 'No promotion'], 400);

    }

    /**
     * Store a newly created promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PromotionResource
     */
    public function store(Request $request)
    {
        $promotion = Promotion::where('title', $request->get('title'))->first();

        if($promotion === null) {
            $promotion = new Promotion;
            $promotion->fill($request->all());
            $promotion->slug = str_slug($request->get('title'), '-');
            if($promotion->save()) {
                return response()->json(['status' => 'success', 'promotion' => $promotion], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Promotion already exists'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Promotion create failed'], 400);
    }

    /**
     * Update the specified promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PromotionResource
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);

        if($promotion !== null) {
            $promotion->fill($request->all());
            $promotion->slug = str_slug($request->get('title'), '-');
            if($promotion->save()) {
                return response()->json(['status' => 'success', 'promotion' => $promotion], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'No promotion'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Promotion update failed'], 400);
    }

    /**
     * Remove the specified promotion from storage.
     *
     * @param  int  $id
     * @return PromotionResource
     */
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        if($promotion->delete()) {
            return response()->json(['status' => 'success', 'listing_id' => $id], 200);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Promotion delete failed'], 400);
        }
    }
}
