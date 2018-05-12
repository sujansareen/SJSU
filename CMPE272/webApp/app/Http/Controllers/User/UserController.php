<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Http\getUrlContent;
use Carbon\Carbon;
use App\User as Model;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 */
class UserController extends Controller{
    public function getList() {
        $list = Model::all();
        return $list;
    }
    public function details($id) {
        return Model::findOrFail($id);
    }
    public function create($data = []) {
        return Model::create($data);
    }
    public function update($id, $data = []) {
        $item = Model::findOrFail($id);
        $item = $item->fill($data);
        $item->save();
        return $item;
    }
    public function archive($id) {
        return Model::findOrFail($id)->delete();
    }
    /**
     * Web Handlers
     */
    
    /**
     * Api Handlers
     */
    public function getListHandler(Request $request) {
        $data   = $request->input();
        $field  = $request->input("field", "first_name");
        $search = $request->input("search", "");
        $table = DB::table('users');
        $valid_field = ['first_name', 'last_name', 'email','cell_phone', 'home_phone'];

        if(in_array($field, $valid_field)){
            $data = $table->select('first_name', 'last_name', 'email','home_address', 'cell_phone', 'home_phone')->where($field, 'LIKE', $search."%")->whereNull('archived')->get();
            return response()->json( $data );
        }
        return response("Error", 400);

    }
    public function signinHandler(Request $request) {
        $email      = $request->input("email", "");
        $password   = $request->input("password", "");
        $user = Model::where('email', '=', $email)
                    ->where('password', '=', $password)
                    ->get();
        if($user){
            $cookie = cookie('user', $user->id, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = false);
            return response()->json($user)->withCookie($cookie);
        }
        return response("Error", 400);
    }
    public function createHandler(Request $request) {
        $data   = $request->input();
        $data ['password'] = Hash::make($data['password']);
        $id = DB::table('users')->insertGetId( $data );
        if($id ){
            return "User successfully created with id $id";
            //$return_data = ["id"=>$id ];
            //return response()->json($return_data);
        }
        return response("Missing Data", 400);
    }
    public function detailsHandler(Request $request, $user_id) {
        $item = DB::table('users')->select('first_name', 'last_name', 'email','home_address', 'cell_phone', 'home_phone')->where('id', $user_id)->whereNull('archived')->first();
        return response()->json($item);
    }

    public function archiveHandler(Request $request, $user_id) {
        $item = DB::table('users')->where('id', $user_id)->update(['archived'=>Carbon::now()]);
        return response()->json( $item );
    }
    public function updateHandler(Request $request, $user_id) {
        $data = $request->input();
        $item = DB::table('users')->where('id', $user_id)->update($data);
        return response()->json( $item );
    }

    public function getListFromAllCompanysHandler(Request $request) {
        $data   = $request->input();
        $field  = $request->input("field", "first_name");
        $search = $request->input("search", "");
        $table = DB::table('users');
        $valid_field = ['first_name', 'last_name', 'email','cell_phone', 'home_phone'];
        if(in_array($field, $valid_field)){
            $data = $table->select('first_name', 'last_name', 'email','home_address', 'cell_phone', 'home_phone')->where($field, 'LIKE', $search."%")->whereNull('archived')->get();
            $data_company_2 = static::getUrlContent('http://students.engr.scu.edu/~kta/StoryMode/getallusers.php');
            return response()->json(  array_merge(static::parseData($data), static::parseData($data_company_2)) );
        }
        return response("Error", 400);
    }
    function parseData($data){
        $data = json_decode($data,true);
        $collection = collect($data)->map(function ($item, $key) {
            return [
                'first_name'    => array_get($item, 'first_name',array_get($item,'firstname','')),
                'last_name'     => array_get($item, 'last_name',array_get($item,'lastname','')),
                'email'         => array_get($item, 'email',array_get($item,'email','')),
                'cell_phone'    => array_get($item, 'cell_phone',array_get($item,'cellphone','')),
                'home_phone'    => array_get($item, 'home_phone',array_get($item,'homephone','')),
                'home_address'  => array_get($item, 'home_address',array_get($item,'homeaddress',''))
            ];
        });
        return $collection->toArray();
    }
    function getUrlContent($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }

}