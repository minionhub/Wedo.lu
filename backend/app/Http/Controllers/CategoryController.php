<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * This method will return a JSON of all company categories in the form of list
     *
     * @return CategoryResource
     */
    public function showAllList()
    {
        $rootCategories = Category::where('parent', 0)->get()->toArray();
        $categories = [];
        foreach ($rootCategories as $index => $rootCategory) {
            $categories = array_merge($categories, $this->getCategoriesList($rootCategory['id'], 0));
        }
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }

    // Show only root categories
    public function showRoots()
    {
        $categories = Category::where('parent', 0)->get()->toArray();
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }

    /**
     * This method will return a JSON of all company categories in the form of tree
     *
     * @return CategoryResource
     */
    public function showAllTreeWithCount()
    {
        $categories = Category::where('parent', 0)->get()->toArray();

        foreach ($categories as $index => $category) {
            $categories[$index] = $this->getCategoriesTree($category['id'], true);
        }
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }

    /**
     * This method will create or update a Category (back office)
     *
     * @param Request $request
     * @return CategoryResource
     */
    public function store(Request $request)
    {
        $category = $request->isMethod('put') ? Category::findOrFail($request->id) : new Category;

        $category->name = $request->input('name');
        $category->icon = $request->input('icon');
        if($category->save()) {
            return new CategoryResource($category);
        }
    }

    /**
     * Show One category by Id
     *
     * @param int $id
     * @return CategoryResource
     */
    public function showOne($id)
    {
        // Get category
        $category = Category::findOrFail($id);
        // Return single category as a resource
        return new CategoryResource($category);
    }


    /**
     * Remove category by Id from storage.
     *
     * @param $id
     * @return CategoryResource
     */
    public function destroy($id)
    {
        $Category = Category::findOrFail($id);
        if($Category->delete()) {
            $children = $this->getChildren($id);
            foreach ($children as $child) {
                $child->parent = 0;
                $child->save();
            }
            return new CategoryResource($Category);
        }
    }

    // Get category and its all children by category id in the form of list
    public function getCategoriesList($id, $depth) {
        $categories = [];
        $category = Category::find($id)->toArray();
        $category['depth'] = $depth;
        $categories[] = $category;
        $children = $this->getChildren($id);
        if(count($children) > 0) {
            $depth++;
            foreach ($children as $child) {
                $categories = array_merge($categories, $this->getCategoriesList($child->id, $depth));
            }
        }
        return $categories;
    }

    // Get category and its all children by category id in the form of tree
    public function getCategoriesTree($id, $withCount) {
        $category = Category::find($id)->toArray();
        if($withCount)
            $category['count'] = DB::table('categorizables')->where('category_id', $id)
                ->where('categorizable_type', 'App\Models\Company')->count();
        $category['children'] = [];
        $children = $this->getChildren($id);
        if(count($children) > 0) {
            foreach ($children as $child) {
                $category['children'][] = $this->getCategoriesTree($child->id, $withCount);
            }
        }
        return $category;
    }

    // Get children
    public function getChildren($id) {
        return Category::where('parent', $id)->get();
    }
}
