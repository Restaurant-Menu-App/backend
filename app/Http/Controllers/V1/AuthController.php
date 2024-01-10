<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => "required|email|unique:users,email",
            'password' => "required|min:8"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            "password" => Hash::make($request->password)
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $token = Auth::user()->createToken('restaurant_menus')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['message' => "User Not Found."], 401);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $token = Auth::user()->createToken('phone')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['message' => "User Not Found."], 401);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['You logout.'], 204);
    }
}
