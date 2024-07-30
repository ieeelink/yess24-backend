<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrantController extends Controller
{
    public function index()
    {
        return view('registrant.index');
    }
}
