<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\Establishment;
use App\Models\Tourist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    private function generateUniqueQRCode()
    {
        $date = Carbon::now();
        $check = false;

        while (!$check){
            $qr_code = 'BT' . $date->day . Str::random(4) . $date->minute . $date->second;
            $findQR = Tourist::where('qr_code', $qr_code)->first();
            if(!$findQR){
                $check = true;
            }
        }
        
        return $qr_code;
    }

    public function createUser(Request $request)
    {
        try {
            //Validated
            if ($request->user_type == 1 || $request->user_type == 3) {
                $request['name'] = $request->first_name . ' ' . $request->last_name;
            }

            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $request['user_id'] = $user->id;

            if ($user->id) {

                $creds = $request->except(['email', 'password', 'user_type']);

                if ($request->user_type == 1) {
                    
                    $creds['qr_code'] = $this->generateuniqueQRCode();                   
                    Tourist::create($creds);

                } else if ($request->user_type == 2) {

                    Establishment::create($creds);

                } else if ($request->user_type == 3) {

                    Admin::create($creds);

                }
            }

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);

    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}