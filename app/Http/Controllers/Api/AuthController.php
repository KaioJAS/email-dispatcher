<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Exceptions\AuthException;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->authenticate(
                $request->email,
                $request->password
            );

            return response()->json([
                'success' => true,
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
                'token_type' => 'Bearer',
                'message' => $result['message']
            ]);

        } catch (AuthException $e) {
            throw $e;
        }
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    public function me()
    {
        if (!$this->authService->isAuthenticated()) {
            return response()->json([
                'success' => false,
                'message' => 'Não autenticado.'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => new UserResource($this->authService->getAuthenticatedUser())
        ]);
    }
}