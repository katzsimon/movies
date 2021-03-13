<?php

use App\Http\Controllers\Katzsimon\Base\AppController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Base
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'api', 'middleware'=>['api']], function () {

    Route::get('home/user', [AppController::class, 'home'])->name('api.home.auth')->middleware(config('settings.api_guard')==='sanctum'?'auth:sanctum':'auth:api');
    Route::get('home', [AppController::class, 'home'])->name('api.home');

});
