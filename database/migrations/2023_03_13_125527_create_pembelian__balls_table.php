<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian__balls', function (Blueprint $table) {
            $table->bigIncrements('id_pembelian_ball');
            $table->string('nama_ball');
            $table->string('supplier')->nullable();
            $table->date('tgl_beli');
            $table->integer('total_pakaian');
            $table->integer('layak_pakai');
            $table->integer('tidak_layak_pakai');
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
        Schema::dropIfExists('pembelian__balls');
    }
}
