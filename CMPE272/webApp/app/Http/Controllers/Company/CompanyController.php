<?php

namespace App\Http\Controllers\Company;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Models\Company;
/**
 * Class CompanyController
 */
class CompanyController extends Controller{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request) {
        $return_data = Company::whereNull('archived')->orderBy('company_id')->get();
        return response()->json( $return_data );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data                  = $request->input();
        return Company::create($data);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(Request $request, $company_id) {
        $item = Company::findOrFail($company_id);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $company_id) {
        $data = $request->input();
        $item = Company::where('company_id', $company_id)->update($data);
        return response()->json( $item );
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(Request $request, $company_id) {
        $item = Company::where('company_id', $company_id)
            ->update(['archived'=>Carbon::now()]);
        return response()->json( $item );
    }
}