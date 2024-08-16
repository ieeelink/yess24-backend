<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,ticket_id',
            'phone' => 'required|digits:10',
        ]);

        $ticket = Ticket::with('registrant')->where('ticket_id', $validated['ticket_id'])->first();


        if($ticket->registrant->phone != $validated['phone'])
        {
            return response(['message' => 'Phone number does not match'], 422);
        };

        $token = $ticket->registrant->createToken('loggedIn', ['*'], now()->addHour() )->plainTextToken;

        return response([
            'token' => $token,
            'data' => $ticket->registrant,
            'ticket_id' => $ticket->ticket_id
        ], 201);
    }
}
