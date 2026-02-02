<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        // (Opsional) kalau mau 1 device = 1 token, hapus token lama bernama sama:
        // $user->tokens()->where('name', $validated['device_name'] ?? 'api-token')->delete();

        $tokenName = $validated['device_name'] ?? 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        // revoke token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out.',
        ]);
    }

    public function logoutAll(Request $request)
    {
        // revoke semua token milik user
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out from all devices.',
        ]);
    }
}
