<?php


use App\Http\Controllers\Katzsimon\Cinema\AppBookingController;
use App\Http\Controllers\Katzsimon\Cinema\AppController;
use App\Http\Controllers\Katzsimon\Cinema\BookingController;
use App\Http\Controllers\Katzsimon\Cinema\CinemaController;
use App\Http\Controllers\Katzsimon\Cinema\FactoryController;
use App\Http\Controllers\Katzsimon\Cinema\ScreeningController;
use App\Http\Controllers\Katzsimon\Cinema\TheatreController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes For Cinemas Package
|--------------------------------------------------------------------------
|

*/

// Admin Routes
Route::group(['prefix'=>'admin', 'middleware' => ['web', 'auth.admin']], function () {
    Route::resource('bookings', BookingController::class, ['as'=>'admin']);
    Route::resource('cinemas', CinemaController::class, ['as'=>'admin']);
    Route::resource('cinemas.theatres', TheatreController::class, ['as'=>'admin']);
    Route::resource('screenings', ScreeningController::class, ['as'=>'admin']);
});






