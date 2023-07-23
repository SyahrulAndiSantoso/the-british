<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanOfflinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__penjualan__offlines', function (Blueprint $table) {
            $table->bigIncrements('id_detail_penjualan_offline');
            $table->string('penjualan_offline_id');
            $table->string('produk_id');
            $table->integer('diskon');
            $table->integer('status');
            $table->timestamps();
            $table->foreign('penjualan_offline_id')->references('id_penjualan_offline')->on('penjualan__offlines');
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
        Schema::dropIfExists('detail__penjualan__offlines');
    }
}
