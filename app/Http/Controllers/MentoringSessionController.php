<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Ticket;
use Illuminate\Http\Request;

class MentoringSessionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event)
    {
        $validated = $request->validate([
            'registrant_count' => 'required|integer|min:2',
            'registrant_array' => 'required|array'
        ]);

        if($event->slot < $validated['registrant_count']) {
            return response()->json([
                'message' => 'The allotted slot have been reached'
            ], 405);
        }

        // Create a Group
        $group = $event->groups()->create();


        foreach ($validated['registrant_array'] as $ticket_id)
        {
            $ticket = Ticket::query()->where('ticket_id', $ticket_id)->first();

            $registrant = $ticket->registrant;

            // Add Event to Event Registrant Table
            $registrant->events()->attach($event);

            // Making Participant
            $participant = Participant::create([
                'registrant_id' => $registrant->id,
                'group_id' => $group->id,
            ]);
        }

        return response()->json([
            'message' => 'The registrants added to mentoring session'
        ],201);
    }
}
