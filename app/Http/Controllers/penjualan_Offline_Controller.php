<?php

namespace App\Http\Controllers;

use App\Models\Detail_Penjualan_Offline;
use App\Models\Detail_Produk;
use App\Models\Detail_Promo;
use App\Models\Penjualan_Offline;
use App\Models\Produk;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;

class penjualan_Offline_Controller extends Controller
{
    protected $penjualanOfflineModel;
    public function __construct()
    {
        $this->penjualanOfflineModel = new Penjualan_Offline();
    }

    public function index()
    {
        $judul = 'Penjualan Offline';
        if (auth()->user()->role == 'admin') {
            return view('admin.penjualan_Offline', compact('judul'));
        } elseif (auth()->user()->role == 'kasir') {
            return view('kasir.penjualan_Offline', compact('judul'));
        } elseif (auth()->user()->role == 'owner') {
            return view('owner.penjualan_Offline', compact('judul'));
        }
    }

    public function data_Penjualan_Offline()
    {
        $data = Penjualan_Offline::where('status', '!=', 2)->get();

        return DataTables::of($data)
            ->editColumn('status', function ($penjualanOffline) {
                if ($penjualanOffline->status == '1') {
                    return '<span class="text-white badge bg-success">Success</span>
                    ';
                } elseif ($penjualanOffline->status == '5') {
                    return '<span class="text-white badge bg-danger">Cancel</span>
                    ';
                }
            })
            ->editColumn('total', function ($penjualanOffline) {
                return 'Rp ' . number_format($penjualanOffline->total, 0, ',', '.');
            })
            ->editColumn('diterima', function ($penjualanOffline) {
                return 'Rp ' . number_format($penjualanOffline->diterima, 0, ',', '.');
            })
            ->editColumn('kembalian', function ($penjualanOffline) {
                return 'Rp ' . number_format($penjualanOffline->kembalian, 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualanOffline) {
                if (auth()->user()->role == 'admin') {
                    return '<a href="' .
                        route('viewDetailPenjualanOfflineAdmin', $penjualanOffline->id_penjualan_offline) .
                        '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                } elseif (auth()->user()->role == 'owner') {
                    return '<a href="' .
                        route('viewDetailPenjualanOfflineOwner', $penjualanOffline->id_penjualan_offline) .
                        '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                } elseif (auth()->user()->role == 'kasir') {
                    if ($penjualanOffline->status == 5) {
                        return '<a href="' .
                            route('viewDetailPenjualanOffline', $penjualanOffline->id_penjualan_offline) .
                            '" class="btn btn-primary"><i
                class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                    } else {
                        return '<a href="' .
                            route('membatalkanPenjualanOffline', $penjualanOffline->id_penjualan_offline) .
                            '" class="' .
                            'btn btn-danger"' .
                            '><i
                        class="bi bi-x"></i>Membatalkan</a> <a href="' .
                            route('viewDetailPenjualanOffline', $penjualanOffline->id_penjualan_offline) .
                            '" class="btn btn-primary"><i
                class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                    }
                }
            })
            ->rawColumns(['status', 'aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view_Tambah_Penjualan_Offline()
    {
        $judul = 'Penjualan Offline';
        $produk = Produk::latest();
        $detailProduk = Detail_Produk::latest();
        $penjualanOffline = penjualan_Offline::select('total')
            ->where(['status'=> 2])
            ->first();
        if (request('search')) {
            $produk = Produk::select('thumbnail', 'nama_produk', 'merk', 'stok', 'harga', 'id_produk')
                ->without(['kategori_produk'])
                ->where('id_produk', 'like', '%' . request('search') . '%')
                ->get();
        }
        return view('kasir.tambah.tambah_Penjualan_Offline', compact('judul', 'produk', 'penjualanOffline'));
    }

    public function data_Tambah_Penjualan_Offline()
    {
        $data = Detail_Penjualan_Offline::select('id_detail_penjualan_offline', 'diskon', 'produks.*', 'penjualan__offlines.*')
            ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
            ->where('penjualan__offlines.status', 2)
            ->get();
        return DataTables::of($data)
            ->addColumn('aksi', function ($detailPenjualanOffline) {
                return '<a href="' .
                    route('hapusDetailPenjualanOffline', $detailPenjualanOffline->id_detail_penjualan_offline) .
                    '" class="' .
                    'btn btn-danger"' .
                    '><i
        class="bi bi-trash3-fill"></i>Hapus</a>';
            })
            ->addColumn('gambar', function ($detailPenjualanOffline) {
                $url = asset('storage/' . "$detailPenjualanOffline->thumbnail");
                return '<img src="' . $url . '" width="100" />';
            })
            ->editColumn('diskon', function ($detailPenjualanOffline) {
                if ($detailPenjualanOffline->diskon == 0) {
                    return 'Tidak Ada';
                } else {
                    return $detailPenjualanOffline->diskon . '%';
                }
            })
            ->editColumn('harga', function ($detailPenjualanOffline) {
                if ($detailPenjualanOffline->diskon != 0) {
                    $hargaDiskon = $detailPenjualanOffline->harga - ($detailPenjualanOffline->harga * $detailPenjualanOffline->diskon) / 100;
                    return '<span class="coret"> Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.') . '</span> Rp ' . number_format($hargaDiskon, 0, ',', '.');
                } else {
                    return 'Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.');
                }
            })
            ->rawColumns(['aksi', 'gambar', 'harga'])
            ->addIndexColumn()
            ->make(true);
    }

    public function proses_Store_Penjualan_Offline(Produk $produk)
    {
        $penjualanOffline = Penjualan_Offline::select('id_penjualan_offline')
            ->where('status', 2)
            ->first();

        $detailPromo = Detail_Promo::select('promos.tipe', 'promos.id_promo', 'promos.jumlah', 'promos.diskon')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->where([
                'detail__promos.produk_id' => $produk->id_produk,
                'promos.status' => 1,
            ])
            ->first();
        if ($penjualanOffline) {
            $dataDetailPenjualanOffline = [
                'penjualan_offline_id' => $penjualanOffline->id_penjualan_offline,
                'produk_id' => $produk->id_produk,
                'diskon' => 0,
                'status' => 1,
            ];
            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::create($dataDetailPenjualanOffline);

            if ($detailPromo) {
                if ($detailPromo->tipe == 'potongan harga') {
                    $updateDetailPenjualanOffline->update([
                        'diskon' => $detailPromo->diskon,
                    ]);
                } elseif ($detailPromo->tipe == 'minimal pembelian') {
                    $keranjang = Detail_Penjualan_Offline::select('detail__penjualan__offlines.id_detail_penjualan_offline', 'detail__penjualan__offlines.diskon', 'produks.id_produk')
                        ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
                        ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
                        ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                        ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                        ->where('penjualan__offlines.status', 2)
                        ->where('promos.id_promo', $detailPromo->id_promo)
                        ->get();

                    if ($keranjang) {
                        if ($keranjang->count() % $detailPromo->jumlah == 0) {
                            foreach ($keranjang as $data) {
                                $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                    'penjualan_offline_id' => $penjualanOffline->id_penjualan_offline,
                                    'produk_id' => $data->id_produk,
                                ])->first();
                                $updateDetailPenjualanOffline->update([
                                    'diskon' => $detailPromo->diskon,
                                ]);
                            }
                        }
                    }
                }
            }
        } else {
            $tgl = Carbon::now();
            $dataPenjualanOffline = [
                'status' => 2,
                'tgl' => $tgl,
            ];
            $penjualanOffline = Penjualan_Offline::create($dataPenjualanOffline);

            $dataDetailPenjualanOffline = [
                'penjualan_offline_id' => $penjualanOffline->id_penjualan_offline,
                'produk_id' => $produk->id_produk,
                'diskon' => 0,
                'status' => 1,
            ];
            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::create($dataDetailPenjualanOffline);

            if ($detailPromo) {
                if ($detailPromo->tipe == 'potongan harga') {
                    $updateDetailPenjualanOffline->update([
                        'diskon' => $detailPromo->diskon,
                    ]);
                } elseif ($detailPromo->tipe == 'minimal pembelian') {
                    $keranjang = Detail_Penjualan_Offline::select('detail__penjualan__offlines.id_detail_penjualan_offline', 'detail__penjualan__offlines.diskon', 'produks.id_produk')
                        ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
                        ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
                        ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                        ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                        ->where('penjualan__offlines.status', 2)
                        ->where('promos.id_promo', $detailPromo->id_promo)
                        ->get();

                    if ($keranjang->count() % $detailPromo->jumlah == 0) {
                        foreach ($keranjang as $data) {
                            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                'penjualan_offline_id' => $penjualanOffline->id_penjualan_offline,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOffline->update([
                                'diskon' => $detailPromo->diskon,
                            ]);
                        }
                    }
                }
            }
        }
        $produk->update(['stok' => 'tidak ada']);
        $total = $this->penjualanOfflineModel->getTotal();
        $penjualanOffline->update([
            'total' => intval($total->total_diskon) + intval($total->total_bukan_diskon),
        ]);

        return redirect()
            ->route('viewTambahPenjualanOffline')
            ->with([
                'aksi' => 'Menambahkan',
                'halaman' => 'Produk',
            ]);
    }

    public function hapus_Detail_Penjualan_Offline($id)
    {
        $dataDetailPenjualanOffline = Detail_Penjualan_Offline::without(['penjualan_offline', 'produk'])->find($id);
        $detailPromo = Detail_Promo::select('promos.*', 'detail__promos.*')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->where([
                'detail__promos.produk_id' => $dataDetailPenjualanOffline->produk_id,
                'promos.status' => 1,
            ])
            ->first();
        $dataDetailPenjualanOffline->delete($id);
        $produk = Produk::find($dataDetailPenjualanOffline->produk_id);
        $produk->update(['stok' => 'ada']);
        if ($detailPromo) {
            if ($detailPromo->tipe == 'minimal pembelian') {
                $keranjang = Detail_Penjualan_Offline::select('detail__penjualan__offlines.id_detail_penjualan_offline', 'detail__penjualan__offlines.diskon', 'produks.id_produk')
                    ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
                    ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
                    ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                    ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                    ->where('penjualan__offlines.status', 2)
                    ->where('promos.id_promo', $detailPromo->id_promo)
                    ->get();

                $index = 0;
                if ($keranjang->count() % $detailPromo->jumlah == 0) {
                    foreach ($keranjang as $data) {
                        $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                            'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                            'produk_id' => $data->id_produk,
                        ])->first();
                        $updateDetailPenjualanOffline->update([
                            'diskon' => $detailPromo->diskon,
                        ]);
                    }
                } else {
                    if ($keranjang->count() > 1) {
                        foreach ($keranjang as $data) {
                            $index++;
                            if ($index == $keranjang->count()) {
                                $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                    'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                    'produk_id' => $data->id_produk,
                                ])->first();
                                $updateDetailPenjualanOffline->update([
                                    'diskon' => 0,
                                ]);
                                break;
                            }
                            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOffline->update([
                                'diskon' => $detailPromo->diskon,
                            ]);
                        }
                    } elseif ($keranjang->count() == 1) {
                        foreach ($keranjang as $data) {
                            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOffline->update([
                                'diskon' => 0,
                            ]);
                        }
                    }
                }
            }
        }
        $total = $this->penjualanOfflineModel->getTotal();
        $penjualanOffline = Penjualan_Offline::where('id_penjualan_offline', $dataDetailPenjualanOffline->penjualan_offline_id)->first();
        if ($total) {
            $penjualanOffline->update([
                'total' => intval($total->total_diskon) + intval($total->total_bukan_diskon),
            ]);
        } else {
            $penjualanOffline->update([
                'total' => 0,
            ]);
        }

        return redirect()
            ->route('viewTambahPenjualanOffline')
            ->with([
                'aksi' => 'Menghapus',
                'halaman' => 'Produk',
            ]);
    }

    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'diterima' => 'required',
        ]);
        if ($request->diterima < $request->total) {
            return redirect()
                ->route('viewTambahPenjualanOffline')
                ->with('title', 'Gagal');
        } else {
            $validatedData['kembalian'] = $request->kembalian;
            $validatedData['status'] = 1;
            $penjualanOffline = Penjualan_Offline::where('status', 2)->first();
            $penjualanOffline->update($validatedData);
            return redirect()
                ->route('viewTambahPenjualanOffline')
                ->with([
                    'aksi' => 'Checkout',
                    'halaman' => 'Penjualan Offline',
                ]);
        }
    }

    public function view_Detail_Penjualan_Offline($id)
    {
        $judul = 'Penjualan Offline';
        $penjualanOffline = Penjualan_Offline::where('id_penjualan_offline', $id)->first();
        if (auth()->user()->role == 'kasir') {
            return view('kasir.detail_Penjualan_Offline', compact('judul', 'id', 'penjualanOffline'));
        } elseif (auth()->user()->role == 'admin') {
            return view('admin.detail_Penjualan_Offline', compact('judul', 'id', 'penjualanOffline'));
        } elseif (auth()->user()->role == 'owner') {
            return view('owner.detail_Penjualan_Offline', compact('judul', 'id', 'penjualanOffline'));
        }
    }

    public function data_Detail_Penjualan_Offline($id)
    {
        $data = Detail_Penjualan_Offline::select('detail__penjualan__offlines.*', 'produks.*')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
            ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
            ->where(['penjualan__offlines.id_penjualan_offline' => $id])
            ->latest()
            ->get();
        if (auth()->user()->role == 'kasir') {
            return DataTables::of($data)
                ->addColumn('gambar', function ($detailPenjualanOffline) {
                    $url = asset('storage/' . "$detailPenjualanOffline->thumbnail");
                    return '<img src="' . $url . '" width="100" />';
                })
                ->editColumn('diskon', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->diskon == 0) {
                        return 'Tidak Ada';
                    } else {
                        return $detailPenjualanOffline->diskon . '%';
                    }
                })
                ->editColumn('harga', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->diskon != 0) {
                        $hargaDiskon = $detailPenjualanOffline->harga - ($detailPenjualanOffline->harga * $detailPenjualanOffline->diskon) / 100;
                        return '<span class="coret"> Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.') . '</span> Rp ' . number_format($hargaDiskon, 0, ',', '.');
                    } else {
                        return 'Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.');
                    }
                })
                ->editColumn('status', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->status == 1) {
                        return '<span class="text-white badge bg-success">Berhasil</span>
                    ';
                    } elseif ($detailPenjualanOffline->status == 5) {
                        return '<span class="text-white badge bg-danger">Dibatalkan</span>
                    ';
                    }
                })
                ->addColumn('aksi', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->status == 1) {
                        return '<a href="' .
                            route('membatalkanDetailPenjualanOffline', $detailPenjualanOffline->id_detail_penjualan_offline) .
                            '" class="' .
                            'btn btn-danger"' .
                            '><i
            class="bi bi-x"></i>Membatalkan</a>';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['gambar', 'harga', 'status', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return DataTables::of($data)
                ->addColumn('gambar', function ($detailPenjualanOffline) {
                    $url = asset('storage/' . "$detailPenjualanOffline->thumbnail");
                    return '<img src="' . $url . '" width="100" />';
                })
                ->editColumn('diskon', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->diskon == 0) {
                        return 'Tidak Ada';
                    } else {
                        return $detailPenjualanOffline->diskon . '%';
                    }
                })
                ->editColumn('harga', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->diskon != 0) {
                        $hargaDiskon = $detailPenjualanOffline->harga - ($detailPenjualanOffline->harga * $detailPenjualanOffline->diskon) / 100;
                        return '<span class="coret"> Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.') . '</span> Rp ' . number_format($hargaDiskon, 0, ',', '.');
                    } else {
                        return 'Rp ' . number_format($detailPenjualanOffline->harga, 0, ',', '.');
                    }
                })
                ->editColumn('status', function ($detailPenjualanOffline) {
                    if ($detailPenjualanOffline->status == '1') {
                        return '<span class="text-white badge bg-success">Berhasil</span>
                    ';
                    } elseif ($detailPenjualanOffline->status == '5') {
                        return '<span class="text-white badge bg-danger">Dibatalkan</span>
                    ';
                    }
                })
                ->rawColumns(['gambar', 'harga', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function proses_Membatalkan_Detail_Penjualan_Offline($id)
    {
        $dataDetailPenjualanOffline = Detail_Penjualan_Offline::without(['penjualan_offline', 'produk'])->find($id);

        $detailPromo = Detail_Promo::select('promos.*', 'detail__promos.*')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->where([
                'detail__promos.produk_id' => $dataDetailPenjualanOffline->produk_id,
                'promos.status' => 1,
            ])
            ->first();
        $dataDetailPenjualanOffline->update(['status' => 5]);

        if ($detailPromo) {
            if ($detailPromo->tipe == 'minimal pembelian') {
                $keranjang = Detail_Penjualan_Offline::select('detail__penjualan__offlines.id_detail_penjualan_offline', 'detail__penjualan__offlines.diskon', 'produks.id_produk')
                    ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
                    ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
                    ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                    ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                    ->where('promos.id_promo', $detailPromo->id_promo)
                    ->where('detail__penjualan__offlines.status', 1)
                    ->get();

                $index = 0;
                if ($keranjang->count() % $detailPromo->jumlah == 0) {
                    foreach ($keranjang as $data) {
                        $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                            'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                            'produk_id' => $data->id_produk,
                        ])->first();
                        $updateDetailPenjualanOffline->update([
                            'diskon' => $detailPromo->diskon,
                        ]);
                    }
                } else {
                    if ($keranjang->count() > 1) {
                        foreach ($keranjang as $data) {
                            $index++;
                            if ($index == $keranjang->count()) {
                                $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                    'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                    'produk_id' => $data->id_produk,
                                ])->first();
                                $updateDetailPenjualanOffline->update([
                                    'diskon' => 0,
                                ]);
                                break;
                            }
                            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOffline->update([
                                'diskon' => $detailPromo->diskon,
                            ]);
                        }
                    } elseif ($keranjang->count() == 1) {
                        foreach ($keranjang as $data) {
                            $updateDetailPenjualanOffline = Detail_Penjualan_Offline::where([
                                'penjualan_offline_id' => $dataDetailPenjualanOffline->penjualan_offline_id,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOffline->update([
                                'diskon' => 0,
                            ]);
                        }
                    }
                }
            }
        }
        $total = $this->penjualanOfflineModel->getTotalPenjualanOffline($dataDetailPenjualanOffline->penjualan_offline_id);

        $penjualanOffline = Penjualan_Offline::where('id_penjualan_offline', $dataDetailPenjualanOffline->penjualan_offline_id)->first();
        if ($total) {
            $penjualanOffline->update([
                'total' => intval($total->total_diskon) + intval($total->total_bukan_diskon),
                'kembalian' => $penjualanOffline->diterima - (intval($total->total_diskon) + intval($total->total_bukan_diskon)),
            ]);
        }

        return redirect()->route('viewDetailPenjualanOffline', $dataDetailPenjualanOffline->penjualan_offline_id);
    }

    public function proses_Membatalkan_Penjualan_Offline($id)
    {
        $penjualanOffline = Penjualan_Offline::where('id_penjualan_offline', $id)->first();
        $penjualanOffline->update(['status' => 5]);
        $detailPenjualanOffline = Detail_Penjualan_Offline::where('penjualan_offline_id', $id)->get();
        foreach ($detailPenjualanOffline as $row) {
            $produk = Detail_Penjualan_Offline::where('id_detail_penjualan_offline', $row->id_detail_penjualan_offline)->first();
            $produk->update(['status' => 5]);
        }
        return redirect()
            ->route('viewPenjualanOfflineKasir')
            ->with([
                'aksi' => 'Checkout',
                'halaman' => 'Penjualan Offline',
            ]);
    }

    public function cetak_Kwitansi()
    {
        $options = [
            'page-width' => '80mm',
            'page-height' => '80mm',
        ];
        $pdf = SnappyPdf::loadView('kasir.kwitansi')->setOptions($options);

        return $pdf->download('kwitansi.pdf');
    }
}
