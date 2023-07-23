<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promo extends Model
{
    use HasFactory;
    protected $table = 'promos';
    protected $dates = ['tgl_mulai','tgl_berakhir'];
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'nama_promo',
        'diskon',
        'deskripsi',
        'jumlah',
        'tipe',
        'tgl_mulai',
        'tgl_berakhir',
        'status',
    ];

    public function detail_promo(){
        return $this->hasMany(Detail_Promo::class,'detail_promo_id','id_detail_promo');
    }

    public function getLastIdPromo(){
        $data = DB::table('promos')
            ->orderBy('id_promo', 'desc')
            ->first();
        return $data;
    }
}
