<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockClosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_closes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stockId')->unsigned();
            $table->decimal('price',12,2);
            $table->timestamps();

            $table->foreign('stockId')->references('id')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_closes');
    }
}
