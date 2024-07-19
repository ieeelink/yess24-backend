<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use App\Models\Ticket;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class ApiController extends Controller
{
    public function get_response_data($data)
    {
        return [
            "id" => $data['id'],
            "name" => $data['name'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "is_ieee_member" => $data['is_ieee_member'],
            "ticket_id" => $data['ticket']['ticket_id']
        ];
    }
    public function get_ticket(Request $request)
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
                "message" => "No registrant with this email address or phone number."
            ],404);
        }

        if($data->is_ieee_member){
            if(! $data->membership_id){
                $data = $data->toArray();

                return response([
                    "message" => "Please enter your IEEE Membership ID to validate your registration.",
                    "data" => $this->get_response_data($data)
                ], 404);
            }
        }

        $data = $data->toArray();

        return [
            "message" => "Success",
            "data" => $this->get_response_data($data)
        ];
    }
}
