<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Penjualan_Online extends Model
{
    use HasFactory;
    protected $table = 'detail__penjualan__onlines';
    protected $primaryKey = 'id_detail_penjualan_online';
    protected $fillable = [
        'penjualan_online_id',
        'produk_id',
        'diskon',
        'status',
    ];

    public function penjualan_online(){
        return $this->belongsTo(Penjualan_Online::class,'penjualan_online_id','id_penjualan_online');
    }

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }
}
