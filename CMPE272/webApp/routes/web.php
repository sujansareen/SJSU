<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {

    Route::get('/', function () {
        return view('services');
    });
    Route::get('/about', function () {
        return view('services');
    });

    Route::get('/services', function () {
        return view('services');
    });
    Route::get('/news', function () {
        return view('services');
    });
    Route::get('/contacts', function () {
        return view('services');
    });
});