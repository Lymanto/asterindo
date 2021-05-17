<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = "tbbank";
    protected $fillable = [
        'nama_bank',
        'nama_rekening',
        'nomor_rekening',
        'jenis_tabungan',
        'cabang_bank',
        'alamat_bank',
        'pic_bank',
        'nomor_telp_bank',
        'nomor_hp_pic',
        'gambar',
        'nama_cs2',
        'no_telp_cs2',
        'nama_teller1',
        'no_telp_teller1',
        'nama_teller2',
        'no_telp_teller2',
    ];
    public $timestamps = false;
}
