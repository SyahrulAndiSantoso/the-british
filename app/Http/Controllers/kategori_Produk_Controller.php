<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Produk;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class kategori_Produk_Controller extends Controller
{
    protected $kategoriProdukModel;
    public function __construct()
    {
        $this->kategoriProdukModel = new Kategori_Produk();
    }
    // Dashboard
    public function index()
    {
        $judul = 'Kategori Produk';
        return view('admin.Kategori_Produk', compact('judul'));
    }

    public function data_Kategori_Produk()
    {
        return DataTables::of(
            Kategori_Produk::select('nama_kategori_produk', 'id_kategori_produk')
                ->latest()
                ->get(),
        )
            ->addColumn('aksi', function ($kategori) {
                return '<a href="' .
                    route('viewEditKategoriProduk', $kategori->id_kategori_produk) .
                    '" class="' .
                    'btn btn-warning"' .
                    '><i
            class="bi bi-pencil-square"></i>Edit</a> <a href="' .
                    route('hapusKategoriProduk', $kategori->id_kategori_produk) .
                    '" class="' .
                    'btn btn-danger"' .
                    '><i
            class="bi bi-trash3-fill"></i>Hapus</a>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view_Edit($id)
    {
        $judul = 'Form Edit Kategori';
        $data = Kategori_Produk::find($id);
        return view('admin.edit.edit_Kategori_Produk', compact('judul', 'data'));
    }

    public function proses_Edit(Request $request)
    {
        $data = Kategori_Produk::find($request->id_kategori_produk);
        $validatedData = $request->validate([
            'nama_kategori_produk' => 'required|min:4',
        ]);
        $validatedData['nama_kategori_produk'] = strtolower($request->nama_kategori_produk);
        $data->update($validatedData);
        return redirect()
            ->route('viewKategoriProduk')
            ->with('aksi', 'Mengupdate');
    }

    public function hapus($id)
    {
        try {
            $data = Kategori_Produk::find($id);
            $data->delete($id);
            return redirect()
                ->route('viewKategoriProduk')
                ->with('aksi', 'Menghapus');
        } catch (\Exception $e) {
            return back()->with('gagal hapus', 'Gagal Menghapus');
        }
    }

    public function proses_Store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori_produk' => 'min:4',
        ]);
        $validatedData['nama_kategori_produk'] = strtolower($request->nama_kategori_produk);
        Kategori_Produk::create($validatedData);

        $filename = storage_path() . '/app/public/kota.txt';
        if (filesize($filename) == 0) {
            $response = Http::withHeaders([
                'key' => 'd4d746be89057f1deddfc549552d2557',
            ])->get('https://api.rajaongkir.com/starter/city');
            $kota = $response['rajaongkir']['results'];
            if (($file = fopen(storage_path() . '/app/public/kota.txt', 'w')) !== false) {
                foreach ($kota as $row) {
                    fputcsv($file, $row);
                }
                fclose($file);
            }
        }

        return redirect()
            ->route('viewKategoriProduk')
            ->with('aksi', 'Menambahkan');
    }
// halaman pembeli
    public function view_Kategori_Produk()
    {
        $judul = 'Kategori Produk';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        return view('pembeli.kategori_produk', compact('judul', 'kategori'));
    }
}
