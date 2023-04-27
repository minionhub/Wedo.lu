<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactPerson;
use App\Models\Listing;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use PhpParser\ErrorHandler\Collecting;

class CompanyController extends Controller
{
    /**
     * Display lists of all companies.
     *
     * @return CompanyResource
     */
    public function index()
    {
        $companies = Company::paginate(20);
        foreach ($companies as $company) {
            $company->services = app('App\Http\Controllers\ServiceController')
                ->servicesByCompanyId($company->listing_id);
        }
        return response()->json(['status' => 'success', 'data' => $companies], 200);
    }

    /**
     * Display lists of companies by user id.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function companiesByUserId($id)
    {
        $companies = Company::select(['listing_id', 'company_name'])
            ->where('user_id', $id)
            ->get();
        //        $companies = Company::where('user_id', $id)->paginate(20);
        //        foreach ($companies as $company) {
        //            $company->services = app('App\Http\Controllers\ServiceController')
        //                ->servicesByCompanyId($company->listing_id);
        //        }
        return response()->json(['status' => 'success', 'data' => $companies], 200);
    }

    /**
     * Display lists of companies by category id.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function companiesByCatId($id)
    {
        $categories = app('App\Http\Controllers\CategoryController')->getCategoriesList($id, 0);
        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = $category['id'];
        }
        $categorizables = DB::table('categorizables')->whereIn('category_id', $categoryIds)
            ->where('categorizable_type', 'App\Models\Company')->get();
        $companyIds = [];
        foreach ($categorizables as $categorizable) {
            $companyIds[] = $categorizable->categorizable_id;
        }
        $companies = Company::whereIn('listing_id', $companyIds)->paginate(20);
        foreach ($companies as $company) {
            $company->services = app('App\Http\Controllers\ServiceController')
                ->servicesByCompanyId($company->listing_id);
        }
        return response()->json(['status' => 'success', 'data' => $companies], 200);
    }

    /**
     * Display lists of companies by subcategory slug.
     *
     * @param  int  $slug
     * @return CompanyResource
     */
    public function companiesByCatSlug($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return $this->companiesByCatId($category->id);
    }

    /**
     * Display lists of companies by subcategory slug.
     *
     * @param  int  $slug
     * @return CompanyResource
     */
    public function companiesByServiceSlug($slug)
    {
        $service = Service::where('slug', $slug)->first();
        $companyServices = DB::Table('companies_services')
            ->where('service_id', $service->id)
            ->get();

        $companyIds = [];
        foreach ($companyServices as $companyService) {
            $companyIds[] = $companyService->company_id;
        }
        $companies = Company::whereIn('listing_id', $companyIds)
            ->paginate(20);
        foreach ($companies as $company) {
            $company->services = app('App\Http\Controllers\ServiceController')
                ->servicesByCompanyId($company->listing_id);
        }
        return response()->json(['status' => 'success', 'data' => $companies], 200);
    }

    /**
     * Display the specified company by id.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function companyById($id)
    {
        $company = Company::findOrFail($id);
        $company->services = app('App\Http\Controllers\ServiceController')
            ->servicesByCompanyId($id);
        $company->categories;
        $company->contactPeople;
        return response()->json(['status' => 'success', 'company' => $company], 200);
    }

    /**
     * Display the specified company's name by id.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function companyNameById($id)
    {
        $company = Company::findOrFail($id);
        $company->services = app('App\Http\Controllers\ServiceController')
            ->servicesByCompanyId($id);
        return response()->json(['status' => 'success', 'company' => $company->company_name], 200);
    }

    /**
     * Display the specified company by slug.
     *
     * @param  string  $slug
     * @return CompanyResource
     */
    public function companyBySlug($slug)
    {
        $company = Company::where('slug', $slug)->first();
        $company->services = app('App\Http\Controllers\ServiceController')
            ->servicesByCompanyId($company->listing_id);

        if ($company !== null)
            return response()->json(['status' => 'success', 'company' => $company], 200);
        return response()->json(['status' => 'failure', 'error' => 'No company'], 400);
    }

    /**
     * Store a newly created company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CompanyResource
     */
    public function store(Request $request)
    {
        $name = $request->get('company')['company_name'];
        $count = Company::where('company_name', $name)->count();


        if ($count <= 0) {
            $company = new Company;
            $company->fill($request->get('company'));
            $company->is_premium_listing = true;
            if ($company->save()) {
                // listings table
                $listing = new Listing;
                $listing->slug = $company->slug;
                $listing->listing_id = $company->listing_id;
                $listing->user_id = $company->user_id;
                $listing->listing_type = 'company';
                $listing->save();

                // services table
                $services = $request->get('services');
                foreach ($services as $service) {
                    if ($service['id'] < 0) {
                        $new_sevice = new Service;
                        $new_sevice->name = $service['name'];
                        $new_sevice->slug = str_slug($service['name'], '-');
                        if ($new_sevice->save()) {
                            DB::table('listings_services')->insert([
                                'listing_id' => $company->listing_id,
                                'service_id' => $new_sevice->id,
                                'type' => 'company'
                            ]);
                        }
                    } else {
                        DB::table('listings_services')->insert([
                            'listing_id' => $company->listing_id,
                            'service_id' => $service['id'],
                            'type' => 'company'
                        ]);
                    }
                }

                // Categories
                $company->categories()->attach($request->get('categories'));

                // contact people
                $contactPeople = $request->get('people');
                foreach ($contactPeople as $person) {
                    if ($person['name'] != null && $person['phone'] != null) {
                        $newPerson = new ContactPerson;
                        $newPerson->name = $person['name'];
                        $newPerson->phone = $person['phone'];
                        $newPerson->position = $person['position'];
                        $newPerson->company_id = $company->listing_id;
                        $newPerson->save();
                    }
                }

                return response()->json(['status' => 'success', 'company' => $company], 200);
            }
        } else {
            return response()->json(['status' => 'failure', 'error' => 'Same company already exists'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Company create failed'], 400);
    }

    /**
     * Update the specified company in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return CompanyResource
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        if ($company !== null) {
            $company->fill($request->get('company'));
            if ($company->save()) {
                // listings table
                $listing = Listing::where('listing_id', $id)
                    ->where('listing_type', 'company')->first();
                $listing->slug = $company->slug;
                $listing->save();

                // services table
                DB::table('listings_services')->where(['listing_id' => $company->listing_id, 'type' => 'company'])
                    ->delete();
                $services = $request->get('services');
                foreach ($services as $service) {
                    if ($service['id'] < 0) {
                        $new_sevice = new Service;
                        $new_sevice->name = $service['name'];
                        $new_sevice->slug = str_slug($service['name'], '-');
                        if ($new_sevice->save()) {
                            DB::table('listings_services')->insert([
                                'listing_id' => $company->listing_id,
                                'service_id' => $new_sevice->id,
                                'type' => 'company'
                            ]);
                        }
                    } else {
                        DB::table('listings_services')->insert([
                            'listing_id' => $company->listing_id,
                            'service_id' => $service['id'],
                            'type' => 'company'
                        ]);
                    }
                }

                // Categories
                $company->categories()->detach();
                $company->categories()->attach($request->get('categories'));

                // contact people
                $contactPeople = $request->get('people');
                ContactPerson::where('company_id', $company->listing_id)->delete();
                foreach ($contactPeople as $person) {
                    if ($person['name'] != null && $person['phone'] != null) {
                        $newPerson = new ContactPerson;
                        $newPerson->name = $person['name'];
                        $newPerson->phone = $person['phone'];
                        $newPerson->position = $person['position'];
                        $newPerson->company_id = $company->listing_id;
                        $newPerson->save();
                    }
                }

                return response()->json(['status' => 'success', 'company' => $company], 200);
            }
        } else {
            return response()->json(['status' => 'failure', 'error' => 'No company'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Company update failed'], 400);
    }

    /**
     * Remove the specified company from storage.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if ($company->delete()) {
            return response()->json(['status' => 'success', 'listing_id' => $id], 200);
        } else {
            return response()->json(['status' => 'failure', 'error' => 'Company delete failed'], 400);
        }
    }

    public function searchCompany(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        $geolocation = true;
        if (!$request->has('geolocation') || $request->get('geolocation') === null || !isset($request->geolocation))
            $geolocation = false;

        $query = $request->get('query');
        $geolocationData = $request->get('geolocation');

        if ($geolocation) {
            $searchResults = Company::complexSearch(array(
                'body' => array(
                    'size' => 100,
                    'query' => array(
                        'multi_match' => array(
                            'query' => $query,
                            'fields' => ['company_name', 'short_desc', 'full_description', 'contact_email']
                        )
                    ),
                    'sort' => [
                        array(
                            '_geo_distance' => array(
                                'location' => array(
                                    'lat' => $geolocationData['lat'],
                                    'lon' => $geolocationData['lon']
                                ),
                                'order' => 'asc',
                                'unit' => 'm'
                            )
                        )
                    ]
                )
            ));

            $hits = $searchResults->getHits()['hits'];

            $companiesIdsWithDistance = [];
            foreach ($hits as $hit) {
                // (int) ($hit['sort'][0]) // distance in m
                // $hit['_source'] // company's array
                // array_push($companiesIdsWithDistance, ['id'=> $hit['_source']['listing_id'], 'distance'=> (int) ($hit['sort'][0])]);
                $companiesIdsWithDistance[$hit['_source']['listing_id']] = (int) ($hit['sort'][0]);
            }

            $companiesWithoutServices = collect($searchResults);
            $paginatedResults = collect($companiesWithoutServices)->paginate(20)->toArray();

            foreach ($paginatedResults['data'] as $index => $companyWithoutServices) {
                $company = Company::find($companyWithoutServices['listing_id']);
                $paginatedResults['data'][$index]['services'] = app('App\Http\Controllers\ServiceController')
                    ->servicesByCompanyId($company->listing_id)->toArray();
                $paginatedResults['data'][$index]['distance'] = $companiesIdsWithDistance[$company->listing_id];
            }

            return response()->json(['status' => 'success', 'totalHits' => $searchResults->totalHits(), 'hits' => $paginatedResults], 200);
        }

        $searchResults = Company::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['company_name', 'short_desc', 'full_description', 'contact_email']
                    ],
                ]
            ],
        ], null, null, 100);

        $totalHits = $searchResults->totalHits();
        if ($totalHits > 100)
            $totalHits = 100;

        $companiesWithoutServices = collect($searchResults);
        $paginatedResults = collect($companiesWithoutServices)->paginate(20)->toArray();

        foreach ($paginatedResults['data'] as $index => $companyWithoutServices) {
            $company = Company::find($companyWithoutServices['listing_id']);
            $paginatedResults['data'][$index]['services'] = app('App\Http\Controllers\ServiceController')
                ->servicesByCompanyId($company->listing_id);
        }

        return response()->json(['status' => 'success', 'totalHits' => $totalHits, 'hits' => $paginatedResults], 200);
    }

    // version without geolocation support
    /* public function searchCompany(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        $query = (string) '*' . $request->get('query') . (string) '*';
        // dd($query);

        $searchResults = Company::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['company_name', 'short_desc', 'full_description', 'contact_email']
                    ],
                ]
            ],
        ], null, null, 100);

        $totalHits = $searchResults->totalHits();
        if ($totalHits > 100)
            $totalHits = 100;

        $companiesWithoutServices = collect($searchResults);
        $paginatedResults = collect($companiesWithoutServices)->paginate(20)->toArray();

        foreach ($paginatedResults['data'] as $index => $companyWithoutServices) {
            $company = Company::find($companyWithoutServices['listing_id']);
            $paginatedResults['data'][$index]['services'] = app('App\Http\Controllers\ServiceController')
                ->servicesByCompanyId($company->listing_id);
        }

        return response()->json(['status' => 'success', 'totalHits' => $totalHits, 'hits' => $paginatedResults], 200);
    } */
}
