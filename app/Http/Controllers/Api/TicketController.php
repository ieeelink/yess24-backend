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

        if($data->ticket_type == "Contributor Ticket")
        {
            $membership_id = 12345789;
            return response()->json([
                "message" => "Successfully found registrant please download your ticket",
                "data" => $this->get_response_data($data->toArray(), $membership_id),
                "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken,
                "isValidated" => true,
            ]);
        }

        if($data->is_ieee_member && ! $data->membership_id){
            return response([
                "message" => "Membership ID not found",
                "data" => $this->get_response_data($data->toArray(), null),
                "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken,
            ], 404);
        }

        $membership_id = $data->is_ieee_member && $data->membership_id ? $data->membership_id->membership_id : null;

        $message = "Successfully found registrant and membership id send for validation";

        if($data->checks->isValidated){
            $message = "Successfully found registrant please download your ticket";
        }

        return [
            "message" => $message,
            "data" => $this->get_response_data($data->toArray(), $membership_id),
            "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken,
            "isValidated" => $data->checks->isValidated,
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
            "isValidated" => (bool) $registrant->checks->isValidated,
        ], 201);

    }

    public function get_ticket(Request $request)
    {

        $data = [
            "name" => $request->user()->name,
            "ticket_id" => $request->user()->ticket->ticket_id,
        ];

        if($request->user()->ticket->ticket_type == "Contributor Ticket")
        {
            return response([
                "message" => "Ticket Generated Successfully",
                "data" => $data,
                "image" => Ticket::generateTicket($data, $request->user()->ticket_type),
                "isValidated" => true
            ], 201);
        }

        if(! $request->user()->checks->isValidated)
        {
            return response([
                "message" => "Your IEEE Membership is not yet validated, check after few hours",
                "data" => $data,
                "isValidated" => false,
            ], 201);

        }

        return response([
            "message" => "Ticket Generated Successfully",
            "data" => $data,
            "image" => Ticket::generateTicket($data, $request->user()->ticket_type),
            "isValidated" => true
        ], 201);

    }
}
