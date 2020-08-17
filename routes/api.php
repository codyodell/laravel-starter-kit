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

Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');

/* Products */
Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');
Route::post('/products', 'ProductController@store');
Route::put('/products/{id}', 'ProductController@update');
Route::delete('/products/{id}', 'ProductController@delete');

/* Categories */
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{id}', 'CategoryController@show');
Route::post('/categories', 'CategoryController@store');
Route::put('/categories/{id}', 'CategoryController@update');
Route::delete('/categories/{id}', 'CategoryController@delete');

/* Brands */
Route::get('/brands', 'BrandController@index');
Route::get('/brands/{id}', 'BrandController@show');
Route::post('/brands', 'BrandController@store');
Route::put('/brands/{id}', 'BrandController@update');
Route::delete('/brands/{id}', 'BrandController@delete');
