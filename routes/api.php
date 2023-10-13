<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TouristController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LogController;
use App\Models\Admin;
use App\Models\Complaint;
use App\Models\EssentialServiceProvider;
use App\Models\Establishment;
use App\Models\TouristSpot;
use App\Models\User;
use App\Models\Tourist;
use App\Models\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* 
    These routes are for testing only. 
    Don't take it seriously. 
*/

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'loginUser');
    Route::post('/register', 'createUser');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
});

Route::controller(TouristController::class)->prefix('v1/tourist')->group(function () {
    Route::get('/list', 'allTourist');
    Route::get('/{id}', 'singleTourist');
    Route::get('/{id}/home', 'touristHome');
    Route::get('/{id}/profile', 'touristProfile');
    Route::put('/{id}/profile/update', 'updateTourist');
});

Route::controller(EstablishmentController::class)->prefix('v1/establishment')->group(function () {
    Route::get('/list', 'allEstablishment');
    Route::get('/{id}', 'singleEstablishment');
    Route::get('/{id}/home', 'establishmentHome');
    Route::get('/{id}/profile', 'establishmentProfile');
    Route::put('/{id}/profile/update', 'updateEstablishment');
    Route::post('/{id}/scan', 'submitEntryLogs');
});

Route::controller(AdminController::class)->prefix('v1/admin')->group(function () {
    Route::get('/list', 'allAdmin');
    Route::get('/{id}', 'singleAdmin');
});

Route::controller(LogController::class)->prefix('v1/logs')->group(function () {
    Route::get('/list', 'allLogs');
    Route::post('/create', 'createLog');
});

Route::controller(ComplaintController::class)->prefix('v1/complaints')->group(function () {
    Route::get('/list', 'allComplaints');
    Route::get('/create', 'createComplaints');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/v1/users', function () {
        $users = User::all();
        return $users;
    });

    Route::get('/v1/tourist_spots', function () {
        $spots = TouristSpot::all();
        return $spots;
    });

    Route::get('/v1/tourist_spots/{id}', function ($id) {
        $spot = TouristSpot::find($id);
        return $spot;

    Route::get('/v1/essential_service_provider', function () {
        $providers = EssentialServiceProvider::all();
        return $providers;
    });
    
    Route::get('/v1/essential_service_provider/{id}', function ($id) {
        $provider = EssentialServiceProvider::find($id);
        return $provider;
    });
    });
});

// generate fake users
Route::get('/v1/generateUsers/{count}', function ($count) {
    User::factory()->count($count)->create();
});

// generate fake tourists
Route::get('/v1/generateTourists/{count}', function ($count) {
    Tourist::factory()->count($count)->create();
});

/* 
    END TESTING ROUTES 
*/