<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSnowballOdis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snowball_odis', function (Blueprint $table) {
            $table->decimal('dividend',6,2)->nullable();
            $table->decimal('bono',6,2)->nullable();
            $table->integer('frequency')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snowball_odis', function (Blueprint $table) {
            $table->dropColumn('dividend');
            $table->dropColumn('bono');
            $table->dropColumn('frequency');
        });
    }
}
