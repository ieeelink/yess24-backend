<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use App\Utils\PhoneNumber;
use App\Utils\Ticketing;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    public function add_data($chunkdata, $is_ieee, $ticket_type)
    {
        $data = [];

        foreach ($chunkdata as $column) {
            $data["name"] = $column[1];
            $data["email"] = $column[2];
            $data["phone"] = PhoneNumber::getNumber($column[3]);
            $data["college_name"] = $column[4];
            $data["gender"] = $column[7];
            $data["t_shirt_size"] = $column[8];
            $data["food_preference"] = $column[9];
            $data["is_ieee_member"] = $is_ieee;
            $data["ticket_type"] = $ticket_type;

            $registrant = Registrant::create($data);


            if($is_ieee){
                $registrant->membership_id()->create([
                    'membership_id' => $column[10],
                ]);
            }

            $registrant->details()->create([
                'year' => $column[5],
                'course' => $column[6],
            ]);

            $ticket_id = Ticketing::generateTicketNumber($ticket_type);

            $registrant->ticket()->create([
                'ticket_id' => $ticket_id,
            ]);

            Ticketing::incrementCount($ticket_type);

        }
    }
    public function bulk_add(){
        return view('bulk.add');
    }

    public function bulk_store(Request $request){
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv',
            'ticket_type' => 'required',
            'is_ieee' => 'required',
            'count' => 'required|integer|numeric|min:1',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->path(), 'r');

        fgetcsv($handle);

        $chunksize = $validated['count'];

        $is_ieee = $validated['is_ieee'] == "true";

        while(!feof($handle))
        {
            $chunkdata = [];

            for($i = 0; $i<$chunksize; $i++)
            {
                $data = fgetcsv($handle);
                if($data === false)
                {
                    break;
                }
                $chunkdata[] = $data;
            }

            $this->add_data($chunkdata, $is_ieee, $validated['ticket_type']);
        }
        fclose($handle);

        return redirect('/registrations');

    }
}
