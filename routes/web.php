<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');

})->name('home');


Route::get('/cari-barang', [ItemController::class, 'publicSearch'])
    ->name('items.public');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

});


Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | QR SCAN
    |--------------------------------------------------------------------------
    */

    Route::get('/scan/{code}', [ItemController::class, 'scan'])
        ->name('items.scan');


    /*
    |--------------------------------------------------------------------------
    | ITEMS / BARANG
    |--------------------------------------------------------------------------
    */

    Route::get('/barang', [ItemController::class, 'index'])
        ->name('items.index');

    Route::get('/barang/tambah', [ItemController::class, 'create'])
        ->name('items.create');

    Route::post('/barang', [ItemController::class, 'store'])
        ->name('items.store');

    Route::get('/barang/{item}', [ItemController::class, 'show'])
        ->name('items.show');

    Route::get('/barang/{item}/edit', [ItemController::class, 'edit'])
        ->name('items.edit');

    Route::put('/barang/{item}', [ItemController::class, 'update'])
        ->name('items.update');

    Route::post('/barang/{item}/claim', [ItemController::class, 'claim'])
        ->name('items.claim');

    Route::post('/barang/{item}/dispose', [ItemController::class, 'dispose'])
        ->name('items.dispose');

    Route::delete('/barang/{item}', [ItemController::class, 'destroy'])
        ->name('items.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | MASTER KATEGORI
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class);


        /*
        |--------------------------------------------------------------------------
        | MASTER USER
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);

    });

});