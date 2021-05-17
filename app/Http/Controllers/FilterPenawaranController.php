<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Status;
use DB;
use App\InputPenawaran;
use App\FilterPenawaran;

class FilterPenawaranController extends Controller
{
    function list_penawaran_search(Request $request)
    {
        $edit = FilterPenawaran::where('kode_sales',$request->session()->get('kode_sales'))->first();
        $edit->status = $request->status;
        $edit->id_pelanggan = $request->id_customer;
        $edit->id_perusahaan = $request->id_perusahaan;
        $edit->id_sales = $request->id_sales;
        $edit->tgl_awal = $request->tgl_awal;
        $edit->tgl_akhir = $request->tgl_akhir;
        $edit->operator = $request->operator;
        $edit->masa_berlaku = $request->masa_berlaku;
        $edit->pajak = $request->pajak;
        $edit->tahun = $request->tahun;
        $edit->timestamps = false;
        $edit->save();
        if($request->status == '<=16'){
            $angka1 = 1;
            $angka2 = 16;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }elseif($request->status == '<=15'){
            $angka1 = 1;
            $angka2 = 15;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }else{
            $operator = substr($request->status,0,1);
            $angka = substr($request->status,1,2);
        }
        $data = InputPenawaran::leftJoin('tbpelanggan', 'tbpelanggan.id', '=', 'tbpenawarandetil.id_pelanggan')
                                        ->leftJoin('tbsekolah','tbsekolah.id','=','tbpenawarandetil.id_sekolah')
                                        ->join('tbkodepo', 'tbkodepo.kode_po', '=', 'tbpenawarandetil.kode_sales')
                                        ->join('tbbarang', 'tbbarang.kode_penawaran', '=', 'tbpenawarandetil.kode_penawaran')
                                        ->join('tbstatus','tbstatus.id','=','tbpenawarandetil.status');
        if($request->id_customer != ''){
            $data->where('tbpenawarandetil.id_pelanggan',$request->id_customer);
        }
        if($request->id_perusahaan != ''){
            $data->where('tbpenawarandetil.id_perusahaan',$request->id_perusahaan);
        }
        if($request->status == '<=15' || $request->status == '<=16'){
            $data->whereBetween('tbpenawarandetil.status',[$angka1,$angka2]);
        }elseif($request->status != ''){
            $data->where('tbpenawarandetil.status',$operator,$angka);
        }
        if($request->id_sales != ''){
            $data->where('tbpenawarandetil.kode_sales',$request->id_sales);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir != ''){
            $data->whereBetween('tbpenawarandetil.tgls',[$request->tgl_awal,$request->tgl_akhir]);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir == ''){
            $data->where('tbpenawarandetil.tgls',$request->tgl_awal);
        }
        if($request->tgl_awal == '' && $request->tgl_akhir != ''){
            $data->where('tbpenawarandetil.tgls',$request->tgl_akhir);
        }
        if($request->tahun != ''){
            $data->where('tbpenawarandetil.tgls','LIKE','%'.$request->tahun.'%');
        }
        if($request->masa_berlaku != ''){
            $data->where('tbpenawarandetil.lama_penawaran',$request->operator,$request->masa_berlaku);
        }
        if($request->pajak != ''){
            $data->where('tbpenawarandetil.pilihan_pajak',$request->pajak);
        }
        $data->select('tbpenawarandetil.kode_penawaran','tbpelanggan.nama_perusahaan', 'tbpenawarandetil.created_at','tbkodepo.kode_po as kode_sales','tbkodepo.nama as nama_sales','tbpenawarandetil.lama_penawaran','tbpenawarandetil.tgl_penawaran',DB::raw('SUM(tbbarang.total) as total'),'tbstatus.status','tbpenawarandetil.tgls','tbpenawarandetil.no_urut','tbsekolah.nama_sekolah');
        $data->groupBy('tbpenawarandetil.kode_penawaran','tbpelanggan.nama_perusahaan', 'tbpenawarandetil.created_at','kode_sales','nama_sales','tbpenawarandetil.lama_penawaran','tbpenawarandetil.tgl_penawaran','tbpenawarandetil.status','tbpenawarandetil.tgls','tbpenawarandetil.no_urut','tbsekolah.nama_sekolah');
        $data->orderBy('tbpenawarandetil.no_urut','DESC');
        $data =$data->get();
        echo $data;
    }
}
