<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressPivotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_chef', function (Blueprint $table) {
            $table->integer('address_id')->unsigned();
            $table->integer('chef_id')->unsigned();
        });

        Schema::create('address_customer', function (Blueprint $table) {
            $table->integer('address_id')->unsigned();
            $table->integer('customer_id')->unsigned();
        });

        Schema::create('address_kitchen', function (Blueprint $table) {
            $table->integer('address_id')->unsigned();
            $table->integer('kitchen_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('address_chef');
        Schema::drop('address_customer');
        Schema::drop('address_kitchen');
    }
}
