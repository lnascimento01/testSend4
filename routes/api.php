<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'AuthenticationController@register');
Route::post('login', 'AuthenticationController@login');
Route::get('logout', 'AuthenticationController@logout');
Route::get('user', 'AuthenticationController@getAuthUser');

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('/')->group(function () {
        Route::get('/', 'HomeController@index');
        Route::get('wishlist', 'WishlistController@getFavs');
        Route::post('wishlist', 'WishlistController@handleFav');
    });
});
