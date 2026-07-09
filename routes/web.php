<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PublicController::class, 'index'])->name('home');

// --------------------------------------------------------
// ROUTE KHUSUS ADMIN DESA (Membutuhkan Login & Role Admin)
// --------------------------------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// --------------------------------------------------------
// ROUTE KHUSUS ADMIN DESA (Membutuhkan Login & Role Admin)
// --------------------------------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/verify/{id}', [AdminController::class, 'verify'])->name('admin.verify');
});

// --------------------------------------------------------
// ROUTE KHUSUS PELAKU UMKM (Membutuhkan Login & Role UMKM)
// --------------------------------------------------------
Route::middleware(['auth', 'umkm'])->prefix('dashboard')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('umkm.dashboard');
    Route::post('/simpan', [UmkmController::class, 'store'])->name('umkm.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
