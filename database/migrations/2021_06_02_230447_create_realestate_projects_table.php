<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealestateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('realestate_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type')->nullable();
            $table->string('status')->nullable();
            $table->string('imageUrl')->nullable();
            $table->decimal('investment',12,2);
            $table->decimal('monthly_estimated',12,2)->nullable();
            $table->decimal('rate', 12,2);
            $table->bigInteger("fintechId")->unsigned(); 
            $table->bigInteger("userId")->unsigned();   
            $table->bigInteger("currencyId")->unsigned();
            $table->date("transactionDate");
            $table->integer("months")->nullable();
            $table->text("information")->nullable();
            $table->timestamps();        
        });

        Schema::table('realestate_projects', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('realestate_projects', function (Blueprint $table){
            $table->foreign('currencyId')->references('id')->on('currencies');
        });

        Schema::table('realestate_projects', function (Blueprint $table){
            $table->foreign('fintechId')->references('id')->on('fintechs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realestate_projects');
    }
}
