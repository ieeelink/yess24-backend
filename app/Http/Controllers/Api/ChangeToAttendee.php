<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use Illuminate\Http\Request;

class ChangeToAttendee extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "emails" => ["required", "array"],
        ]);

        $emails = $validated["emails"];

        $attendees_added = [];
        $attendees_not_found = [];

        foreach ($emails as $email)
        {
            $registrant = Registrant::where("email", $email)->first();

            if($registrant == null){
                $attendees_not_found[] = $email;
                continue;
            }

            $checks = $registrant->checks;
            $checks->isAttending = true;
            $checks->save();

            $attendees_added[] = $email;
        }

        return response()->json([
            "count_of_added_attendees" => count($attendees_added),
            "count_of_not_attendees" => count($attendees_not_found),
            "attendees_not_found" => $attendees_not_found,
            "attendees_added" => $attendees_added,
        ], 201);
    }
}
