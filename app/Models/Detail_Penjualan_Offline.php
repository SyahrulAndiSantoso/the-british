<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Penjualan_Offline extends Model
{
    use HasFactory;
    protected $table = 'detail__penjualan__offlines';
    protected $primaryKey = 'id_detail_penjualan_offline';
    protected $fillable = [
        'penjualan_offline_id',
        'produk_id',
        'diskon',
        'status',
    ];

    public function penjualan_offline(){
        return $this->belongsTo(Penjualan_Offline::class,'penjualan_offline_id','id_penjualan_offline');
    }

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }
}
