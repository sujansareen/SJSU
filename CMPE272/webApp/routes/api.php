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

Route::post('user/signin', 'User\UserController@signinHandler');

Route::group([
    'prefix' => 'users',
], function () {
    Route::get('', 'User\UserController@getListHandler');
    Route::get('/all_companys', 'User\UserController@getListFromAllCompanysHandler');
    Route::post('', 'User\UserController@createHandler');
    Route::group([
        'prefix' => '{user_id}',
    ], function (){
        Route::get('', 'User\UserController@detailsHandler');
        Route::put('', 'User\UserController@updateHandler');
        Route::delete('', 'User\UserController@archiveHandler');
    });
});
Route::group([
    'prefix' => 'companies',
], function () {
    Route::get('', 'Company\CompanyController@getListHandler');
    Route::post('', 'Company\CompanyController@createHandler');
    Route::group([
        'prefix' => '{company_id}',
    ], function (){
        Route::get('', 'Company\CompanyController@detailsHandler');
        Route::put('', 'Company\CompanyController@updateHandler');
        Route::delete('', 'Company\CompanyController@archiveHandler');
    });
});
Route::group([
    'prefix' => 'products',
], function () {
    Route::get('', 'Product\ProductController@getListHandler');
    Route::post('', 'Product\ProductController@createHandler');
    Route::group([
        'prefix' => '{product_id}',
    ], function (){
        Route::get('', 'Product\ProductController@detailsHandler');
        Route::put('', 'Product\ProductController@updateHandler');
        Route::delete('', 'Product\ProductController@archiveHandler');
        Route::group([
            'prefix' => 'reviews',
            ], function () {
            Route::get('', 'Product\ReviewController@getListHandler');
            Route::post('', 'Product\ReviewController@createHandler');
            Route::group([
                'prefix' => '{review_id}',
            ], function (){
                Route::get('', 'Product\ReviewController@detailsHandler');
                Route::put('', 'Product\ReviewController@updateHandler');
                Route::delete('', 'Product\ReviewController@archiveHandler');
            });
        });
    });
});