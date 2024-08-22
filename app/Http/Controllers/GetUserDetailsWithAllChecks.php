<?php

namespace App\Http\Controllers;

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

        return response()->json([
            "name" => $registrant->name,
            "email" => $registrant->email,
            "college_name" => $registrant->college_name,
            "ticket_id" => $ticket->ticket_id,
            "checks" => $registrant->checks,
        ]);

    }
}
