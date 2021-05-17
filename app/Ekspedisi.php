<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    protected $table = "tbekspedisi";
    protected $fillable = [
        'ekspedisi',
        'alamat',
        'no_telp',
        'no_hp',
        'nama_pic',
        'email',
        'memo',
        'nama_pic_gudang',
        'no_telp_gudang',
        'no_hp_gudang',
        'nama_keuangan',
        'no_telp_keuangan',
        'no_hp_keuangan',
        'nama_kurir',
        'no_telp_kurir',
        'no_hp_kurir',
    ];
}
