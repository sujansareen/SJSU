<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($data=[]) {
        return view('home');
    }

    public function home($data=[]) {
        return view('containers.home');
    }
    public function about($data=[]) {
        return view('containers.about',$data);
    }
    public function services($data=[]) {
        return view('containers.services',$data);
    }
    public function productDetail($id, $data=[]) {
        $data['product_id'] = array_get($data,'product_id',$id);
        return view('containers.product',$data);
    }
    public function news($data=[]) {
        return view('containers.news');
    }
    public function contact($data=[]) {
        return view('containers.contact',$data);
    }
    public function user($data=[]) {
        return view('containers.user',$data);
    }
    public function all_users($data=[]) {
        return view('containers.all_users',$data);
    }
}
