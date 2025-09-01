<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool;
    public function logout(): void;
}
