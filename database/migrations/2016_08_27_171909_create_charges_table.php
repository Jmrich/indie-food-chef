<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('amount');
            $table->integer('amount_refunded')->default(0);
            $table->boolean('captured')->default(0);
            $table->string('application_fee')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->string('source_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::drop('charges');
    }
}
