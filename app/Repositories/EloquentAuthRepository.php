<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class EloquentAuthRepository implements AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
