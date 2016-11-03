<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewables', function (Blueprint $table) {
            $table->integer('review_id')->unsigned();
            $table->morphs('reviewable');

            $table->foreign('review_id')
                ->references('id')
                ->on('reviews')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reviewables');
    }
}
