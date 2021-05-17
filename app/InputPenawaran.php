<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputPenawaran extends Model
{
    protected $table = 'tbpenawarandetil';
    protected $fillable = [
        'no_urut',
        'kode_sales',
        'kode_penawaran',
        'perihal',
        'pilihan_pajak',
        'note',
        'lama_penawaran',
        'tgl_penawaran',
        'id_perusahaan',
        'pelanggan_pilih',
        'id_sekolah',
        'id_pelanggan',
        'status',
        'tgls',
        'memo',
        'gambar1',
        'gambar2',
        'ttd',
        'ttd_id_sales',
        'created_at'
    ];
    public function pelanggan()
    {
        return $this->belongsTo('App\pelanggan','id_pelanggan','id');
    }
    public function sales()
    {
        return $this->belongsTo('App\KodePO','kode_sales','kode_po');
    }
    public function status()
    {
        return $this->belongsTo('App\Status','status','id');
    }
    public function perusahaan()
    {
        return $this->belongsTo('App\PerusahaanPO','id_perusahaan','id');
    }
    public function barang()
    {
        return $this->hasMany('App\Barang','kode_penawaran','kode_penawaran');
    }
    public function sekolah()
    {
        return $this->belongsTo('App\Sekolah','id_sekolah','id');
    }
}
