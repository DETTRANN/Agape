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