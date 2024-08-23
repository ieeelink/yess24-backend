<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Check;
use Illuminate\Http\Request;

class AddValidationForCheckId extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
           "check_id" => "required",
           "is_member" => "required",
        ]);

        $check = Check::find($validated["check_id"]);

        if($check->isAttending)
        {
            return response()->json([
                "message" => "Already attending"
            ], 406);
        }

        $registrant = $check->registrant;
        $registrant->is_ieee_member = $validated["is_member"];
        $registrant->save();


        $check->isValidated = 1;
        $check->isAttending = 1;
        $check->save();

        return response()->json([
            "message" => "User Validated Successfully"
        ],201);
    }
}
