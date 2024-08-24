<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddValidatedEmailCSV extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('email.add');
    }
}
