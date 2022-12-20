<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success(data: [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ]);
        } else {
            return $this->unauthorized('Invalid credentials');
        }
    }

    public function getAuthUser()
    {
        $user = Auth::user();

        return $this->success(data: new UserResource($user));
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success();
    }
}
