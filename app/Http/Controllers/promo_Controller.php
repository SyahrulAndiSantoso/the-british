<?php

namespace App\Http\Controllers;

use App\Models\Detail_Produk;
use App\Models\Detail_Promo;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class promo_Controller extends Controller
{
    protected $promoModel;
    public function __construct()
    {
        $this->promoModel = new Promo();
    }
    public function index()
    {
        $judul = 'Promo';
        return view('admin.promo', compact('judul'));
    }

    public function data_Promo()
    {
        return DataTables::of(
            Promo::select('id_promo', 'nama_promo', 'diskon', 'deskripsi', 'tipe', 'tgl_mulai', 'tgl_berakhir', 'status')
                ->latest()
                ->get(),
        )
            ->addColumn('aksi', function ($promo) {
                return '<a href="' .
                    route('viewEditPromo', $promo->id_promo) .
                    '" class="' .
                    'btn btn-warning"' .
                    '><i
            class="bi bi-pencil-square"></i>Edit</a> <a href="' .
                    route('hapusPromo', $promo->id_promo) .
                    '" class="' .
                    'btn btn-danger"' .
                    '><i
            class="bi bi-trash3-fill"></i>Hapus</a> <a href="' .
                    route('viewDetailPromo', $promo->id_promo) .
                    '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
            })
            ->editColumn('diskon', function ($promo) {
                return $promo->diskon . '%';
            })
            ->editColumn('tgl_mulai', function($promo){
                $tgl = $promo->tgl_mulai;
                return $tgl->format('d M Y');

            })
            ->editColumn('tgl_berakhir', function($promo){
                $tgl = $promo->tgl_berakhir;
                return $tgl->format('d M Y');

            })
            ->editColumn('status', function ($promo) {
                if ($promo->status == 1) {
                    return '<span class="text-white badge bg-success">Aktif</span>';
                } else {
                    return '<span class="text-white badge bg-danger">Non Aktif</span>';
                }
            })
            ->rawColumns(['aksi', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store_Promo(Request $request)
    {
        $validatedData = $request->validate([
            'nama_promo' => 'required',
            'diskon' => 'required',
            'jumlah' => 'required',
            'tipe' => 'required',
            'tgl_mulai' => 'required',
            'tgl_berakhir' => 'required',
        ]);

        $validatedData['status'] = 1;
        $validatedData['nama_promo'] = ucwords($request->nama_promo);

        if ($request->tipe == 'minimal pembelian') {
            $validatedData['deskripsi'] = 'Beli ' . $request->jumlah . ' Diskon ' . $request->diskon . '%';
        } else {
            $validatedData['deskripsi'] = 'Diskon ' . $request->diskon . '%';
        }

        $promo = Promo::create($validatedData);
        return redirect()->route('viewDetailPromo', $promo->id_promo);
    }

    public function proses_Hapus_Promo(Promo $promo)
    {
        try {
            $promo->delete($promo->id_promo);
            return redirect()
                ->route('viewPromo')
                ->with('aksi', 'Menghapus');
        } catch (\Exception $e) {
            return back()->with('gagal hapus', 'Gagal Menghapus');
        }
    }

    public function view_Edit_Promo(Promo $promo)
    {
        $judul = 'Promo';
        return view('admin.edit.edit_Promo', compact('promo', 'judul'));
    }

    public function proses_Edit_Promo(Request $request)
    {
        $validatedData = $request->validate([
            'nama_promo' => 'required|min:3',
            'diskon' => 'required',
            'tipe' => 'required',
            'jumlah' => 'required',
            'tgl_mulai' => 'required',
            'tgl_berakhir' => 'required',
            'status' => 'required',
        ]);
        $validatedData['nama_promo'] = ucwords($request->nama_promo);

        if ($request->tipe == 'minimal pembelian') {
            $validatedData['deskripsi'] = 'Beli ' . $request->jumlah . ' Diskon ' . $request->diskon . '%';
        } else {
            $validatedData['deskripsi'] = 'Diskon ' . $request->diskon . '%';
        }

        $promo = Promo::find($request->id_promo);
        $promo->update($validatedData);
        return redirect()
            ->route('viewPromo')
            ->with('aksi', 'Mengupdate');
    }

    public function view_Detail_Promo(Promo $promo)
    {
        $judul = 'Detail Promo';
        $produk = null;
        if (request('search')) {
            $produk = Produk::where('id_produk', request('search'))->get();
        }
        return view('admin.detail_promo', compact('judul', 'produk', 'promo'));
    }

    public function data_Detail_Promo($id)
    {
        $data = Detail_Promo::select('detail__promos.*', 'produks.*','merks.nama_merk','ukurans.ukuran', 'promos.*')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
            ->join('ukurans', 'produks.ukuran_id', '=', 'ukurans.id_ukuran')
            ->where('detail__promos.promo_id', $id)
            ->get();
        return DataTables::of($data)
            ->editColumn('harga', function ($detailPromo) {
                return 'Rp ' . number_format($detailPromo->harga, 0, ',', '.');
            })
            ->addColumn('aksi', function ($detailPromo) {
                return '<a href="' . route('hapusDetailPromo', $detailPromo->id_detail_promo) . '" class="' . 'btn btn-danger"' . '><i class="bi bi-trash3-fill"></i>Hapus</a>';
            })
            ->addColumn('gambar', function ($detailPromo) {
                $url = asset('storage/' . "$detailPromo->thumbnail");
                return '<img src="' . $url . '" width="100" />';
            })
            ->rawColumns(['aksi', 'gambar'])
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store_Detail_Promo(Request $request)
    {
        $cekPromo = Produk::select('produks.id_produk')
            ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where('promos.id_promo', $request->idpromo)
            ->where('produks.id_produk', $request->idproduk)
            ->first();

        $cekProduk = Produk::select('produks.id_produk')
            ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where('promos.status', 1)
            ->where('promos.id_promo', '!=', $request->idpromo)
            ->where('produks.id_produk', $request->idproduk)
            ->first();

        if ($cekPromo) {
            return redirect()
                ->route('viewDetailPromo', $request->idpromo)
                ->with([
                    'gagal' => 'Produk Sudah Ditambahkan',
                ]);
        } elseif ($cekProduk) {
            return redirect()
                ->route('viewDetailPromo', $request->idpromo)
                ->with([
                    'gagal' => 'Produk Sedang Berada Pada Promo Yang Lain',
                ]);
        } else {
            $dataDetailPromo = [
                'produk_id' => $request->idproduk,
                'promo_id' => $request->idpromo,
            ];
            Detail_Promo::create($dataDetailPromo);
            return redirect()
                ->route('viewDetailPromo', $request->idpromo)
                ->with([
                    'aksi' => 'Menambahkan',
                ]);
        }
    }

    public function proses_Hapus_Detail_Promo(Detail_Promo $detail_promo)
    {
        $detail_promo->delete($detail_promo->id_detail_promo);
        return redirect()
            ->route('viewDetailPromo', $detail_promo->promo->id_promo)
            ->with([
                'aksi' => 'Menghapus',
            ]);
    }

    public function proses_Checkout(Promo $promo)
    {
        $detailPromo = Detail_Promo::where('promo_id', $promo->id_promo);
        if ($detailPromo->count()) {
            return redirect()->route('viewPromo')->with([
                'aksi' => 'Menambahkan',
            ]);
        } else {
            return redirect()
                ->route('viewDetailPromo', $promo->id_promo)
                ->with('gagal', 'Menambahkan');
        }
    }
}
