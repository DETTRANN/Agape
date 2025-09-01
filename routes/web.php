<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

// Página inicial
Route::get('/', function () {
    return view('index');
})->name('home');

// Views estáticas auxiliares (acesso simples)
Route::get('/views/login', function () {
    return view('login');
});

Route::get('/views/register', function () {
    return view('register');
});

Route::get('/views/system', function () {
    return view('system');
});

Route::get('/views/contato', function () {
    return view('contato');
});

Route::get('/views/pwdredefinition', function () {
    return view('pwdredefinition');
});

Route::get('/views/pwdreset', function () {
    return view('pwdreset');
});

// Rota POST para processar redefinição de senha (se necessário)
Route::post('/views/pwdredefinition', function () {
    // lógica mínima de exemplo
    return redirect('/views/pwdreset');
});

// Rotas de autenticação (agrupadas)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Página do sistema (protegida)
Route::get('/system', function () {
    return view('system');
})->middleware('auth')->name('system.page');

// Registro de clientes
Route::get('/register', [ClienteController::class, 'create'])->name('register');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
