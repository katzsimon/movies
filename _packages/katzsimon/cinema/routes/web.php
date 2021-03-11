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
    Route::post('booking/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('admin.bookings.cancel');
    Route::resource('bookings', BookingController::class, ['as'=>'admin']);
    Route::resource('cinemas', CinemaController::class, ['as'=>'admin']);
    Route::resource('cinemas.theatres', TheatreController::class, ['as'=>'admin']);
    Route::resource('screenings', ScreeningController::class, ['as'=>'admin']);

    Route::post('factory/screenings', [FactoryController::class, 'makeScreenings'])->name('admin.factory.screenings');
    Route::post('factory/bookings', [FactoryController::class, 'makeBookings'])->name('admin.factory.bookings');
});



// App Routes
Route::group(['middleware' => ['web']], function () {
    Route::get('cinemas', [AppController::class, 'indexCinemas'])->name('cinemas');
    Route::get('upcoming-movies', [AppController::class, 'upcomingMovies'])->name('movies.upcoming');
    Route::get('screenings/{movie}', [AppController::class, 'upcomingMovieScreenings'])->name('screenings');

    Route::group(['middleware' => ['auth']], function () {
        Route::post('booking', [AppBookingController::class, 'handleBooking'])->name('booking.handle');
        Route::post('booking/cancel/{booking}', [AppBookingController::class, 'cancelBooking'])->name('booking.cancel');
        Route::get('booking/movie/{movie}', [AppBookingController::class, 'bookingMovie'])->name('booking.movie');
        Route::get('booking/screening/{screening}', [AppBookingController::class, 'bookingScreening'])->name('booking.screening');
        Route::get('booking', [AppBookingController::class, 'booking'])->name('booking');
    });

});


