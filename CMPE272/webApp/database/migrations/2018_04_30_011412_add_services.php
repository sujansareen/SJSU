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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('service')->default(false);
            $table->unsignedInteger('company_id')->default(0);
        });
        DB::table('products')->update(['company_id' => 1]);
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('company_id')
                ->references('company_id')->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('service');
            $table->dropColumn('company_id');
        });
    }
    
}
