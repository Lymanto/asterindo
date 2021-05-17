<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TandaTerimaBarang;
class KodePO extends Model
{
    protected $table = "tbkodepo";
    public function id_sales()
    {
        return $this->hasMany('App\TandaTerimaBarang');
    }
}
