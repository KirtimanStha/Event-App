<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date')->get();
        return response()->json(EventResource::collection($events));
    }

    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Event::createSlug($request->title, 'id', 0);
        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event Created Successfully!',
            'event' => new EventResource($event)
        ]);
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->first();

        if($event == null){
            return response()->json([
                'message' => 'Event Not Found!'
            ], 404);
        }
        return response()->json(new EventResource($event));
    }

    public function update(EventRequest $request, string $slug)
    {
        $event = Event::where('slug', $slug)->first();

        if($event == null){
            return response()->json([
                'message' => 'Event Not Found!'
            ], 404);
        }
        $validated = $request->validated();
        if($request->title !== $event->title){
            $validated['slug'] = Event::createSlug($request->title, 'id', 0);
        }
        $event->update($validated);

        return response()->json([
            'message' => 'Event Updated Successfully!',
            'event' => new EventResource($event)
        ]);
    }

    public function destroy(string $slug)
    {
        $event = Event::where('slug', $slug)->first();

        if($event == null){
            return response()->json([
                'message' => 'Event Not Found!'
            ], 404);
        }
        
        $event->delete();
        
        return response()->json([
            'status' => 'success',
            'message'=>'Event Deleted Successfully!!'
        ]);
    }
}
