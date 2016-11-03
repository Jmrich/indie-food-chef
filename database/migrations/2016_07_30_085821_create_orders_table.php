<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kitchen_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->string('charge_id')->nullable();
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total');
            $table->boolean('delivery');
            $table->string('delivery_address')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->boolean('is_complete')->default(0);
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('was_refunded')->default(0);
            $table->timestamps();

            $table->foreign('kitchen_id')
                ->references('id')
                ->on('kitchens')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::drop('orders');
    }
}
