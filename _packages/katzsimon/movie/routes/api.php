<?php

use App\Http\Controllers\Katzsimon\Movie\AppController;
use App\Http\Controllers\Katzsimon\Movie\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Movies Pakcage
|--------------------------------------------------------------------------
|
|
*/


Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::get('movies', [AppController::class, 'movies'])->name('api.movies');
});
