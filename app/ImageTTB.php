<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
class ImageTTB extends Model
{
    protected $table = 'tbimagettb';
    protected $fillable = ['no_do','gambar'];
    public function getSrcAttribute()
    {
        return Storage::url($this->gambar);
    }
}
