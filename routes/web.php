<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// auth
Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/menu/edit-profil', function () {
    return view('auth.edit-profil');
});

// menu (hanya untuk yang sudah login)
Route::middleware('auth')->group(function () {

    // Dashboard (bisa diakses semua yang login)
    Route::get('/menu/dashboard', function () {
        return view('menu.dashboard');
    })->middleware('permission:view items');

    // Data Barang (bisa diakses semua yang punya permission view items)
    Route::get('/menu/data-barang', function () {
        return view('menu.data-barang');
    })->middleware('permission:view items');

    // Tambah Barang (bisa diakses semua yang punya permission create items)
    Route::get('/menu/tambah-barang', function () {
        return view('menu.tambah-barang');
    })->middleware('permission:create items');

    // Preview Barang (bisa diakses semua yang punya permission view items)
    Route::get('/menu/preview-barang', function () {
        return view('menu.preview-barang');
    })->middleware('permission:view items');

    // Tambah Kategori (bisa diakses semua yang punya permission create categories)
    Route::get('/menu/tambah-kategori', function () {
        return view('menu.tambah-kategori');
    })->middleware('permission:create categories');

    // Data User (hanya admin yang punya permission manage users)
    Route::get('/menu/data-user', function () {
        return view('menu.data-user');
    })->middleware('permission:manage users');

});



