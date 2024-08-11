<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrant;
use App\Utils\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\False_;

class TicketController extends Controller
{
    public function get_response_data($data, $id)
    {
        return [
            "id" => $data['id'],
            "name" => $data['name'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "is_ieee_member" => $data['is_ieee_member'],
            "membership_id" => $id,
        ];
    }

    public function validate_user(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|integer|numeric',
        ]);

        $email = $validated['email'];
        $phone = $validated['phone'];

        $data = Registrant::with('ticket', 'membership_id')
            ->where('email', $email)
            ->orWhere('phone', $phone)
            ->first();

        if(! $data) {
            return response([
                "message" => "User not found, please enter your valid credentials."
            ],404);
        }

        if($data->is_ieee_member && ! $data->membership_id){
            return response([
                "message" => "Membership ID not found",
                "data" => $this->get_response_data($data->toArray(), null),
                "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken,
            ], 404);
        }

        $membership_id = $data->is_ieee_member && $data->membership_id ? $data->membership_id->membership_id : null;

        return [
            "message" => "Successfully found registrant and his ticket",
            "data" => $this->get_response_data($data->toArray(), $membership_id),
            "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken
        ];
    }

    public function store_membership_id(Request $request)
    {
        $registrant =  $request->user();

        $validated = $request->validate([
            'membership_id' => 'required|integer|unique:membership_ids,membership_id'
        ]);

        if(! $registrant->is_ieee_member){
            return response([
                "message" => "Not a IEEE Member",
                "data" => $this->get_response_data($registrant->toArray(), null)
            ], 401);
        }

        if($registrant->is_ieee_member && $registrant->membership_id){
            return response([
                "message" => "Membership ID already exists",
                "data" => $this->get_response_data($registrant->toArray(), $registrant->membership_id->membership_id),
            ], 401);
        }

        $registrant->membership_id()->create([
            'membership_id' => $validated['membership_id']
        ]);

        return response()->json([
            "message" => "Successfully added membership id to " . $registrant->name,
            "data" => $this->get_response_data($registrant->toArray(), $validated['membership_id']),
        ], 201);

    }

    public function get_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return response([
                "message" => "Image not found"
            ], 404);
        }

        $user =  $request->user();
        $ticket_id = $request->user()->ticket->ticket_id;

//        return response([
//            "message" => "Ticket Generated Successfully",
//            "data" => [
//                "ticket_id" => $ticket_id,
//                "user" => $user,
//            ],
//            "image" => Ticket::generateTicket($ticket_id, $request->file('image'))
//        ], 201);

        return view('welcome', [
            'ticket_id' => $ticket_id,
            'image' => Ticket::generateTicket($ticket_id, $request->file('image')),
        ]);

    }
}
