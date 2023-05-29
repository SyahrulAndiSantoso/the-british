<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Promo extends Model
{
    use HasFactory;
    protected $table = 'detail__promos';
    protected $primaryKey = 'id_detail_promo';
    protected $fillable = [
        'promo_id',
        'produk_id',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }

    public function promo(){
        return $this->belongsTo(Promo::class,'promo_id','id_promo');
    }
}
