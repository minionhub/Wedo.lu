<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pageByName($name) {
        $page = Page::where('name', $name)->first();
        return response()->json(['status' => 'success', 'page' => $page->content], 200);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->name = $request->get('name');
        $page->content = $request->get('content');
        if($page->save()) {
            return response()->json(['status' => 'success', 'message' => 'Page saved'], 200);
        }
    }
}
