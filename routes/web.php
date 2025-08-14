<?php

use Illuminate\Support\Facades\Route;

// auth
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});

// menu
Route::get('/menu/dashboard', function () {
    return view('menu.dashboard');
});

