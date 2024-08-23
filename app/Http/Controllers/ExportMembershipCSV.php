<?php

namespace App\Http\Controllers;

use App\Models\MembershipId;
use Illuminate\Http\Request;

class ExportMembershipCSV extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $filename = 'membership.csv';

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
                'registrant_id',
                'membership_id'
            ]);

            // Fetch and process data in chunks
            MembershipId::whereRelation("registrant.checks", "isValidated", "false")->chunk(25, function ($members) use ($handle) {
                foreach ($members as $member) {
                    // Extract data from each employee.
                    $data = [
                        $member->id ?? '',
                        $member->registrant_id ?? '',
                        $member->membership_id ?? '',
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
