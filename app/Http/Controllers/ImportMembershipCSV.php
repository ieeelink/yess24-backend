<?php

namespace App\Http\Controllers;

use App\Models\MembershipId;
use Illuminate\Http\Request;

class ImportMembershipCSV extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'count' => 'required|integer|numeric|min:1',
        ]);

        $file = $request->file('csv_file');

        $handle = fopen($file->path(), 'r');

        fgetcsv($handle);

        $chunksize = $validated['count'];

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

            $this->validate_membership($chunkdata);
        }
        fclose($handle);

        return redirect('/registrations');
    }

    private function validate_membership($chunkdata)
    {
        foreach($chunkdata as $id)
        {
            $membership = MembershipId::where("membership_id", $id)->first();
            $registrant = $membership->registrant;
            $checks = $registrant->checks;
            $checks->isValidated = true;
            $checks->save();
        }
    }
}
