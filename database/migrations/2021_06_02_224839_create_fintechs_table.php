<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFintechsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fintechs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('imageUrl');
            $table->boolean('active');
            $table->string('color');
            $table->string('tag');
            $table->string('route');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fintechs');
    }
}
