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

Route::get('/views/tabela_estoque', function () {
    return view('tabela_estoque');
})->middleware('auth')->name('tabela_estoque');

// Página do sistema (protegida) - rota principal
Route::get('/system', function () {
    return view('system');
})->middleware('auth')->name('system.page');

// Redireciona a rota antiga para a nova
Route::get('/views/system', function () {
    return redirect()->route('system.page');
})->middleware('auth');

// Registro de clientes
Route::get('/register', [ClienteController::class, 'create'])->name('register');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
