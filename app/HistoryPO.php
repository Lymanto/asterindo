<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPO extends Model
{
    protected $table= "tbhistorypo";
    protected $fillable = ['kode_po','created_at'];
}
