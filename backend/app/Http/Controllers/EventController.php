<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display lists of all events.
     *
     * @return EventResource
     */
    public function index()
    {
        $events = Event::paginate(20);
        return response()->json(['status' => 'success', 'data' => $events], 200);
    }

    /**
     * Display lists of events by user id.
     *
     * @param  int  $id
     * @return EventResource
     */
    public function eventsByUserId($id)
    {
        $events = Event::where('user_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $events], 200);
    }

    /**
     * Display lists of events by company id.
     *
     * @param  int  $id
     * @return EventResource
     */
    public function eventsByCompanyId($id)
    {
        $events = Event::where('company_id', $id)->paginate(20);
        return response()->json(['status' => 'success', 'data' => $events], 200);
    }

    /**
     * Display the specified event by id.
     *
     * @param  int  $id
     * @return EventResource
     */
    public function eventById($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['status' => 'success', 'event' => $event], 200);
    }

    /**
     * Display the specified event by slug.
     *
     * @param  string  $slug
     * @return EventResource
     */
    public function eventBySlug($slug)
    {
        $event = Event::where('slug', $slug)->first();
        if($event !== null)
            return response()->json(['status' => 'success', 'event' => $event], 200);
        return response()->json(['status' => 'failure', 'error' => 'No event'], 400);

    }

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return EventResource
     */
    public function store(Request $request)
    {
        $event = Event::where('title', $request->get('title'))->first();

        if($event === null) {
            $event = new Event;
            $event->fill($request->all());
            $event->slug = str_slug($request->get('title'), '-');
            if($event->save()) {
                return response()->json(['status' => 'success', 'event' => $event], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Event already exists'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Event create failed'], 400);
    }

    /**
     * Update the specified event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return EventResource
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if($event !== null) {
            $event->fill($request->all());
            $event->slug = str_slug($request->get('title'), '-');
            if($event->save()) {
                return response()->json(['status' => 'success', 'event' => $event], 200);
            }
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'No event'], 400);
        }
        return response()->json(['status' => 'failure', 'error' => 'Event update failed'], 400);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  int  $id
     * @return EventResource
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if($event->delete()) {
            return response()->json(['status' => 'success', 'listing_id' => $id], 200);
        }
        else {
            return response()->json(['status' => 'failure', 'error' => 'Event delete failed'], 400);
        }
    }
}
