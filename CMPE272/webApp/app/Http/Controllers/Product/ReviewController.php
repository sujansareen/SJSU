<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class ReviewController
 */
class ReviewController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request, $product_id) {
        $table = DB::table('reviews');
        $list = $table->orderBy('created_at')->get();
        $return_data = $list;
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $product_id) {
        $data                  = $request->input();
        $id = DB::table('reviews')->insertGetId( $data );
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
    public function details(Request $request, $product_id, $id) {
        $item = DB::table('reviews')->where('id', $id)->first();
        if($item){
            return response()->json($item);
        }
        return response("Missing Data", 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $product_id, $id) {
        $data = $request->input();
        $data['product_id'] = array_get($data,'product_id',$product_id);
        $item = DB::table('reviews')->where('id', $id)->update($data);
        return response()->json( $item );
    }


}