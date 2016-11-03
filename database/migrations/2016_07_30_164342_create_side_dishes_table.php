<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSideDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_dishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->float('price');
            $table->float('extra_cost');
            $table->boolean('is_archived')->default(0);
            $table->integer('kitchen_id')->unsigned();
            $table->timestamps();

            $table->foreign('kitchen_id')
                ->references('id')
                ->on('kitchens')
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
        Schema::drop('side_dishes');
    }
}
