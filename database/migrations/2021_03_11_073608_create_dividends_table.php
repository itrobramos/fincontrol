<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDividendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dividends', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->integer('referenceId');
            $table->date("efectiveDate");
            $table->decimal('amount',12,2);
            $table->integer('stocksCount');
            $table->bigInteger("currencyId")->unsigned();
            $table->bigInteger("userId")->unsigned(); 
            $table->timestamps();
        });

        Schema::table('dividends', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('dividends', function (Blueprint $table){
            $table->foreign('currencyId')->references('id')->on('currencies');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dividends');
    }
}
