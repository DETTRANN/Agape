<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthRepositoryInterface;

class AuthController extends Controller
{
    public function __construct(private AuthRepositoryInterface $auth)
    {
        //
    }

    /**
     * Exibe o formulário de login
     */
    public function showLoginForm()
    {
        return view('login'); // certifique-se que o arquivo resources/views/login.blade.php existe
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        \Log::info('Tentativa de login', ['email' => $credentials['email']]);

        if ($this->auth->attemptLogin($credentials['email'], $credentials['password'])) {
            // Regenera a sessão para evitar fixation
            $request->session()->regenerate();
            \Log::info('Login bem-sucedido, redirecionando para system.page');
            
            // Debug: testar redirecionamento direto
            return redirect('/system')->with('success', 'Login realizado com sucesso!');
        }

        \Log::info('Login falhou');
        return back()
            ->withErrors(['email' => 'Credenciais inválidas'])
            ->onlyInput('email');
    }

    /**
     * Efetua logout
     */
    public function logout(Request $request)
    {
        $this->auth->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login.form');
    }
}
