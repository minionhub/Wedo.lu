<?php

namespace App\Http\Controllers;

use App\Models\Timezone;
use Illuminate\Http\Request;

class TimezoneController extends Controller
{
    public function timezones() {
        $timezones = Timezone::all();
        return response()->json(['status' => 'success', 'data' => $timezones], 200);
    }
}
