<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('imageUrl')->nullable();
            $table->bigInteger("parentCategoryId")->unsigned()->nullable();    
            $table->bigInteger("userId")->unsigned();         
            $table->timestamps();
        });

        Schema::table('expenses_categories', function (Blueprint $table){
            $table->foreign('parentCategoryId')->references('id')->on('expenses_categories');
        });

        Schema::table('expenses_categories', function (Blueprint $table){
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
        Schema::dropIfExists('expenses_categories');
    }
}
