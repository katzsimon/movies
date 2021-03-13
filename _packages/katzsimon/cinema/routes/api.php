<?php

use App\Http\Controllers\Katzsimon\Cinema\AppBookingController;
use App\Http\Controllers\Katzsimon\Cinema\AppController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes for Cinemas Package
|--------------------------------------------------------------------------
|
*/



Route::group(['prefix' => 'api', 'middleware' => ['api', config('settings.api_guard')==='sanctum'?'auth:sanctum':'auth:api']], function () {
    Route::get('bookings', [AppBookingController::class, 'userBookings'])->name('api.bookings.user');

    Route::post('booking/cancel/{booking}', [AppBookingController::class, 'cancelBooking'])->name('api.booking.cancel');
    Route::get('booking/movie/{movie}', [AppBookingController::class, 'bookingMovie'])->name('api.booking.movie');
    Route::get('booking/screening/{screening}', [AppBookingController::class, 'bookingScreening'])->name('api.booking.screening');
    Route::get('booking', [AppBookingController::class, 'booking'])->name('api.booking');
    Route::post('booking', [AppBookingController::class, 'handleBooking'])->name('api.booking.handle');
});



Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::get('test', [AppController::class, 'test'])->name('testapi');
    Route::get('upcoming-screenings', [AppController::class, 'indexUpcoming']);
    Route::get('upcoming-movies', [AppController::class, 'upcomingMovies'])->name('api.screenings.movies');
    Route::get('screenings/{movie}', [AppController::class, 'upcomingMovieScreenings'])->name('api.screenings');
    Route::get('cinemas', [AppController::class, 'indexCinemas'])->name('api.cinemas');
});
