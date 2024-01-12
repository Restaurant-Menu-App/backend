<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric|unique:users,phone|digits_between:5,11',
            'email' => "nullable|email|unique:users,email",
            'password' => "required|min:8",
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            "password" => Hash::make($request->password),
            'role_id' => $request->role
        ]);

        if (Auth::attempt($request->only(['phone', 'password']))) {
            $token = Auth::user()->createToken('restaurant_menus')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['message' => "User Not Found."], 401);
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:8'
    //     ]);

    //     if (Auth::attempt($request->only(['email', 'password']))) {
    //         $token = Auth::user()->createToken('phone')->plainTextToken;
    //         return response()->json(['token' => $token], 200);
    //     }
    //     return response()->json(['message' => "User Not Found."], 401);
    // }

    public function login(Request $request)
    {

        $request->validate([
            'credentials' => 'required|string',
            'password' => "required"
        ]);

        $user = User::where('name', $request->credentials)
            ->orWhere('phone', $request->credentials)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'These Credentials do not match.'
            ], 402);
        }

        $token = $user->createToken('restaurant_menus')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['You logout.']);
    }
}
