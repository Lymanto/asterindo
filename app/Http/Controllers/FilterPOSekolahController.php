<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\StatusSekolah;
use App\POSekolah;
use App\FilterPOSekolah;

class FilterPOSekolahController extends Controller
{
    function list_po_sekolah_search(Request $request)
    {   
        $edit = FilterPOSekolah::where('kode_sales',$request->session()->get('kode_sales'))->first();
        $edit->status = $request->status;
        $edit->tgl_awal = $request->tgl_awal;
        $edit->tgl_akhir = $request->tgl_akhir;
        $edit->tahun = $request->tahun;
        $edit->timestamps = false;
        $edit->save();
        if($request->status == '<=11'){
            $angka1 = 1;
            $angka2 = 11;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }elseif($request->status == '<=10'){
            $angka1 = 1;
            $angka2 = 10;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }else{
            $operator = substr($request->status,0,1);
            $angka = substr($request->status,1,2);
        }
        $data = POSekolah::with('perusahaan','status','sales','sekolah','bank');
        
        if($request->status == '<=11' || $request->status == '<=10'){
            $data->whereBetween('tbsekolahpo.id_status',[$angka1,$angka2]);
        }elseif($request->status != ''){
            $data->where('tbsekolahpo.id_status',$operator,$angka);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir != ''){
            $data->whereBetween('tbsekolahpo.tgl',[$request->tgl_awal,$request->tgl_akhir]);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir == ''){
            $data->where('tbsekolahpo.tgl',$request->tgl_awal);
        }
        if($request->tgl_awal == '' && $request->tgl_akhir != ''){
            $data->where('tbsekolahpo.tgl',$request->tgl_akhir);
        }
        if($request->tahun != ''){
            $data->where('tbsekolahpo.tgl','LIKE','%'.$request->tahun.'%');
        }
        $data->orderBy('tbsekolahpo.no_urut','DESC');
        $data = $data->get();
        echo $data;
    }
}
