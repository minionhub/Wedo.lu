<?php

namespace App\Http\Controllers;

use App\Models\ProjectStartTime;
use Illuminate\Http\Request;

class ProjectStartTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStartTimes()
    {
        $times = ProjectStartTime::all()->toArray();
        return response()->json(['status' => 'success', 'data' => $times], 200);
    }

    public function getStartTimeByKey($key)
    {
        $time = ProjectStartTime::where('key', $key)->get()->toArray();
        if (empty($time))
            return response()->json(['status' => 'failure', 'data' => 'Project start time not found'], 404);

        return response()->json(['status' => 'success', 'data' => $time], 200);
    }

    public function getStartTimeKeyByText(Request $request)
    {
        if (!$request->has('text') || $request->get('text') == null || empty($request->get('text')))
            return response()->json(['status' => 'failure', 'data' => 'Incorrect project start time text'], 400);

        $key = ProjectStartTime::where('text', $request->get('text'))->value('key');

        if (empty($key) && $key !== 0)
            return response()->json(['status' => 'failure', 'data' => 'Project start time not found'], 404);

        return response()->json(['status' => 'success', 'key' => $key], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectStartTime  $projectStartTime
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectStartTime $projectStartTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectStartTime  $projectStartTime
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectStartTime $projectStartTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectStartTime  $projectStartTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectStartTime $projectStartTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectStartTime  $projectStartTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectStartTime $projectStartTime)
    {
        //
    }
}
