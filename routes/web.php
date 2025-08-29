<?php

use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('index');
    });

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
        // Aqui você pode adicionar lógica para processar o email
        return redirect('/views/pwdreset');
    });