<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POSekolah extends Model
{
    protected $table = "tbsekolahpo";
    protected $fillable = [
        'no_urut',
        'kode',
        'kode_sales',
        'id_sekolah',
        'id_perusahaan',
        'alamat_pengiriman',
        'tgl',
        'tgl_lunas',
        'no_surat',
        'ppn',
        'judul_project',
        'grandtotal',
        'jumlah_uang_terima',
        'id_bank',
        'id_status',
        'ttd',
        'ttd_id_sales',
        'gambar1',
        'gambar2',
        'gambar3',
        'gambar4',
    ];
    public function sekolah()
    {
        return $this->belongsTo('App\Sekolah','id_sekolah','id');
    }
    public function sales()
    {
        return $this->belongsTo('App\KodePO','kode_sales','kode_po');
    }
    public function status()
    {
        return $this->belongsTo('App\StatusSekolah','id_status','id');
    }
    public function perusahaan()
    {
        return $this->belongsTo('App\PerusahaanPO','id_perusahaan','id');
    }
    public function bank()
    {
        return $this->belongsTo('App\Bank','id_bank','id');
    }
}
