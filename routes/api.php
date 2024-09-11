<?php

use App\Http\Controllers\Api\AddFoodValidation;
use App\Http\Controllers\Api\AddSwagController;
use App\Http\Controllers\Api\AddValidationForCheckId;
use App\Http\Controllers\Api\GetAllEvents;
use App\Http\Controllers\Api\GetDataUsingEmail;
use App\Http\Controllers\Api\GetMyCertificate;
use App\Http\Controllers\Api\GetUserDetailsWithAllChecks;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MentoringSessionController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\GetAppStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Check api
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ticket related apis and its controller
Route::controller(TicketController::class)
    ->group(function () {
        Route::post('/validate-user' ,'validate_user');
        Route::post('/add-membership-id', 'store_membership_id')->middleware('auth:sanctum');
        Route::post('/get-ticket', 'get_ticket')->middleware('auth:sanctum');
    });


// Neetoform Related Apis and its Controller
//Route::controller(NeetoFormController::class)
//    ->group(function () {
//    Route::get('/data', 'data');
//    Route::post('/neetoform/ieee', 'store_ieee');
//    Route::post('/neetoform/non-ieee', 'store_non_ieee');
//});

// Login for user.
Route::post('/login', LoginController::class);

// Mentoring Session api.
Route::post('/events/mentoring-session/{event}', MentoringSessionController::class);

// Get All Mentoring Session.
Route::get('/events/mentoring-session', GetAllEvents::class);

Route::post('/certificates', GetMyCertificate::class);

Route::post('/app/user', GetUserDetailsWithAllChecks::class);

Route::post('/app/email-validation', GetDataUsingEmail::class);

Route::post('/app/add-validation', AddValidationForCheckId::class);

Route::post('/app/food-validation', AddFoodValidation::class);

Route::post('/app/swag-validation', AddSwagController::class);

Route::get('/app/status', GetAppStatus::class);




