<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\StatusEkspedisi;
use App\BukuEkspedisi;
use App\FilterBukuEkspedisi;

class FilterBukuEkspedisiController extends Controller
{
    public function list_buku_ekspedisi_search(Request $request){
        $edit = FilterBukuEkspedisi::where('kode_sales',$request->session()->get('kode_sales'))->first();
        $edit->status = $request->status;
        $edit->tgl_awal = $request->tgl_awal;
        $edit->tgl_akhir = $request->tgl_akhir;
        $edit->tahun = $request->tahun;
        $edit->timestamps = false;
        $edit->save();
        if($request->status == '<=5'){
            $angka1 = 1;
            $angka2 = 5;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }elseif($request->status == '<=4'){
            $angka1 = 1;
            $angka2 = 4;
            // $operator = substr($request->status,0,2);
            // $angka = substr($request->status,2,2);
        }else{
            $operator = substr($request->status,0,1);
            $angka = substr($request->status,1,2);
        }
        $data = BukuEkspedisi::with('status');
        
        if($request->status == '<=5' || $request->status == '<=4'){
            $data->whereBetween('tbbukuekspedisi.status',[$angka1,$angka2]);
        }elseif($request->status != ''){
            $data->where('tbbukuekspedisi.status',$operator,$angka);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir != ''){
            $data->whereBetween('tbbukuekspedisi.tgl',[$request->tgl_awal,$request->tgl_akhir]);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir == ''){
            $data->where('tbbukuekspedisi.tgl',$request->tgl_awal);
        }
        if($request->tgl_awal == '' && $request->tgl_akhir != ''){
            $data->where('tbbukuekspedisi.tgl',$request->tgl_akhir);
        }
        if($request->tahun != ''){
            $data->where('tbbukuekspedisi.tgl','LIKE','%'.$request->tahun.'%');
        }
        $data->orderBy('tbbukuekspedisi.no_urut','DESC');
        $data = $data->get();
        echo $data;
    }
}
