<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Region;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * This method will return a JSON of all addresses (back office)
     *
     * @return AddressResource
     */
    public function showAll()
    {
        $address = Address::all();
        return new AddressResource($address);
    }

    public function addressesByCompanyId($id) {
        if($id == null || $id <= 0) {
            return $this->addressesByUser();
        }
        $company = Company::select(['listing_id', 'company_name'])
            ->where('listing_id', $id)->first();
        $addresses = Address::where('company_id', $id)
            ->orderByRaw('company_id - is_primary ASC')
            ->get();
        foreach ($addresses as $address) {
            $address->country = Country::find($address->country_id);
            $address->company = $company;
        }
        return new AddressResource($addresses);
    }

    public function addressesByUser() {
        $addresses = Address::where('user_id', Auth::user()->id)
            ->orderByRaw('company_id - is_primary ASC')
            ->get();
        foreach ($addresses as $address) {
            $address->country = Country::find($address->country_id);
            $address->company = Company::select(['listing_id', 'company_name'])
                ->where('listing_id', $address->company_id)->first();
        }
        return new AddressResource($addresses);
    }

    public function setDefaultAddress($id) {
        $address = Address::find($id);
        Address::where('company_id', $address->company_id)
            ->update(['is_primary' => false]);
        $address->is_primary = true;
        if($address->save()) {
            return new AddressResource($address);
        }
    }

    /**
     * This method will create or update an address (back office)
     *
     * @param Request $request
     * @return AddressResource
     */
    public function store(Request $request)
    {
        $address = $request->isMethod('put') ? Address::findOrFail($request->id) : new Address;

        $address->first_name = $request->input('first_name');
        $address->last_name = $request->input('last_name');
        $address->country_id = $request->input('country_id');
        $address->street_name = $request->input('street_name');
        $address->house_number = $request->input('house_number');
        $address->city = $request->input('city');
        $address->zip = $request->input('zip');
        $address->phone = $request->input('phone');
        $address->email = $request->input('email');
        $address->user_id = $request->input('user_id');
        $address->company_id = $request->input('company_id');

        $isPrimaryExist = Address::where('company_id', $request->input('company_id'))
                ->where('is_primary', true)->count() > 0;
        $address->is_primary = $isPrimaryExist ? false : true;
        if($address->save()) {
            return new AddressResource($address);
        }
    }

    /**
     * Show One address by Id
     *
     * @param $address_id
     * @return AddressResource
     */
    public function showOne($id)
    {
        // Get address
        $address = Address::find($id);
        // Return single address as a resource
        return new AddressResource($address);
    }


    /**
     * Remove address by Id from storage.
     *
     * @param int $id
     * @return AddressResource
     */
    public function destroy($id)
    {
        $address = Address::where('id', $id)
            ->first();
        if($address->delete())
            return new AddressResource($address);
    }
}
