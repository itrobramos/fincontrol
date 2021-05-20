<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedRentPaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_rent_paids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fixedRentInvestmentId')->unsigned();
            $table->date('date');
            $table->integer('number');
            $table->decimal('amount',12,2);
            $table->decimal('percent',12,2);
            $table->timestamps();

            $table->foreign('fixedRentInvestmentId')->references('id')->on('fixed_rent_investments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixed_rent_paids');
    }
}
