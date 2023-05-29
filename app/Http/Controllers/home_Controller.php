<?php

namespace App\Http\Controllers;

use App\Models\Detail_Promo;
use App\Models\Kategori_Produk;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;

class home_Controller extends Controller
{
    public function index()
    {
        $judul = 'Beranda';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $kategoriProduk = Kategori_Produk::select('nama_kategori_produk')
            ->limit(8)
            ->get();
        $promo = Promo::select('nama_promo', 'id_promo')
            ->where('status', 1)
            ->latest()
            ->get();
        $detailPromo = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'promos.id_promo', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.deskripsi', 'detail__promos.promo_id')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
                'promos.status' => 1,
            ])
            ->latest('promos.id_promo')
            ->get();

        return view('pembeli.beranda', compact('judul', 'kategori', 'kategoriProduk', 'promo', 'detailPromo'));
    }
}
