<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool
    {
        // Usa o provider padrão do Laravel para autenticação
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function logout(): void
    {
        Auth::logout();
    }

}
