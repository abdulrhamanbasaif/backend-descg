<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Add this line
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register(request $request)
    {
        // Logic to register a new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);

    }

    function login(request $request)
    {
        // Logic to authenticate a user
        $user = User::where('email', $request->input('email'))->first();
        $pass = hash::check($request->input('password'), $user->password);

        if(!$user&& !$pass) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message' => 'Login successful', 'token' => $token], 200);
    }
}
