<?php

namespace App\Http\Controllers;

use App\Models\TouristSpot;
use Illuminate\Http\Request;

class TouristSpotController extends Controller
{
    public function createTouristSpot(Request $request){
        try {
            $touristSpot = $request->only([
                'name',
                'description',
                'address',
                'imgUrl',
                'gMapUrl'
            ]);

            $newTouristSpot = TouristSpot::create($touristSpot);

            return response()->json([
                'status' => 'success',
                'message' => 'Tourist spot created successfully.',
                'tourist_spot' => $newTouristSpot
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllTouristSpots(){
        try {
            $touristSpots = TouristSpot::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Tourist spots fetched successfully.',
                'tourist_spots' => $touristSpots
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }        
    }

     public function getTouristSpotById($id){
        try {
            $touristSpot = TouristSpot::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Tourist spot fetched successfully.',
                'tourist_spot' => $touristSpot
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }        
    }   

    public function updateTouristSpot(Request $request, $id){
        try {
            $touristSpot = TouristSpot::findOrFail($id);

            if(!$touristSpot){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Tourist spot does not exist.'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string',
                'address' => 'sometimes|string',
                'description' => 'sometimes|string',
                'imgUrl' => 'sometimes|string',
                'gMapUrl' => 'sometimes|string',
            ]);

            $touristSpot->fill($validated);
            $touristSpot->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Tourist spot updated successfully.',
                'tourist_spot' => $touristSpot
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteTouristSpot($id){
        try {
            $touristSpot = TouristSpot::findOrFail($id);

            if(!$touristSpot){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Tourist spot does not exist.'
                ], 404);
            }

            $touristSpot->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Tourist spot deleted successfully.',
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
