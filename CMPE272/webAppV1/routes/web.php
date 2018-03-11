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
$info = [
    ["title"=>"Duplicates & storage made easy", "msg"=>"you can create inexpensive backups and copies of your irreplaceable memories"],
    ["title"=>"Analog players are obsolete & unavailable", "msg"=>"Old analog equipment can be unreliable and viewing can sometimes damage fragile analog media."],
    ["title"=>"Digital means forever", "msg"=>"Digital formats don't degrade overtime, unlike analog formats."],
    ["title"=>"Find special moments easily", "msg"=>"DVDs allow you to quickly access the videos you want to see and share."],
    ["title"=>"Share memories & connect with people", "msg"=>"share home movies and slides with family and friends via email, Web galleries, Facebook"],
    ["title"=>"Instant access anytime, anywhere", "msg"=>"you can view digitized memories on your PC, Mac, iPhone, iPad or Android mobile devices"]
];


Route::group([], function () use ($info){
    Route::get('/', function () {
        return view('containers.home');
    });
    Route::get('/about', function () use ($info){
        return view('containers.about',['info' => $info]);
    });
    Route::get('/services', function () {
        return view('containers.services');
    });
    Route::get('/news', function () {
        return view('containers.news');
    });
    Route::get('/contacts', function () {
        return view('containers.contact');
    });
});