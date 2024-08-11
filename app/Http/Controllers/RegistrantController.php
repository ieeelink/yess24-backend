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

    public function show(Registrant $registrant){
        return view('registrant.show', [
            'registrant' => $registrant,
            'ticket_id' => $registrant->ticket->ticket_id,
            'membership_id' => $registrant->membership_id ? $registrant->membership_id->membership_id : null,
            'events' => $registrant->events
        ]);
    }
}
