<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'device_id' => 'required|unique:users',
            'password' => 'required|string',
        ]);
 

        $user = User::create([
            'name' => $validatedData['name'],
            'company_id' => $request->company_id,
            'salesman_id' => $request->salesman_id,
            // 'just_kashf' => "tt",
            'device_id' => $request->device_id,
            'just' => $request->just,
            'email' => $request->email,
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'true',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function login(Request $request)
    {
         $credentials = $request->validate([
            'name' => ['required'],
            'device_id' => ['required'],
            'password' => ['required'],
        ]);
        
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('device_id', $request['device_id'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'true',
            'access_token' => $token,
            'token_type' => 'Bearer',
            "data" => $user,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'true'
        ]);
    }
}
