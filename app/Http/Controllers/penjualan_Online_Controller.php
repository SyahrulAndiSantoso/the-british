<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Detail_Penjualan_Online;
use App\Models\Detail_Produk;
use App\Models\Detail_Promo;
use App\Models\Kategori_Produk;
use App\Models\Ongkir;
use App\Models\Penjualan_Online;
use App\Models\Produk;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class penjualan_Online_Controller extends Controller
{
    protected $penjualanOnlineModel;
    public function __construct()
    {
        $this->penjualanOnlineModel = new Penjualan_Online();
    }

    public function index()
    {
        $judul = 'Penjualan Online';
        if (auth()->user()->role == 'admin') {
            return view('admin.penjualan_Online', compact('judul'));
        } else {
            return view('owner.penjualan_Online', compact('judul'));
        }
    }

    public function data_Penjualan_Online()
    {
        $data = Penjualan_Online::select(['id_penjualan_online', 'user_id', 'tgl', 'total', 'status'])
            ->where('status', '!=', 2)
            ->with(['user'])
            ->latest()
            ->get();
        return DataTables::of($data)
            ->addColumn('aksi', function ($penjualanOnline) {
                if (auth()->user()->role == 'admin') {
                    if ($penjualanOnline->status == 5) {
                        return '<a href="' .
                            route('viewDetailPenjualanOnline', $penjualanOnline->id_penjualan_online) .
                            '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a> <a href="https://wa.me/' .
                            $penjualanOnline->user->nomor .
                            '" class="btn btn-success"><i class="bi bi-whatsapp mr-2"></i>Whatsapp</a>
                            <a href="' .
                            route('viewTambahPengembalianDanaAdmin', $penjualanOnline->id_penjualan_online) .
                            '" class="btn btn-warning"><i class="bi bi-cash mr-2"></i>Pengembalian Dana</a>';
                    } elseif($penjualanOnline->status == 6) {
                        return '<a href="' .
                            route('membatalkanPenjualanOnline', $penjualanOnline->id_penjualan_online) .
                            '" class="' .
                            'btn btn-danger"' .
                            '><i
                    class="bi bi-x"></i>Membatalkan</a> <a href="' .
                            route('viewDetailPenjualanOnline', $penjualanOnline->id_penjualan_online) .
                            '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a><a href="' .
            route('paketDikirim', $penjualanOnline->id_penjualan_online) .
            '" class="btn btn-dark"><i class="bi bi-truck mr-2"></i>Paket Dikirim</a>';
                    }elseif($penjualanOnline->status == 7||$penjualanOnline->status == 1||$penjualanOnline->status == 4||$penjualanOnline->status == 3){
                        return '<a href="' .
                            route('viewDetailPenjualanOnline', $penjualanOnline->id_penjualan_online) .
                            '" class="btn btn-primary"><i
            class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                    }elseif($penjualanOnline->status == 12){
                        return '<a href="' .
                        route('viewDetailPenjualanOnline', $penjualanOnline->id_penjualan_online) .
                        '" class="btn btn-primary"><i
        class="bi bi-eye-fill mr-2"></i>Lihat Detail</a><a href="' .
        route('viewDetailPenjualanOnline', $penjualanOnline->id_penjualan_online) .
        '" class="btn btn-dark"><i class="bi bi-truck mr-2"></i>Paket Dikirim</a> <a href="' .
        route('viewTambahPengembalianDanaAdmin', $penjualanOnline->id_penjualan_online) .
        '" style="cursor:pointer;" class="text-white btn btn-warning"><i class="bi bi-cash mr-2"></i>Pengembalian Dana</a>
        <a href="https://wa.me/62'.$penjualanOnline->user->nomor .'" class="btn btn-success"><i class="bi bi-whatsapp mr-2"></i>Whatsapp</a>';
                    }
                } else {
                    return '<a href="' .
                        route('viewDetailPenjualanOnlineOwner', $penjualanOnline->id_penjualan_online) .
                        '" class="btn btn-primary"><i
    class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>';
                }
            })
            ->editColumn('total', function ($dataPenjualanOnline) {
                return 'Rp ' . number_format($dataPenjualanOnline->total, 0, ',', '.');
            })
            ->editColumn('tgl', function ($dataPenjualanOnline) {
                $tgl = $dataPenjualanOnline->tgl;
                return $tgl->format('d M Y');
            })
            ->editColumn('status', function ($dataPenjualanOnline) {
                if ($dataPenjualanOnline->status == 1) {
                    return '<span class="text-white badge bg-success">Transaksi Berhasil</span>
                    ';
                } elseif ($dataPenjualanOnline->status == 3) {
                    return '<span class="text-white badge bg-info">Pending</span>
                    ';
                } elseif ($dataPenjualanOnline->status == 4) {
                    return '<span class="text-white badge bg-danger">Transaksi Expired</span>
                    ';
                } elseif ($dataPenjualanOnline->status == 5) {
                    return '<span class="text-white badge bg-danger">Transaksi Dibatalkan</span>
                    ';
                } elseif($dataPenjualanOnline->status == 6||$dataPenjualanOnline->status == 12){
                    return '<span class="text-white badge bg-info">Pembayaran Berhasil</span>
                    ';
                }elseif($dataPenjualanOnline->status == 7){
                    return '<span class="text-white badge bg-dark">Paket Sedang Dikirim</span>
                    ';
                }
            })
            ->rawColumns(['aksi', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function view_Detail_Penjualan_Online($id)
    {
        $judul = 'Detail Penjualan Online';
        $ongkir = Ongkir::where('penjualan_online_id', $id)->first();
        $penjualanOnline = Penjualan_Online::select('total', 'sub_total')
            ->where('id_penjualan_online', $id)
            ->first();
        if (auth()->user()->role == 'admin') {
            return view('admin.detail_Penjualan_Online', compact('judul', 'id', 'ongkir', 'penjualanOnline'));
        } else {
            return view('owner.detail_Penjualan_Online', compact('judul', 'id', 'ongkir', 'penjualanOnline'));
        }
    }

    public function data_Detail_Penjualan_Online($id)
    {
        $data = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon', 'detail__penjualan__onlines.status', 'detail__penjualan__onlines.produk_id','produks.id_produk', 'produks.harga','produks.thumbnail','produks.nama_produk','merks.nama_merk','ukurans.ukuran')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
            ->join('ukurans', 'produks.ukuran_id', '=', 'ukurans.id_ukuran')    
            ->where('detail__penjualan__onlines.penjualan_online_id', $id)
            ->get();
        if (auth()->user()->role == 'admin') {
            return DataTables::of($data)
                ->addColumn('qty', function(){
                return '1';
                })
                ->addColumn('gambar', function ($detailPenjualanOnline) {
                    $url = asset('storage/' . $detailPenjualanOnline->thumbnail);
                    return '<img src="' . $url . '" width="100" />';
                })
                ->editColumn('diskon', function ($detailPenjualanOnline) {
                    if ($detailPenjualanOnline->diskon == 0) {
                        return 'Tidak Ada';
                    } else {
                        return $detailPenjualanOnline->diskon . '%';
                    }
                })
                ->editColumn('status', function ($detailPenjualanOnline) {
                    if ($detailPenjualanOnline->status == 1) {
                        return '<span class="text-white badge bg-success">Berhasil</span>
                    ';
                    } elseif ($detailPenjualanOnline->status == 5) {
                        return '<span class="text-white badge bg-danger">Dibatalkan</span>
                    ';
                    }
                })
                ->editColumn('harga', function ($detailPenjualanOnline) {
                    if($detailPenjualanOnline->diskon>0){
                        $hargaDiskon = $detailPenjualanOnline->harga - ($detailPenjualanOnline->harga * $detailPenjualanOnline->diskon) / 100;
                        return '<span class="coret"> Rp ' . number_format($detailPenjualanOnline->harga, 0, ',', '.') . '</span> Rp ' . number_format($hargaDiskon, 0, ',', '.');
                    }else{
                        return 'Rp ' . number_format($detailPenjualanOnline->harga, 0, ',', '.');
                    }
                })
                ->addColumn('aksi', function ($detailPenjualanOnline) {
                    if ($detailPenjualanOnline->status == 1) {
                        return '<a href="' .
                            route('membatalkanDetailPenjualanOnline', $detailPenjualanOnline->id_detail_penjualan_online) .
                            '" class="' .
                            'btn btn-danger"' .
                            '><i
            class="bi bi-x"></i>Membatalkan</a>';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['gambar', 'aksi', 'status','harga'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return DataTables::of($data)
            ->addColumn('qty', function(){
                return '1';
            })
                ->addColumn('gambar', function ($detailPenjualanOnline) {
                    $url = asset('storage/' . $detailPenjualanOnline->thumbnail);
                    return '<img src="' . $url . '" width="100" />';
                })
                ->editColumn('diskon', function ($detailPenjualanOnline) {
                    if ($detailPenjualanOnline->diskon == 0) {
                        return 'Tidak Ada';
                    } else {
                        return $detailPenjualanOnline->diskon . '%';
                    }
                })
                ->editColumn('status', function ($detailPenjualanOnline) {
                    if ($detailPenjualanOnline->status == 1) {
                        return '<span class="text-white badge bg-success">Berhasil</span>
                    ';
                    } elseif ($detailPenjualanOnline->status == 5) {
                        return '<span class="text-white badge bg-danger">Dibatalkan</span>
                    ';
                    }
                })
                ->editColumn('harga', function ($detailPenjualanOnline) {
                    return 'Rp ' . number_format($detailPenjualanOnline->harga, 0, ',', '.');
                })
                ->rawColumns(['gambar', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function data_Alamat_Pengiriman($id)
    {
        $data = Penjualan_Online::select('alamats.provinsi', 'alamats.kabupaten', 'alamats.kecamatan', 'alamats.kelurahan', 'alamats.alamat_detail')
            ->join('alamats', 'penjualan__onlines.alamat_id', '=', 'alamats.id_alamat') 
            ->where('penjualan__onlines.id_penjualan_online', $id)
            ->get();
            return DataTables::of($data)->make(true);
    }

    public function data_Jasa_Pengiriman($id)
    {
        $data = Ongkir::where('penjualan_online_id', $id);
        return DataTables::of($data)
            ->addColumn('kurir', function () {
                return 'JNE';
            })
            ->make(true);
    }

    public function proses_Membatalkan_Detail_Penjualan_Online($id)
    {
        $id_detail_penjualan_online = $id;
        $dataDetailPenjualanOnline = Detail_Penjualan_Online::without(['penjualan_online', 'produk'])->find($id_detail_penjualan_online);
        $dataDetailPenjualanOnline->update(['status' => 5]);
        $penjualanOnline = Penjualan_Online::where('id_penjualan_online',  $dataDetailPenjualanOnline->penjualan_online_id)->first();
        $penjualanOnline->update(['status'=>12]);

        $detailPromo = Detail_Promo::select('promos.tipe', 'promos.id_promo', 'promos.jumlah', 'promos.diskon')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->where([
                'detail__promos.produk_id' => $dataDetailPenjualanOnline->produk_id,
                'promos.status' => 1,
            ])
            ->first();

        if ($detailPromo) {
            if ($detailPromo->tipe == 'minimal pembelian') {
                $keranjang = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon', 'produks.id_produk')
                    ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
                    ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                    ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                    ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                    ->where('penjualan__onlines.status', 2)
                    ->where('promos.id_promo', $detailPromo->id_promo)
                    ->where('detail__penjualan__onlines.status', 1)
                    ->get();

            
                if ($keranjang->count() % $detailPromo->jumlah == 0) {
                    foreach ($keranjang as $data) {
                        $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                            'penjualan_online_id' => $dataDetailPenjualanOnline->penjualan_online_id,
                            'produk_id' => $data->id_produk,
                        ])->first();
                        $updateDetailPenjualanOnline->update([
                            'diskon' => $detailPromo->diskon,
                        ]);
                    }
                } else {
                    if ($keranjang->count() > $detailPromo->jumlah) {
                        $index = $keranjang->count();
                        foreach ($keranjang as $data) {
                           
                            if ($index  % $detailPromo->jumlah == 0) {
                                while($index!=0){
                                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                        'penjualan_online_id' => $dataDetailPenjualanOnline->penjualan_online_id,
                                        'produk_id' => $data->id_produk,
                                    ])->first();
                                    $updateDetailPenjualanOnline->update([
                                        'diskon' => $detailPromo->diskon,
                                    ]);
                                    $index--;
                                }
                               
                            }else{
                                $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                    'penjualan_online_id' => $dataDetailPenjualanOnline->penjualan_online_id,
                                    'produk_id' => $data->id_produk,
                                ])->first();
                                $updateDetailPenjualanOnline->update([
                                    'diskon' => 0,
                                ]);
                                $index--;
                            }
                           
                        }
                    } else {
                        foreach ($keranjang as $data) {
                            $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                'penjualan_online_id' => $dataDetailPenjualanOnline->penjualan_online_id,
                                'produk_id' => $data->id_produk,
                            ])->first();
                            $updateDetailPenjualanOnline->update([
                                'diskon' => 0,
                            ]);
                        }
                    }
                }
            }
        }

        $detailPenjualanOnline = Detail_Penjualan_Online::select('diskon')
            ->where('penjualan_online_id', $dataDetailPenjualanOnline->penjualan_online_id)
            ->where('status', 1)
            ->get();
        $berat = 450 * $detailPenjualanOnline->count() + 100;
        $kurir = 'jne';
        $id_kota_asal = '444';
        $ongkir = null;

        $dataOngkir = Ongkir::select('kota_id', 'service')
            ->where('penjualan_online_id', $dataDetailPenjualanOnline->penjualan_online_id)
            ->first();

        $responseCost = Http::withHeaders([
            'key' => 'd4d746be89057f1deddfc549552d2557',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $id_kota_asal,
            'destination' => $dataOngkir->kota_id,
            'weight' => $berat,
            'courier' => $kurir,
        ]);

        $dataOngkirRajaOngkir = $responseCost['rajaongkir']['results'][0]['costs'];
        foreach ($dataOngkirRajaOngkir as $row) {
            foreach ($row['cost'] as $data) {
                if ($row['service'] == $dataOngkir->service) {
                    $ongkir = $data['value'];
                    break;
                }
            }
        }

        $dataOngkosKirim = [
            'total_ongkir' => $ongkir,
        ];
        $dataOngkir->update($dataOngkosKirim);

        $dataTotal = $this->penjualanOnlineModel->getTotalPenjualanOnline($dataDetailPenjualanOnline->penjualan_online_id);
        if ($dataTotal) {
            $dataEditTotal = [
                'total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon) + $ongkir,
                'sub_total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon),
            ];
        } else {
            $dataEditTotal = [
                'total' => 0,
                'sub_total' => 0,
            ];
        }
        $dataPenjualanOnline = Penjualan_Online::find($dataDetailPenjualanOnline->penjualan_online_id);
        $dataPenjualanOnline->update($dataEditTotal);
        return redirect()->route('viewDetailPenjualanOnline', $dataDetailPenjualanOnline->penjualan_online_id)->with('aksi', 'Membatalkan');
    }

    public function proses_Membatalkan_Penjualan_Online($id)
    {
        $penjualanOnline = Penjualan_Online::where('id_penjualan_online', $id)->first();
        $penjualanOnline->update(['status' => 5]);
        $detailPenjualanOnline = Detail_Penjualan_Online::where('penjualan_online_id', $id)->get();
        foreach ($detailPenjualanOnline as $row) {
            $produk = Detail_Penjualan_Online::where('id_detail_penjualan_online', $row->id_detail_penjualan_online)->first();
            $produk->update(['status' => 5]);
        }
        return redirect()->route('viewPenjualanOnline')->with('aksi', 'Membatalkan');
    }

    public function paket_Dikirim($id){
        $penjualanOnline = Penjualan_Online::where('id_penjualan_online',$id)->first();
        $penjualanOnline->update(['status'=>7]);
        return redirect()->back()->with('aksi', 'Paket Dikirim');
    }
 //halaman pembeli
    public function acc_Paket($id){
        $penjualanOnline = Penjualan_Online::where('id_penjualan_online',$id)->first();
        $penjualanOnline->update(['status'=>1]);
        return redirect()->back()->with([
            'aksi' => 'Mengkonfirmasi',
            'halaman' => 'Transaksi',
        ]);
        
    }
   
    public function view_Penjualan_Online_Pembeli()
    {
        $judul = 'Transaksi';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $detailPenjualanOnline = $this->penjualanOnlineModel->getDetailKeranjang();
        $penjualanOnline = Penjualan_Online::select('penjualan__onlines.id_penjualan_online', 'penjualan__onlines.sub_total', 'penjualan__onlines.total', 'users.*', 'alamats.*')
            ->leftjoin('users', 'penjualan__onlines.user_id', '=', 'users.id_user')
            ->leftjoin('alamats', 'penjualan__onlines.alamat_id', '=', 'alamats.id_alamat')
            ->where([
                'penjualan__onlines.user_id' => auth()->user()->id_user,
                'penjualan__onlines.status' => 2,
            ])
            ->first();
        $alamat = Alamat::select('id_alamat', 'keterangan')
            ->without(['user'])
            ->where('user_id', auth()->user()->id_user)
            ->get();
           
        $ongkir = Ongkir::select('total_ongkir', 'penjualan_online_id')
            ->where('penjualan_online_id', $penjualanOnline->id_penjualan_online)
            ->first();
            
        $diskon = detail_penjualan_online::select('diskon')
            ->groupBy('diskon')
            ->where([
                'penjualan_online_id' => $penjualanOnline->id_penjualan_online,
            ])
            ->where('diskon', '>', 0)
            ->get();

        if ($ongkir) {
            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $currentTime=time();

            $expireTime = $currentTime+(4*60*60);

            $expireDateTime = date('Y-m-d H:i:s', $expireTime);



            $params = [
                'transaction_details' => [
                    'order_id' => $penjualanOnline->id_penjualan_online,
                    'gross_amount' => $penjualanOnline->total,
                ],
                'customer_details' => [
                    'first_name' => $penjualanOnline->nama_user,
                    'last_name' => ' ',
                    'email' => $penjualanOnline->email,
                    'phone' => $penjualanOnline->nomor,
                ],
                'expiry' => [
                    'unit' => 'minute',
                    'duration' => 240, // 4 jam dalam menit
                ],

            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } else {
            $snapToken = null;
        }
        return view('pembeli.transaksi', compact('judul', 'detailPenjualanOnline', 'penjualanOnline', 'alamat', 'ongkir', 'snapToken', 'diskon', 'kategori'));
    }

    public function data_Paket_Layanan(Request $request)
    {
        $id_alamat = $request->idAlamat;
        $alamat = Alamat::select('kabupaten')
            ->where('id_alamat', $id_alamat)
            ->first();
        $id_kota_asal = '444';
        $detailPenjualanOnline = $this->penjualanOnlineModel->getDetailKeranjang();
        $berat = 450 * $detailPenjualanOnline->count() + 100;
        $kurir = 'jne';
        $id_kota_tujuan = null;

        $kota = [];
        if (($open = fopen(storage_path() . '/app/public/kota.txt', 'r')) !== false) {
            while (($dataFile = fgetcsv($open, 1000, ',')) !== false) {
                $kota[] = $dataFile;
            }

            fclose($open);

            foreach ($kota as $row) {
                $data = strtoupper($row[3] . ' ' . $row[4]);
                if ($data == $alamat->kabupaten) {
                    $id_kota_tujuan = $row[0];
                    break;
                }
            }
        }

        $responseCost = Http::withHeaders([
            'key' => 'd4d746be89057f1deddfc549552d2557',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $id_kota_asal,
            'destination' => $id_kota_tujuan,
            'weight' => $berat,
            'courier' => $kurir,
        ]);

        $dataOngkir = $responseCost['rajaongkir']['results'][0]['costs'];
        echo '<option select value="">Pilih Paket Layanan</option>';
        foreach ($dataOngkir as $row) {
            foreach ($row['cost'] as $data) {
                echo '<option value="' . $id_kota_tujuan . '|' . $row['service'] . '|' . $data['value'] . '|' . $data['etd'] . '">' . $row['service'] . ' Rp ' . number_format($data['value'], 0, ',', '.') . ' ' . $data['etd'] . ' Hari' . '</option>';
            }
        }
    }

    public function proses_Store_Alamat_Pengiriman(Request $request)
    {
        $validatedData = $request->validate([
            'alamat_id' => 'required',
            'paket' => 'required',
        ]);
        $penjualanOnline = Penjualan_Online::where([
            'user_id' => auth()->user()->id_user,
            'status' => 2,
        ])->first();

        $data = explode('|', $request->paket);
        $kota_id = $data[0];
        $service = $data[1];
        $ongkir = $data[2];
        $estimasi = $data[3] . ' hari';
        $cekDataOngkir = Ongkir::where('penjualan_online_id', $penjualanOnline->id_penjualan_online)->first();
        $dataStoreOngkir = [
            'service' => $service,
            'estimasi' => $estimasi,
            'total_ongkir' => $ongkir,
            'kota_id' => $kota_id,
            'penjualan_online_id' => $penjualanOnline->id_penjualan_online,
        ];

        if ($cekDataOngkir) {
            $cekDataOngkir->update($dataStoreOngkir);
        } else {
            Ongkir::create($dataStoreOngkir);
        }

        $dataTotal = $this->penjualanOnlineModel->getTotal();
        $dataOngkir = Ongkir::where('penjualan_online_id', $penjualanOnline->id_penjualan_online)->first();

        $dataAlamatPengiriman = [
            'alamat_id' => $request->alamat_id,
            'total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon) + $dataOngkir->total_ongkir,
        ];
        $penjualanOnline->update($dataAlamatPengiriman);
        return back()->with('aksi', 'Menambahkan');
    }

    public function midtrans_Callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            $tgl = Carbon::now();
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $penjualanOnline = Penjualan_Online::find($request->order_id);
                $penjualanOnline->update([
                    'status' => 6,
                    'tgl' => $tgl,
                ]);
                $detailPenjualanOnline = Detail_Penjualan_Online::where('penjualan_online_id', $request->order_id)->get();
                foreach ($detailPenjualanOnline as $row) {
                    $produk = Produk::where('id_produk', $row->produk_id)->first();
                    $produk->update(['stok' => 0]);
                }
            } elseif ($request->transaction_status == 'pending') {
                $penjualanOnline = Penjualan_Online::find($request->order_id);
                $penjualanOnline->update([
                    'status' => 3,
                    'tgl' => $tgl,
                ]);
            } elseif ($request->transaction_status == 'expire') {
                $penjualanOnline = Penjualan_Online::find($request->order_id);
                $penjualanOnline->update([
                    'status' => 4,
                    'tgl' => $tgl,
                ]);

            } elseif ($request->transaction_status == 'cancel') {
                $penjualanOnline = Penjualan_Online::find($request->order_id);
                $penjualanOnline->update([
                    'status' => 5,
                    'tgl' => $tgl,
                ]);
            }
        }
    }

    public function invoice()
    {
        $penjualanOnline = Penjualan_Online::select('id_penjualan_online', 'total', 'sub_total', 'tgl', 'va_number', 'status')
            ->where([
                'user_id' => auth()->user()->id_user,
            ])
            ->where('status', '!=', 2)
            ->latest()
            ->first();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $detailPenjualanOnlineMidtrans = \Midtrans\Transaction::status($penjualanOnline->id_penjualan_online);
        $detailPenjualanOnlineMidtrans = json_decode(json_encode($detailPenjualanOnlineMidtrans), true);
        $vaNumber = $detailPenjualanOnlineMidtrans['va_numbers'][0]['va_number'];
        $bank = $detailPenjualanOnlineMidtrans['va_numbers'][0]['bank'];

        $dataPenjualanOnline = [
            'va_number' => $vaNumber,
        ];
        $penjualanOnline->update($dataPenjualanOnline);

        $jasaPengiriman = Ongkir::select('service', 'estimasi', 'total_ongkir')
            ->where('penjualan_online_id', $penjualanOnline->id_penjualan_online)
            ->first();

        $detailPenjualanOnline = detail_penjualan_online::select('detail__penjualan__onlines.diskon', 'detail__penjualan__onlines.status', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'merks.nama_merk')
            ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
            ->join('merks', 'produks.merk_id', '=', 'merks.id_merk')
            ->where([
                'detail__penjualan__onlines.penjualan_online_id' => $penjualanOnline->id_penjualan_online,
            ])
            ->get();

        $diskon = detail_penjualan_online::select('diskon')
            ->groupBy('diskon')
            ->where([
                'status' => 1,
                'penjualan_online_id' => $penjualanOnline->id_penjualan_online,
            ])
            ->where('diskon', '>', 0)
            ->get();
        $judul = 'Invoice Transaksi';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        return view('pembeli.detail_transaksi', compact('judul', 'penjualanOnline', 'jasaPengiriman', 'detailPenjualanOnline', 'diskon', 'kategori'));
    }
}
