<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\RegistrantController;
use App\Http\Middleware\CheckReferer;
use App\Utils\Ticket;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome', [
        'image' => Ticket::generateTicket("hello")
    ]);
});

Route::controller(BulkController::class)->group(function () {
    Route::get('/bulk/add', 'bulk_add');

    Route::post('/bulk', 'bulk_store');
});



