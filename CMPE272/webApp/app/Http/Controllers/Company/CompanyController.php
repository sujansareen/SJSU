<?php

namespace App\Http\Controllers\Company;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Company as Model;
/**
 * Class CompanyController
 */
class CompanyController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request) {
        $return_data = Model::whereNull('archived')->orderBy('company_id')->get();
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        return Model::create($data);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $company_id) {
        $item = Model::findOrFail($company_id);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $company_id) {
        $data = $request->input();
        $item = Model::where('company_id', $company_id)->update($data);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $company_id) {
        $item = Model::findOrFail($company_id)->delete();
        return response()->json( $item );
    }
}