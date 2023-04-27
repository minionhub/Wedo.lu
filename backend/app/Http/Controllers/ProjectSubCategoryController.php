<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use App\Models\ProjectSubCategory;
use App\Http\Resources\ProjectSubCategoryResource;

class ProjectSubCategoryController extends Controller
{
    /**
     * This method will return a JSON of all subcategories
     *
     * @return ProjectSubCategoryResource
     */
    public function showAll()
    {
        $subcategories = ProjectSubCategory::all();
        return new ProjectSubCategoryResource($subcategories);
    }

    /**
     * This method will create or update a SubCategory (back office)
     *
     * @param Request $request
     * @return ProjectSubCategoryResource
     */
    public function store(Request $request)
    {
        $subcategory = $request->isMethod('put') ? ProjectSubCategory::findOrFail($request->subcategory_id) : new ProjectSubCategory;

        $subcategory->subcategory_name = $request->input('subcategory_name');
        $subcategory->category_id = $request->input('category_id');
        $subcategory->subcategory_slug = Str::slug($request->input('subcategory_name'));
        if ($subcategory->save()) {
            return new ProjectSubCategoryResource($subcategory);
        }
    }

    /**
     * Show One subcategory by Id
     *
     * @param $subcategory_id
     * @return ProjectSubCategoryResource
     */
    public function showOne($subcategory_id)
    {
        // Get subcategory
        $subcategory = ProjectSubCategory::findOrFail($subcategory_id);
        // Return single subcategory as a resource
        return new ProjectSubCategoryResource($subcategory);
    }

    public function showOneBySlug($slug)
    {
        $projectSubCategory = ProjectSubCategory::where('subcategory_slug', $slug)->get();
        if (0 === count($projectSubCategory))
            return response()->json(['status' => 'failure', 'error' => 'No such project subcategory exists'], 400);
        else
            return response()->json(['status' => 'success', 'subcategory' => new ProjectSubCategoryResource($projectSubCategory)], 200);

    }

    /**
     * Show One subcategory by Id
     *
     * @param $subcategory_id
     * @return ProjectSubCategoryResource
     */
    public function showOneBySlugs($cat_slug, $subcat_slug)
    {
        $cat = ProjectCategory::where('category_slug', $cat_slug)->first();
        $subcat = ProjectSubCategory::where('subcategory_slug', $subcat_slug)->first();

        if ($cat !== null and $subcat !== null) {
            if (($cat->category_id) === ($subcat->category_id))
                return response()->json(['status' => 'success', 'subcategory' => new ProjectSubCategoryResource($subcat)], 200);
        }

        return response()->json(['status' => 'failure', 'error' => 'No such combination of category and subcategory exists'], 400);
    }

    /**
     * This method will return a JSON of all subcategories that belong to a chosen category
     *
     * @return ProjectSubCategoryResource
     */
    public function showSubcatsByCat($category_id)
    {
        $subcategories = ProjectSubCategory::all()->where('category_id', $category_id);
        return new ProjectSubCategoryResource($subcategories);
    }

    /**
     * This method will return a JSON of all subcategories that belong to a chosen category
     *
     * @return ProjectSubCategoryResource
     */
    public function showSubcatsByCatExceptOneSubcat($except_subcategory_id)
    {
        // check cat and subcat for existence before proceeding and fail if it doesn't exist
        $subcat = ProjectSubCategory::find($except_subcategory_id);
        $cat = ProjectCategory::find($subcat->category_id);

        if ($cat === null and $subcat === null)
            return response()->json(['status' => 'failure', 'error' => 'Both project category and project subcategory don\'t exist'], 400);

        else if ($cat === null)
            return response()->json(['status' => 'failure', 'error' => 'No such project category exists'], 400);

        else if ($subcat === null)
            return response()->json(['status' => 'failure', 'error' => 'No such project subcategory exists'], 400);

        $subcategories = ProjectSubCategory::all()->where('category_id', $subcat->category_id);

        $all_subcats_except_one_subcat = [];

        foreach ($subcategories as $subcat) {
            if ($subcat['subcategory_id'] != $except_subcategory_id) {
                array_push($all_subcats_except_one_subcat, $subcat);
            }
        }

        return response()->json(['status' => 'success', 'subcategories' => new ProjectSubCategoryResource( $all_subcats_except_one_subcat)], 200);
    }

    /**
     * Remove subcategory by Id from storage. (back office)
     *
     * @param $subcategory_id
     * @return ProjectSubCategoryResource
     */
    public function destroy($subcategory_id)
    {
        $projectSubCategory = ProjectSubCategory::findOrFail($subcategory_id);
        if ($projectSubCategory->delete())
            return new ProjectSubCategoryResource($projectSubCategory);
    }


}
