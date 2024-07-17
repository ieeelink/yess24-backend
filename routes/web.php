<?php

use App\Http\Controllers\RegistrantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(RegistrantController::class)
    ->group(function () {
    Route::post('/neetoform/ieee', 'store_ieee');
    Route::post('/neetoform/non_ieee', 'store_non_ieee');
});

Route::get('/bulk/early/ieee', function () {
    return view('bulk.early.ieee');
});

Route::get('/token', function () {
    return csrf_token();
});


