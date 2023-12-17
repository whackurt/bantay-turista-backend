<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function createSchedule(Request $request)
    {
        try {
            $schedule = $request->only([
                'type',
                'scheduleUrl',
            ]);

            $newSchedule = Schedule::create($schedule);

            return response()->json([
                'status' => 'success',
                'message' => 'Schedule created successfully.',
                'schedule' => $newSchedule
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllSchedules()
    {
        try {
            $schedules = Schedule::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Schedules fetched successfully.',
                'schedules' => $schedules
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getScheduleById(string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
        
            return response()->json([
                'status' => 'success',
                'message' => 'Schedule fetched successfully.',
                'schedule' => $schedule
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function updateSchedule(Request $request, string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if(!$schedule){
                return response()->json([
                    'status'=>false, 
                    'message' => 'schedule does not exist.'
                ], 404);
            }

            $validated = $request->validate([
                'type' => 'sometimes|string',
                'scheduleUrl' => 'sometimes|string',
            ]);

            $schedule->fill($validated);
            $schedule->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Schedule updated successfully.',
                'schedule' => $schedule
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function deleteSchedule(string $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);

            if(!$schedule){
                return response()->json([
                    'status'=>false, 
                    'message' => 'Schedule does not exist.'
                ], 404);
            }

            $schedule->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Schedule deleted successfully.',
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
