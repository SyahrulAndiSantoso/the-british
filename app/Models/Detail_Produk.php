<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Produk extends Model
{
    use HasFactory;
    protected $table= 'detail__produks';
    protected $primaryKey = 'id_detail_produk';
    protected $fillable = [
        'produk_id',
        'gambar'
    ];

    public function produk(){
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }
}
