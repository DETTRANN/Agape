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

        if ($this->auth->attemptLogin($credentials['email'], $credentials['password'])) {
            // Regenera a sessão para evitar fixation
            $request->session()->regenerate();
            return redirect()->route('system.page'); // <- certifique-se que essa rota existe
        }

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
