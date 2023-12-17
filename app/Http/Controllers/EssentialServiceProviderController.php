<?php

namespace App\Http\Controllers;

use App\Models\EssentialServiceProvider;
use Illuminate\Http\Request;

class EssentialServiceProviderController extends Controller
{
    public function createProvider(Request $request){
        try {
            $provider = $request->only([
                'name',
                'address',
            ]);

            $newProvider = EssentialServiceProvider::create($provider);

            return response()->json([
                'status' => 'success',
                'message' => 'Essential service provider created successfully.',
                'provider' => $newProvider
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllProviders(){
        try {
            $providers = EssentialServiceProvider::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Essential service providers fetched successfully.',
                'providers' => $providers
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }        
    }

    public function getProviderById($id){
        try {
            $provider = EssentialServiceProvider::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Essential service provider fetched successfully.',
                'provider' => $provider
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }        
    }

    public function updateProvider(Request $request, $id){
        try {
            $provider = EssentialServiceProvider::findOrFail($id);

            if(!$provider){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Essential Service Provider does not exist.'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string',
                'address' => 'sometimes|string',
            ]);

            $provider->fill($validated);
            $provider->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Essential service provider updated successfully.',
                'provider' => $provider
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteProvider($id){
        try {
            $provider = EssentialServiceProvider::findOrFail($id);

            if(!$provider){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Essential Service Provider does not exist.'
                ], 404);
            }

            $provider->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Essential Service Provider deleted successfully.',
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
