<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class GetAllEvents extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            "message" => "Got all events",
            "events" => Event::query()->where("type", "Mentoring Session")->get()
        ],201);
    }
}
