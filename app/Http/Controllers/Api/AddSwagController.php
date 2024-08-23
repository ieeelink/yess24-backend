<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AddSwagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "ticket_id" => "required"
        ]);

        $ticket =  Ticket::where("ticket_id", $validated["ticket_id"])->first();

        $registrant = $ticket->registrant;
        $checks = $registrant->checks;

        if($checks->swagsProvided)
        {
            return response()->json([
                "message" => "Already attending"
            ], 406);
        }

        $checks->swagsProvided = 1;
        $checks->isAttending = 1;
        $checks->save();

        return response()->json([
            "name" => $registrant->name,
            "email" => $registrant->email,
            "phone" => $registrant->phone,
            "ticket_id" => $ticket->ticket_id,
            "checks" => $registrant->checks
        ],201);
    }
}
