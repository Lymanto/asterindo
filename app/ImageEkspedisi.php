<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
class ImageEkspedisi extends Model
{
    protected $table = 'tbimageekspedisi';
    protected $fillable = ['id_ekspedisi','gambar'];
    public function getSrcAttribute()
    {
        return Storage::url($this->gambar);
    }
}
