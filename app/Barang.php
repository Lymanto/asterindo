<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "tbbarang";
    protected $fillable = ['nama_barang','qty','satuan','harga_satuan','total','kode_penawaran','created_at','updated_at'];
}
