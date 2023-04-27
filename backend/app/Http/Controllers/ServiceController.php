<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function services() {
        $services = Service::all();
        return response()->json(['status' => 'success', 'data' => $services], 200);
    }

    public function servicesByCompanyId($id) {
        return $this->servicesByListingId($id, 'company');
    }

    public function servicesByEventId($id) {
        return $this->servicesByListingId($id, 'event');
    }

    public function servicesByListingId($id, $type) {
        $listingServices = DB::table('listings_services')
            ->where('listing_id', $id)
            ->where('type', $type)
            ->get();

        $serviceIds = [];

        foreach ($listingServices as $listingService) {
            $serviceIds[] = $listingService->service_id;
        }

        return Service::whereIn('id', $serviceIds)->get();
    }
}
