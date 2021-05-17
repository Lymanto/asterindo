<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'tbrule';
    protected $fillable = [
        'periode_wsb',
        'masa_berlaku_penawaran',
        'prefik_gps_npsn',
        'gmaps_prefix',
        'gmaps_middle',
        'gmaps_suffix'
    ];
    public $timestamps = false;
}
