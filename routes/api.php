<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TouristController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Comparator\Factory;
use App\Models\User;
use App\Models\Tourist;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::get('/users', function () {
    $users = User::all();
    return $users;
});

Route::get('/tourists', function () {
    $tourists = Tourist::all();
    return view('tourists.index', ['tourists' => $tourists]);
});

Route::get('/tourist/{id}', function ($id) {
    $tourist = Tourist::find($id);
    if ($tourist) {
        return view('tourists.tourist', ['tourist' => $tourist]);
    }
    abort(404);
});

// generate fake users
Route::get('/generateUsers/{count}', function ($count) {
    User::factory()->count($count)->create();
});

// generate fake tourists
Route::get('/generateTourists/{count}', function ($count) {
    Tourist::factory()->count($count)->create();
});

/* 
    END TESTING ROUTES 
*/