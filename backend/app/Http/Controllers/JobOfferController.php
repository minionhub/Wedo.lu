<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Region;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobOfferController extends Controller
{
    /**
     * Display lists of all joboffers.
     *
     * @return JobOfferResource
     */
    public function index()
    {
        $jobOffers = JobOffer::paginate(20);
        return response()->json(['status' => 'success', 'data' => $jobOffers], 200);
    }

    /**
     * Display lists of joboffers by user id.
     *
     * @param  int  $id
     * @return JobOfferResource
     */
    public function jobOffersByUserId($id)
    {
        $jobOffers = JobOffer::where('user_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $jobOffers], 200);
    }

    /**
     * Display lists of joboffers by company id.
     *
     * @param  int  $id
     * @return JobOfferResource
     */
    public function jobOffersByCompanyId($id)
    {
        $jobOffers = JobOffer::where('company_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $jobOffers], 200);
    }

    /**
     * Display lists of joboffers by multi filter options.
     *
     * @param  int  $id
     * @return JobOfferResource
     */
    public function jobOffersByMultiOptions(Request $request)
    {
        $title = $request->get('title');
        $jobOffers = JobOffer::where('job_title', 'like',  '%' . $title . '%');

        if ($request->has('contracts') && $request->get('contracts') != null) {
            $contracts = $request->get('contracts');
            $jobOffers = $jobOffers->whereIn('contract_type', $contracts);
        }

        if ($request->has('categories') && $request->get('categories') != null) {
            $catIds = $request->get('categories');
            $categories = [];
            foreach ($catIds as $catId) {
                $categories = array_merge($categories, app('App\Http\Controllers\CategoryController')->getCategoriesList($catId, 0));
            }
            $categoryIds = [];
            foreach ($categories as $category) {
                $categoryIds[] = $category['id'];
            }
            $jobOffers = $jobOffers->whereIn('category_id', $categoryIds);
        }

        if ($request->has('regions') && $request->get('regions') != null) {
            $regionIds = $request->get('regions');
            $jobOffers = $jobOffers->where(function ($query) use ($regionIds) {
                $query = $query->whereJsonContains('region', array_pop($regionIds));
                foreach ($regionIds as $regionId) {
                    $query = $query->orWhereJsonContains('region', $regionId);
                }
            });
        }

        $jobOffers = $jobOffers->paginate(21)->toArray();

        foreach ($jobOffers['data'] as $index => $jobOffer) {
            $region = [];
            $regionIds = json_decode($jobOffer['region']);
            foreach ($regionIds as $regionId) {
                $region[] = Region::find($regionId)->name;
            }
            $jobOffers['data'][$index]['region'] = $region;
        }

        return response()->json(['status' => 'success', 'data' => $jobOffers], 200);
    }

    /**
     * Display the specified joboffer by id.
     *
     * @param  int  $id
     * @return JobOfferResource
     */
    public function jobOfferById($id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        return response()->json(['status' => 'success', 'jobOffer' => $jobOffer], 200);
    }

    /**
     * Display the specified joboffer by slug.
     *
     * @param  string  $slug
     * @return JobOfferResource
     */
    public function jobOfferBySlug($slug)
    {
        $jobOffer = JobOffer::where('slug', $slug)->first();
        if ($jobOffer !== null)
            return response()->json(['status' => 'success', 'jobOffer' => $jobOffer], 200);
        return response()->json(['status' => 'failure', 'error' => 'No joboffer'], 400);
    }

    /**
     * Store a newly created joboffer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JobOfferResource
     */
    public function store(Request $request)
    {
        $jobOffer = new JobOffer;
        $jobOffer->fill($request->get('joboffer'));

        if($jobOffer->save()) {
            // listings table
            $listing = new Listing;
            $listing->slug = $jobOffer->slug;
            $listing->listing_id = $jobOffer->listing_id;
            $listing->user_id = $jobOffer->user_id;
            $listing->listing_type = 'job_offer';
            $listing->save();
            return response()->json(['status' => 'success', 'joboffer' => $jobOffer], 200);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'JobOffer create failed'], 400);
        }
    }

    /**
     * Update the specified joboffer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JobOfferResource
     */
    public function update(Request $request, $id)
    {
        $jobOffer = JobOffer::find($id);

        if($jobOffer !== null) {
            $jobOffer->fill($request->get('joboffer'));
            if($jobOffer->save()) {
                // listings table
                $listing = Listing::where('listing_id', $id)
                    ->where('listing_type', 'job_offer')->first();
                $listing->slug = $jobOffer->slug;
                $listing->save();
                return response()->json(['status' => 'success', 'joboffer' => $jobOffer], 200);
            }
        } else {
            return response()->json(['status' => 'failure', 'error' => 'No joboffer'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'JobOffer update failed'], 400);
    }

    /**
     * Remove the specified joboffer from storage.
     *
     * @param  int  $id
     * @return JobOfferResource
     */
    public function destroy($id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        if ($jobOffer->delete()) {
            return response()->json(['status' => 'success', 'listing_id' => $id], 200);
        } else {
            return response()->json(['status' => 'failure', 'error' => 'JobOffer delete failed'], 400);
        }
    }

    public function searchJoboffer(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        // check if there is contract_type
        $contractType = true;
        if (!$request->has('contract_type') || $request->get('contract_type') === null || !isset($request->contract_type))
            $contractType = false;

        // check if there are categories
        $categories = true;
        if (!$request->has('categories') || $request->get('categories') === null || !isset($request->categories))
            $categories = false;

        // check if there are cities
        $regions = true;
        if (!$request->has('regions') || $request->get('regions') === null || !isset($request->regions))
            $regions = false;

        $query = $request->get('query');

        $searchResults = JobOffer::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['job_title', 'full_description', 'contract_type', 'company_name',  'contact_email']
                    ]
                ]
            ],
        ], null, null, 100);

        $searchResultsCollection = collect($searchResults);

        if ($contractType)
            $searchResultsCollection = $searchResultsCollection->whereIn('contract_type', $request->get('contract_type'));

        if ($categories) {
            $catIds = $request->get('categories');
            $cats = [];
            foreach ($catIds as $catId) {
                $cats = array_merge($cats, app('App\Http\Controllers\CategoryController')->getCategoriesList($catId, 0));
            }
            $categoryIds = [];
            foreach ($cats as $cat) {
                $categoryIds[] = $cat['id'];
            }
            $searchResultsCollection = $searchResultsCollection->whereIn('category_id', array_unique($categoryIds));
        }

        $results = $searchResultsCollection->toArray();
        $resultsKeys = [];

        // extract search joboffers primary keys from search results
        foreach ($results as $result) {
            array_push($resultsKeys, $result['listing_id']);
        }

        $searchResultsCollectio = DB::table('job_offers')->whereIn('listing_id', $resultsKeys);
        $searchResultsCollection = $searchResultsCollectio->get();

        if ($regions) {
            $regionIds = $request->get('regions');

            $searchResultsCollecti = $searchResultsCollectio->where(function ($_query) use ($regionIds) {
                $_query = $_query->whereJsonContains('region', array_pop($regionIds));
                foreach ($regionIds as $regionId) {
                    $_query = $_query->orWhereJsonContains('region', $regionId);
                }
            });

            $searchResultsCollection = $searchResultsCollecti->get();
        }

        // as of now we don't need to show number of hits for joboffers yet
        // $totalResults = $searchResultsCollection;

        $searchResultsCollection = $searchResultsCollection->paginate(20)->toArray();

        foreach ($searchResultsCollection['data'] as $index => $jobOffer) {
            $region = [];
            $regionIds = json_decode($jobOffer->region);
            foreach ($regionIds as $regionId) {
                $region[] = Region::find($regionId)->name;
            }
            $searchResultsCollection['data'][$index]->region = $region;
        }

        return response()->json(['status' => 'success', 'data' => $searchResultsCollection], 200);
    }
}
