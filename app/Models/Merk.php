<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;
    protected $table = 'merks';
    protected $primaryKey = 'id_merk';
    protected $fillable = [
        'nama_merk',
    ];

    public function produk(){
        return $this->hasMany(Produk::class,'produk_id','id_produk');
    }
}
