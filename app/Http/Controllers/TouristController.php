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
            'nationality', 'photo_url', 'contact_number', 'qr_code')->find($id);
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
        
        $tourist = Tourist::findOrFail($id);
        
        if(!$tourist){
            return response()->json([
                'status'=>false, 
                'message' => 'Tourist ID does not exist.'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'date_of_birth' => 'sometimes|string',
            'country' => 'sometimes|string',
            'state_province' => 'sometimes|string',
            'city_municipality' => 'sometimes|string',
            'address_1' => 'sometimes|string',
            'address_2' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'nationality' => 'sometimes|string',
            'photo_url' => 'sometimes|string',
            'contact_number' => 'sometimes|string',
        ]);

        $tourist->fill($validated);
        $tourist->save();

        return response()->json([
            'status'=>true, 
            'message' => 'Tourist updated successfully.', 
            'data' => $tourist
        ], 200);
    }
}