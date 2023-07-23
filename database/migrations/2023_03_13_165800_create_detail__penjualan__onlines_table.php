<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__penjualan__onlines', function (Blueprint $table) {
            $table->bigIncrements('id_detail_penjualan_online');
            $table->string('penjualan_online_id');
            $table->string('produk_id');
            $table->integer('diskon');
            $table->integer('status');
            $table->timestamps();
            $table->foreign('penjualan_online_id')->references('id_penjualan_online')->on('penjualan__onlines'); 
            $table->foreign('produk_id')->references('id_produk')->on('produks'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail__penjualan__onlines');
    }
}
