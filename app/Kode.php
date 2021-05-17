<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    protected $table = 'tbkodepenawaran';
    protected $fillable = [
        'kode_penawaran',
        'nama_sales',
        'jabatan'
    ];
}
