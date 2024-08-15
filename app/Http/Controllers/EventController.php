<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        return view('event.index', [
            'events' => Event::all()
        ]);
    }

    public function add(){
        return view('event.add');
    }

    public function show(Event $event)
    {
        return view('event.show', ['registrants' => $event->registrants()->with('group_member')->get()]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
            'slot' => 'required|int',
        ]);
        Event::create($validated);
        return redirect('/events');
    }
}
