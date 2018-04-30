<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCompanies extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->createCompaniesTable();
        $this->addGroupCompanies();
    }
    public function createcompaniesTable() {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('img')->default('');
            $table->string('url');
            $table->string('owner')->default('');
            $table->string('description')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('companies');
    }

    public function addGroupCompanies() {
        $companies = [
            [
                "name" => "My Memories",
                "owner" => "Arturo",
                "url" => "http://mymemories.arturomontoya.me",
            ],
            [
                "name" => "Story Mode",
                "owner" => "Kevin",
                "url" => "http://students.engr.scu.edu/~kta/StoryMode/",
            ], 
            [
                "name" => "Embedded System Solution",
                "owner" => "Fulbert",
                "url" => "http://fulbertj.com",
            ],
            [
                "name" => "Alphabet Bookstore",
                "owner" => "Sujan",
                "url" => "http://sujansareen.com/",
            ],
            [
                "name" => "PaperClipper",
                "owner" => "WeiYang",
                "url" => "http://weiyangpan272.net",
            ]
        ];
        foreach ($companies as $key=>$company) {
            $id     = DB::table('companies')->insertGetId( $company );
            echo sprintf("Added %s to companies - %s \n", array_get($company,'name','') , $id);
        }
    }
}
