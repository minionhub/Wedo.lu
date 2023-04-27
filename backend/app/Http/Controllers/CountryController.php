<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * This method will return a JSON of all addresses (back office)
     *
     * @return AddressResource
     */
    public function index()
    {
        $countries = Country::all();
        return response()->json(['status' => 'success', 'data' => $countries], 200);
    }
}
