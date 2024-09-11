<?php

use App\Http\Controllers\AddValidatedEmailCSV;
use App\Http\Controllers\AddValidatedMembershipCSV;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\EmailViaMembershipValidation;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExportDataOfMembershipNotGiven;
use App\Http\Controllers\ExportMembershipCSV;
use App\Http\Controllers\FetchAttendeeDetails;
use App\Http\Controllers\ImportMembershipCSV;
use App\Http\Controllers\RegistrantController;
use App\Http\Controllers\ViewCertificatesDashboard;
use App\Utils\Certificate;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome', [
        'image' => Certificate::generateCertificate("Benison Abraham", "College of Engineering Vadakara")
    ]);
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'store'])->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::controller(BulkController::class)->group(function () {
        Route::get('/registrations/add', 'bulk_add');

        Route::post('/registrations', 'bulk_store');
    });

    Route::get('/registrations', [RegistrantController::class, 'index'])->name('registrations');
    Route::get('/registrations/{registrant}', [RegistrantController::class, 'show']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/add', [EventController::class, 'add']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/membership/download', ExportMembershipCSV::class);
    Route::get('/emails/download', ExportDataOfMembershipNotGiven::class);
    Route::get('/membership/add', AddValidatedMembershipCSV::class);
    Route::post('/membership', ImportMembershipCSV::class);
    Route::get('/email/add', AddValidatedEmailCSV::class);
    Route::post('/email', EmailViaMembershipValidation::class);

    Route::get('/attendee-details', FetchAttendeeDetails::class);
    Route::get('/certificates', [ViewCertificatesDashboard::class, 'index']);
    Route::get('/certificates/download', [ViewCertificatesDashboard::class, 'download_details']);

});

//Route::get('/change-is-valid-for-contributors', function (){
//    $checks = Check::whereRelation("registrant", "ticket_type", "Contributor Ticket")->get();
//    foreach ($checks as $check)
//    {
//        $check->isValidated = true;
//        $check->save();
//    }
//    return Check::whereRelation("registrant", "ticket_type", "Contributor Ticket")->get();
//});



