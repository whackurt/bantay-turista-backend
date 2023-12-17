<?php

namespace App\Http\Controllers;

use App\Models\EmergencyHotlineNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EmergencyHotlineNumbersController extends Controller
{
    public function createHotline(Request $request)
    {
        try {
            $hotline = $request->only([
                'agencyName',
                'address',
                'agencyLogo',
                'hotlineNumber',
            ]);

            $newHotline = EmergencyHotlineNumber::create($hotline);

            return response()->json([
                'status' => 'success',
                'message' => 'Emergency hotline number created successfully.',
                'hotline' => $newHotline
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllHotlines()
    {
        try {
            $hotlines = EmergencyHotlineNumber::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Emergency hotline numbers fetched successfully.',
                'hotlines' => $hotlines
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getHotlineById(string $id)
    {
        try {
            $hotline = EmergencyHotlineNumber::findOrFail($id);
        
            return response()->json([
                'status' => 'success',
                'message' => 'Emergency hotline number fetched successfully.',
                'hotline' => $hotline
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function updateHotline(Request $request, string $id)
    {
        try {
            $hotline = EmergencyHotlineNumber::findOrFail($id);

            if(!$hotline){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Hotline does not exist.'
                ], 404);
            }

            $validated = $request->validate([
                'agencyName' => 'sometimes|string',
                'address' => 'sometimes|string',
                'agencyLogo' => 'sometimes|string',
                'hotlineNumber' => 'sometimes|string',
            ]);

            $hotline->fill($validated);
            $hotline->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Hotline updated successfully.',
                'tourist_spot' => $hotline
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function deleteHotline(string $id)
    {
        try {
            $hotline = EmergencyHotlineNumber::findOrFail($id);

            if(!$hotline){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Hotline does not exist.'
                ], 404);
            }

            $hotline->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Hotline deleted successfully.',
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
