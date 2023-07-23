<?php

namespace App\Http\Controllers;

use App\Models\Detail_Penjualan_Offline;
use App\Models\Kategori_Produk;
use App\Models\Penjualan_Offline;
use Illuminate\Http\Request;

class laporan_Penjualan_Offline_Controller extends Controller
{
    public function index()
    {
        $judul = 'Laporan Penjualan Offline';
        $kategori = Kategori_Produk::all();
        $hasil = null;
        $total = null;

        if (auth()->user()->role == 'admin') {
            return view('admin.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        } else {
            return view('owner.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        }
    }

    public function cek_Laporan_Penjualan_Offline(Request $request)
    {
        $judul = 'Laporan Penjualan Offline';
        $kategori = Kategori_Produk::all();
        $validatedData = $request->validate([
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
        ]);

        if ($request->filter) {
            $hasil = Detail_Penjualan_Offline::select('detail__penjualan__offlines.diskon','produks.id_produk','produks.nama_produk', 'produks.harga', 'merks.nama_merk','kategori__produks.nama_kategori_produk')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__offlines.status', '=', 1)
                ->where('detail__penjualan__offlines.status', '=', 1)
                ->groupBy('produks.id_produk')
                ->get();

            $total = Detail_Penjualan_Offline::selectRaw('SUM(IF(detail__penjualan__offlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__offlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__offlines.diskon/100),0)) as total_diskon')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__offlines.status', '=', 1)
                ->where('detail__penjualan__offlines.status', '=', 1)
                ->first();
        } else {

                $hasil = Detail_Penjualan_Offline::select('detail__penjualan__offlines.diskon','produks.id_produk','produks.nama_produk', 'produks.harga', 'merks.nama_merk','kategori__produks.nama_kategori_produk')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('penjualan__offlines.status', '=', 1)
                ->where('detail__penjualan__offlines.status', '=', 1)
                ->groupBy('produks.id_produk')
                ->orderBy('kategori__produks.nama_kategori_produk','desc')
                ->get();

                $total = Detail_Penjualan_Offline::selectRaw('SUM(IF(detail__penjualan__offlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__offlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__offlines.diskon/100),0)) as total_diskon')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('penjualan__offlines.status', '=', 1)
                ->where('detail__penjualan__offlines.status', '=', 1)
                ->first();
        }
        if (auth()->user()->role == 'admin') {
            return view('admin.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        } else {
            return view('owner.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        }
    }
}
