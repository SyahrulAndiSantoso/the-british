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
            $table->string('id_produk')->primary()->unique();
            $table->unsignedBigInteger('kategori_produk_id');
            $table->unsignedBigInteger('ukuran_id');
            $table->unsignedBigInteger('merk_id');
            $table->string('nama_produk');
            $table->string('thumbnail');
            $table->string('stok');
            $table->string('ukuran');
            $table->integer('harga');
            $table->string('merk');
            $table->text('deskripsi');
            $table->timestamps();
            $table->foreign('kategori_produk_id')->references('id_kategori_produk')->on('kategori__produks');
            $table->foreign('ukuran_id')->references('id_ukuran')->on('ukurans');
            $table->foreign('merk_id')->references('id_merk')->on('merks');
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
