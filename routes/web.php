<?php

use App\Http\Controllers\BulkController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrantController;
use App\Utils\Ticket;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome', [
        'image' => Ticket::generateTicket("hello")
    ]);
});

Route::controller(BulkController::class)->group(function () {
    Route::get('/registrations/add', 'bulk_add');

    Route::post('/registrations', 'bulk_store');
});

Route::get('/registrations', [RegistrantController::class, 'index']);
Route::get('/registrations/{registrant}', [RegistrantController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);


