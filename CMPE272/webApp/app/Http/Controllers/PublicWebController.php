<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Visited as Visited;

class PublicWebController extends Controller {
    public function __construct() {
    }
    public function home(Request $request, $data=[]) {
        $data = array_merge($data, static::getData());
        return view('containers.home');
    }
    public function about(Request $request, $data=[]) {
        $data = array_merge($data, static::getData());
        return view('containers.about',$data);
    }
    public function services(Request $request, $data=[]) {
        $data = array_merge($data, static::getData());
        return view('containers.services',$data);
    }
  
    public function productDetail(Request $request, $id, $data=[]) {
        $user_id = Auth::user() ? auth()->user()->id : '';
        ProductController::updateProductVisited($id,$user_id);
        $data = array_merge($data, static::getData());
        $data['product'] = ProductController::getDetailsWithReviews($id);
        $data['product_id'] = array_get($data,'product_id',$id);
        return view('containers.product',$data);
    }
   public function products(Request $request, $data=[]) {
        $products_flag = $request->input('products','products');
        $fetchedData = ProductController::getAllList($data);
        $data = array_merge($data, static::getData(), $fetchedData);
        $data['products'] = array_get($data,$products_flag,[]);
        return view('containers.products',$data);
    }
    public function news(Request $request, $data=[]) {
        $data = array_merge($data, static::getData());
        return view('containers.news');
    }
    public function contact(Request $request, $data=[]) {
        $data = array_merge($data, static::getData());
        return view('containers.contact',$data);
    }














    public function getData() {
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
        return  [ "info"=>$info,"cards"=>$cards,"contents"=>$contents,"contacts"=>$contacts ];

    }
}
