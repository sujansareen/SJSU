<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Product as Model;
use App\Models\Review as ReviewModel;
use App\User as UserModel;

/**
 * Class ProductController
 */
class ProductController extends Controller{
    public function getList() {
        $list = Model::all();
        return $list;
    }
    public static function getDetailsWithReviews($product_id) {
        $average = 0;
        $reviewlist = ReviewModel::where('product_id', $product_id)->orderBy('created_at', 'desc')->get();
        $item = Model::findOrFail($product_id)->toArray();
        $user_ids = $reviewlist->pluck('user_id');
        $item['users'] = UserModel::whereIn('id', $user_ids)->get()->keyBy('id')->all();
        $ratings = array_filter($reviewlist->pluck('rating')->toArray());
        if($ratings){
            $average = array_sum($ratings)/count($ratings);
        }
        $item['average'] = number_format($average, 2);
        $item['reviews'] = $reviewlist->map(function ($review) use($item) {
            $user = array_get($item['users'], $review['user_id'],[]);
            $review = $review->toArray();
            $review['user']=$user;
            return $review;
        })->toArray();
        return $item;
    }
    public function create($data = []) {
        return Model::create($data);
    }
    public function details($id) {
        return Model::findOrFail($id);
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
    
    /*
    * 
    * Api Handlers 
    * 
    */
    public function getLastVisitedCookie(Request $request, $id) {
        $cookie_products = $request->cookie('last_visited');
        $products = $cookie_products ? explode(",",$cookie_products):[];
        array_unshift($products,$id);
        $unique = array_unique($products);
        $last_visited = array_slice($unique, 0, 5, true);
        $products_string = implode(",", $last_visited);
        $cookie = cookie('last_visited', $products_string, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = false);
        return $cookie;
    }
    public function getListHandler(Request $request) {
        $filter_by_ids  = $request->input('ids', false);
        $most_visited   = $request->input('most_visited', 0);
        $company_id   = $request->input('company_id', 0);

        if($most_visited){
            $list = Model::whereNull('archived')->orderBy('visited', 'desc')->take($most_visited)->get();
            $return_data = $list;
        } else if($company_id){
            $list = Model::where('company_id',$company_id )->orderBy('updated_at', 'desc')->get();
            $return_data = $list;
        } else if($filter_by_ids && is_array ($filter_by_ids)){
            $list = Model::all();
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
            $return_data = Model::all();
        }
        return response()->json( $return_data );
    }
    public function createHandler(Request $request) {
        $data = $request->input();
        return response()->json( static::create($data) );
    }
    public function detailsHandler(Request $request, $id) {
        $item = static::details($id);
        $cookie = static::getLastVisitedCookie($request, $id);
        $item = $item->fill(['visited' => $item->visited+1]);
        $item->save();
        return response()->json($item)->withCookie($cookie);
    }
    public function updateHandler(Request $request, $id) {
        $data = $request->input();
        return response()->json( static::update($id, $data) );
    }
    public function archiveHandler(Request $request, $id) {
        return response()->json( static::archive($id) );
    }


}