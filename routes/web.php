<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute default yang akan mengarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes (Login & Register)
// Prefix untuk menghindari konflik nama route.
Route::prefix('auth')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/edit', fn() => view('auth.edit-profil'))->name('profile.edit');
        Route::post('/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    });

    // Main Menu Routes
    Route::prefix('menu')->group(function () {

        // Permission untuk melihat data barang
        Route::middleware('permission:view items')->group(function () {
            Route::get('/dashboard', fn() => view('menu.dashboard'))->name('dashboard');
            Route::get('/preview-barang', fn() => view('menu.preview-barang'))->name('preview-barang');
            Route::get('/data-barang', [BarangController::class, 'index'])->name('data-barang');
        });

        // Permission untuk mengedit data barang
        Route::middleware('permission:edit items')->group(function () {
            // Mengganti parameter {id} menjadi {barang} untuk konsistensi dengan Route Model Binding
            Route::put('/data-barang/{barang}', [BarangController::class, 'update'])->name('data-barang.update');
        });

        // Permission untuk menghapus data barang
        Route::middleware('permission:delete items')->group(function () {
            // Mengganti parameter {id} menjadi {barang} untuk konsistensi dengan Route Model Binding
            Route::delete('/data-barang/{barang}', [BarangController::class, 'destroy'])->name('data-barang.destroy');
        });

        // Category Management (Permission: view|create|edit|delete categories)
        Route::middleware('permission:view categories|create categories|edit categories|delete categories')->group(function () {
            Route::get('/manage-kategori', [KategoriController::class, 'index'])->name('kategori.index');
            Route::post('/manage-kategori', [KategoriController::class, 'store'])->name('kategori.store');
            // Mengganti parameter {id} menjadi {kategori} untuk konsistensi dengan Route Model Binding
            Route::put('/manage-kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
            // Mengganti parameter {id} menjadi {kategori} untuk konsistensi dengan Route Model Binding
            Route::delete('/manage-kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        });

        // User Management (Permission: manage users)
        Route::middleware('permission:manage users')->group(function () {
            Route::resource('data-user', UserController::class)->names('data-user');
        });
    });
});