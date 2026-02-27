<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::with('unit')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'title' => 'required',
            'event_date' => 'required|date'
        ]);

        $event = Event::create($request->all());

        return response()->json([
            'message' => 'Event created',
            'event' => $event
        ], 201);
    }
}
