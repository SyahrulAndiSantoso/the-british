<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanOfflinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan__offlines', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan_offline');
            $table->bigInteger('total')->nullable();
            $table->bigInteger('diterima')->nullable();
            $table->bigInteger('kembalian')->nullable();
            $table->integer('status');
            $table->date('tgl')->nullable();
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
        Schema::dropIfExists('penjualan__offlines');
    }
}
