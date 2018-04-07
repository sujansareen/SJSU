<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $data = $table->select('first_name', 'last_name', 'email','cell_phone', 'home_phone')->where($field, 'LIKE', $search."%")->get();
            return response()->json( $data );
        }
        return response("Error", 400);

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request, $user_id) {
        $email                  = $request->input("email", "");
        $password                  = $request->input("password", "");
        $table = DB::table('users');
        $data = $table->select('first_name', 'last_name', 'email','cell_phone', 'home_phone')->whereColumn([
                    ['email', '=', $email],
                    ['password', '>', $password]
                ])->get();
        if($data){
            return response()->json( $data );
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


}