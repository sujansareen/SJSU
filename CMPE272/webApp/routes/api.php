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
Route::group([
    'prefix' => 'user',
], function () {
    Route::get('', 'User\UserController@getList');
    Route::get('/all_companys', 'User\UserController@getListFromAllCompanys');
    Route::post('/signin', 'User\UserController@signin');
});



Route::group([
    'prefix' => 'users',
], function () {
    Route::get('', 'User\UserController@getList');
    Route::get('/all_companys', 'User\UserController@getListFromAllCompanys');
    Route::post('', 'User\UserController@create');
    Route::group([
        'prefix' => '{user_id}',
    ], function (){
        Route::get('', 'User\UserController@details');
        Route::put('', 'User\UserController@update');
        Route::delete('', 'User\UserController@archive');
    });
});
Route::group([
    'prefix' => 'products',
], function () {
    Route::get('', 'Product\ProductController@getList');
    Route::post('', 'Product\ProductController@create');
    Route::group([
        'prefix' => '{product_id}',
    ], function (){
        Route::get('', 'Product\ProductController@details');
        Route::put('', 'Product\ProductController@update');
    });
});