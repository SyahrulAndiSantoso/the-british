<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->unsignedBigInteger('kategori_produk_id');
            $table->string('nama_produk');
            $table->string('thumbnail');
            $table->string('stok');
            $table->string('ukuran');
            $table->integer('harga');
            $table->string('merk');
            $table->text('deskripsi');
            $table->timestamps();
            $table->foreign('kategori_produk_id')->references('id_kategori_produk')->on('kategori__produks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
