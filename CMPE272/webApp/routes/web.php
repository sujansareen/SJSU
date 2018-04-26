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
        "img"=>$user_info[2]
    ];
});


$data = [
    "info"=>$info,
    "cards"=>$cards,
    "contents"=>$contents,
    "contacts"=>$contacts
];
Route::get('/welcome', function () {
    return view('welcome');
});

Route::group([], function () use ($data){
    Route::get('/', function () {
        return view('containers.home');
    });
    Route::get('/about', function () use ($data){
        return view('containers.about',$data);
    });
    Route::get('/services', function ()  use ($data){
        return view('containers.services',$data);
    });
    Route::get('/products/{id}', function ($id) use ($data){
        $data['product_id'] = $id;
        return view('containers.product',$data);
    });
    Route::get('/news', function () {
        return view('containers.news');
    });
    Route::get('/contacts', function () use ($data){
        return view('containers.contact',$data);
    });
    Route::get('/user', function () use ($data){
        return view('containers.user',$data);
    });
    Route::get('/company', function () use ($data){
        return view('containers.all_users',$data);
    });
});