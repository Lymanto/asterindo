<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPenawaran extends Model
{
    protected $table = "tbhistorypenawaran";
    protected $fillable = ['kode_penawaran','created_at'];
}
