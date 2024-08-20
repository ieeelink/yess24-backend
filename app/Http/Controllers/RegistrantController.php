<?php

namespace App\Http\Controllers;

use App\Models\Registrant;

class RegistrantController extends Controller
{
    public function index()
    {
        $registrants = Registrant::query()->paginate(200);
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
