<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\Listing;
use App\Models\UserActiveProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getAllUsers()
    {
        if (Auth::user()->role == 'Administrator' || Auth::user()->role == 'Moderator') {
            $users = User::all();
            return response()->json(['status' => 'success', 'users' => $users->paginate(20)], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);
    }

    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role == 'Administrator' || Auth::user()->role == 'Moderator') {
            $user = User::findOrFail($id);
            $user->fill($request->get('user'));
            $user->save();
            return response()->json(['status' => 'success', 'user' => $user], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);
    }

    public function blockAllUsersContent($user_id)
    {
        if (Auth::user()->role == 'Administrator' || Auth::user()->role == 'Moderator') {

            if (Auth::user()->is_blocked)
                return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);

            $user = User::findOrFail($user_id);

            // find out if that user has any listings
            $listings = Listing::where('user_id', $user->id)->get();

            if (0 === $listings->count())
                return response()->json(['status' => 'failure', 'error' => 'This user doesn\'t have any listings'], 404);

            foreach ($listings as $listing) {
                $listing->is_blocked = true;
            }

            $result = $listings->count() . ' listings of user ' . $user->id . ' was successfully blocked';

            return response()->json(['status' => 'success', 'result' => $result], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);
    }

    public function unblockAllUsersContent($user_id)
    {
        if (Auth::user()->role == 'Administrator' || Auth::user()->role == 'Moderator') {

            if (Auth::user()->is_blocked)
                return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);

            $user = User::findOrFail($user_id);

            // find out if that user has any listings
            $listings = Listing::where('user_id', $user->id)->get();

            if (0 === $listings->count())
                return response()->json(['status' => 'failure', 'error' => 'This user doesn\'t have any listings'], 404);

            foreach ($listings as $listing) {
                $listing->is_blocked = 'false';
            }

            $result = $listings->count() . ' listings of user ' . $user->id . ' was successfully unblocked';

            return response()->json(['status' => 'success', 'result' => $result], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);
    }

    public function getUserType($user_id)
    {

        // check user for existence
        $user = User::find($user_id);

        if (!isset($user))
            return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);

        if (!$user->manages_companies)
            return response()->json(['status' => 'success', 'user' => 'private'], 200);
        else
            return response()->json(['status' => 'success', 'user' => 'professional'], 200);
    }

    public function getCompaniesIdsByUserId($user_id)
    {

        // check user for existence
        $user = User::find($user_id);

        if (!isset($user))
            return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);

        $companies = Company::where('user_id', $user_id)->pluck('listing_id');

        if ($companies->isEmpty())
            return response()->json(['status' => 'success', 'user' => 'private'], 200);
        else
            return response()->json(['status' => 'success', 'user' => 'professional', 'companies_ids' => $companies], 200);
    }

    public function getUserMainSubscriptions()
    {
        $user_id = Auth::user()->id;

        // check user for existence
        $user = User::find($user_id);

        if (!isset($user))
            return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);

        if ($user->manages_companies == false && $user->role === Role::Regular)
            return response()->json(['status' => 'success', 'main' => 'user'], 200);

        $userProducts = UserActiveProduct::where('user_id', $user_id)->get();
        $products = [];

        foreach ($userProducts as $userProduct) {
            $userProduct->company_name = Company::findOrFail($userProduct->company_id)->company_name;
            $userProduct->product_name = Product::findOrFail($userProduct->product_id)->name;
            $userProduct->product_price = Product::findOrFail($userProduct->product_id)->price;
            $userProduct->product_cycle = Product::findOrFail($userProduct->product_id)->cycle;
            array_push($products, $userProduct);
        }

        return response()->json(['status' => 'success', 'main' => $products], 200);
    }

    public function getUserHighestSubscription()
    {
        $user_id = Auth::user()->id;

        // check user for existence
        $user = User::find($user_id);

        if (!isset($user))
            return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);

        if ($user->manages_companies == false && $user->role === Role::Regular)
            return response()->json(['status' => 'success', 'main' => 'user'], 200);

        $userProducts = UserActiveProduct::where('user_id', $user_id)->get();

        $productSlugs = [];

        foreach ($userProducts as $userProduct) {
            array_push($productSlugs, Product::where('id', $userProduct->product_id)->where('product_type_id', 1)->value('slug'));
        }

        if (1 == count($productSlugs)) {
            return response()->json(['status' => 'success', 'main' => $productSlugs[0]], 200);
        } else if (1 < count($productSlugs)) {
            $userProductPrices = [];

            foreach ($userProducts as $userProduct) {
                array_push($userProductPrices, Product::where('id', $userProduct->product_id)->where('product_type_id', 1)->value('price'));
            }

            $mostExpensiveSubscriptionsPrice = max($userProductPrices);
            $highestProductToReturn = Product::where('product_type_id', 1)->where('price', $mostExpensiveSubscriptionsPrice)->value('slug');

            return response()->json(['status' => 'success', 'main' => $highestProductToReturn], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
