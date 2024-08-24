<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class EmailViaMembershipValidation extends Controller
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
        foreach($chunkdata as $email)
        {
            $registrant = Registrant::where("email", $email)->first();
            $checks = $registrant->checks;
            $checks->isValidated = true;
            $checks->save();
        }
    }
}
