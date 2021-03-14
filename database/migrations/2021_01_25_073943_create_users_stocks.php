<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("userId")->unsigned();
            $table->bigInteger("stockId")->unsigned();
            $table->decimal('averagePrice');
            $table->decimal('quantity');
            $table->bigInteger("currencyId")->unsigned();
            $table->bigInteger("brokerId")->unsigned();
            $table->date("transactionDate");
            $table->timestamps();
        });
        
        Schema::table('users_stocks', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('users_stocks', function (Blueprint $table){
            $table->foreign('stockId')->references('id')->on('stocks')->onDelete('cascade');
        });

        Schema::table('users_stocks', function (Blueprint $table){
            $table->foreign('currencyId')->references('id')->on('currencies');
        });

        Schema::table('users_stocks', function (Blueprint $table){
            $table->foreign('brokerId')->references('id')->on('brokers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_stocks');
    }
}
