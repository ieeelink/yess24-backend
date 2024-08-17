<?php

use App\Http\Controllers\BulkController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrantController;
use App\Utils\Ticket;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome', [
        'image' => Ticket::generateTicket([
            "name" => "Benison Abraham",
            "ticket_id" => "YESS0534"
        ], "")
    ]);
})->name('home');

//Route::login('/login', )

Route::middleware('auth')->group(function () {
    Route::controller(BulkController::class)->group(function () {
        Route::get('/registrations/add', 'bulk_add');

        Route::post('/registrations', 'bulk_store');
    });

    Route::get('/registrations', [RegistrantController::class, 'index']);
    Route::get('/registrations/{registrant}', [RegistrantController::class, 'show']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/add', [EventController::class, 'add']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store']);
});




