<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AddMyEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event)
    {
        $registrant = $request->user();

        $registrant_events =  $registrant->events;

        // Checks for if the registrant as registered the event already
        foreach ($registrant_events as $registrant_event) {
            if($registrant_event->id === $event->id) {
                return response()->json([
                    "message" => sprintf("You have already registered for %s", $event->name)
                ], 405);
            }
        }

        // Checks if the slot is filled

        $registrant->events()->attach($event);

        return response()->json([
            "message" => sprintf("%s has successfully registered for %s", $registrant->name, $event->name)
        ], 201);
    }
}
