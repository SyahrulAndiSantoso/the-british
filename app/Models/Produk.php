<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'produks';
    protected $primaryKey = 'id_produk';
    protected $keyType = 'string';
    protected $fillable = ['id_produk','kategori_produk_id', 'nama_produk', 'thumbnail', 'stok', 'ukuran_id', 'gambar', 'harga', 'merk_id', 'deskripsi'];

    public function detail_penjualan_online()
    {
        return $this->hasMany(Detail_Penjualan_Online::class, 'detail_penjualan_online_id', 'id_detail_penjualan_online');
    }

    public function detail_penjualan_offline()
    {
        return $this->hasMany(Detail_Penjualan_Offline::class, 'detail_penjualan_offline_id', 'id_detail_penjualan_offline');
    }

    public function kategori_produk()
    {
        return $this->belongsTo(Kategori_Produk::class, 'kategori_produk_id', 'id_kategori_produk');
    }


    public function merk(){
        return $this->belongsTo(Merk::class, 'merk_id', 'id_merk');
    }

    public function ukuran(){
        return $this->belongsTo(Ukuran::class, 'ukuran_id', 'id_ukuran');
    }
    public function detail_promo()
    {
        return $this->hasMany(Detail_Promo::class, 'detail_promo_id', 'id_detail_promo');
    }

    public function detail_produk()
    {
        return $this->hasMany(Detail_Produk::class, 'detail_produk_id', 'id_detail_prodouk');
    }

    public function getLastIdProduk()
    {
        $data = DB::table('produks')
            ->orderBy('id_produk', 'desc')
            ->get();

        return $data;
    }

}
