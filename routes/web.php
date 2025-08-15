<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Login & Register
Route::get('/', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Hanya untuk user login
Route::middleware('auth')->group(function () {

    // Edit profil
    Route::get('/menu/edit-profil', fn() => view('auth.edit-profil'))->name('profile.edit');
    Route::post('/menu/edit-profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Menu utama
    Route::prefix('menu')->group(function () {

        // View items
        Route::middleware('permission:view items')->group(function () {
            Route::view('/dashboard', 'menu.dashboard')->name('dashboard');
            Route::view('/data-barang', 'menu.data-barang')->name('data-barang');
            Route::view('/preview-barang', 'menu.preview-barang')->name('preview-barang');
        });

        // Create items
        Route::get('/tambah-barang', fn() => view('menu.tambah-barang'))
            ->middleware('permission:create items')->name('tambah-barang');

        Route::get('/tambah-kategori', fn() => view('menu.tambah-kategori'))
            ->middleware('permission:create categories')->name('tambah-kategori');

        // Manage users
        Route::middleware('permission:manage users')->group(function () {
            Route::resource('data-user', UserController::class)->names('data-user');
        });
    });
});
