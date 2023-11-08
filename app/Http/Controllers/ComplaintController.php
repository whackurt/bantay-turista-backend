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

    public function createComplaint(Request $request)
    {
        $details = $request->only([
            'tourist_id',
            'description',
            'response',
            'resolved'
        ]);

        $complaint = Complaint::create($details);

        return response()->json([
            'status' => 'success',
            'message' => 'Complaint successfully created.',
            'complaint' => $complaint
        ], 201);
    }
}