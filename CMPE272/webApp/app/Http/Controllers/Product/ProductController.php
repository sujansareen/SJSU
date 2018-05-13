<?php

namespace App\Http\Controllers\Product;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Product as Model;
use App\Models\Review as ReviewModel;
use App\Models\Company as CompanyModel;
use App\User as UserModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Visited as VisitedModel;
/**
 * Class ProductController
 */
class ProductController extends Controller{
    public static function updateProductVisited($product_id='',$user_id='',$company_id='') {
        $user_id = Auth::user() ? auth()->user()->id : $user_id;
        if ($user_id) {
            $test = DB::table('products')->select('company_id')->where('id', $product_id)->get();
            $visit['company_id'] = $company_id?$company_id:$test->first()->company_id;
            $visit['product_id'] = $product_id;
            $visit['user_id'] = $user_id;
            return VisitedModel::updateOrCreate( $visit)->touch();
        }
        return false;
    }
    public function getList() {
        $list = Model::all();
        return $list;
    }
    public static function getAllListHandler(Request $request) {
        return static::getAllList($request->input());
    }
    public static function getAllList($data=[]) {
        $company_id = array_get($data, 'company_id',false);
        $user_id = Auth::user() ? auth()->user()->id : 0;
        if($company_id){
            $product_id_bycompany = Model::where('company_id',$company_id)->pluck('id');
            $reviews = ReviewModel::whereNull('archived')->whereIn('product_id', $product_id_bycompany);
        }
        else{
            $reviews = ReviewModel::whereNull('archived');
        }
        $reviews = $reviews->orderBy('rating', 'asc')->get();
        $rating_avg_keyed = $reviews->groupBy('product_id')
            ->map(function ($review, $key){
                $item = $review->first();
                $item['avg_rating'] = number_format($review->avg('rating'), 2);
                return $item;
            });
        $companies = CompanyModel::all();
        $visited = VisitedModel::where('user_id', $user_id)->orderBy('updated_at', 'desc')->get();
        $last_visited_product_ids = $visited->pluck('product_id');
        $visited_list = Model::whereIn('id', $last_visited_product_ids)->get()->keyBy('id')->all();
        $return_data['visited'] = $last_visited_product_ids->map(function ($item, $key) use($visited_list){
            $product=$visited_list[$item];
            $product->company;
            return $product;
        });
        // top_rated
        $ratings = $rating_avg_keyed->values();
        $product_ids = $ratings->sortByDesc('avg_rating')->values()->pluck('product_id')->take(5);

        $list = Model::whereIn('id', $product_ids->all())->get()->keyBy('id')->all();
        $return_data['top_rated'] = $product_ids->map(function ($item, $key) use($list,$rating_avg_keyed){
            $product=$list[$item];
            $product->company;
            $product['avg_rating'] = array_get($rating_avg_keyed,$item.".avg_rating",0);
            return $product;
        });
        // top_visited
        if($company_id){
            $top_visited = Model::whereNull('archived')->where('company_id', $company_id)->orderBy('visited', 'desc')->take(5)->get();
        }
        else{
            $top_visited = Model::whereNull('archived')->orderBy('visited', 'desc')->take(5)->get();
        }
        $return_data['top_visited'] = $top_visited->map(function ($product, $key) use($list){
            $product->company;
            return $product;
        })->all();
       // all products
       $products = Model::all();
       $products = $products->map(function ($product, $key) use($list){
            $product->company;
            return $product;
        });
       $return_data['products'] = $products->toArray();
       // company 1 products
       $return_data['company_1'] = $products->filter(function ($value) {
            return $value->company_id ==1;
        })->values()->all();
       $return_data['company_2'] = $products->filter(function ($value) {
            return $value->company_id ==2;
        })->values()->all();
       $return_data['company_3'] = $products->filter(function ($value) {
            return $value->company_id ==3;
        })->values()->all();
       $return_data['company_4'] = $products->filter(function ($value) {
            return $value->company_id ==4;
        })->values()->all();
       $return_data['company_5'] = $products->filter(function ($value) {
            return $value->company_id ==5;
        })->values()->all();
       $return_data['reviews'] = $reviews;
       $return_data['companies'] = $companies;
       return $return_data;
    }
    public static function getListWithReviews() {
        $products = Model::all();
        $reviews = ReviewModel::all();
        $companies = CompanyModel::all();

        return [
            "products"=>$products,
            "reviews"=>$reviews,
            "companies"=>$companies
        ];
    }
    public static function getDetailsWithReviews($product_id) {
        $average = 0;
        $reviewlist = ReviewModel::where('product_id', $product_id)->orderBy('created_at', 'desc')->get();
        $product = Model::findOrFail($product_id);
        $visited = $product->visited ? $product->visited+1 : 1;
        $product = $product->fill(['visited' => $visited]);
        $product->save();
        $item = $product->toArray();
        $company = $product->company;
        $item['company'] = $product->company;
        $user_ids = $reviewlist->pluck('user_id');
        $ratings = array_filter($reviewlist->pluck('rating')->toArray());
        if($ratings){
            $average = array_sum($ratings)/count($ratings);
        }
        $item['average'] = number_format($average, 2);
        $item['baseurl'] = $company['url'] == 'http://mymemories.arturomontoya.me'?'/images/products':$company['url'];
        $item['users'] = UserModel::whereIn('id', $user_ids)->get()->keyBy('id')->all();
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
        $company_id = $request->input('company_id','1');
        $user_id = $request->input('user_id',false);
        $item = static::details($id);
        $cookie = static::getLastVisitedCookie($request, $id);
        $return_data = static::getDetailsWithReviews($id);
        $return_data['company'] = $item->company;
        static::updateProductVisited($id,$user_id,$company_id);
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