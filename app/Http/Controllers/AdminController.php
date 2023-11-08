<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Log;

class AdminController extends Controller
{
    public function allAdmin(){
        $admins = Admin::all();
        return view('admin.index', ['admins' => $admins]);
    }
    
    public function singleAdmin($id){
        $admin = Admin::find($id);
        
        if(!$admin){
            return response()->json(['message' => 'Admin ID does not exist.'], 404);
        }

        return view('admin.admin', ['admin' => $admin]);
    }

    public function viewLogs(){
        $logs = Log::all();
        //return response()->json(['logs' => $logs]);
        return view('log.index', ['logs' => $logs]);
    }

    public function viewFilterLogs($id){
        $logs = Log::all()->where('tourist_id', $id);
        //return response()->json(['logs' => $logs]);
        return view('log.index', ['logs' => $logs]);
    }
}
