<?php

namespace App\Http\Controllers;

use App\Models\Detail_Penjualan_Online;
use App\Models\Kategori_Produk;
use App\Models\Penjualan_Online;
use Illuminate\Http\Request;

class laporan_Penjualan_Online_Controller extends Controller
{
    public function index()
    {
        $judul = 'Laporan Penjualan Online';
        $kategori = Kategori_Produk::all();
        if(auth()->user()->role == 'admin'){
            return view('admin.laporan_Penjualan_Online', compact('judul', 'kategori'));
        }else{
            return view('owner.laporan_Penjualan_Online', compact('judul', 'kategori'));
        }
    }

    public function cek_Laporan_Penjualan_Online(Request $request)
    {
        $validatedData = $request->validate([
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
        ]);
        $judul = 'Laporan Penjualan Online';
        $kategori = Kategori_Produk::all();

        if ($request->filter) {
            $hasil = Detail_Penjualan_Online::select('detail__penjualan__onlines.diskon','produks.id_produk','produks.nama_produk', 'produks.harga', 'merks.nama_merk','kategori__produks.nama_kategori_produk')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__onlines.status', '=', 1)
                ->where('detail__penjualan__onlines.status', '=', 1)
                ->groupBy('produks.id_produk')
                ->get();

            $total = Detail_Penjualan_Online::selectRaw('SUM(IF(detail__penjualan__onlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__onlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__onlines.diskon/100),0)) as total_diskon')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__onlines.status', '=', 1)
                ->where('detail__penjualan__onlines.status', '=', 1)
                ->first();
        } else {
                $hasil = Detail_Penjualan_Online::select('detail__penjualan__onlines.diskon','produks.id_produk','produks.nama_produk', 'produks.harga', 'merks.nama_merk','kategori__produks.nama_kategori_produk')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('penjualan__onlines.status', '=', 1)
                ->where('detail__penjualan__onlines.status', '=', 1)
                ->groupBy('produks.id_produk')
                ->orderBy('kategori__produks.nama_kategori_produk','desc')
                ->get();

                $total = Detail_Penjualan_Online::selectRaw('SUM(IF(detail__penjualan__onlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__onlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__onlines.diskon/100),0)) as total_diskon')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('penjualan__onlines.status', '=', 1)
                ->where('detail__penjualan__onlines.status', '=', 1)
                ->first();
        }
        if(auth()->user()->role == 'admin'){
            return view('admin.laporan_Penjualan_Online', compact('judul', 'kategori', 'hasil', 'total'));
        }else{
            return view('owner.laporan_Penjualan_Online', compact('judul', 'kategori', 'hasil', 'total'));
        }
    }
}
