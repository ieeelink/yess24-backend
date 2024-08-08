<?php

use App\Http\Controllers\Api\AddMyEventController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NeetoFormController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(TicketController::class)
    ->group(function () {
        Route::post('/validate-user' ,'validate_user');
        Route::post('/add-membership-id', 'store_membership_id')->middleware('auth:sanctum');
        Route::post('/get-ticket', 'get_ticket')->middleware('auth:sanctum');
    });

Route::controller(NeetoFormController::class)
    ->group(function () {
    Route::get('/data', 'data');
    Route::post('/neetoform/ieee', 'store_ieee');
    Route::post('/neetoform/non-ieee', 'store_non_ieee');
});

Route::post('/login', LoginController::class);
Route::post('/events/{event}', AddMyEventController::class);

