<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return $this->notAuth();
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
        ]);
    }

    private function notAuth()
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                'password' => [
                    'Invalid credentials'
                ],
            ]
        ], 422);
    }
}
