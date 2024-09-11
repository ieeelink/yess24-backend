<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class ViewCertificatesDashboard extends Controller
{
    public function index()
    {
        return view('certificates.index', [
            'no_of_attendees' => Registrant::whereRelation("checks", "isAttending", true)->count(),
            'no_of_certificates_downloaded' => Registrant::whereRelation("checks", "isCertificateIssued", true)->count(),
        ]);
    }

    public function download_details()
    {
        $filename = 'Certificates Not Downloaded.csv';

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
                'is_ieee_member',
                'ticket_type'
            ]);

            // Fetch and process data in chunks
            Registrant::whereRelation("checks", "isAttending", true)->whereRelation("checks", "isCertificateIssued", false)->chunk(25, function ($registrants) use ($handle) {
                foreach ($registrants as $registrant) {
                    // Extract data from each employee.
                    $data = [
                        $registrant->id ?? '',
                        $registrant->name ?? '',
                        $registrant->email ?? '',
                        $registrant->phone ?? '',
                        $registrant->college ?? ''
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
