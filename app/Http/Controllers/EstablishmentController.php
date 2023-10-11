<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Models\Tourist;
use App\Models\Log;
use DB;

class EstablishmentController extends Controller
{
    public function allEstablishment(){
        $est = Establishment::all();
        return $est;
    }

    public function singleEstablishment($id){
        $est = Establishment::find($id);
        return view('establishment.index', ['est' => $est]);
    }

    public function establishmentHome($id){
        try{
            $est = Establishment::select('name', 'address', 'photo_url')->find($id);
            $logs = Log::all()->where('establishment_id', $id);
            $timestamps = $logs->pluck('created_at');
            $touristID = $logs->pluck('tourist_id');
            $tourists = [];

            foreach ($touristID as $i){
                $idToName = Tourist::where('id', $i)->select(DB::raw('CONCAT(first_name, " ", last_name) as full_name'))->pluck('full_name');
                $tourists = array_merge($tourists, $idToName->toArray());
            }
              
            return view('establishment.home')->with('est', $est)->with('tourists', $tourists)->with('timestamps', $timestamps);
                // ->with('est', $est);
                // ->with('tourists', $tourists)
                // ->with('timestamps', $timestamps);
            // return response()->json(['est' => $est, 'tourists' => $tourists, 'timestamps' => $timestamps], 200);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
