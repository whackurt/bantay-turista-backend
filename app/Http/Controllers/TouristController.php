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
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'date_of_birth' => 'sometimes|required',
            'country' => 'sometimes|required|string',
            'state_province' => 'sometimes|required|string',
            'city_municipality' => 'sometimes|required|string',
            'address_1' => 'sometimes|required|string',
            'address_2' => 'sometimes|required|string',
            'gender' => 'sometimes|required|string',
            'nationality' => 'sometimes|required',
            'photo_url' => 'sometimes|required',
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