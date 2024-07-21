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

Route::controller(RegistrantController::class)->group(function () {
    Route::get('/data', 'data');
    Route::post('/neetoform/ieee', 'store_ieee');
    Route::post('/neetoform/non_ieee', 'store_non_ieee');
});

Route::controller(BulkController::class)->group(function () {
    Route::get('/bulk/add', 'bulk_add');

    Route::post('/bulk', 'bulk_store');
});

Route::controller(ApiController::class)
    ->middleware(CheckReferer::class)
    ->group(function () {
    Route::post('/api/tickets' ,'get_ticket');
    Route::post('/api/{registrant}/add_membership_id', 'store_membership_id');
});



