<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tourist;
use App\Models\User;

class TouristController extends Controller
{
    public function allTourist(){
        $tourists = Tourist::all();
        return view('tourists.index', ['tourists' => $tourists]);
    }

    public function touristHome($id){
        $tourist = Tourist::select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'address', 'qr_code')->find($id);
        
        if(!$tourist){
            return response()->json(['message' => 'Tourist ID does not exist.'], 404);
        }

        return view('tourists.home')->with('tourist', $tourist);
    }

    public function touristProfile($id){
        $tourist = Tourist::select('first_name', 'last_name', 'date_of_birth', 'address', 'gender',
            'nationality', 'photo_url', 'contact_number')->find($id);
        if(!$tourist){
            return response()->json(['message' => 'Tourist ID does not exist.'], 404);
        }
        return response()->json(['data' => $tourist], 200);
    }

    public function updateTourist(Request $request, $id){
        $validate = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'date_of_birth' => 'sometimes',
            'address' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'nationality' => 'sometimes',
            'photo_url' => 'sometimes',
            'contact_number' => 'sometimes|integer',
        ]);
    
        $name = $request->input('first_name') . ' ' . $request->input('last_name');
        $tourist = Tourist::find($id);
        $tourist->update($validate);
        $user = User::find($tourist->user_id);
        $user->name = $name;
        $user->save();


        return response()->json(['data' => $tourist], 200);
    }
}