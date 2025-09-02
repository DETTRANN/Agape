<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\AuthRepositoryInterface;
use Exception;

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
        if (Auth::check()) {
            return redirect()->route('system.page');
        }
        return view('login');
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            Log::info('Tentativa de login', ['email' => $credentials['email']]);

            if ($this->auth->attemptLogin($credentials['email'], $credentials['password'])) {
                $request->session()->regenerate();
                Log::info('Login bem-sucedido', ['user' => Auth::id()]);
                
                return redirect()
                    ->intended(route('system.page'))
                    ->with('success', 'Login realizado com sucesso!');
            }

            Log::warning('Falha no login', ['email' => $credentials['email']]);
            return back()
                ->withErrors(['email' => 'Credenciais inválidas'])
                ->withInput($request->only('email'));
        } catch (Exception $e) {
            Log::error('Erro no login', [
                'error' => $e->getMessage(),
                'email' => $request->input('email')
            ]);
            
            return back()
                ->withErrors(['error' => 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.'])
                ->withInput($request->only('email'));
        }
    }

    /**
     * Efetua logout
     */
    public function logout(Request $request)
    {
        try {
            $userId = Auth::id(); // Guarda o ID do usuário antes do logout
            
            $this->auth->logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            Log::info('Logout realizado com sucesso', ['user_id' => $userId]);
            
            return redirect()
                ->route('auth.login.form')
                ->with('success', 'Logout realizado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro no logout', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao fazer logout. Por favor, tente novamente.');
        }
    }
}
