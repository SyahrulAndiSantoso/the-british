<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamats';
    protected $primaryKey = 'id_alamat';
    protected $fillable = [
        'user_id',
        'keterangan',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'alamat_detail',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id_user');
    }

    public function penjualan_online(){
        return $this->hasMany(Penjualan_Online::class,'penjualan_online_id','id_penjualan_online');
    }
}
