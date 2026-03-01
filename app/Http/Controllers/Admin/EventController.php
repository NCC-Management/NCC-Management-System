<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('unit')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
         $units = \App\Models\Unit::all();
        return view('admin.events.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required',
            'title' => 'required',
            'event_date' => 'required|date',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')
            ->with('success','Event Created Successfully');
    }

    public function edit(Event $event)
    {
        $units = Unit::all();
        return view('admin.events.edit', compact('event','units'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'unit_id' => 'required',
            'title' => 'required',
            'event_date' => 'required|date',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success','Event Updated Successfully');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success','Event Deleted Successfully');
    }
}