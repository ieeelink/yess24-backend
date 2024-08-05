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

    public function store(Request $request){
        return $request;
    }
}
