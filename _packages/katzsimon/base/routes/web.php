<?php


/*
|--------------------------------------------------------------------------
| Web Routes For Base
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Katzsimon\Base\AdminController;
use App\Http\Controllers\Katzsimon\Base\AppController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin', 'middleware' => ['web']], function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth.admin');
});


Route::group(['middleware' => ['web']], function () {
    Route::get('/', [AppController::class, 'home'])->name('home');
    Route::get('account', [AppController::class, 'account'])->name('account')->middleware(['auth']);
});

