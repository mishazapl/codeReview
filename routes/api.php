<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API version 1.
 */

Route::prefix('/v1')->group(function () {

    /**
     * Роуты авторизации.
     */

    Route::prefix('/user')->group(function () {

        Route::middleware('redisUnRegister')->post('/register', 'auth\RegisterController@store');

        Route::middleware('redisUnRegister')->post('/auth', 'auth\LoginController@store');

    });

});
