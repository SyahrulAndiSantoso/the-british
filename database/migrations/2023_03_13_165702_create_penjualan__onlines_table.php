<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan__onlines', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan_online');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('alamat_id')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('sub_total')->nullable();
            $table->integer('status');
            $table->date('tgl')->nullable();
            $table->timestamps();
            $table
                ->foreign('user_id')
                ->references('id_user')
                ->on('users');
            $table
                ->foreign('alamat_id')
                ->references('id_alamat')
                ->on('alamats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan__onlines');
    }
}
