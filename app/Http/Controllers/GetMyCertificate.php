<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class GetMyCertificate extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:registrant,email'
        ]);

        $registrant = Registrant::where('email', $validated['email'])->first();

        if (! $registrant) {
            return response()->json([
                'message' => 'Registrant not found, check if you have entered the email correctly',
            ], 404);
        }

        if(! $registrant->checks->isAttending)
        {
            return response()->json([
                'message' => 'It says that you were not attending the event, if there is a mistake report immediately via form given below',
            ]);
        }

        return response()->json([
            'message' => 'Registrant found, certificate has been generated',
//            'certificate' => $registrant->certificate(),
        ]);
    }
}
