<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServices extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->createServicesTable();
    }
     public function createServicesTable() {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('service_id');
            $table->string('name');
            $table->string('img')->default('');
            $table->string('url')->default('');
            $table->string('description')->default('');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')
                ->references('company_id')->on('companies')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('services');
    }
}
