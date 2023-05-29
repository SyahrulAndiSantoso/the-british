<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_Produk extends Model
{
    use HasFactory;
    protected $table = 'kategori__produks';
    protected $primaryKey = 'id_kategori_produk';
    protected $fillable = ['nama_kategori_produk'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'produk_id', 'id_produk');
    }
    public function getRouteKeyName(): string
    {
        return 'nama_kategori_produk';
    }
}
