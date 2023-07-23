<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merk;
use Yajra\DataTables\Facades\DataTables;

class merk_Controller extends Controller
{
    public function index(){
        $judul = 'Merk';
        return view('admin.merk', compact('judul'));
    }

    public function data_merk(){
        $data = Merk::select('id_merk','nama_merk')
        ->latest('created_at')->get();
        return DataTables::of($data)
        ->addColumn('aksi',function($merk){
            return '<a href="' .
            route('viewEditMerk', $merk->id_merk) .
            '" class="' .
            'btn btn-warning"' .
            '><i
    class="bi bi-pencil-square"></i>Edit</a> <a href="' .
            route('hapusMerk', $merk->id_merk) .
            '" class="' .
            'btn btn-danger"' .
            '><i
    class="bi bi-trash3-fill"></i>Hapus</a>';
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function proses_Store(Request $request){
        $validatedData = $request->validate([
            'nama_merk' => 'required|min:3'
        ]);
        $validatedData['nama_merk'] = strtoupper($request->nama_merk);
        Merk::create($validatedData);
        return redirect()
                ->route('viewMerk')
                ->with('aksi', 'Menambahkan');
    }

    public function hapus(Merk $merk){
        try{
            $merk->delete($merk->id_merk);
            return redirect()
                ->route('viewMerk')
                ->with([
                    'aksi' => 'Menghapus'
                ]);
        }catch(\Exception $e){
            return back()->with('gagal hapus', 'Gagal Menghapus');
        }
        
    }

    public function view_Edit(Merk $merk){
        $judul = 'Merk';
        $data = Merk::select('id_merk','nama_merk')->first();
        return view('admin.edit.edit_Merk', compact('judul', 'data'));
    }

    public function proses_Edit(Request $request){
       
        $data = Merk::find($request->id_merk)->first();
        $validatedData = $request->validate([
            'nama_merk' => 'required|min:3'
        ]);
        $validatedData['nama_merk']=strtoupper($request->nama_merk);
        $data->update($validatedData);
        return redirect()
            ->route('viewMerk')
            ->with('aksi', 'Mengupdate');
    }
}
