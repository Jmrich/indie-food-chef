<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_fees', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('account')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('amount_refunded')->default(0);
            $table->string('charge_id');
            $table->boolean('refunded')->default(0);
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
        Schema::drop('application_fees');
    }
}
