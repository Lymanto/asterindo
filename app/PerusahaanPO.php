<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TandaTerimaBarang;
class PerusahaanPO extends Model
{
    protected $table = "tbperusahaanpo";
    protected $fillable= ['nama_perusahaan','npwp','email'];
    protected $primaryKey = 'id';
    public function id_perusahaan()
    {
        return $this->belongsTo(TandaTerimaBarang::class,'id_perusahaan');
    }
}
