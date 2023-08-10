<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TouristController;
use App\Models\Admin;
use App\Models\EssentialServiceProvider;
use App\Models\Establishment;
use App\Models\TouristSpot;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Tourist;
use App\Models\Log;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
});


/* 
    These routes are for testing only. 
    Don't take it seriously. 
*/

Route::get('/v1/users', function () {
    $users = User::all();
    return $users;
})->middleware('auth:sanctum');

Route::get('/v1/tourists', function () {
    $tourists = Tourist::all();
    return view('tourists.index', ['tourists' => $tourists]);
});

Route::get('/v1/tourist/{id}', function ($id) {
    $tourist = Tourist::find($id);
    if ($tourist) {
        return view('tourists.tourist', ['tourist' => $tourist]);
    }
    abort(404);
});

Route::get('/v1/establishment/{id}', function ($id) {
    $est = Establishment::find($id);
    return view('establishment.index', ['est' => $est]);
});

Route::get('/v1/admin', function () {
    $admins = Admin::all();
    return view('admin.index', ['admins' => $admins]);
});

Route::get('/v1/admin/{id}', function ($id) {
    $admin = Admin::find($id);
    return view('admin.admin', ['admin' => $admin]);
});

Route::get('/v1/tourist_spot', function () {
    $spots = TouristSpot::all();
    return $spots;
});

Route::get('/v1/tourist_spot/{id}', function ($id) {
    $spot = TouristSpot::find($id);
    return $spot;
});

Route::get('/v1/essential_service_provider', function () {
    $providers = EssentialServiceProvider::all();
    return $providers;
});

Route::get('/v1/essential_service_provider/{id}', function ($id) {
    $provider = EssentialServiceProvider::find($id);
    return $provider;
});

Route::get('/v1/logs', function () {
    $log = Log::all();
    return view('log.index', ['log' => $log]);
});

Route::post('/v1/log', [LogController::class, 'create']);

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