<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class CompanyController
 */
class CompanyController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request) {
        return response()->json( [] );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        $id = DB::table('companies')->insertGetId( $data );
        if($id){
            $return_data = ["id"=>$id ];
            return response()->json($return_data);
        }
        return response("Missing Data", 400);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $id) {
        $item = DB::table('companies')->where('id', $id)->first();
        if($item){
            return response()->json($item);
        }
        return response("Missing Data", 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user_id) {
        return response()->json( [] );
    }


}