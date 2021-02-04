<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currencyIdOrigin')->unsigned();;
            $table->bigInteger('currencyIdDestiny')->unsigned();;
            $table->decimal('price',12,4);
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('exchanges', function (Blueprint $table){
            $table->foreign('currencyIdOrigin')->references('id')->on('currencies');
        });


        Schema::table('exchanges', function (Blueprint $table){
            $table->foreign('currencyIdDestiny')->references('id')->on('currencies');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
