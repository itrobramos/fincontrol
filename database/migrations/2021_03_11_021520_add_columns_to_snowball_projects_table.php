<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSnowballProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snowball_proyects', function (Blueprint $table) {
            $table->integer('shares');
            $table->decimal('offering',12,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snowball_proyects', function (Blueprint $table) {
            $table->dropColumn('shares');
            $table->dropColumn('offering');
        });
    }
}
