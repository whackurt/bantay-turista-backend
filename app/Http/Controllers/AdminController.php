<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Log;
use App\Models\TouristSpot;

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

    public function createTouristSpot(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|min:5|max:50',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'imageUrl' => 'required|string|max:255',
        ]);  

        $tourist_spot = TouristSpot::create($validate);

        return response()->json([
            'status' => 'success',
            'message' => 'Tourist Spot created',
            'data' => $tourist_spot
        ], 200);
    }
}
