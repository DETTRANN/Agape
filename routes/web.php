<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

// Página inicial
Route::get('/', function () {
    return view('index');
})->name('home');

// Rotas de autenticação
Route::get('/login', function () {
    return view('login');
})->name('auth.login.form');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Views estáticas auxiliares (acesso simples)
Route::get('/views/login', function () {
    return redirect()->route('auth.login.form');
});

Route::get('/views/register', function () {
    return view('register');
});

// Rotas protegidas - apenas para usuários autenticados
Route::middleware(['auth', 'force.auth'])->group(function () {
    // Página do sistema (protegida) - rota principal
    Route::get('/system', function () {
        return view('system');
    })->name('system.page');

    // Tabela de estoque
    Route::get('/views/tabela_estoque', function () {
        return view('tabela_estoque');
    })->name('tabela_estoque');

    // Redireciona a rota antiga para a nova
    Route::get('/views/system', function () {
        return redirect()->route('system.page');
    });
});

// Registro de clientes
Route::get('/register', [ClienteController::class, 'create'])->name('register');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// Rota de teste para verificar autenticação
Route::get('/auth-test', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'guard' => config('auth.defaults.guard')
    ]);
});

// Rota para forçar logout (teste)
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return response()->json(['message' => 'Logout realizado']);
});
