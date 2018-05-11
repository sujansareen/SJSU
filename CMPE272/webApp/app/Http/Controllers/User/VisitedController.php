<?php

namespace App\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;
use App\Http\getUrlContent;
use Carbon\Carbon;
use App\Models\Visited as Model;

class VisitedController extends Controller
{
    public function detailsHandler(Request $request, $user_id, $company_id) {
       $item = DB::table('visited')->select('user_id', 'product_id')->where('user_id', $user_id)->where('company_id' , $company_id)->whereNull('archived')->distinct()->get();
       return response()->json($item);
    }

    public function archiveHandler(Request $request, $user_id) {
        $item = DB::table('visited')->where('id', $user_id)->update(['archived'=>Carbon::now()]);
        return response()->json( $item );
    }
    public function createHandler(Request $request) {
        $data = $request->input();
        $item = DB::table('visited')->insertGetId($data);
        return response()->json( $item );
    }

}
