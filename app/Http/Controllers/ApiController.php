<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function get_response_data($data)
    {
        return [
            "id" => $data['id'],
            "name" => $data['name'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "is_ieee_member" => $data['is_ieee_member']
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
                "message" => "Not found"
            ],404);
        }

        if($data->is_ieee_member && ! $data->membership_id){
            return response([
                "message" => "ID not found",
                "data" => $this->get_response_data($data->toArray()),
                "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken,
            ], 404);
        }

        return [
            "message" => "Successfully found registrant and his ticket",
            "data" => $this->get_response_data($data->toArray()),
            "token" => $data->createToken('validated', ['*'], now()->addHour() )->plainTextToken
        ];
    }

    public function store_membership_id(Request $request)
    {
        $registrant =  $request->user();

        if(! $registrant->is_ieee_member){
            return response([
                "message" => "Not a IEEE Member",
                "data" => $this->get_response_data($registrant->toArray())
            ], 401);
        }

        if($registrant->is_ieee_member && $registrant->membership_id){
            return response([
                "message" => "Membership ID already exists",
                "data" => $this->get_response_data($registrant->toArray())
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'membership_id' => 'required|integer|unique:membership_ids,membership_id'
        ]);

        if($validator->fails()) {
            return response()->json([
                "message" => "Membership ID already exists or not a numeric",
                "data" => $request->all()
            ], 404);
        }

        $membership_id = $validator->validated()['membership_id'];

        $registrant->membership_id()->create([
            'membership_id' => $membership_id
        ]);

        return response()->json([
            "message" => "Successfully add membership id to registrant",
            "data" => $this->get_response_data($registrant->toArray())
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
        $ticket_id = $request->user()->ticket()->ticket_id;

        return response([
            "message" => "Ticket Generated Successfully",
            "data" => [
                "ticket_id" => $ticket_id,
                "user" => $user,
            ],
            "image" => $request->file('image')
        ], 201);
    }
}
