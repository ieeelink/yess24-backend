<?php

namespace App\Http\Controllers;

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

        $registrant = $check->registrant;
        $registrant->is_ieee_member = $validated["is_member"];
        $registrant->save();


        $check->isValidated = true;
        $check->isAttending = true;
        $check->save();

        return response()->json([
            "message" => "User Validated Successfully"
        ],201);
    }
}
