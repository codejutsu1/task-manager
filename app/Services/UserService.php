<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function createUser($validated): JsonResponse
    {
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return response()->json([
            'data' => new UserResource($user),
            'token' => $token,
            'token_type' => 'bearer'
        ], 201);
    }
}