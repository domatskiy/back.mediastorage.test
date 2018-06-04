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

Route::get('', function () {
    return ['uploaded'];
    });

Route::get('uploaded/{user_hash}/{file_hash}', 'MediaStorageController@get');

Route::middleware('msuser')->group(function () {
    Route::post('upload', 'MediaStorageController@upload');
});
