<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class GetUserDetailsWithAllChecks extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "ticket_id" => "required|exists:tickets,ticket_id",
        ]);

        $ticket = Ticket::where("ticket_id", $validated["ticket_id"])->first();

        $registrant = $ticket->registrant;

        if($registrant->checks->isAttending)
        {
            return response()->json([
                "message" => "Already attending"
            ], 406);
        }

        $check = $registrant->checks;
        $check->isAttending = true;
        $check->save();

        return response()->json([
            "name" => $registrant->name,
            "email" => $registrant->email,
            "college_name" => $registrant->college_name,
            "ticket_id" => $ticket->ticket_id,
            "checks" => $registrant->checks,
        ]);

    }
}
