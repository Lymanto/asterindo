<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use App\KodePO;
Use App\Pelanggan;
Use App\PerusahaanPO;
Use App\StatusTTB;
Use App\BarangTTB;
class TandaTerimaBarang extends Model
{
    protected $table = "tbtandaterimabarang";
    protected $fillable = [
        'no_urut',
        'no_do',
        'id_perusahaan',
        'nama_kota_perusahaan',
        'nama_perusahaan_isi',
        'nama_customer_isi',
        'id_customer',
        'customer_isi',
        'tgl',
        'nama_pengantar',
        'nama_pengantar_isi',
        'id_sales',
        'nama_penerima',
        'note',
        'memo',
        'id_status',
        'ttd',
        'ttd_id_sales',
        'gambar1',
        'gambar2',
        'gambar3',
        'gambar4',
        'created_at',
        'updated_at',
    ];
    public function customer()
    {
        return $this->belongsTo('App\pelanggan','id_customer','id');
    }
    public function sales()
    {
        return $this->belongsTo('App\KodePO','id_sales','id');
    }
    public function status()
    {
        return $this->belongsTo('App\StatusTTB','id_status','id');
    }
    public function perusahaan()
    {
        return $this->belongsTo(PerusahaanPO::class,'id_perusahaan','id');
    }
    public function barang()
    {
        return $this->hasMany(BarangTTB::class,'no_do','no_do');
    }
}
