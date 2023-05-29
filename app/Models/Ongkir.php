<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    use HasFactory;
    protected $table = 'ongkirs';
    protected $primaryKey = 'id_ongkir';
    protected $fillable = [
        'penjualan_online_id',
        'kota_id',
        'service',
        'estimasi',
        'total_ongkir'
    ];
}
