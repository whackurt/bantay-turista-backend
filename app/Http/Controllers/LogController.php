<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function allLogs(){
        $logs = Log::all();
        //return response()->json(['logs' => $logs]);
        return view('log.index', ['logs' => $logs]);
    }

    public function createLog(Request $request)
    {
        $logDetails = $request->only(['tourist_id', 'establishment_id']);

        $log = Log::create($logDetails);

        return response()->json([
            'status' => 'success',
            'message' => 'Log created',
            'log' => $log
        ], 201);
    }
}