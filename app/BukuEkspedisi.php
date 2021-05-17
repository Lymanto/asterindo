<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BukuEkspedisi extends Model
{
    protected $table = "tbbukuekspedisi";
    protected $fillable = [
        'id',
        'tgl',
        'jam',
        'nama_ekspedisi',
        'jumlah_coli',
        'nama_pengirim',
        'alamat_pengirim',
        'untuk',
        'penerima_barang',
        'no_po',
        'status',
        'ttd',
        'gambar1',
        'gambar2',
        'gambar3',
        'gambar4',
        'gambar5',
        'gambar6',
        'gambar7',
        'gambar8',
        'gambar9',
        'gambar10',
        'gambar11',
        'gambar12',
        'memo',
        'no_telp_pengirim',
        'jenis_barang',
    ];
    public function status()
    {
        return $this->belongsTo('App\StatusEkspedisi','status','id');
    }
}
