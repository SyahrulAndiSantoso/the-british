<?php

namespace App\Http\Controllers;

use App\Models\Detail_Produk;
use App\Models\Detail_Promo;
use App\Models\Kategori_Produk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class produk_Controller extends Controller
{
    protected $produkModel;
    public function __construct()
    {
        $this->produkModel = new Produk();
    }
    // Function untuk halaman dashboard
    public function index()
    {
        $judul = 'Produk';
        $kategori = Kategori_Produk::all();

        return view('admin.produk', compact('judul', 'kategori'));
    }

    public function data_produk()
    {
        $data = Produk::select(['id_produk', 'kategori_produk_id', 'nama_produk', 'thumbnail', 'stok', 'ukuran', 'harga', 'merk', 'deskripsi'])
            ->with(['kategori_produk'])
            ->latest()
            ->get();
        return DataTables::of($data)
            ->editColumn('thumbnail', function ($produk) {
                $url = asset('storage/' . "$produk->thumbnail");
                return '<img src="' . $url . '" width="100" />';
            })
            ->addColumn('aksi', function ($produk) {
                return '<a href="' .
                    route('viewEditProduk', $produk->id_produk) .
                    '" class="' .
                    'btn btn-warning"' .
                    '><i
            class="bi bi-pencil-square"></i>Edit</a> <a href="' .
                    route('hapusProduk', $produk->id_produk) .
                    '" class="' .
                    'btn btn-danger"' .
                    '><i
            class="bi bi-trash3-fill"></i>Hapus</a> <a href="' .
                    route('viewDetailProduk', $produk->id_produk) .
                    '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
            })
            ->editColumn('harga', function ($produk) {
                return 'Rp ' . number_format($produk->harga, 0, ',', '.');
            })
            ->rawColumns(['aksi', 'thumbnail'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view_Edit(Produk $produk)
    {
        $judul = 'Produk';
        $kategori = Kategori_Produk::all();
        $data = Produk::find($produk->id_produk);
        return view('admin.edit.edit_Produk', compact('judul', 'data', 'kategori'));
    }

    public function proses_Edit(Request $request)
    {
        $data = Produk::find($request->id_produk);
        $validatedData = $request->validate([
            'kategori_produk_id' => 'required',
            'nama_produk' => 'required|min:4',
            'stok' => 'required',
            'ukuran' => 'required',
            'harga' => 'required',
            'merk' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'required|image',
        ]);
        Storage::delete($request->thumbnailLama);

        $gambar = $request->file('thumbnail');
        $cekDirektory = Storage::disk('public')->exists('gambar-produk');
        if (!$cekDirektory) {
            Storage::makeDirectory('public/gambar-produk');
        }
        $namaGambar = 'gambar-produk/' . time() . $gambar->getClientOriginalName();
        Image::make($request->file('thumbnail'))
            ->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save('storage/' . $namaGambar);
        $validatedData['thumbnail'] = $namaGambar;
        $validatedData['nama_produk'] = ucwords($request->nama_produk);
        $validatedData['nama_produk'] = ucwords($request->nama_produk);
        $validatedData['ukuran'] = strtoupper($request->ukuran);
        $validatedData['merk'] = strtoupper($request->merk);
        $data->update($validatedData);
        return redirect()
            ->route('viewProduk')
            ->with('aksi', 'Mengupdate');
    }

    public function proses_Store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_produk_id' => 'required',
            'nama_produk' => 'required|min:4',
            'ukuran' => 'required',
            'harga' => 'required',
            'merk' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'required|image',
        ]);
        $gambar = $request->file('thumbnail');
        $cekDirektory = Storage::disk('public')->exists('gambar-produk');
        if (!$cekDirektory) {
            Storage::makeDirectory('public/gambar-produk');
        }

        $namaGambar = 'gambar-produk/' . time() . $gambar->getClientOriginalName();
        Image::make($request->file('thumbnail'))
            ->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save('storage/' . $namaGambar);
        $validatedData['thumbnail'] = $namaGambar;
        $validatedData['nama_produk'] = ucwords($request->nama_produk);
        $validatedData['ukuran'] = strtoupper($request->ukuran);
        $validatedData['merk'] = strtoupper($request->merk);
        $validatedData['stok'] = 'ada';
        Produk::create($validatedData);
        $produk = $this->produkModel->getLastIdProduk()->first();

        return redirect()
            ->route('viewDetailProduk', $produk->id_produk)
            ->with('status', 'baru');
    }

    public function proses_Checkout()
    {
        $produk = $this->produkModel->getLastIdProduk()->first();
        $detailProduk = Detail_Produk::where('produk_id', $produk->id_produk);

        if ($detailProduk->count()) {
            return redirect()
                ->route('viewProduk')
                ->with('aksi', 'Menambahkan');
        }
        return redirect()
            ->route('viewDetailProduk', $produk->id_produk)
            ->with([
                'gagal' => 'Menambahkan',
                'status' => 'baru',
            ]);
    }

    public function hapus(Produk $produk)
    {
        try {
            $data = Produk::find($produk->id_produk);
            $data->delete($produk->id_produk);
            return redirect()
                ->route('viewProduk')
                ->with('aksi', 'Menghapus');
        } catch (\Exception $e) {
            return back()->with('gagal hapus', 'Gagal Menghapus');
        }
    }

    public function view_Detail_Produk($id)
    {
        $judul = 'Produk';
        $produk = $this->produkModel->getLastIdProduk()->first();
        $detailProduk = Detail_Produk::where('produk_id', $id)->get();
        $idLast = $produk->id_produk;
        return view('admin.detail_produk', compact('judul', 'id', 'idLast', 'detailProduk'));
    }

    public function data_Detail_Produk(Produk $produk)
    {
        $data = Detail_Produk::where('produk_id', $produk->id_produk);
        return DataTables::of($data)
            ->addColumn('gambar', function ($dataDetailProduk) {
                $url = asset('storage/' . "$dataDetailProduk->gambar");
                return '<img src="' . $url . '" width="400" />';
            })
            ->addColumn('aksi', function ($detailProduk) {
                return '<a href="' .
                    route('hapusDetailProduk', $detailProduk->id_detail_produk) .
                    '" class="' .
                    'btn btn-danger"' .
                    '><i
    class="bi bi-trash3-fill"></i>Hapus</a>';
            })
            ->rawColumns(['gambar', 'aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store_Detail_Produk(Request $request)
    {
        $validatedData = $request->validate([
            'gambar' => 'required|image',
        ]);
        $gambar = $request->file('gambar');
        $namaGambar = 'gambar-produk/' . time() . $gambar->getClientOriginalName();
        Image::make($request->file('gambar'))
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save('storage/' . $namaGambar);
        $validatedData['produk_id'] = $request->produk_id;
        $validatedData['gambar'] = $namaGambar;
        Detail_Produk::create($validatedData);
        return redirect()
            ->route('viewDetailProduk', $request->produk_id)
            ->with([
                'aksi' => 'Menambahkan',
                'status' => 'baru',
            ]);
    }

    public function hapus_Detail_Produk(Detail_Produk $detail_produk)
    {
        $data = Detail_Produk::find($detail_produk->id_detail_produk);
        Storage::delete($data->gambar);
        $data->delete($detail_produk->id_detail_produk);
        return redirect()
            ->route('viewDetailProduk', $data->produk_id)
            ->with([
                'aksi' => 'Menghapus',
                'status' => 'baru',
            ]);
    }
    // Function untuk halaman pembeli
    public function view_Produk_Pembeli()
    {
        $produk = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.stok', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi')
            ->leftjoin('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([['produks.stok', '!=', 'tidak ada'], ['produks.nama_produk', 'like', '%' . request('search') . '%']])
            ->orWhere('produks.merk', 'like', '%' . request('search') . '%')
            ->orWhere('kategori__produks.nama_kategori_produk', 'like', '%' . request('search') . '%')
            ->latest('produks.id_produk')
            ->get();
        if (!request('search') || $produk->count() == 0) {
            $produk = null;
        }
        $judul = 'Produk';

        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        return view('pembeli.produk', compact('produk', 'judul', 'kategori'));
    }

    public function view_Detail_Produk_Pembeli($id)
    {
        $id_produk = decrypt($id);
        $detailProduk = Detail_Produk::select('gambar')
            ->without('produk')
            ->where('produk_id', $id_produk)
            ->get();

        $produk = Produk::select('produks.id_produk', 'produks.deskripsi as deskripsi_produk', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'kategori__produks.nama_kategori_produk', 'promos.nama_promo', 'promos.id_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi as deskripsi_promo')
            ->leftjoin('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
            ->leftjoin('detail__produks', 'produks.id_produk', '=', 'detail__produks.produk_id')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.id_produk' => $id_produk,
            ])
            ->first();

        $produkPromo = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'promos.id_promo', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.deskripsi')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
                'promos.status' => 1,
                'promos.id_promo' => $produk->id_promo,
            ])
            ->limit(8)
            ->get();

        $allProduk = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.harga', 'produks.thumbnail', 'produks.merk', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
            ])
            ->limit(8)
            ->latest('produks.id_produk')
            ->get();

        $judul = 'Detail Produk';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();

        return view('pembeli.detail_produk', compact('detailProduk', 'produk', 'allProduk', 'produkPromo', 'judul', 'kategori'));
    }

    public function view_Semua_Produk_Pembeli()
    {
        $judul = 'Semua Produk';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $produk = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.harga', 'produks.thumbnail', 'produks.merk', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
            ])
            ->get();

        return view('pembeli.produk', compact('produk', 'judul', 'kategori'));
    }

    public function view_Semua_Produk_Promo_Pembeli($id)
    {
        $id_promo = decrypt($id);
        $judul = 'Semua Produk Promo';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $produk = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi')
            ->leftjoin('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
                'promos.id_promo' => $id_promo,
            ])
            ->get();
            dd($produk);
        return view('pembeli.produk', compact('produk', 'judul', 'kategori'));
    }

    public function view_Semua_Produk_Kategori($id)
    {
        $nama_kategori_produk = $id;
        $judul = 'Produk';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $produk = Produk::select('produks.id_produk', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk', 'produks.stok', 'promos.nama_promo', 'promos.diskon', 'promos.tipe', 'promos.status', 'promos.deskripsi')
            ->leftjoin('kategori__produks', 'produks.kategori_produk_id', '=', 'kategori__produks.id_kategori_produk')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->where([
                'produks.stok' => 'ada',
                'kategori__produks.nama_kategori_produk' => $nama_kategori_produk,
            ])
            ->latest('produks.id_produk')
            ->get();

        return view('pembeli.produk', compact('produk', 'judul', 'kategori'));
    }
}
