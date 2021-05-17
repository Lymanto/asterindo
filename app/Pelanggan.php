<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TandaTerimaBarang;
class Pelanggan extends Model
{
    protected $table = 'tbpelanggan';
    public function id_customer()
    {
        return $this->belongsTo('App\TandaTerimaBarang');
    }
}
