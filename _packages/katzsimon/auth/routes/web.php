<?php

use App\Http\Controllers\Katzsimon\Auth\AppAuthController;
use App\Http\Controllers\Katzsimon\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes For Authentication
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix'=>'admin', 'middleware' => ['web']], function () {
    Route::get('register', [AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('register', [AdminAuthController::class, 'handleRegister'])->name('admin.register.handle');
    Route::get('login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'handleLogin'])->name('admin.login.handle');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::group(['middleware' => ['web']], function () {
    Route::get('register', [AppAuthController::class, 'register'])->name('register');
    Route::post('register', [AppAuthController::class, 'handleRegister'])->name('register.handle');
    Route::get('login', [AppAuthController::class, 'login'])->name('login');
    Route::post('login', [AppAuthController::class, 'handleLogin'])->name('login.handle');
    Route::get('logout', [AppAuthController::class, 'logout'])->name('logout');
});
