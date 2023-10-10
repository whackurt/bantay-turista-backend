<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Establishment;

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
}
