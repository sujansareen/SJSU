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
    public function getList($product_id) {
        $list = Model::where('product_id', $product_id)->orderBy('created_at')->get();
        return $list;
    }
    public function create($data=[]) {
        return Model::create($data);
    }
    public function details($id) {
        return Model::findOrFail($id);
    }
    public function update($id, $data=[]) {
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
    public function getListHandler(Request $request, $product_id) {
        $data = $request->input();
        $data['product_id'] = array_get($data,'product_id',$product_id);
        return response()->json( static::getList($product_id) );
    }
    public function createHandler(Request $request, $product_id) {
        $data = $request->input();
        $data['product_id'] = array_get($data,'product_id',$product_id);
        return response()->json( static::create($data) );
    }
    public function detailsHandler(Request $request, $product_id, $id) {
        return response()->json( static::details($id) );
    }
    public function updateHandler(Request $request, $product_id, $id) {
        $data = $request->input();
        $data['product_id'] = array_get($data,'product_id',$product_id);
        return response()->json( static::update($id, $data) );
    }
    public function archiveHandler(Request $request, $product_id, $id) {
        return response()->json( static::archive($id) );
    }

}