<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthException;

class AuthService
{
    public function authenticate(string $email, string $password): array
    {
        $user = User::byEmail($email)->first();

        if (!$user || !$user->checkPassword($password)) {
            throw new AuthException('Credenciais inválidas.');
        }

        $user->tokens()->delete();

        $token = $user->createToken('email-dispatcher-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'message' => 'Login realizado com sucesso.'
        ];
    }

    public function logout(): void
    {
        $user = Auth::user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }
    }

    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }

    public function isAuthenticated(): bool
    {
        return Auth::check();
    }
}