<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class RegistrantController extends Controller
{
    public function index()
    {
        $registrants = Registrant::query(10)->get();
        return view('registrant.index', [
            'registrants' => $registrants
        ]);
    }
}
