<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    /**
     * This method will return a JSON of all claims (back office)
     */
    public function index()
    {
        $claims = Claim::all();
        return response()->json(['status' => 'success', 'data' => $claims], 200);
    }

    /**
     * This method will add new claim
     */
    public function store(Request $request) {
        $claim = new Claim;
        $company_id = $request->get('company_id');
        if(Company::find($company_id)->toArray() == null)
            return response()->json(['status' => 'failure'], 400);

        $claim->user_id = Auth::user()->id;
        $claim->company_id = $company_id;
        if($claim->save()) {
            return response()->json(['status' => 'success', 'claim_id' => $claim->id], 200);
        }
        else {
            return response()->json(['status' => 'failure'], 400);
        }
    }
}
