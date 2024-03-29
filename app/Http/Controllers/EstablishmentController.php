<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\Tourist;
use App\Models\Log;
use App\Models\User;
use DB;

class EstablishmentController extends Controller
{
    private function getEntryLogs($id){
        $logs = Log::all()->where('establishment_id', $id);
        $timestamps = $logs->pluck('created_at');
        $touristID = $logs->pluck('tourist_id');
        $tourists = [];
        $date = [];
        $time = [];
        $count = 0;

        foreach ($touristID as $i){
            $idToName = Tourist::where('id', $i)->select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'))->pluck('full_name');
            $currentTimeStamp = explode(' ', $timestamps[$count]);
            $date[] = $currentTimeStamp[0];
            $time[] = $currentTimeStamp[1];
            $tourists = array_merge($tourists, $idToName->toArray());
            $count++;
        }

        return array($tourists, $date, $time);
    }

    public function getEstablishmentById($id){
        try {
            $establishment = Establishment::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Establishment fetched successfully.',
                'establishment' => $establishment
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }       
    }

    public function getAllEstablishments(){

        try {
            $establishments = Establishment::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Establishments fetched successfully.',
                'establishments' => $establishments
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        } 
    }

    public function establishmentHome($id){
        try {
            $est = Establishment::select('name', 'city_municipality', 'barangay', 'address_1', 'photo_url')->find($id);

            if(!$est){
                return response()->json(['message' => 'Establishment ID does not exist.'], 404);
            }

            list($tourists, $date, $time) = $this->getEntryLogs($id);
              
//            return view('establishment.home')->with('est', $est)->with('tourists', $tourists)->with('date', $date)->with('time', $time);
            return response()->json([
            'status'=>true, 
            'message' => 'Establishment fetched successfully.', 
            'data' => [
                'establishment'=> $est,
                'tourists'=> $tourists,
                'date'=> $date,
                'time'=> $time
            ]
        ], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function establishmentProfile($id){
        try {
            $est = Establishment::find($id);
            if(!$est){
                return response()->json(['message' => 'Establishment ID does not exist.'], 404);
            }
            return response()->json(['data' => $est], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateEstablishment(Request $request, $id){
        try {

            $est = Establishment::findOrFail($id);

            if(!$est){
            return response()->json([
                'status'=>false, 
                'message' => 'Establishment ID does not exist.'
            ], 404);
        }

            $validated = $request->validate([
                'name' => 'sometimes|string',
                'city_municipality' => 'sometimes|string',
                'barangay' => 'sometimes|string',
                'address_1' => 'sometimes|string',
                'contact_number' => 'sometimes|string',
                'owner_name' => 'sometimes|string',
                'owner_email' => 'sometimes|email',
                'owner_phone' => 'sometimes|string',
                'photo_url' => 'sometimes',
                'type_id' => 'sometimes|string',
            ]);    

            $est->fill($validated);
            $est->save();

            /* $est = Establishment::find($id);
            $est->update($validate);
            $user = User::find($est->user_id);
            $user->name = $request->input('name');;
            $user->save();
            */
    
            return response()->json([
            'status'=>true, 
            'message' => 'Establishment updated successfully.', 
            'data' => $est
        ], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function submitEntryLogs(Request $request, $id){
        try {
            $validate = $request->input(['qr_code']); 
            $tourist = Tourist::where('qr_code', $request->qr_code)->first();
            $log = Log::create(['tourist_id' => $tourist->id, 'establishment_id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Log created',
                'log' => $log
            ], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function viewEntryLogs($id){
        try{
            list($tourists, $date, $time) = $this->getEntryLogs($id);
             return view('establishment.logs')->with('tourists', $tourists)->with('date', $date)->with('time', $time);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
