<?php

namespace App\Http\Controllers;

use App\Models\Pembelian_Ball;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class pembelian_Ball_Controller extends Controller
{
    protected $pembelianBallModel;
    public function __construct()
    {
        $this->pembelianBallModel = new Pembelian_Ball();
    }
    public function index()
    {
        $judul = 'Pembelian Ball';
        if (auth()->user()->role == 'admin') {
            return view('admin.pembelian_Ball', compact('judul'));
        } elseif (auth()->user()->role == 'owner') {
            return view('owner.pembelian_Ball', compact('judul'));
        }
    }

    public function data_Pembelian_Ball()
    {
        return DataTables::of(
            Pembelian_Ball::select('id_pembelian_ball', 'nama_ball', 'tgl_beli', 'total_pakaian')
                ->latest()
                ->get(),
        )
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ball' => 'required',
            'tgl_beli' => 'required',
            'total_pakaian' => 'required',
        ]);

        Pembelian_Ball::create($validatedData);
        return redirect()
            ->route('viewPembelianBallAdmin')
            ->with('aksi', 'Menambahkan');
    }
}
