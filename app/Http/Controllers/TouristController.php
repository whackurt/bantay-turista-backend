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
        return response()->json([
            'status'=>true, 
            'message' => 'Tourist fetched successfully.', 
            'data' => $tourists
        ], 200);
    }

    public function touristHome($id){
        $tourist = Tourist::select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'),'photo_url', 'country', 'city_municipality', 'state_province', 'address_1', 'address_2', 'qr_code')->find($id);
        
        if(!$tourist){
            return response()->json([
                'status'=>false, 
                'message' => 'Tourist ID does not exist.'
            ], 404);
        }

        return response()->json([
            'status'=>true, 
            'message' => 'Tourist fetched successfully.', 
            'data' => $tourist
        ], 200);
    }


    public function touristProfile($id){
        $tourist = Tourist::select('first_name', 'last_name', 'date_of_birth', 'country', 'city_municipality', 'state_province', 'address_1', 'address_2', 'gender',
            'nationality', 'photo_url', 'contact_number')->find($id);
        if(!$tourist){
            return response()->json([
                'status'=>false, 
                'message' => 'Tourist ID does not exist.'
            ], 404);
        }

        return response()->json([
            'status'=>true, 
            'message' => 'Tourist fetched successfully.', 
            'data' => $tourist
        ], 200);
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
        
        if(!$tourist){
            return response()->json([
                'status'=>false, 
                'message' => 'Tourist ID does not exist.'
            ], 404);
        }

        $tourist->update($validate);

        $user = User::find($tourist->user_id);
        $user->name = $name;
        $user->save();


        return response()->json([
            'status'=>true, 
            'message' => 'Tourist updated successfully.', 
            'data' => $tourist
        ], 200);
    }
}