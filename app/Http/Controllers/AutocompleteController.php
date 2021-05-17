<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pelanggan;
use Supplier;
use DB;
class AutocompleteController extends Controller
{
    function fetch(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbpelanggan')
            ->select('kode_pelanggan')
            ->where('kode_pelanggan', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_pelanggan,0,1);
            $kode = substr($data->kode_pelanggan,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
    function perusahaan_fetch(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbperusahaanpo')
            ->select('kode_perusahaan')
            ->where('kode_perusahaan', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_perusahaan,0,1);
            $kode = substr($data->kode_perusahaan,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
    
    function perusahaan_fetch_edit(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbperusahaanpo')
            ->select('kode_perusahaan')
            ->where('kode_perusahaan', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_perusahaan,0,1);
            $kode = substr($data->kode_perusahaan,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
    
    function vendor_fetch(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbsupplier')
            ->select('kode_vendor')
            ->where('kode_vendor', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_vendor,0,1);
            $kode = substr($data->kode_vendor,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
    function vendor_fetch_edit(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbsupplier')
            ->select('kode_vendor')
            ->where('kode_vendor', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_vendor,0,1);
            $kode = substr($data->kode_vendor,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
    
    function fetch_edit(Request $request)
    {
        if($request->get('query'))
        {
        $query = $request->get('query');
        $data = DB::table('tbpelanggan')
            ->select('kode_pelanggan')
            ->where('kode_pelanggan', 'LIKE', "%$query%")
            ->latest()
            ->first();
        if($data != ''){
            $huruf = substr($data->kode_pelanggan,0,1);
            $kode = substr($data->kode_pelanggan,1,4);
            $kode++;
            $urut = str_pad($kode, 4, "0", STR_PAD_LEFT);
            
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'.$huruf.$urut.'</li>
            ';
            $output .= '</ul>';
        }elseif($data == ''){
            $query = strtoupper($request->get('query'));
            $output = '<ul class="dropdown-menu w-100" style="display:block; position:relative">';
            $output .= '
            <li>'. $query.'0001' .'</li>
            ';
            $output .= '</ul>';
        }
        echo $output;
        }
    }
}
