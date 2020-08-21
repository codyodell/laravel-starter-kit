<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middlewarroup. Now create something great!
|
*/


Route::get('/', 'Front\\HomeController@index')->name('front.home');
Route::get('files/{id}/preview', 'Front\\FileController@filePreview')->name('front.file.preview');
Route::get('files/{id}/download', 'Front\\FileController@fileDownload')->name('front.file.download');

Auth::routes();

// admin
Route::prefix('admin')->namespace('Admin')->group(function () {
    // single page
    Route::get('/', 'SinglePageController@displaySPA')->name('admin.spa');
    // resource routes
    Route::resource('users', 'UserController');
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');
    Route::resource('brands', 'BrandController');
    Route::resource('groups', 'GroupController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('files', 'FileController');
    Route::resource('file-groups', 'FileGroupController');
});
