<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian_Dana extends Model
{
    use HasFactory;
    protected $table = 'pengembalian__danas';
    protected $primaryKey = 'id_pengembalian_dana';
    protected $fillable = ['penjualan_online_id','bukti','total_dana','keterangan'];

    public function penjualan_online()
    {
        return $this->belongsTo(Penjualan_Online::class, 'penjualan_online_id', 'id_penjualan_online');
    }
}
