<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan_Online extends Model
{
    use HasFactory;
    protected $table = 'penjualan__onlines';
    protected $primaryKey = 'id_penjualan_online';
    protected $fillable = ['user_id', 'alamat_id', 'total', 'sub_total', 'status', 'tgl', 'ongkir','va_number'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function detail_penjualan_online()
    {
        return $this->hasMany(Detail_Penjualan_Online::class, 'detail_penjualan_online_id', 'id_detail_penjualan_online');
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'alamat_id', 'id_alamat');
    }

    public function getPenjualanOnline()
    {
        return Penjualan_Online::select('id_penjualan_online', 'alamat_id')
            ->where([
                'user_id' => auth()->user()->id_user,
                'status' => 2,
            ])
            ->first();
    }

    public function getTotal()
    {
        return Detail_Penjualan_Online::selectRaw('SUM(IF(detail__penjualan__onlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__onlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__onlines.diskon/100),0)) as total_diskon')
            ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
            ->where([
                'users.id_user' => auth()->user()->id_user,
                'penjualan__onlines.status' => 2,
            ])
            ->first();
    }

    public function getSubTotal()
    {
        return detail_penjualan_online::selectRaw('SUM(produks.harga) as subtotal')
            ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
            ->where([
                'users.id_user' => auth()->user()->id_user,
                'penjualan__onlines.status' => 2,
            ])
            ->first();
    }

    public function getTotalPenjualanOnline($id)
    {
        return Detail_Penjualan_Online::selectRaw('SUM(IF(detail__penjualan__onlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__onlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__onlines.diskon/100),0)) as total_diskon')
            ->join('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->join('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
            ->where([
                'penjualan__onlines.id_penjualan_online' => $id,
                'detail__penjualan__onlines.status' => 1,
            ])
            ->first();
    }

    public function getDetailKeranjang()
    {
        return Detail_Penjualan_Online::select('produks.nama_produk', 'produks.thumbnail', 'produks.ukuran', 'produks.stok', 'produks.harga', 'produks.merk', 'detail__penjualan__onlines.diskon', 'detail__penjualan__onlines.id_detail_penjualan_online', 'promos.nama_promo', 'promos.tipe')
            ->leftjoin('penjualan__onlines', 'penjualan__onlines.id_penjualan_online', '=', 'detail__penjualan__onlines.penjualan_online_id')
            ->leftjoin('produks', 'produks.id_produk', '=', 'detail__penjualan__onlines.produk_id')
            ->leftjoin('detail__promos', 'produks.id_produk', '=', 'detail__promos.produk_id')
            ->leftjoin('promos', 'detail__promos.promo_id', '=', 'promos.id_promo')
            ->leftjoin('users', 'users.id_user', '=', 'penjualan__onlines.user_id')
            ->where([
                'users.id_user' => auth()->user()->id_user,
                'penjualan__onlines.status' => 2,
            ])
            ->get();
    }
}
