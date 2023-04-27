<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Region;
use App\Models\Company;
use App\Models\Promotion;
use App\Models\Event;
use App\Models\JobOffer;
use App\Models\Listing;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function listingBySlug($slug) {
        $listing = Listing::where('slug', $slug)->first();

        $result = null;
        switch ($listing->listing_type) {
            case 'company':
                $result = Company::find($listing->listing_id);
                $result->services = app('App\Http\Controllers\ServiceController')
                    ->servicesByCompanyId($result->listing_id);
                $result->regions = Region::whereIn('region_id', json_decode($result->region))->get();
                $result->contactPeople;
                $result->promotions;
                $result->jobOffers;
                $result->events;
                break;
            case 'job_offer':
                $result = JobOffer::find($listing->listing_id);
                $result->regions = Region::whereIn('region_id', json_decode($result->region))->get();
                break;
            case 'promotion':
                $result = Promotion::find($listing->listing_id);
                $result->region = Region::find($result->region);
                $result->company = Company::select(['logo_img', 'company_name', 'slug'])
                    ->where('listing_id', $result->company_id)
                    ->first();
                break;
            case 'event':
                $result = Event::find($listing->listing_id);
                $result->region = Region::find($result->region);
                $result->company = Company::select(['logo_img', 'company_name', 'slug'])
                    ->where('listing_id', $result->company_id)
                    ->first();
                $result->services = app('App\Http\Controllers\ServiceController')
                    ->servicesByEventId($result->listing_id);
                break;
        }

        return response()->json(['status' => 'success', 'listing' => $result, 'listingType' => $listing->listing_type, 'listingStatus' => $listing->status, 'isListingBlocked' => $listing->is_blocked], 200);
    }

    public function listingsByUser() {
        $userId = Auth::user()->id;

        $listings = Listing::select(['listing_id', 'listing_type', 'slug'])
            ->where('user_id', $userId)->paginate(25);

        foreach ($listings as $listing) {
            $type = $listing->listing_type;

            switch ($type) {
                case 'company':
                    $listing->data = Company::select('company_name AS title', 'logo_img', 'created_at')
                        ->where('listing_id', $listing->listing_id)->first();
                    break;
                case 'job_offer':
                    $listing->data = JobOffer::select('job_title AS title', 'logo_img', 'created_at')
                        ->where('listing_id', $listing->listing_id)->first();
                    break;
                case 'promotion':
                    $listing->data = Promotion::select('title', 'logo_img', 'created_at')
                        ->where('listing_id', $listing->listing_id)->first();
                    break;
                case 'event':
                    $listing->data = Event::select('title', 'logo_img', 'created_at')
                        ->where('listing_id', $listing->listing_id)->first();
                    break;
            }
        }

        return response()->json([
            'status' => 'success',
            'listings' => $listings
        ], 200);
    }

    public function listingsByServiceSlug($slug) {
        $service = Service::where('slug', $slug)->first();
        $listings = DB::Table('listings_services')
            ->select(['listing_id', 'type'])
            ->where('service_id', $service->id)
            ->paginate(20);

        foreach ($listings as $listing) {
            $type = $listing->type;

            switch ($type) {
                case 'company':
                    $listing->data = Company::select([
                        'listing_id', 'company_name AS title', 'logo_img', 'cover_img', 'short_desc AS desc', 'slug',
                        'contact_email', 'map_latitude', 'map_longitude', 'set_of_images', 'phone', 'website_url',
                        'opening_hours', 'houseNbr', 'city'
                    ])->where('listing_id', $listing->listing_id)->first();
                    $listing->data->services = app('App\Http\Controllers\ServiceController')
                        ->servicesByCompanyId($listing->data->listing_id);
                    break;
                case 'event':
                    $listing->data = Event::select([
                        'listing_id', 'title', 'logo_img', 'cover_img', 'full_description AS desc', 'slug',
                        'contact_email', 'map_latitude', 'map_longitude', 'set_of_images'
                    ])->where('listing_id', $listing->listing_id)->first();
                    $listing->data->services = app('App\Http\Controllers\ServiceController')
                        ->servicesByEventId($listing->data->listing_id);
                    break;
            }
        }

        return response()->json([
            'status' => 'success',
            'listings' => $listings
        ], 200);
    }

    public function getListingStatusBySlug($slug) {
        $listing = Listing::where('slug', $slug)->first();

        if (isset($listing)) {
            return response()->json(['status' => 'success', 'listing' => $listing->status], 200);
        }

        return response()->json(['status' => 'failure', 'listing' => 'Listing not found'], 404);
    }

    public function setListingStatusBySlug($slug, Request $request)
    {
        $user = Auth::user();
        if ($user->role == 'Administrator' || $user->role == 'Moderator') {

            if (!$request->has('status') || $request->get('status') === null || !isset($request->status))
                return response()->json(['status' => 'failure', 'error' => 'Status parameter is missing'], 400);

            $statusToSet = $request->get('status');

            $listing = Listing::where('slug', $slug)->first();
            $listing->status = $statusToSet;

            $listing->save();

            if (isset($listing)) {
                return response()->json(['status' => 'success', 'listing' => $listing->status]);
            }
        }
        return response()->json(['status' => 'failure', 'error' => 'Unauthorized'], 403);
    }
}
