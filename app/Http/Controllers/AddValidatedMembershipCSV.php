<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddValidatedMembershipCSV extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('membership.add');
    }
}
