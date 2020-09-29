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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/restaurant/menu', 'App\Http\Controllers\RestaurantController@createMenu');
Route::get('/restaurant/menu', 'App\Http\Controllers\RestaurantController@index');
Route::post('/restaurant/menu/edit', 'App\Http\Controllers\RestaurantController@editMenu');
Route::post('restaurant/menu/delete', 'App\Http\Controllers\RestaurantController@deleteMenu');


Route::get('/restaurant/items', 'App\Http\Controllers\RestaurantController@getAllItems');
Route::post('/restaurant/items', 'App\Http\Controllers\RestaurantController@createItem');
Route::post('/restaurant/items/delete', 'App\Http\Controllers\RestaurantController@createItem');