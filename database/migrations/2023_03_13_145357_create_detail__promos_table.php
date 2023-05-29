<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__promos', function (Blueprint $table) {
            $table->bigIncrements('id_detail_promo');
            $table->unsignedBigInteger('promo_id');
            $table->unsignedBigInteger('produk_id');
            $table->timestamps();
            $table->foreign('promo_id')->references('id_promo')->on('promos');
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
        Schema::dropIfExists('detail__promos');
    }
}
