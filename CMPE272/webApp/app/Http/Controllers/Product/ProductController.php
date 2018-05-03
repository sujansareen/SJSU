<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class ProductController
 */
class ProductController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request) {
        $filter_by_ids  = $request->input('ids', false);
        $most_visited   = $request->input('most_visited', 0);
        $company_id   = $request->input('company_id', 0);
        $table = DB::table('products');
        if($most_visited){
            $list = $table->whereNull('archived')->orderBy('visited', 'desc')->take($most_visited)->get();
            $return_data = $list;
        } else if($company_id){
            $list = $table->where('company_id',$company_id )->whereNull('archived')->orderBy('updated_at', 'desc')->get();
            $return_data = $list;
        } else if($filter_by_ids && is_array ($filter_by_ids)){
            $list = $table->get();
            $return_data = [];
            foreach ($filter_by_ids as $item) {
                $first = array_first($list, function ($value, $key) use ($item,$list){
                    return $value->id == $item;
                });
                if($first){
                    $return_data[] = $first;
                }
            }

        } else {
            $return_data = $table->get();
        }
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        $id = DB::table('products')->insertGetId( $data );
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
    public function details(Request $request, $id) {
        $item = DB::table('products')->where('id', $id)->whereNull('archived')->first();
        if($item){
            $cookie_products = $request->cookie('last_visited');
            $products = $cookie_products ? explode(",",$cookie_products):[];
            array_unshift($products,$id);
            $unique = array_unique($products);
            $last_visited = array_slice($unique, 0, 5, true);
            $products_string = implode(",", $last_visited);
            $cookie = cookie('last_visited', $products_string, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = false);
            DB::table('products')->where('id', $id)->whereNull('archived')
                ->update(['visited' => $item->visited+1]);
            return response()->json($item)->withCookie($cookie);
        }
        return response("Missing Data", 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $data = $request->input();
        $item = DB::table('products')->where('id', $id)->update($data);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $id) {
        $item = DB::table('products')->where('id', $id)->update(['archived'=>Carbon::now()]);
        return response()->json( $item );
    }


}