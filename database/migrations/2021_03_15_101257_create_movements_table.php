<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("userId")->unsigned();
            $table->bigInteger("accountId")->unsigned();
            $table->integer('type');
            $table->decimal('amount',12,2);
            $table->string('concept');
            $table->date("transactionDate");
            $table->string('receiptUrl');
            $table->timestamps();
        });

        Schema::table('movements', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('movements', function (Blueprint $table){
            $table->foreign('accountId')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
