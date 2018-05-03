<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviews extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->createReviewsTable();
    }
     public function createReviewsTable() {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->string('review');
            $table->tinyInteger('rating');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('reviews');
    }
}
