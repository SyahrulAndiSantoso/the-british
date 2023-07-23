<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ukuran;
use Yajra\DataTables\Facades\DataTables;

class ukuran_Controller extends Controller
{
    public function index(){
        $judul = 'Ukuran';
        return view('admin.ukuran', compact('judul'));
    }

    public function data_ukuran(){
        $data = Ukuran::select('id_ukuran','ukuran')
        ->latest('created_at')->get();
        return DataTables::of($data)
        ->addColumn('aksi',function($ukuran){
            return '<a href="' .
            route('viewEditUkuran', $ukuran->id_ukuran) .
            '" class="' .
            'btn btn-warning"' .
            '><i
    class="bi bi-pencil-square"></i>Edit</a> <a href="' .
            route('hapusUkuran', $ukuran->id_ukuran) .
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

        $validatedData=$request->validate([
            'ukuran' =>'required'
        ]);
        $validatedData['ukuran']=strtoupper($request->ukuran);
        Ukuran::create($validatedData);
        return redirect()
                ->route('viewUkuran')
                ->with('aksi', 'Menambahkan');
    }

    public function hapus(Ukuran $ukuran){
        try{
            $ukuran->delete($ukuran->id_ukuran);
            return redirect()
                ->route('viewUkuran')
                ->with([
                    'aksi' => 'Menghapus'
                ]);
        }catch(\Exception $e){
            return back()->with('gagal hapus', 'Gagal Menghapus');
        }
       
    }

    public function view_Edit(Ukuran $ukuran){
        $judul = 'Ukuran';
        $data = Ukuran::select('id_ukuran','ukuran')->first();
        return view('admin.edit.edit_Ukuran', compact('judul', 'data'));
    }

    public function proses_Edit(Request $request){
       
        $data = Ukuran::find($request->id_ukuran)->first();
        $validatedData = $request->validate([
            'ukuran' => 'required|regex:/^[a-zA-Z]+$/u'
        ]);
        $validatedData['ukuran']=strtoupper($request->ukuran);
        $data->update($validatedData);
        return redirect()
            ->route('viewUkuran')
            ->with('aksi', 'Mengupdate');
    }
}
