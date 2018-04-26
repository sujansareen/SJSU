<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $data = static::getUrlContent('https://randomuser.me/api/?results=25');
        $users = json_decode($data,true)['results'];
        $users = static::parseData($users);
        foreach ($users as $key=>$user) {
            $id     = DB::table('users')->insertGetId( $user );
            echo sprintf("Added %s to user - %s \n", array_get($user,'name','') , $id);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->delete();
    }
    function parseData($data){
        $collection = collect($data)->map(function ($item, $key) {
            return [
                'first_name'    => array_get($item, 'name.first',''),
                'last_name'     => array_get($item, 'name.last',''),
                'email'         => array_get($item, 'email',''),
                'cell_phone'    => array_get($item, 'cell',''),
                'home_phone'    => array_get($item, 'phone',''),
                'home_address'  => array_get($item, 'location.street',''),
                'password'      =>  array_get($item, 'login.password','')
            ];
        });
        return $collection->toArray();
    }
    function getUrlContent($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }
}
