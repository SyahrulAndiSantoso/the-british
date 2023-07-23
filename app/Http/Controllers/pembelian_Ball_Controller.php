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
            Pembelian_Ball::select('id_pembelian_ball', 'nama_ball', 'tgl_beli','layak_pakai', 'tidak_layak_pakai', 'total_pakaian', 'supplier')
            ->latest()
                ->get(),
        )
        ->editColumn('tgl_beli', function($pembelianBall){
            $tgl = $pembelianBall->tgl_beli;
            return $tgl->format('d M Y');
        })
        ->editColumn('supplier', function($pembelianBall){
            if($pembelianBall->supplier){
                return $pembelianBall->supplier;
            }else{
                return 'tidak ada';
            }
        })
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ball' => 'required',
            'tgl_beli' => 'required',
            'layak_pakai' => 'required',
            'tidak_layak_pakai' => 'required',
        ]);
        $validatedData['total_pakaian'] = $request->layak_pakai+$request->tidak_layak_pakai;
        if($request->supplier){
            $validatedData['supplier']=$request->supplier;
        }

        Pembelian_Ball::create($validatedData);
        return redirect()
            ->route('viewPembelianBallAdmin')
            ->with('aksi', 'Menambahkan');
    }
}
