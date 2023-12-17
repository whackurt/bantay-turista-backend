<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function createFeedback(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tourist_id' => 'required|integer',
                'rating' => 'required|integer|min:1|max:5',
                'comment_suggestion' => 'nullable|string' 
            ]);

            $feedback = new Feedback();
            $feedback->tourist_id = $validatedData['tourist_id'];
            $feedback->rating = $validatedData['rating'];
            $feedback->comment_suggestion = $validatedData['comment_suggestion'];

            $feedback->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback created successfully.',
                'feedback' => $feedback
            ], 201); 

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);        
        }
    }

    public function getAllFeedback()
    {
        try {
            $feedback = Feedback::all();

            return response()->json([
                'status' => 'success',
                'message' => 'All feedback fetched successfully.',
                'feedback' => $feedback
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getFeedbackById($id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found.'
                ], 404); 
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback fetched successfully.',
                'feedback' => $feedback
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500); // Return 500 status code for internal server error
        }
    }
    public function deleteFeedback($id)
    {
        try {
            $feedback = Feedback::find($id);

            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found.'
                ], 404); 
            }

            $feedback->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback deleted successfully.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500); // Return 500 status code for internal server error
        }
    }
}
