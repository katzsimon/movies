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
    Route::resource('movies', MovieController::class, ['as'=>'admin']);
});
