<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Status;
use App\PODetil;
use App\FilterPO;

class FilterPOController extends Controller
{
    function list_po_search(Request $request)
    {   
        $edit = FilterPO::where('kode_sales',$request->session()->get('kode_sales'))->first();
        $edit->status = $request->status;
        $edit->tgl_awal = $request->tgl_awal;
        $edit->tgl_akhir = $request->tgl_akhir;
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
        $data = PODetil::with('perusahaan','status','sales','vendor','barang');
        if($request->status == '<=15' || $request->status == '<=16'){
            $data->whereBetween('tbpodetil.status',[$angka1,$angka2]);
        }elseif($request->status != ''){
            $data->where('tbpodetil.status',$operator,$angka);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir != ''){
            $data->whereBetween('tbpodetil.tgl',[$request->tgl_awal,$request->tgl_akhir]);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir == ''){
            $data->where('tbpodetil.tgl',$request->tgl_awal);
        }
        if($request->tgl_awal == '' && $request->tgl_akhir != ''){
            $data->where('tbpodetil.tgl',$request->tgl_akhir);
        }
        if($request->tahun != ''){
            $data->where('tbpodetil.tgl','LIKE','%'.$request->tahun.'%');
        }
        $data->orderBy('tbpodetil.no_urut','DESC');
        $data = $data->get();
        echo $data;
    }
}
