<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_menu', function (Blueprint $table) {
            $table->integer('dish_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('starting_quantity');
            $table->integer('quantity_remaining');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dish_menu');
    }
}
