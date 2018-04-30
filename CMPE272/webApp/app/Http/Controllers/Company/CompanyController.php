<?php

namespace App\Http\Controllers\Company;

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
        $table = DB::table('companies');
        $list = $table->orderBy('company_id')->get();
        $return_data = $list;
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        $company_id = DB::table('companies')->insertGetId( $data );
        if($company_id){
            $return_data = ["company_id"=>$company_id ];
            return response()->json($return_data);
        }
        return response("Missing Data", 400);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $company_id) {
        $item = DB::table('companies')->where('company_id', $company_id)->first();
        if($item){
            return response()->json($item);
        }
        return response("Missing Data", 400);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $company_id) {
        return response()->json( [] );
    }


}