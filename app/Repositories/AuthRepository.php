<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;

class AuthRepository implements AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool
    {
        \Log::info('AuthRepository: Iniciando attemptLogin', ['email' => $email]);
        
        // Busca o cliente pelo email
        $cliente = Cliente::where('email', $email)->first();
        
        if (!$cliente) {
            \Log::info('AuthRepository: Cliente não encontrado');
            return false;
        }
        
        \Log::info('AuthRepository: Cliente encontrado', ['cliente_id' => $cliente->id]);
        
        // Verifica se a senha está correta
        if (Hash::check($password, $cliente->senha)) {
            \Log::info('AuthRepository: Senha correta, fazendo login');
            Auth::login($cliente);
            return true;
        }
        
        \Log::info('AuthRepository: Senha incorreta');
        return false;
    }

    public function logout(): void
    {
        Auth::logout();
    }

}
