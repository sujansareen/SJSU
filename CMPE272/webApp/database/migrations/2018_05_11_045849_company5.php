<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->addProducts();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('products')->where('company_id', 5)->delete();
    }
    public function addProducts() {
        $locations = [
            [
                "name" => "English to Chinese",
                "description" => "English to Chinese Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/english-to-chinese-300x203.jpg",
                "url" => "2018/04/26/service1/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Chinese to English",
                "description" => "Chinese to Engish Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/chinese_to_english.png",
                "url" => "2018/04/26/service2/",
                "service" => false,
				"company_id" => 5,
            ],
            [  
                "name" => "English to Japanese",
                "description" => "English to Japanese Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/japanese-to-english-300x202.jpg",
                "url" => "2018/04/26/service3/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Japanese to English",
                "description" => "Japanese to English Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/japanese_to_english-300x300.jpg",
                "url" => "2018/04/26/service4/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "English to Russian",
                "description" => "English to Russian Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/English-to-Russian-300x254.jpg",
                "url" => "2018/04/26/service5/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Russian to English",
                "description" => "Russian to English Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/russian_to_english.png",
                "url" => "2018/04/26/service6/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Chinese to Japanese",
                "description" => "Chinese to Japanese Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/chinese_to_japanese.png",
                "url" => "2018/04/26/service7/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Japanese to Chinese",
                "description" => "Japanese to Chinese Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/japanese_to_chinese.png",
                "url" => "2018/04/26/service8/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Chinese to Russian",
                "description" => "Chinese to Russian Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/chinese_to_russian-300x183.png",
                "url" => "2018/04/26/service9/",
                "service" => false,
				"company_id" => 5,
            ],
            [
                "name" => "Russian to Chinese",
                "description" => "Russian to Chinese Translation Proof Read.",
                "img" => "wp-content/uploads/2018/04/russian_to_chinese-300x187.png",
                "url" => "2018/04/26/service10/",
                "service" => false,
				"company_id" => 5,
            ]
        ];
        foreach ($locations as $key=>$location) {
            $id     = DB::table('products')->insertGetId( $location );
            echo sprintf("Added %s to products - %s \n", array_get($location,'name','') , $id);
        } 
    }
}
