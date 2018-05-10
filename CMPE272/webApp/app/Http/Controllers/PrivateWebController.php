<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivateWebController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function index($data=[]) {
        return view('home');
    }
    public function user($data=[]) {
        return view('containers.user',$data);
    }
    public function all_users($data=[]) {
        return view('containers.all_users',$data);
    }
}
