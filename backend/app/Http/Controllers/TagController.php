<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display lists of all tags.
     *
     * @return TagResource
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json(['status' => 'success', 'data' => $tags], 200);
    }

    /**
     * Display the specified tag by id.
     *
     * @param  int  $id
     * @return TagResource
     */
    public function tagById($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json(['status' => 'success', 'tag' => $tag], 200);
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TagResource
     */
    public function store(Request $request)
    {
        $tag = Tag::where('name', $request->get('name'))->first();

        if($tag === null) {
            $tag = new Tag;
            $tag->fill($request->all());
            if($tag->save()) {
                return response()->json(['status' => 'success', 'tag' => $tag], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Tag already exists'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Tag create failed'], 400);
    }

    /**
     * Update the specified tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return TagResource
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        if($tag !== null) {
            $tag->fill($request->all());
            if($tag->save()) {
                return response()->json(['status' => 'success', 'tag' => $tag], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'No tag'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Tag update failed'], 400);
    }

    /**
     * Remove the specified tag from storage.
     *
     * @param  int  $id
     * @return TagResource
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        if($tag->delete()) {
            DB::table('post_tag')->delete(['tag_id' => $id]);
            return response()->json(['status' => 'success', 'tag_id' => $id], 200);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Tag delete failed'], 400);
        }
    }
}
