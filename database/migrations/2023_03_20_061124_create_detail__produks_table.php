<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__produks', function (Blueprint $table) {
            $table->bigIncrements('id_detail_produk');
            $table->string('produk_id');
            $table->string('gambar');
            $table->timestamps();
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
        Schema::dropIfExists('detail__produks');
    }
}
