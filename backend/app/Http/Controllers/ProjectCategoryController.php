<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectCategoryResource;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    /**
     * This method will return a JSON of all categories
     *
     * @return ProjectCategoryResource
     */
    public function showAll()
    {
        $categories = ProjectCategory::all();
        return new ProjectCategoryResource($categories);
    }

    /**
     * This method will create or update a Category (back office)
     *
     * @param Request $request
     * @return ProjectCategoryResource
     */
    public function store(Request $request)
    {
        $category = $request->isMethod('put') ? ProjectCategory::findOrFail($request->category_id) : new ProjectCategory;

        $category->category_name = $request->input('category_name');
        $category->category_icon = $request->input('category_icon');
        $category->category_slug = Str::slug($request->input('category_name'));
        if($category->save()) {
            return new ProjectCategoryResource($category);
        }
    }

    /**
     * Show One category by Id
     *
     * @param int $category_id
     * @return ProjectCategoryResource
     */
    public function showOne($category_id)
    {
        // Get category
        $category = ProjectCategory::findOrFail($category_id);
        // Return single category as a resource
        return new ProjectCategoryResource($category);
    }

    /**
     * Show One category by slug
     *
     * @param int $category_id
     * @return ProjectCategoryResource
     */
    public function showOneBySlug($slug)
    {
        // Get category
        $category = ProjectCategory::where('category_slug', $slug)->first();
        // Return single category as a resource
        return new ProjectCategoryResource($category);
    }

    /**
     * Remove category by Id from storage.
     *
     * @param int $id
     * @return ProjectCategoryResource
     */
    public function destroy($id)
    {
        $projectCategory = ProjectCategory::findOrFail($id);
        if($projectCategory->delete())
            return new ProjectCategoryResource($projectCategory);
    }
}
