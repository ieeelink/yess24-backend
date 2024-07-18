<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    public function add_data($chunkdata, $is_ieee, $ticket_type)
    {
        $data = [];

        foreach ($chunkdata as $column) {
            $data["name"] = $column[1];
            $data["email"] = $column[2];
            $data["phone"] = $column[3];
            $data["college_name"] = $column[4];
            $data["gender"] = $column[5];
            $data["t_shirt_size"] = $column[6];
            $data["food_preference"] = $column[7];
            $data["is_ieee_member"] = $is_ieee;
            $data["ticket_type"] = $ticket_type;

            $registrant = Registrant::create($data);

            if($is_ieee){
                $registrant->membership_id()->create([
                    'membership_id' => $column[8],
                ]);
            }
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
            'count' => 'required|int'
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

        return $chunkdata;

    }
}
