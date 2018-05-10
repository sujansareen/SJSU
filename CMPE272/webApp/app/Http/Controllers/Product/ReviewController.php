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
        $return_data = Model::where('product_id', $product_id)->orderBy('created_at')->get();
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $product_id) {
        $data = $request->input();
        return Model::create($data);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $product_id, $id) {
        $item = Model::findOrFail($id);
        return response()->json( $item );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $product_id, $id) {
        $data = $request->input();
        $data['product_id'] = array_get($data,'product_id',$product_id);
        $item = Model::findOrFail($id);
        $item = $item->fill($data);
        $item->save();
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $product_id, $id) {
        $item = Model::findOrFail($id)->delete();
        return response()->json( $item );
    }

}