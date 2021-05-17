<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paragraf extends Model
{
    protected $table = 'tbparagraf';
    protected $fillable = ['sapaan','salam_penutup','paragraf1','pajak','masa_berlaku','paragraf2','created_at','updated_at'];
}
