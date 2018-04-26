<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Http\getUrlContent;
/**
 * Class UserController
 */
class UserController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request) {
        $data                  = $request->input();
        $field                  = $request->input("field", "first_name");
        $search                  = $request->input("search", "");
        $table = DB::table('users');
        $valid_field = ['first_name', 'last_name', 'email','cell_phone', 'home_phone'];

        if(in_array($field, $valid_field)){
            $data = $table->select('first_name', 'last_name', 'email','home_address', 'cell_phone', 'home_phone')->where($field, 'LIKE', $search."%")->get();
            return response()->json( $data );
        }
        return response("Error", 400);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request) {
        $email                  = $request->input("email", "");
        $password                  = $request->input("password", "");
        $table = DB::table('users');
        $data = $table->where('email', '=', $email)->where('password', '=', $password)->get();
        if($data){
            $cookie = cookie('user', 'sdfdlksdjflksdfjl;ajkf', $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = false);
            return response()->json($data)->withCookie($cookie);
        }
        return response("Error", 400);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        $id = DB::table('users')->insertGetId( $data );
        if($id ){
            $return_data = ["id"=>$id ];
            return response()->json($return_data);
        }
        return response("Missing Data", 400);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $user_id) {
        $data                  = $request->input();

        $return_data = [];
        return response()->json($return_data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $user_id) {
        $data                  = $request->input();

        $return_data = [];
        return response()->json($return_data);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user_id) {
        $data                  = $request->input();

        $return_data = [];
        return response()->json($return_data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListFromAllCompanys(Request $request) {
        $data                  = $request->input();
        $field                  = $request->input("field", "first_name");
        $search                  = $request->input("search", "");
        $table = DB::table('users');
        $valid_field = ['first_name', 'last_name', 'email','cell_phone', 'home_phone'];
        if(in_array($field, $valid_field)){
            $data = $table->select('first_name', 'last_name', 'email','home_address', 'cell_phone', 'home_phone')->where($field, 'LIKE', $search."%")->get();
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