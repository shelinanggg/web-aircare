<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/cari-barang', [ItemController::class, 'publicSearch'])->name('items.public');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes (staff & admin)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/scan/{code}',       [ItemController::class, 'scan'])->name('items.scan');
    Route::get('/barang',            [ItemController::class, 'index'])->name('items.index');
    Route::get('/barang/tambah',     [ItemController::class, 'create'])->name('items.create');
    Route::post('/barang',           [ItemController::class, 'store'])->name('items.store');
    Route::get('/barang/{item}',     [ItemController::class, 'show'])->name('items.show');
    Route::get('/barang/{item}/edit',[ItemController::class, 'edit'])->name('items.edit');
    Route::put('/barang/{item}',     [ItemController::class, 'update'])->name('items.update');
    Route::post('/barang/{item}/claim',   [ItemController::class, 'claim'])->name('items.claim');
    Route::post('/barang/{item}/dispose', [ItemController::class, 'dispose'])->name('items.dispose');
    Route::delete('/barang/{item}',       [ItemController::class, 'destroy'])->name('items.destroy');
});
