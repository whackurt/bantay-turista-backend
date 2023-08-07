<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Establishment;
use App\Models\Tourist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'create']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => ($request->user_type == 1 || $request->user_type == 3) ? ($request->first_name . ' ' . $request->last_name) : $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $request['user_id'] = $user->id;

        if ($user->id) {

            $creds = $request->except(['email', 'password', 'user_type']);

            if ($request->user_type == 1) {

                Tourist::create($creds);

            } else if ($request->user_type == 2) {

                Establishment::create($creds);

            } else if ($request->user_type == 3) {

                Admin::create($creds);

            }
        }

        return response()->json([
            'status' => "success",
            'message' => 'User successfully registered.',
        ], 201);
    }

    public function logout()
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