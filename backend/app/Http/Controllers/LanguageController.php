<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $langs = Language::all();
        return response()->json(['status' => 'success', 'language' => $langs], 200);
    }

    public function getLanguageById($id)
    {
        if (!is_numeric($id))
            return response()->json(['status' => 'failure', 'error' => 'Wrong language id'], 400);

        $langs = Language::find($id);

        if ($langs == null) {
            return response()->json(['status' => 'failure', 'error' => 'Language not found'], 404);
        }
        return response()->json(['status' => 'success', 'language' => $langs], 200);
    }

    public function getLanguageByKey($key)
    {
        if (!is_numeric($key))
            return response()->json(['status' => 'failure', 'error' => 'Wrong language key'], 400);

        $langs = Language::where('key', $key)->get();
        if (0 === count($langs)) {
            return response()->json(['status' => 'failure', 'error' => 'Language not found'], 404);
        }
        return response()->json(['status' => 'success', 'language' => $langs], 200);
    }

    public function getLanguageByCode($code)
    {
        if (is_numeric($code))
            return response()->json(['status' => 'failure', 'error' => 'Wrong language code'], 400);

        $langs = Language::where('code', $code)->get();
        if (0 === count($langs)) {
            return response()->json(['status' => 'failure', 'error' => 'Language not found'], 404);
        }
        return response()->json(['status' => 'success', 'language' => $langs], 200);
    }

    public function getLanguageByName($name)
    {
        if (is_numeric($name))
            return response()->json(['status' => 'failure', 'error' => 'Wrong language name'], 400);

        $langs = Language::where('code', $name)->get();
        if (0 === count($langs)) {
            return response()->json(['status' => 'failure', 'error' => 'Language not found'], 404);
        }
        return response()->json(['status' => 'success', 'language' => $langs], 200);
    }
}
