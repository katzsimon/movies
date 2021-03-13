<?php

use App\Http\Controllers\Katzsimon\Auth\AppAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Authentication
|--------------------------------------------------------------------------
|
|
*/




Route::group(['prefix' => 'api'], function () {

    Route::post('login', [AppAuthController::class, 'handleLogin']);
    Route::post('register', [AppAuthController::class, 'handleRegister']);

    Route::group(['middleware' => [config('settings.api_guard')==='sanctum'?'auth:sanctum':'auth:api']], function () {
        Route::post('logout', [AppAuthController::class, 'logout']);
        Route::get('auth-status', [AppAuthController::class, 'status']);
    });

});
