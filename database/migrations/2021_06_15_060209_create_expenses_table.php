<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('store')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger("categoryId")->unsigned()->nullable();    
            $table->bigInteger("userId")->unsigned();         
            $table->bigInteger("accountId")->unsigned()->nullable();         
            $table->decimal('amount', 12, 2);
            $table->date('date')->nullable();
            $table->timestamps();
        });

        Schema::table('expenses', function (Blueprint $table){
            $table->foreign('categoryId')->references('id')->on('expenses_categories');
        });

        Schema::table('expenses', function (Blueprint $table){
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('expenses', function (Blueprint $table){
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
        Schema::dropIfExists('expenses');
    }
}
