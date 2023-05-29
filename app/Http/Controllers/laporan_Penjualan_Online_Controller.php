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
            $hasil = Detail_Penjualan_Online::select('penjualan__onlines.tgl', 'penjualan__onlines.total', 'users.nama_user')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
                ->join('users', 'penjualan__onlines.user_id', '=', 'users.id_user')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__onlines.status', '=', 1)
                ->get();

            $total = Detail_Penjualan_Online::selectRaw('SUM(penjualan__onlines.total) as total_keseluruhan')
                ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
                ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
                ->join('users', 'penjualan__onlines.user_id', '=', 'users.id_user')
                ->join('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?) AND kategori__produks.id_kategori_produk = ?', [$request->tgl_awal, $request->tgl_akhir, $request->filter])
                ->where('penjualan__onlines.status', '=', 1)
                ->first();
        } else {
            $hasil = Penjualan_Online::select('penjualan__onlines.tgl', 'penjualan__onlines.total', 'users.nama_user')
                ->join('users', 'penjualan__onlines.user_id', '=', 'users.id_user')
                ->whereRaw('(penjualan__onlines.tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('penjualan__onlines.status', '=', 1)
                ->get();

            $total = Penjualan_Online::selectRaw('SUM(total) as total_keseluruhan')
                ->whereRaw('(tgl BETWEEN ? AND ?)', [$request->tgl_awal, $request->tgl_akhir])
                ->where('status', '=', 1)
                ->first();
        }
        if(auth()->user()->role == 'admin'){
            return view('admin.laporan_Penjualan_Online', compact('judul', 'kategori', 'hasil', 'total'));
        }else{
            return view('owner.laporan_Penjualan_Online', compact('judul', 'kategori', 'hasil', 'total'));
        }
    }
}
