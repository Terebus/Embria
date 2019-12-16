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

Route::namespace('Api')->group(function () {
    Route::group(['prefix' => 'news'], function () {
        Route::get('get', 'NewsController@get');
        Route::post('delete', 'NewsController@delete')->middleware('auth');
        Route::post('update', 'NewsController@update')->middleware('auth');
        Route::post('add', 'NewsController@create')->middleware('auth');
    });

    Route::group(['prefix' => 'photos'], function () {
       Route::get('get','PhotosController@get');
       Route::post('add', 'PhotosController@create')->middleware('auth');
       Route::post('delete', 'PhotosController@delete')->middleware('auth');
    });

    Route::post('like','LikesController@like')->middleware('auth');
});
