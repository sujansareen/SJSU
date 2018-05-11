<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Visited extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->createVisitedTable();
    }
     public function createVisitedTable() {
        Schema::create('visited', function (Blueprint $table) {
            $table->increments('visited_id');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')
            ->references('company_id')->on('companies');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->string('archived')->nullable()->default(null);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('visited');
    }
}
