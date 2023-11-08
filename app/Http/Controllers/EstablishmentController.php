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

    public function allEstablishment(){
        $est = Establishment::all();
        return $est;
    }

    public function singleEstablishment($id){
        $est = Establishment::find($id);
        return view('establishment.index', ['est' => $est]);
    }

    public function establishmentHome($id){
        try {
            $est = Establishment::select('name', 'address', 'photo_url')->find($id);

            if(!$est){
                return response()->json(['message' => 'Establishment ID does not exist.'], 404);
            }

            list($tourists, $date, $time) = $this->getEntryLogs($id);
              
            return view('establishment.home')->with('est', $est)->with('tourists', $tourists)->with('date', $date)->with('time', $time);
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
            $validate = $request->validate([
                'name' => 'sometimes|string',
                'address' => 'sometimes|string',
                'contact_number' => 'sometimes|integer',
                'owner_name' => 'sometimes|string',
                'owner_email' => 'sometimes|email',
                'owner_phone' => 'sometimes|integer',
                'photo_url' => 'sometimes',
            ]);    

            $est = Establishment::find($id);
            $est->update($validate);
            $user = User::find($est->user_id);
            $user->name = $request->input('name');;
            $user->save();
    
    
            return response()->json(['data' => $est], 200);
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
