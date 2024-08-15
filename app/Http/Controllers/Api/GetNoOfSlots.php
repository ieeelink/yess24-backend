<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
