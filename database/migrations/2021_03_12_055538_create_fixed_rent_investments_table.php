<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedRentInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_rent_investments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',12,2);
            $table->decimal('rate',5,2);
            $table->integer('term');
            $table->decimal('totalEarnings',12,2);
            $table->integer('daysCount');
            $table->integer('dayFixed');
            $table->date("initialDate");
            $table->date("endDate");
            $table->boolean("reinvest");
            $table->bigInteger("fixed_rent_platformsId")->unsigned();
            $table->timestamps();
        });

        Schema::table('fixed_rent_investments', function (Blueprint $table){
            $table->foreign('fixed_rent_platformsId')->references('id')->on('fixed_rent_platforms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixed_rent_investments');
    }
}
