<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
$data = [ "info"=>[],"cards"=>[],"contents"=>[],"contacts"=>[] ];

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group([], function () use ($data){
    Route::get('/', 'HomeController@home')->name('main');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/services', 'HomeController@services')->name('services');
    Route::get('/products/{id}', 'HomeController@productDetail')->name('productDetail');
    Route::get('/news', 'HomeController@news')->name('news');
    Route::get('/contacts', 'HomeController@contact')->name('contact');
    Route::get('/user', 'HomeController@user')->name('user');
    Route::get('/company', 'HomeController@all_users')->name('all_users');
});
Auth::routes();











/**
 *
//TODO: move to stub data init
$info = [
    ["title"=>"Duplicates & storage made easy", "msg"=>"you can create inexpensive backups and copies of your irreplaceable memories"],
    ["title"=>"Analog players are obsolete & unavailable", "msg"=>"Old analog equipment can be unreliable and viewing can sometimes damage fragile analog media."],
    ["title"=>"Digital means forever", "msg"=>"Digital formats don't degrade overtime, unlike analog formats."],
    ["title"=>"Find special moments easily", "msg"=>"DVDs allow you to quickly access the videos you want to see and share."],
    ["title"=>"Share memories & connect with people", "msg"=>"share home movies and slides with family and friends via email, Web galleries, Facebook"],
    ["title"=>"Instant access anytime, anywhere", "msg"=>"you can view digitized memories on your PC, Mac, iPhone, iPad or Android mobile devices"]
];

$cards = [
    ["header"=>"HD Videos", "img"=>"images/usb_sd_card_types.png", "price"=>"$9.99" ,"list"=>["USB / DVD / SD Cards"]],
    ["header"=>"Videotapes", "img"=>"images/video_types.png", "price"=>"$14.99" ,"list"=>["VHS / VHS-C / Hi8"]],
    ["header"=>"Photos", "img"=>"images/photo_types.png", "price"=>"$19.99" ,"list"=>[]],
];
$contents = [ "1 Washington Sq","San Jose, CA 95192"," montoya33@live.com]"];

$filename = './resources/views/stubData/contacts.txt';
if (!file_exists($filename)) {
    $filename = '.'.'./resources/views/stubData/contacts.txt';
}
$contacts_file = file($filename);
$contacts_collection = collect($contacts_file);

$contacts = $contacts_collection->map(function ($item, $key) {
    $user_info = explode(",", $item);
    return [
        "full_name"=>$user_info[0],
        "title"=>$user_info[1],
        "img"=> trim($user_info[2])
    ];
});


 */
