<?php

namespace App\Http\Controllers\API;

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
        // tourist
        if ($request->user_type == 1) {

        }

        // establishment
        if ($request->user_type == 2) {

        }

        // admin
        if ($request->user_type == 3) {

        }

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
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    public function register(Request $request)
    {
        // tourist
        if ($request->user_type == 1) {
            $new_tourist = Tourist::create($request->data);
            if ($new_tourist) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Tourist registered successfully.',
                    'data' => $new_tourist
                ], 200);
            }
            return response()->isServerError();
        }

        // establishment
        if ($request->user_type == 2) {

        }
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