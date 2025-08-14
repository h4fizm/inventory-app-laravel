<?php

use Illuminate\Support\Facades\Route;

// auth
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/menu/edit-profil', function () {
    return view('auth.edit-profil');
});

// menu
Route::get('/menu/dashboard', function () {
    return view('menu.dashboard');
});
Route::get('/menu/data-barang', function () {
    return view('menu.data-barang');
});
Route::get('/menu/tambah-barang', function () {
    return view('menu.tambah-barang');
});
Route::get('/menu/preview-barang', function () {
    return view('menu.preview-barang');
});
Route::get('/menu/tambah-kategori', function () {
    return view('menu.tambah-kategori');
});
Route::get('/menu/data-user', function () {
    return view('menu.data-user');
});


