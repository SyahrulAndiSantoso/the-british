<?php

namespace App\Http\Controllers;

use App\Models\Penjualan_Offline;
use App\Models\Penjualan_Online;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class dashboard_Controller extends Controller
{
    public function index(){
        $judul = 'Dashboard';

        if(auth()->user()->role == 'admin'){
            $penjualanOnline = Penjualan_Online::all()->count();
            $penjualanOffline = Penjualan_Offline::all()->count();
            $produk = Produk::where('stok',1)->count();
            $promo = Promo::where('status',1)->count();
            return view('admin.dashboard', compact('judul','penjualanOnline','penjualanOffline','produk','promo'));
        }else if(auth()->user()->role == 'owner'){
            $penjualanOnline = Penjualan_Online::all()->count();
            $penjualanOffline = Penjualan_Offline::all()->count();
            $produk = Produk::where('stok',1)->count();
            return view('owner.dashboard', compact('judul','penjualanOnline','penjualanOffline','produk'));
            
        }else if(auth()->user()->role == 'kasir'){
            $penjualanOffline = Penjualan_Offline::all()->count();
            return view('kasir.dashboard', compact('judul','penjualanOffline'));

        }
    }
}
