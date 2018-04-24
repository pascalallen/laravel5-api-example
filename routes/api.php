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

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');

// Route::group(['middleware' => 'auth:api'], function() {
    Route::get('properties', 'PropertyController@index');
    Route::get('properties/{property}', 'PropertyController@show');
    Route::post('properties', 'PropertyController@store');
    Route::post('properties/find-multiple', 'PropertyController@findMultiple');
    Route::put('properties/{property}', 'PropertyController@update');
    Route::delete('properties/{property}', 'PropertyController@delete');

    Route::get('reservations', 'ReservationController@index');
    Route::get('reservations/{reservation}', 'ReservationController@show');
    Route::post('reservations', 'ReservationController@store');
    Route::post('reservations/find', 'ReservationController@findByDate');
    Route::put('reservations/{reservation}', 'ReservationController@update');
    Route::delete('reservations/{reservation}', 'ReservationController@delete');
// });
