<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TandaTerimaBarang;
class StatusTTB extends Model
{
    protected $table = "tbstatusttb";
    public function id_status()
    {
        return $this->belongsTo('App\TandaTerimaBarang');
    }
}
