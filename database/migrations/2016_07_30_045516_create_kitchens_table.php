<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('slug');
            $table->string('food_category');
            $table->string('timezone');
            $table->string('stripe_id');
            $table->string('stripe_public_key');
            $table->string('stripe_secret_key');
            $table->boolean('is_active')->default(1);
            $table->boolean('delivers')->default(0);
            $table->integer('delivery_fee')->default(0);
            $table->integer('tax_rate')->default(0);
            $table->integer('chef_id')->unsigned();
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
        Schema::drop('kitchens');
    }
}
