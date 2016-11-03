<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishSideDishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_side_dish', function (Blueprint $table) {
            $table->integer('dish_id');
            $table->integer('side_dish_id');

            $table->unique(['dish_id', 'side_dish_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dish_side_dish');
    }
}
