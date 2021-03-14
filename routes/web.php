<?php

use App\Http\Controllers\Katzsimon\Movie\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'admin', 'middleware' => ['web', 'auth.admin']], function () {
    Route::delete('movies/{movie}/screenings', [MovieController::class, 'destroyWithScreenings'])->name('admin.movies.destroy.screenings');
});
