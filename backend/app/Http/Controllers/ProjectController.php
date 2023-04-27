<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Models\Region;
use App\Models\Project;
use App\Models\Language;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Models\ProjectStartTime;
use App\Models\ProjectSubCategory;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        if (0 !== count($projects))
            return response()->json(['status' => 'success', 'data' => $projects], 200);
        else
            return response()->json(['status' => 'failure', 'error' => 'No projects'], 400);
    }

    public function searchAmongAllProjects(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        // if paginate is missing or empty
        if (!$request->has('paginate') || $request->get('paginate') === null || !isset($request->paginate))
            return response()->json(['status' => 'failure', 'error' => 'Paginate parameter is missing'], 400);

        // if page is missing or empty
        if (!$request->has('page') || $request->get('page') === null || !isset($request->page))
            return response()->json(['status' => 'failure', 'error' => 'Page parameter is missing'], 400);

        $paginate = $request->get('paginate');
        $page = $request->get('page');
        $query = $request->get('query');

        if ($page < 1)
            return response()->json(['status' => 'failure', 'error' => 'Wrong page'], 400);
        if ($page == 1)
            $offset = 0;
        else
            $offset = $page * $paginate - $paginate;

        $projects = Project::searchByQuery([
            'multi_match' => [
                'query' => $query,
                'fields' => ["title", "description", "author_name", "author_email"]
            ],
        ], null, null, $paginate, $offset);

        return response()->json(['status' => 'success', 'totalHits' => $projects->totalHits(), 'hits' => $projects], 200);
    }

    public function searchAmongAllPublishedProjects(Request $request)
    {
        $categories = false;
        if ($request->has('categories') && $request->get('categories') != null) {

            $categories = true;

            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcatIds = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcatIds, $subcat->subcategory_id);
            }
        }

        /*******************************************/

        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        $query = $request->get('query');

        $searchResults = Project::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'description', 'author_name', 'author_email']
                    ],
                ],
                'filter' => [
                    'term' => ['status' => 'published']
                ],
            ],
        ], null, null, 666);

        $resultsWithoutCategories = $searchResults;

        $resultProjectsIds = [];
        $searchResultsIds = [];

        if ($categories) {
            foreach ($searchResults as $searchResult)
                array_push($searchResultsIds, $searchResult['project_id']);

            // $searchResultsIds now contains all search results projects ids
            // $subcatIds contains all selected subcats ids
            // now need to check each project with reference table, and only take these that belong to selected subcats

            $resultProjectsIds = DB::table('projects_project_subcategories')->whereIn('project_id', $searchResultsIds)->whereIn('subcategory_id', $subcatIds)->pluck('project_id')->toArray();

            $resultsWithCategories = Project::findMany($resultProjectsIds);

            return response()->json(['status' => 'success', 'totalHits' => $resultsWithCategories->count(), 'hits' => $resultsWithCategories->paginate(10)], 200);
        }

        return response()->json(['status' => 'success', 'totalHits' => $resultsWithoutCategories->totalHits(), 'hits' => collect($resultsWithoutCategories)->paginate(10)], 200);
    }

    public function searchAmongOwnProjects(Request $request)
    {
        $categories = false;
        if ($request->has('categories') && $request->get('categories') != null) {

            $categories = true;

            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcatIds = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcatIds, $subcat->subcategory_id);
            }
        }

        /*******************************************/

        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        $query = $request->get('query');

        $searchResults = Project::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'description', 'author_name', 'author_email']
                    ],
                ],
                'filter' => [
                    'term' => ['author_id' => Auth::user()->id]
                ],
            ],
        ], null, null, 666);

        $resultsWithoutCategories = $searchResults;

        $resultProjectsIds = [];
        $searchResultsIds = [];

        if ($categories) {
            foreach ($searchResults as $searchResult)
                array_push($searchResultsIds, $searchResult['project_id']);

            // $searchResultsIds now contains all search results projects ids
            // $subcatIds contains all selected subcats ids
            // now need to check each project with reference table, and only take these that belong to selected subcats

            $resultProjectsIds = DB::table('projects_project_subcategories')->whereIn('project_id', $searchResultsIds)->whereIn('subcategory_id', $subcatIds)->pluck('project_id')->toArray();

            $resultsWithCategories = Project::findMany($resultProjectsIds);

            return response()->json(['status' => 'success', 'totalHits' => $resultsWithCategories->count(), 'hits' => $resultsWithCategories->paginate(10)], 200);
        }

        return response()->json(['status' => 'success', 'totalHits' => $resultsWithoutCategories->totalHits(), 'hits' => collect($resultsWithoutCategories)->paginate(10)], 200);
    }

    public function searchAmongOwnPublishedProjects(Request $request) {
        $categories = false;
        if ($request->has('categories') && $request->get('categories') != null) {

            $categories = true;

            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcatIds = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcatIds, $subcat->subcategory_id);
            }
        }

        /*******************************************/

        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        $query = $request->get('query');

        $searchResults = Project::searchByQuery([
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'description', 'author_name', 'author_email']
                    ],
                ],
                'filter' => [
                    'term' => ['author_id' => Auth::user()->id]
                ],
            ],
        ], null, null, 666);

        // $searchResults contain all own projects, now need to only leave published ones
        // $published = gettype();
        $ownPublishedProjects = collect($searchResults->toArray())->where('status', '"published"')->toArray();

        $resultsWithoutCategories = $ownPublishedProjects;

        $resultProjectsIds = [];
        $searchResultsIds = [];

        if ($categories) {
            foreach ($ownPublishedProjects as $ownPublishedProject)
                array_push($searchResultsIds, $ownPublishedProject['project_id']);

            // $searchResultsIds now contains all search results projects ids
            // $subcatIds contains all selected subcats ids
            // now need to check each project with reference table, and only take these that belong to selected subcats

            $resultProjectsIds = DB::table('projects_project_subcategories')->whereIn('project_id', $searchResultsIds)->whereIn('subcategory_id', $subcatIds)->pluck('project_id')->toArray();

            $resultsWithCategories = Project::findMany($resultProjectsIds);

            return response()->json(['status' => 'success', 'totalHits' => $resultsWithCategories->count(), 'hits' => $resultsWithCategories->paginate(10)], 200);
        }

        return response()->json(['status' => 'success', 'totalHits' => count($resultsWithoutCategories), 'hits' => collect($resultsWithoutCategories)->paginate(10)], 200);
    }

    public function searchForProjectsAmongTitleOnly(Request $request)
    {
        // if query is missing or empty
        if (!$request->has('query') || $request->get('query') === null || !isset($request->query))
            return response()->json(['status' => 'failure', 'error' => 'Query parameter is missing'], 400);

        // if paginate is missing or empty
        if (!$request->has('paginate') || $request->get('paginate') === null || !isset($request->paginate))
            return response()->json(['status' => 'failure', 'error' => 'Paginate parameter is missing'], 400);

        // if page is missing or empty
        if (!$request->has('page') || $request->get('page') === null || !isset($request->page))
            return response()->json(['status' => 'failure', 'error' => 'Page parameter is missing'], 400);

        $paginate = $request->get('paginate');
        $page = $request->get('page');
        $query = $request->get('query');

        if ($page < 1)
            return response()->json(['status' => 'failure', 'error' => 'Wrong page'], 400);
        if ($page == 1)
            $offset = 0;
        else
            $offset = $page * $paginate - $paginate;

        $projects = Project::searchByQuery([
            'multi_match' => [
                'query' => $query,
                'fields' => ["title"]
            ],
        ], null, null, $paginate, $page);

        return response()->json(['status' => 'success', 'totalHits' => $projects->totalHits(), 'hits' => $projects], 200);
    }

    public function getPublishedProjects()
    {
        $projects = Project::where('status', 'published')->paginate(10);
        if (0 !== count($projects))
            return response()->json(['status' => 'success', 'data' => $projects], 200);
        else
            return response()->json(['status' => 'failure', 'error' => 'No projects'], 400);
    }

    public function showProjectBySlug($slug)
    {
        $project = Project::where('slug', $slug)->get();
        if (0 !== count($project))
            return response()->json(['status' => 'success', 'project' => $project], 200);
        else
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
    }

    public function increaseOffersCounter($projectId, $userId)
    {
        $project = Project::find($projectId);

        if ($project == null) {
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
        }

        $numberOfOffers = $project->number_of_offers;
        $project->number_of_offers = ++$numberOfOffers;

        DB::table('user_contacted_projects')->insert([
            'user_id' => $userId,
            'project_id' => $project->project_id,
            'has_contacted' => true
        ]);

        if ($project->save()) {
            return response()->json(['status' => 'success', 'project' => $project], 200);
        }
    }

    public function getUserContactedProject($projectId, $userId)
    {
        $project = Project::find($projectId);

        if ($project == null) {
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
        }

        $result = DB::table('user_contacted_projects')
            ->where('user_id', $userId)
            ->where('project_id', $projectId)
            ->value('has_contacted');

        if ($result == null)
            return response()->json(['status' => 'success', 'contacted' => 'No'], 200);
        else
            return response()->json(['status' => 'success', 'contacted' => 'Yes'], 200);
    }

    public function showProjectsByCategoryId($category_id)
    {
        // check category for existence first
        $cat = ProjectCategory::find($category_id);

        if (!isset($cat)) {
            return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
        }

        $projectAllSubcatsByCat = DB::table('project_subcategories')
            ->where('category_id', $category_id)
            ->get();

        $subcat_ids = [];

        foreach ($projectAllSubcatsByCat as $subcat) {
            array_push($subcat_ids, $subcat->subcategory_id);
        }

        // $subcat_ids array now contain all project subcategories' id's that belong to $category_id
        $projectsProjectSubcats = DB::table('projects_project_subcategories')
            ->get();

        $project_ids = [];

        foreach ($projectsProjectSubcats as $subcatRecord) {
            if (in_array($subcatRecord->subcategory_id, $subcat_ids))
                array_push($project_ids, $subcatRecord->project_id);
        }

        // $project_ids now contains all project's id's that belong to $category_id
        $projects = Project::whereIn('project_id', $project_ids)->paginate(10);

        return response()->json(['status' => 'success', 'projects' => $projects], 200);
    }

    public function showProjectsByCategoriesIds(Request $request)
    {

        if ($request->has('categories') && $request->get('categories') != null) {
            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcat_ids = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcat_ids, $subcat->subcategory_id);
            }

            // $subcat_ids array now contain all project subcategories' id's that belong to $category_id
            $projectsProjectSubcats = DB::table('projects_project_subcategories')
                ->get();

            $project_ids = [];

            foreach ($projectsProjectSubcats as $subcatRecord) {
                if (in_array($subcatRecord->subcategory_id, $subcat_ids))
                    array_push($project_ids, $subcatRecord->project_id);
            }

            // $project_ids now contains all project's id's that belong to $category_id
            $projects = Project::whereIn('project_id', $project_ids)->paginate(10);

            return response()->json(['status' => 'success', 'projects' => $projects], 200);
        }
        return response()->json(['status' => 'failure', 'error' => 'No categories are given'], 400);
    }

    public function showPublishedProjectsByCategoriesIds(Request $request)
    {

        if ($request->has('categories') && $request->get('categories') != null) {
            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcat_ids = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcat_ids, $subcat->subcategory_id);
            }

            // $subcat_ids array now contain all project subcategories' id's that belong to $category_id
            $projectsProjectSubcats = DB::table('projects_project_subcategories')
                ->get();

            $project_ids = [];

            foreach ($projectsProjectSubcats as $subcatRecord) {
                if (in_array($subcatRecord->subcategory_id, $subcat_ids))
                    array_push($project_ids, $subcatRecord->project_id);
            }

            // $project_ids now contains all project's id's that belong to $category_id
            $projects = Project::whereIn('project_id', $project_ids)->where('status', 'published')->paginate(10);

            return response()->json(['status' => 'success', 'projects' => $projects], 200);
        }
        return response()->json(['status' => 'failure', 'error' => 'No categories are given'], 400);
    }

    public function showPublishedProjectsByCategoriesIdsByAuthor(Request $request)
    {

        if ($request->has('categories') && $request->get('categories') != null && $request->get('email') && $request->get('email') != null) {
            $catIds = $request->get('categories');

            // check categories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);
            }

            // also check user for existence
            $user = User::where('email', $request->get('email'))->get();

            if (0 == count($user)) {
                return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);
            }

            // ----------------------------------

            foreach ($catIds as $catId) {
                $cat = ProjectCategory::find($catId);
            }

            $projectAllSubcatsByCats = ProjectSubCategory::whereIn('category_id', $catIds)->get();

            $subcat_ids = [];

            foreach ($projectAllSubcatsByCats as $subcat) {
                array_push($subcat_ids, $subcat->subcategory_id);
            }

            // $subcat_ids array now contain all project subcategories' id's that belong to $category_id
            $projectsProjectSubcats = DB::table('projects_project_subcategories')
                ->get();

            $project_ids = [];

            foreach ($projectsProjectSubcats as $subcatRecord) {
                if (in_array($subcatRecord->subcategory_id, $subcat_ids))
                    array_push($project_ids, $subcatRecord->project_id);
            }

            // $project_ids now contains all project's id's that belong to $category_id
            $projects = Project::whereIn('project_id', $project_ids)->where('author_email', $request->get('email'))->where('status', 'published')->paginate(10);

            if (0 == count($projects))
                return response()->json(['status' => 'failure', 'error' => 'This user doesn\'t have any projects in chosen categories'], 400);
            else
                return response()->json(['status' => 'success', 'projects' => $projects], 200);
        }
        return response()->json(['status' => 'failure', 'error' => 'The request is incomplete'], 400);
    }

    public function showProjectsBySubCategoriesIds(Request $request)
    {

        if ($request->has('subcategories') && $request->get('subcategories') != null) {

            $subcatIds = $request->get('subcategories');

            // check subcategories for existence first
            // fail early if at least 1 category is non-existent
            foreach ($subcatIds as $subcatId) {
                $subcat = ProjectSubCategory::find($subcatId);
                if (!isset($subcat))
                    return response()->json(['status' => 'failure', 'error' => 'Project subcategory doesn\'t exist'], 400);
            }

            $projectsProjectSubcats = DB::table('projects_project_subcategories')
                ->get();

            $projectIds = [];

            foreach ($projectsProjectSubcats as $subcatRecord) {
                if (in_array($subcatRecord->subcategory_id, $subcatIds))
                    array_push($projectIds, $subcatRecord->project_id);
            }

            $projects = Project::whereIn('project_id', $projectIds)->paginate(10);

            return response()->json(['status' => 'success', 'projects' => $projects], 200);
        }
        return response()->json(['status' => 'failure', 'error' => 'No subcategories are given'], 400);
    }

    public function getProjectCats($project_id)
    {
        // first check project for existence
        $project = Project::find($project_id);

        if (!isset($project)) {
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
        }

        $projectsProjectSubcats = DB::table('projects_project_subcategories')
            ->get();

        $subcatsIds = [];

        foreach ($projectsProjectSubcats as $subcatRecord) {
            if ($subcatRecord->project_id == $project_id)
                array_push($subcatsIds, $subcatRecord->subcategory_id);
        }

        // $subcats = [];
        $cats = [];

        foreach ($subcatsIds as $subcatId)
            array_push($cats, ProjectCategory::find(ProjectSubCategory::find($subcatId)->category_id));

        return response()->json(['status' => 'success', 'categories' => $cats], 200);
    }

    public function getProjectSubcats($project_id)
    {
        // first check project for existence
        $project = Project::find($project_id);

        if (!isset($project)) {
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
        }

        $projectsProjectSubcats = DB::table('projects_project_subcategories')
            ->get();

        $subcatsIds = [];

        foreach ($projectsProjectSubcats as $subcatRecord) {
            if ($subcatRecord->project_id == $project_id)
                array_push($subcatsIds, $subcatRecord->subcategory_id);
        }

        $subcats = [];

        foreach ($subcatsIds as $subcatId) {
            array_push($subcats, ProjectSubCategory::find($subcatId));
        }

        return response()->json(['status' => 'success', 'subcategories' => $subcats], 200);
    }

    public function getPublishedProjectsByAuthor(Request $request)
    {
        if ($request->has('email') && $request->get('email') != null) {

            // first check user for existence
            $user = User::where('email', $request->get('email'))->get();

            if (0 == count($user)) {
                return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);
            }

            $projects = Project::where('author_email', $request->get('email'))->where('status', 'published')->paginate(10);

            if (0 !== count($projects))
                return response()->json(['status' => 'success', 'data' => $projects], 200);
            else
                return response()->json(['status' => 'failure', 'error' => 'This user doesn\'t have any projects'], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'No email found in the request'], 400);
    }

    public function getSubcatsCat($subcats, $subcat_id)
    {
        foreach ($subcats as $subcat) {
            if ($subcat->subcategory_id == $subcat_id) {
                return $subcat->category_id;
                break;
            }
        }
    }

    public function getOrSetUserProjectNotifications(Request $request)
    {
        if ($request->has('user') && $request->get('user') != null) {

            // check user for existence
            $user = User::find($request->get('user'));

            if (!isset($user)) {
                return response()->json(['status' => 'failure', 'error' => 'User doesn\'t exist'], 400);
            }

            if (!($user->role == Role::Pro || $user->role == Role::Administrator))
                return response()->json(['status' => 'failure', 'error' => 'This user doesn\'t have access to projects'], 400);

            if ($request->has('save') && $request->get('save') != null && $request->get('save') == 1) {

                if ($request->has('email')) {

                    // TODO: add email validation here
                    // 1. check if email format is correct
                    // 2. validate email using external email validation service
                    // 3. only save if validated

                    $user->email_project_notifications = $request->get('email');
                    $user->save();
                }

                if ($request->has('notifications') && $request->get('notifications') != null) {

                    $notificationsToSet = $request->get('notifications');

                    // check submitted project subcategories for existence
                    $subcats = ProjectSubCategory::findOrFail($request->get('notifications'));

                    // delete user's previous records of user's notifications
                    ProjectNotification::where('user_id', $user->id)->delete();

                    foreach ($notificationsToSet as $notificationToSet) {
                        $newNotification = new ProjectNotification;
                        $newNotification->user_id = $user->id;
                        $newNotification->subcat_id = $notificationToSet;
                        $newNotification->notify = true;
                        $newNotification->save();
                    }

                    return response()->json(['status' => 'success', 'data' => 'User project notifications settings were successfully updated'], 200);
                }

                // here if notifications is empty (all unchecked), then save disable all notifications

                // delete user's previous records of user's notifications
                ProjectNotification::where('user_id', $user->id)->delete();

                return response()->json(['status' => 'success', 'data' => 'User project notifications settings were successfully updated (were all disabled)'], 200);
            }

            if ($request->has('category') && $request->get('category') != null) {

                // check project category for existence
                $cat = ProjectCategory::find($request->get('category'));
                if (!isset($cat))
                    return response()->json(['status' => 'failure', 'error' => 'Project category doesn\'t exist'], 400);

                // get subcats ids by cat id
                $subcats = ProjectSubCategory::where('category_id', $request->category)->pluck('subcategory_id')->toArray();
                $notifications = ProjectNotification::where('user_id', $user->id)->where('notify', 1)->pluck('subcat_id');

                $result = [];
                // if subcat_id is in array $subcats, then add it to result array
                foreach ($notifications as $notification) {
                    if (in_array($notification, $subcats)) {
                        array_push($result, $notification);
                    }
                }

                return response()->json(['status' => 'success', 'notifications by category' => $result], 200);
            }

            //  if request did not contain category, then return notifications for all categories for that user
            $notifications = ProjectNotification::where('user_id', $user->id)->where('notify', 1)->pluck('subcat_id')->toArray();

            $unique = [];
            $results = [];

            $subcats = DB::table('project_subcategories')->get()->toArray();

            foreach ($subcats as $subcat)
                if (in_array($subcat->subcategory_id, $notifications))
                    array_push($results, (object) array('category_id' => $subcat->category_id, 'notifications' => []));

            $unique = array_unique($results, SORT_REGULAR);
            $results = [];

            foreach ($unique as $record)
                array_push($results, $record);

            foreach ($results as $result)
                foreach ($notifications as $notification)
                    if ($result->category_id == $this->getSubcatsCat($subcats, $notification))
                        array_push($result->notifications, $notification);

            return response()->json(['status' => 'success', 'notifications for all categories' => $results], 200);
        }
        return response()->json(['status' => 'failure', 'error' => 'No correct project category id or user id found in the request, check if JSON is correct'], 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // empty request
        if (0 === count($request->all())) {
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed'], 400);
        }

        // check every field for correctness

        // if title is missing or empty
        if (!$request->has('title') || $request->get('title') === null || !isset($request->title))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a quotation request title'], 400);

        // if description is missing or empty
        if (!$request->has('description') || $request->get('description') === null || !isset($request->description))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a quotation request description'], 400);

        // if author_name is missing or empty
        if (!$request->has('author_name') || $request->get('author_name') === null || !isset($request->author_name))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a quotation request author name'], 400);

        // if author_email is missing or empty
        if (!$request->has('author_email') || $request->get('author_email') === null || !isset($request->author_email))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a quotation request author email'], 400);

        // validate email format
        $validated_email = !!filter_var($request->get('author_email'), FILTER_VALIDATE_EMAIL);

        if (!$validated_email)
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, author\'s email format is incorrect'], 400);

        // if author_phone is missing or empty
        if (!$request->has('author_phone') || $request->get('author_phone') === null || !isset($request->author_phone))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a quotation request author phone'], 400);

        // if project_address is missing or empty
        if (!$request->has('project_address') || $request->get('project_address') === null || !isset($request->project_address))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify an address'], 400);

        // if region is missing or empty
        if (!$request->has('region') || $request->get('region') === null || !isset($request->region))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a region'], 400);

        $regionsIds = $request->get('region');

        // check if region ids are correct
        foreach ($regionsIds as $regionId) {
            if (Region::find($regionId) == null)
                return response()->json(['status' => 'failure', 'error' => 'Project creation failed, incorrect region was specified'], 400);
        }

        // check if start_time is missing or empty
        if (!$request->has('start_time') || $request->get('start_time') === null || !isset($request->start_time))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a start time'], 400);

        // check if start_time is actually correct
        $correctStartTimes = ProjectStartTime::all()->pluck('key')->toArray();
        if (!in_array($request->get('start_time'), $correctStartTimes))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a correct start time key'], 400);

        // check if website_language is missing or empty
        if (!$request->has('website_language') || $request->get('website_language') === null || !isset($request->website_language))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a website language'], 400);

        // check if website_language is actually correct
        $website_lang = Language::where('code', $request->get('website_language'))->get()->toArray();
        if (empty($website_lang))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a correct website language'], 400);

        // check if author_prefers_to_be_contacted_in is missing or empty
        if (!$request->has('author_prefers_to_be_contacted_in') || $request->get('author_prefers_to_be_contacted_in') === null || !isset($request->author_prefers_to_be_contacted_in))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a language that the author prefers to be contacted in'], 400);

        // check if website_language is actually correct
        $project_lang = Language::where('code', $request->get('author_prefers_to_be_contacted_in'))->get()->toArray();
        if (empty($project_lang))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a correct project language'], 400);

        // check if project' subcategory_id is missing or empty
        if (!$request->has('subcategory_id') || $request->get('subcategory_id') === null || !isset($request->subcategory_id))
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify project\'s subcategory id'], 400);

        // check if project' subcategory_id is actually correct
        $subcat = ProjectSubCategory::find($request->get('subcategory_id'));
        if ($subcat == null)
            return response()->json(['status' => 'failure', 'error' => 'Project creation failed, please specify a correct existing project\'s subcategory id'], 400);

        // validation passed, now let's create a quotation request

        // check if user is anonymous or authenticated
        if (!Auth::user() == null) {
            // user is authenticated
            $userId = Auth::user()->id;
        } else {
            // user is anonymous
            // then we need to create a new user account
            // first check if we have registered user with such an email
            $userId = User::where('email', $request->get('author_email'))->value('id');
        }

        if ($userId == null) {

            // we don't have such a user
            // then create an account for him
            $newUser = new User;
            $newUser->display_name = $request->get('author_name');
            $newUser->email = $request->get('author_email');
            $pass = $this->generateStrongPassword();
            $newUser->password = Hash::make($pass);
            $newUser->role = Role::Regular;
            $newUser->save();

            // then send him his new credentials by mail
            // then force him to change password at 1st login
        }

        if (isset($newUser))
            $userId = $newUser->id;

        $project = new Project;

        $project->title = $request->get('title');
        $project->website_language = $request->get('website_language');
        $project->publish_date = date('Y-m-d');
        $project->status = json_encode(ProjectStatus::draft);
        $project->description = $request->get('description');
        //$project->attached_files = json_encode($request->get('attached_files'));
        $project->author_name = $request->get('author_name');
        $project->author_email = $request->get('author_email');
        $project->author_phone = $request->get('author_phone');
        $project->author_prefers_to_be_contacted_in = $request->get('author_prefers_to_be_contacted_in');
        $project->project_address = $request->get('project_address');
        $project->region = json_encode($request->get('region'));
        $project->start_time = $request->get('start_time');
        $project->number_of_offers = 0;
        $project->author_id = $userId;

        $project->save();
        DB::table('projects_project_subcategories')->insert(
            array(
                'subcategory_id' => $request->get('subcategory_id'),
                'project_id' => $project->project_id
            )
        );

        return response()->json(['status' => 'success', 'project' => $project], 200);
    }

    public function archiveProject($project_id)
    {
        // first check project for existence
        $project = Project::findOrFail($project_id);

        if (!isset($project)) {
            return response()->json(['status' => 'failure', 'error' => 'Project doesn\'t exist'], 400);
        }

        if ($project->author_id == null)
            return response()->json(['status' => 'failure', 'error' => 'Failed to archive the project'], 403);

        $archived = '"archived"';

        // check if currently logged in user is this project's author
        if ($project->author_id == Auth::user()->id) {

            if (strcmp($project->status, $archived) == 0)
                return response()->json(['status' => 'failure', 'error' => 'The project is already archived'], 400);

            $project->status = $archived;
            $project->save();
            return response()->json(['status' => 'success', 'project' => 'Project archived successfully'], 200);
        } else {
            return response()->json(['status' => 'failure', 'error' => 'Failed to archive the project'], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

    /* Generates a strong password of N length containing at least one lower case letter,
       one uppercase letter, one digit, and one special character. The remaining characters
       in the password are chosen at random from those four sets.

       The available characters in each set are user friendly - there are no ambiguous
       characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
       makes it much easier for users to manually type or speak their passwords.

       Note: the $add_dashes option will increase the length of the password by
       floor(sqrt(N)) characters.

       https://gist.github.com/tylerhall/521810
    */
    public function generateStrongPassword($length = 12, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
}
