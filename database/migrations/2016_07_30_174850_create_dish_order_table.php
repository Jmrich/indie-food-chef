<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDishOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_order', function (Blueprint $table) {
            $table->integer('dish_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->string('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dish_order');
    }
}
