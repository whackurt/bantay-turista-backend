<?php

use App\Http\Controllers\Auth\AuthController;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/v1/users', function () {
        $users = User::all();
        return $users;
    });

    Route::get('/v1/tourists', function () {
        $tourists = Tourist::all();
        return view('tourists.index', ['tourists' => $tourists]);
    });

    Route::get('/v1/tourists/{id}/home', function ($id) {
        $tourist = Tourist::select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'address', 'qr_code')->find($id);
        if(!$tourist){
            return response()->json(['message' => 'Tourist ID does not exist.'], 404);
        }
        return response()->json(['data' => $tourist], 200);
    });

    Route::get('/v1/tourists/{id}/profile', function ($id) {
        $tourist = Tourist::find($id);
        if(!$tourist){
            return response()->json(['message' => 'Tourist ID does not exist.'], 404);
        }
        return response()->json(['data' => $tourist], 200);
    });

    Route::get('/v1/tourist_spots', function () {
        $spots = TouristSpot::all();
        return $spots;
    });

    Route::get('/v1/tourist_spots/{id}', function ($id) {
        $spot = TouristSpot::find($id);
        return $spot;
    });

    Route::get('/v1/establishments', function () {
        $est = Establishment::all();
        return $est;
    });

    Route::get('/v1/establishments/{id}', function ($id) {
        $est = Establishment::find($id);
        return view('establishment.index', ['est' => $est]);
    });
});


Route::get('/v1/admin', function () {
    $admins = Admin::all();
    return view('admin.index', ['admins' => $admins]);
});

Route::get('/v1/admin/{id}', function ($id) {
    $admin = Admin::find($id);
    return view('admin.admin', ['admin' => $admin]);
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
    $logs = Log::all();
    //return response()->json(['logs' => $logs]);
    return view('log.index', ['logs' => $logs]);
});

Route::post('/v1/log', [LogController::class, 'create']);

Route::post('/v1/complaints', [ComplaintController::class, 'create']);

Route::get('/v1/complaints', function () {
    $complaints = Complaint::all();
    return view('complaint.index', ['complaints' => $complaints]);
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