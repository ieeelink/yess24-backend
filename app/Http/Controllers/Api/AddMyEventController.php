<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AddMyEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event)
    {
        $registrant = $request->user();

        $registrant->events()->attach($event);

        return response()->json([
            "message" => sprintf("%s has successfully registered for %s", $registrant->name, $event->name)
        ], 201);
    }
}
