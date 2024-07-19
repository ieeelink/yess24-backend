<?php

use App\Http\Controllers\BulkController;
use App\Http\Controllers\RegistrantController;
use App\Http\Middleware\CheckReferer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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

Route::post('/api/test', function (Request $request) {
    dd($request->header('referer'));
})->middleware(CheckReferer::class);



