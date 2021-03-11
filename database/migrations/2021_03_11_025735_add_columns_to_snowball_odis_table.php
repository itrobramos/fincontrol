<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSnowballOdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snowball_odis', function (Blueprint $table) {
            $table->date("efectiveDate");
            $table->string('pdfUrl');     
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
            $table->dropColumn("efectiveDate");
            $table->dropColumn('pdfUrl');   
        });
    }
}
