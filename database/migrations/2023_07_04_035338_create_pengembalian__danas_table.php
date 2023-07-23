<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian__danas', function (Blueprint $table) {
            $table->bigIncrements('id_pengembalian_dana');
            $table->string('penjualan_online_id');
            $table->string('bukti');
            $table->integer('total_dana');
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('penjualan_online_id')
            ->references('id_penjualan_online')
            ->on('penjualan__onlines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian__danas');
    }
}
