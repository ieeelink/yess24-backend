<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

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


        DB::beginTransaction();
        // Create a Group
        try {
            $group = $event->groups()->create();


            foreach ($validated['registrant_array'] as $ticket_id)
            {
                $ticket = Ticket::query()->where('ticket_id', $ticket_id)->first();

                $registrant = $ticket->registrant;

                // Add Event to Event Registrant Table
                $registrant->event($event);

                // Making Participant
                $participant = Participant::create([
                    'registrant_id' => $registrant->id,
                    'group_id' => $group->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getLine() == 43 ? "Registrant Not Found" : $exception->getMessage()
            ], 405);
        }


        return response()->json([
            'message' => 'The registrants added to mentoring session'
        ],201);
    }
}
