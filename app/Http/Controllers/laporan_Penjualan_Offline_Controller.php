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
            $hasil = Detail_Penjualan_Offline::select('penjualan__offlines.tgl', 'penjualan__offlines.total')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__offlines.status', '=', 1)
                ->get();

            $total = Detail_Penjualan_Offline::selectRaw('SUM(penjualan__offlines.total) as total_keseluruhan')
                ->join('penjualan__offlines', 'detail__penjualan__offlines.penjualan_offline_id', '=', 'penjualan__offlines.id_penjualan_offline')
                ->join('produks', 'detail__penjualan__offlines.produk_id', '=', 'produks.id_produk')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__offlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__offlines.status', '=', 1)
                ->first();
        } else {
            $hasil = Penjualan_Offline::select('tgl', 'total')
                ->whereRaw('(tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('status', '=', 1)
                ->get();

            $total = Penjualan_Offline::selectRaw('SUM(total) as total_keseluruhan')
                ->whereRaw('(tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('status', '=', 1)
                ->first();
        }
        if (auth()->user()->role == 'admin') {
            return view('admin.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        } else {
            return view('owner.laporan_Penjualan_Offline', compact('judul', 'kategori', 'hasil', 'total'));
        }
    }
}
