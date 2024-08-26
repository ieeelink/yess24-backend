<?php

namespace App\Http\Controllers;

use App\Models\MembershipId;
use App\Models\Registrant;
use Illuminate\Http\Request;

class FetchAttendeeDetails extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $filename = 'attendee.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'index',
                'name',
                'email',
                'phone',
                'college_name',
                'is_ieee_member',
                'ticket_type'
            ]);

            // Fetch and process data in chunks
            Registrant::whereRelation("checks", "isAttending", true)->chunk(25, function ($registrants) use ($handle) {
                foreach ($registrants as $registrant) {
                    // Extract data from each employee.
                    $data = [
                        $registrant->id ?? '',
                        $registrant->name ?? '',
                        $registrant->email ?? '',
                        $registrant->phone ?? '',
                        $registrant->college_name ?? '',
                        $registrant->is_ieee_member ?? '',
                        $registrant->ticket_type ?? '',
                    ];

                    // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
}
