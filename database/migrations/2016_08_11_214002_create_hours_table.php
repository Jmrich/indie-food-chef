<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('day_of_week');
            $table->time('open');
            $table->time('closed');
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
        Schema::drop('hours');
    }
}
