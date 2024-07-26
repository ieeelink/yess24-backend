<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\RegistrantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ApiController::class)
    ->group(function () {
        Route::post('/tickets' ,'get_ticket');
        Route::post('/{registrant}/add_membership_id', 'store_membership_id');
    });

Route::controller(RegistrantController::class)->group(function () {
    Route::get('/data', 'data');
    Route::post('/neetoform/ieee', 'store_ieee');
    Route::post('/neetoform/non_ieee', 'store_non_ieee');
});
