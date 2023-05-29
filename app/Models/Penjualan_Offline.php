<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan_Offline extends Model
{
    use HasFactory;
    protected $table = 'penjualan__offlines';
    protected $primaryKey = 'id_penjualan_offline';
    protected $fillable = ['total', 'status', 'tgl','diterima','kembalian'];

    public function detail_penjualan_offline()
    {
        return $this->hasMany(Detail_Penjualan_Offline::class, 'detail_penjualan_offline_id', 'id_detail_penjualan_offline');
    }

    public function getTotal()
    {
        return Detail_Penjualan_Offline::selectRaw('SUM(IF(detail__penjualan__offlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__offlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__offlines.diskon/100),0)) as total_diskon')
            ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
            ->where([
                'penjualan__offlines.status' => 2,
            ])
            ->first();
    }

    public function getTotalPenjualanOffline($id){
        return Detail_Penjualan_Offline::selectRaw('SUM(IF(detail__penjualan__offlines.diskon=0, produks.harga,0)) as total_bukan_diskon, SUM(IF(detail__penjualan__offlines.diskon>0,produks.harga-(produks.harga*detail__penjualan__offlines.diskon/100),0)) as total_diskon')
            ->join('penjualan__offlines', 'penjualan__offlines.id_penjualan_offline', '=', 'detail__penjualan__offlines.penjualan_offline_id')
            ->join('produks', 'produks.id_produk', '=', 'detail__penjualan__offlines.produk_id')
            ->where([
                'penjualan__offlines.id_penjualan_offline' => $id,
                'detail__penjualan__offlines.status' => 1
            ])
            ->first();
    }
}
