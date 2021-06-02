<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedgirasolProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redgirasol_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rgid');
            $table->string('type');
            $table->string('qualification');
            $table->string('status');
            $table->string('imageUrl')->nullable();
            $table->decimal('investment',12,2);
            $table->decimal('monthly_estimated',12,2);
            $table->decimal('rate', 12,2);
            $table->bigInteger("userId")->unsigned();   
            $table->bigInteger("currencyId")->unsigned();
            $table->date("transactionDate");
            $table->integer("months");
            $table->timestamps();
        });

        Schema::table('redgirasol_projects', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('redgirasol_projects', function (Blueprint $table){
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
        Schema::dropIfExists('redgirasol_projects');
    }
}
