<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PODetil extends Model
{
    protected $table = "tbpodetil";
    protected $fillable = [
        "no_urut",
        "kode_sales",
        "kode_po",
        "paket",
        "attn",
        "cc",
        "id_supplier",
        "id_perusahaan",
        "tgl",
        "re",
        "pajak",
        "id_ekspedisi",
        "ekspedisi_dll",
        "note",
        "npwp",
        "ttd",
        "ttd_id_sales",
        "status",
        "memo",
        "gambar1",
        "gambar2",
        "created_at",
        "updated_at",
    ];
    public function vendor()
    {
        return $this->belongsTo('App\Supplier','id_supplier','id');
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
        return $this->hasMany('App\BarangPO','kode_po','kode_po');
    }
}
