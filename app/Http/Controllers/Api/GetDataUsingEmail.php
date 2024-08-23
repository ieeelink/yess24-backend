<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use Illuminate\Http\Request;

class GetDataUsingEmail extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:registrants,email'
        ]);

        $registrant = Registrant::where('email', $validated['email'])->first();

        if($registrant->checks->isAttending)
        {
            return response()->json([
                "message" => "Already attending"
            ], 406);
        }

        return response()->json([
            "name" => $registrant->name,
            "email" => $registrant->email,
            "phone" => $registrant->phone,
            "checks" => $registrant->checks
        ]);
    }
}
