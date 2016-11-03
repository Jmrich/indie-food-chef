<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_id')->nullable();
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->string('address')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('formatted_address');
            $table->boolean('pickup_location')->default(0);
            $table->integer('kitchen_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kitchen_addresses');
    }
}
