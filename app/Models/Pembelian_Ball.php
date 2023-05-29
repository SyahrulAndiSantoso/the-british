<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian_Ball extends Model
{
    use HasFactory;
    protected $table = 'pembelian__balls';
    protected $primaryKey = 'id_pembelian_ball';
    protected $fillable = [
        'nama_ball',
        'tgl_beli',
        'total_pakaian',
    ];
}
