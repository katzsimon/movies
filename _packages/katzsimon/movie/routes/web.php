<?php


use App\Http\Controllers\Katzsimon\Movie\AppController;
use App\Http\Controllers\Katzsimon\Movie\FactoryController;
use App\Http\Controllers\Katzsimon\Movie\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes For Movies Package
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix'=>'admin', 'middleware' => ['web', 'auth.admin']], function () {
    Route::get('movies/genre/{genre?}', [MovieController::class, 'index'])->name('admin.movies.index.genre');
    Route::delete('movies/{movie}/screenings', [MovieController::class, 'destroyWithScreenings'])->name('admin.movies.destroy.screenings');
    Route::resource('movies', MovieController::class, ['as'=>'admin']);
    Route::post('factory/movies', [FactoryController::class, 'makeMovie'])->name('admin.factory.movies');
});
