<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class GetAppStatus extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $isValidated = Registrant::whereRelation("checks", "isValidated", "1")->get()->count();
        $isAttending = Registrant::whereRelation("checks", "isAttending", "1")->get()->count();
        $isFoodProvided = Registrant::whereRelation("checks", "isFoodProvided", "1")->get()->count();
        $swagsProvided = Registrant::whereRelation("checks", "swagsProvided", "1")->get()->count();

        return response()->json([
            "isValidated" => $isValidated,
            "isAttending" => $isAttending,
            "isFoodProvided" => $isFoodProvided,
            "swagsProvided" => $swagsProvided
        ], 201);
    }
}
