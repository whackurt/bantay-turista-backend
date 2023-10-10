<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function allComplaints(){
        $complaints = Complaint::all();
        return view('complaint.index', ['complaints' => $complaints]);
    }
}