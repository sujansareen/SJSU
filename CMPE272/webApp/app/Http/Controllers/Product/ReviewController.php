<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Review as Model;


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
        $list = $table->where('product_id', $product_id)->whereNull('archived')->orderBy('created_at')->get();
        $return_data = $list;
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $product_id) {
        $data                  = $request->input();
        $id = DB::table('reviews')->insertGetId( $data ,'review_id');
        if($id ){
            $return_data = ["review_id"=>$id ];
            return response()->json($return_data);
        }
        return response("Missing Data", 400);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $product_id, $id) {
        $item = DB::table('reviews')->where('review_id', $id)->whereNull('archived')->first();
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
        $item = DB::table('reviews')->where('review_id', $id)->update($data);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $product_id, $id) {
        $item = DB::table('reviews')->where('review_id', $id)->update(['archived'=>Carbon::now()]);
        return response()->json( $item );
    }

}