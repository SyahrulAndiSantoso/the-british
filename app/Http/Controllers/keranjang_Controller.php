<?php

namespace App\Http\Controllers;

use App\Models\Detail_Penjualan_Online;
use App\Models\Detail_Produk;
use App\Models\Detail_Promo;
use App\Models\Kategori_Produk;
use App\Models\Ongkir;
use App\Models\Penjualan_Online;
use App\Models\Produk;
use Illuminate\Http\Request;

class keranjang_Controller extends Controller
{
    protected $keranjangModel;
    public function __construct()
    {
        $this->keranjangModel = new Penjualan_Online();
    }

    public function index()
    {
        $judul = 'Keranjang';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        $detailKeranjang = $this->keranjangModel->getDetailKeranjang();
        $diskon = null;
        $keranjang = Penjualan_Online::select('sub_total', 'id_penjualan_online')
            ->without(['user', 'alamat'])
            ->where([
                'user_id' => auth()->user()->id_user,
                'status' => 2,
            ])
            ->first();
        if ($keranjang) {
            $diskon = detail_penjualan_online::select('diskon')
                ->groupBy('diskon')
                ->where([
                    'penjualan_online_id' => $keranjang->id_penjualan_online,
                ])
                ->where('diskon', '>', 0)
                ->get();
        }

        $dataTotal = $this->keranjangModel->getTotal();

        return view('pembeli.keranjang', compact('judul', 'detailKeranjang', 'keranjang', 'diskon', 'dataTotal', 'kategori'));
    }

    public function proses_Tambah_Keranjang($id)
    {
        $id_produk = decrypt($id);
        $produk = Produk::select('stok')
            ->where('id_produk', $id_produk)
            ->first();

        $cekProduk = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon', 'produks.id_produk')
            ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->join('users', 'penjualan__onlines.user_id', '=', 'users.id_user')
            ->where('penjualan__onlines.status', 2)
            ->where('users.id_user', auth()->user()->id_user)
            ->where('produks.id_produk', $id_produk)
            ->get();

        if ($cekProduk->count() != 0) {
            return back()->with('gagal', 'Gagal');
        } else {
            if ($produk->stok == 1) {
                $dataPenjualanOnline = $this->keranjangModel->getPenjualanOnline();
                $detailPromo = Detail_Promo::select('promos.tipe', 'promos.id_promo', 'promos.jumlah', 'promos.diskon')
                    ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
                    ->where([
                        'detail__promos.produk_id' => $id_produk,
                        'promos.status' => 1,
                    ])
                    ->first();

                if ($dataPenjualanOnline) {
                    $dataTambahDetailPenjualanOnline = [
                        'penjualan_online_id' => $dataPenjualanOnline->id_penjualan_online,
                        'produk_id' => $id_produk,
                        'diskon' => 0,
                        'status' => 1,
                    ];
                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::create($dataTambahDetailPenjualanOnline);
                    if ($detailPromo) {
                        if ($detailPromo->tipe == 'potongan harga') {
                            $updateDetailPenjualanOnline->update([
                                'diskon' => $detailPromo->diskon,
                            ]);
                        } elseif ($detailPromo->tipe == 'minimal pembelian') {
                            $keranjang = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon', 'detail__penjualan__onlines.penjualan_online_id','produks.id_produk')
                                ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
                                ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
                                ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                                ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                                ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                                ->where('penjualan__onlines.status', 2)
                                ->where('users.id_user',auth()->user()->id_user)
                                ->where('promos.id_promo', $detailPromo->id_promo)
                                ->get();
                           
                            if ($keranjang->count() % $detailPromo->jumlah == 0) {
                              
                                foreach ($keranjang as $data) {
                                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                        'penjualan_online_id' => $data->penjualan_online_id,
                                        'produk_id' => $data->id_produk,
                                    ])->first();
                                    $updateDetailPenjualanOnline->update([
                                        'diskon' => $detailPromo->diskon,
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    $idPenjualanOnline = Penjualan_Online::latest('id_penjualan_online')->first();
                    $idBaru = $idPenjualanOnline ? sprintf('INV%06d', substr($idPenjualanOnline->id_penjualan_online, 3) + 1) : 'INV000001';
                    $dataTambahPenjualanOnline = [
                        'id_penjualan_online'=>$idBaru,
                        'user_id' => auth()->user()->id_user,
                        'status' => 2,
                    ];
                    Penjualan_Online::create($dataTambahPenjualanOnline);
                    $dataPenjualanOnline = $this->keranjangModel->getPenjualanOnline();
                    $dataTambahDetailPenjualanOnline = [
                        'penjualan_online_id' => $dataPenjualanOnline->id_penjualan_online,
                        'produk_id' => $id_produk,
                        'diskon' => 0,
                        'status' => 1,
                    ];
                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::create($dataTambahDetailPenjualanOnline);
                    if ($detailPromo) {
                        if ($detailPromo->tipe == 'potongan harga') {
                            $updateDetailPenjualanOnline->update([
                                'diskon' => $detailPromo->diskon,
                            ]);
                        } elseif ($detailPromo->tipe == 'minimal pembelian') {
                            $keranjang = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon','detail__penjualan__onlines.penjualan_online_id', 'produks.id_produk')
                                ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
                                ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
                                ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                                ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                                ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                                ->where('penjualan__onlines.status', 2)
                                ->where('users.id_user',auth()->user()->id_user)
                                ->where('promos.id_promo', $detailPromo->id_promo)
                                ->get();

                            if ($keranjang->count() % $detailPromo->jumlah == 0) {
                                foreach ($keranjang as $data) {
                                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                        'penjualan_online_id' => $data->penjualan_online_id,
                                        'produk_id' => $data->id_produk,
                                    ])->first();
                                    $updateDetailPenjualanOnline->update([
                                        'diskon' => $detailPromo->diskon,
                                    ]);
                                }
                            }
                        }
                    }
                }
                $dataTotal = $this->keranjangModel->getTotal();
                $dataSubTotal = $this->keranjangModel->getSubTotal();

                $ongkir = Ongkir::select('total_ongkir')
                    ->where('penjualan_online_id', $dataPenjualanOnline->id_penjualan_online)
                    ->first();
                if ($dataPenjualanOnline->alamat_id) {
                    $dataEditTotal = [
                        'total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon) + $ongkir->total_ongkir,
                        'sub_total' => $dataSubTotal->subtotal,
                    ];
                } else {
                    $dataEditTotal = [
                        'total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon),
                        'sub_total' => $dataSubTotal->subtotal,
                    ];
                }

                $dataPenjualanOnline->update($dataEditTotal);
                return redirect()->back()->with('title', 'Berhasil');
                
            } else {
                return redirect()
                    ->route('beranda')
                    ->with('title', 'Stok Produk Habis');
            }
        }
    }

    public function proses_Hapus_Keranjang($id)
    {
        $id_detail_penjualan_online = decrypt($id);
        $dataDetailPenjualanOnline = Detail_Penjualan_Online::select('id_detail_penjualan_online','produk_id','penjualan_online_id')->without(['penjualan_online', 'produk'])->where('id_detail_penjualan_online',$id_detail_penjualan_online)->first();
     
        $detailPromo = Detail_Promo::select('promos.tipe', 'promos.id_promo', 'promos.jumlah', 'promos.diskon')
            ->join('promos', 'promos.id_promo', '=', 'detail__promos.promo_id')
            ->where([
                'detail__promos.produk_id' => $dataDetailPenjualanOnline->produk_id,
                'promos.status' => 1,
            ])
            ->first();

        $dataDetailPenjualanOnline->delete($id_detail_penjualan_online);

        

        if ($detailPromo) {
            if ($detailPromo->tipe == 'minimal pembelian') {
                $keranjang = Detail_Penjualan_Online::select('detail__penjualan__onlines.id_detail_penjualan_online', 'detail__penjualan__onlines.diskon','detail__penjualan__onlines.penjualan_online_id', 'produks.id_produk')
                    ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
                    ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
                    ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
                    ->join('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
                    ->join('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
                    ->where('penjualan__onlines.status', 2)
                    ->where('users.id_user',auth()->user()->id_user)
                    ->where('promos.id_promo', $detailPromo->id_promo)
                    ->get();

               
                if ($keranjang->count() % $detailPromo->jumlah == 0) {
                    foreach ($keranjang as $data) {
                        $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                            'penjualan_online_id' => $data->penjualan_online_id,
                            'produk_id' => $data->id_produk,
                        ])->first();
                        $updateDetailPenjualanOnline->update([
                            'diskon' => $detailPromo->diskon,
                        ]);
                    }
                } else {
                    $index = $keranjang->count();
                    if ($keranjang->count() > $detailPromo->jumlah) {
                        foreach ($keranjang as $data) {
                           
                            if ($index % $detailPromo->jumlah==0) {
                                while($index!=0){
                                    $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                        'penjualan_online_id' => $data->penjualan_online_id,
                                        'produk_id' => $data->id_produk,
                                    ])->first();
                                    $updateDetailPenjualanOnline->update([
                                        'diskon' => $detailPromo->diskon,
                                    ]);
                                    $index--;
                                }
                                
                            }else{
                                $updateDetailPenjualanOnline = Detail_Penjualan_Online::where([
                                    'penjualan_online_id' =>  $data->penjualan_online_id,
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
                                'penjualan_online_id' => $data->penjualan_online_id,
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

        $dataTotal = $this->keranjangModel->getTotal();
        $dataSubTotal = $this->keranjangModel->getSubTotal();
        if ($dataTotal) {
            $dataEditTotal = [
                'total' => intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon),
                'sub_total' => $dataSubTotal->subtotal,
            ];
        } else {
            $dataEditTotal = [
                'total' => 0,
                'sub_total' => 0,
            ];
        }
        $dataPenjualanOnline = Penjualan_Online::find($dataDetailPenjualanOnline->penjualan_online_id);
        $dataPenjualanOnline->update($dataEditTotal);
        return back()->with('title', 'Berhasil');
    }

    public function checkout()
    {
        $status = Detail_Penjualan_Online::select('produks.nama_produk')
        ->leftjoin('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
        ->leftjoin('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
        ->leftjoin('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
        ->where([
            'users.id_user' => auth()->user()->id_user,
            'penjualan__onlines.status' => 2,
            'produks.stok' => 0,
        ])
        ->get();

        if ($status->count()==0) {
            return redirect()->route('transaksi');
        } else {
            return back();
        }
    }
}
