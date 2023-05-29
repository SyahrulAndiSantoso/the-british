<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVaNumberToPenjualanOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan__onlines', function (Blueprint $table) {
            $table->string('va_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan__onlines', function (Blueprint $table) {
            $table->dropColumn('va_number');
        });
    }
}
