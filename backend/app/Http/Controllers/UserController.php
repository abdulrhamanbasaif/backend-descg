<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register(Request $request)
    {
        // Logic to register a new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')) // تشفير كلمة المرور
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    function login(Request $request)
    {
        // Logic to authenticate a user
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Login successful', 'token' => $token], 200);
    }
}
