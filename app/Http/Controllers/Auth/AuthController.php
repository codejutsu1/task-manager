<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLoginRequest;

class AuthController extends Controller
{
    public function login(StoreLoginRequest $request)
    {
        if(!Auth::attempt($request->validated())){
            return response()->json([
                'message' => 'Login Information invalid'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer'
        ]);

    }
}
