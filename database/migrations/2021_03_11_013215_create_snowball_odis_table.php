<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnowballOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snowball_odis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('snowballProjectId')->unsigned();
            $table->integer('quantity');
            $table->decimal('ODIPrice',12,2);
            $table->date("transationDate");
            $table->bigInteger("userId")->unsigned();
            $table->timestamps();
        });
                
        Schema::table('snowball_odis', function (Blueprint $table){
            $table->foreign('snowballProjectId')->references('id')->on('snowball_proyects')->onDelete('cascade');
        });

        Schema::table('snowball_odis', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snowball_odis');
    }
}
