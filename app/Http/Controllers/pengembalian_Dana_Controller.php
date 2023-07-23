<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian_Dana;
use App\Models\Detail_Penjualan_Online;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Penjualan_Online;

class pengembalian_Dana_Controller extends Controller
{
    public function index(){
        $judul = 'Pengembalian Dana';
        $pengembalianDana = Pengembalian_Dana::select('penjualan_online_id','bukti','total_dana','keterangan')->latest()->get();
        if(auth()->user()->role == 'admin'){
            return view('admin.pengembalian_Dana', compact('judul','pengembalianDana'));
            
        }else{
            return view('owner.pengembalian_Dana', compact('judul','pengembalianDana'));

        }
    }

    public function view_Tambah($id){
        $judul ='Form Pengembalian Dana';
        return view('admin.tambah.tambah_Pengembalian_Dana', compact('judul','id'));
    }

    public function proses_Store(Request $request){
        $validatedData = $request->validate([
            'bukti' => 'required|image|max:1024',
            'total_dana' => 'required',
            'keterangan' => 'required|min:7',
            'penjualan_online_id' => 'required',
        ]);
        $total_dana = str_replace(',', '', $request->total_dana);
        $validatedData['total_dana']=$total_dana;

        $gambar = $request->file('bukti');
        $cekDirektory = Storage::disk('public')->exists('bukti-pengembalian-dana');
        if (!$cekDirektory) {
            Storage::makeDirectory('public/bukti-pengembalian-dana');
        }

        $namaGambar = 'bukti-pengembalian-dana/' . time() . $gambar->getClientOriginalName();
        
        Image::make($request->file('bukti'))
            ->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('storage/' . $namaGambar);
        $validatedData['bukti'] = $namaGambar;
        Pengembalian_Dana::create($validatedData);
        return redirect()->route('viewPengembalianDanaAdmin')
        ->with('aksi', 'Menambahkan');
    }

}
