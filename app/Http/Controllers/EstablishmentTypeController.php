<?php

namespace App\Http\Controllers;

use App\Models\EstablishmentType;
use Illuminate\Http\Request;

class EstablishmentTypeController extends Controller
{
    public function getEstablishmentTypes(){
        try{
            $estTypes = EstablishmentType::all();

            return response()->json([
                'status'=>true, 
                'message'=> 'Establishment types fetched successfully.', 
                'data'=> $estTypes
            ], 200);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function createEstablishmentType(Request $request){
        try{
            $newEstType = EstablishmentType::create([
                'name' => $request->name,
            ]);

            if($newEstType->id){
                return response()->json([
                    'status'=>true, 
                    'message'=> 'Establishment type created successfully.', 
                    'data'=> $newEstType
                ], 200);
            }           

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
