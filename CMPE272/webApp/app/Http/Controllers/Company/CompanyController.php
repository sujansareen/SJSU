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
class CompanyController extends Controller {
    public function getList() {
        $list = Model::whereNull('archived')->orderBy('company_id')->get();
        return $list;
    }
    public function details($company_id) {
        return Model::findOrFail($company_id);
    }
    public function create($data = []) {
        return Model::create($data);
    }
    public function update($company_id, $data = []) {
        $item = Model::findOrFail($company_id);
        $item = $item->fill($data);
        $item->save();
        return $item;
    }
    public function archive($company_id) {
        return Model::findOrFail($company_id)->delete();
    }

    /*
    * 
    * Api Handlers 
    * 
    */

    public function getListHandler(Request $request) {
        return response()->json( static::getList($data) );
    }
    public function createHandler(Request $request) {
        $data = $request->input();
        return response()->json( static::create($data) );
    }
    public function detailsHandler(Request $request, $company_id) {
        return response()->json( static::details($company_id) );
    }
    public function updateHandler(Request $request, $company_id) {
        $data = $request->input();
        return response()->json( static::update($company_id, $data) );
    }
    public function archiveHandler(Request $request, $company_id) {
        return response()->json( static::archive($company_id) );
    }
}