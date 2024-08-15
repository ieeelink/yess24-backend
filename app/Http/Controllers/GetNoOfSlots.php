<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class GetNoOfSlots extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event)
    {
        $message = $event->slot > 0 ? 'Slots Available' : 'No Slots Available';
        return response()->json([
            "message" => $message,
            "slots" => $event->slot
        ]);
    }
}
