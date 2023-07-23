<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    use HasFactory;
    protected $table = 'ukurans';
    protected $primaryKey = 'id_ukuran';
    protected $fillable = [
        'ukuran',
    ];

    public function produk(){
        return $this->hasMany(Produk::class,'produk_id','id_produk');
    }
}
