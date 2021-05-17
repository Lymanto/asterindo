<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangPO extends Model
{
    protected $table = "tbbarangpo";
    protected $fillable = ['kode_po','nama_barang','qty','satuan','harga_satuan','total','keterangan','created_at','updated_at'];
}
