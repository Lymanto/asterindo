<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Rule;
class MasterRule extends Controller
{
    public function master_penawaran_rule(Request $request)
    {
        if($request->session()->get('role_id') == '1'){
        $rule = Rule::all()->sortByDesc('id');
        return view('master_rule',['rule' => $rule]);
        }else{
            return abort(403);
        }
    }
    public function master_penawaran_rule_tambah(Request $request)
    {
        $request->validate([
            'periode_wsb' => 'required'
        ],[
            'periode_wsb.required' => 'Periode WSB harus diisi'
        ]);
        Rule::create([
            'periode_wsb' => $request->periode_wsb,
            'masa_berlaku_penawaran' => $request->masa_berlaku_penawaran,
            'prefik_gps_npsn' => $request->prefik_gps_npsn,
            'gmaps_prefix' => $request->gmaps_prefix,
            'gmaps_middle' => $request->gmaps_middle,
            'gmaps_suffix' => $request->gmaps_suffix
        ]);
        return Redirect::back()->with('success','Data berhasil ditambahkan');
    }
    public function master_penawaran_rule_edit(Request $request)
    {
        $edit = Rule::find($request->id);
        $edit->periode_wsb = $request->periode_wsb;
        $edit->masa_berlaku_penawaran = $request->masa_berlaku_penawaran;
        $edit->prefik_gps_npsn = $request->prefik_gps_npsn;
        $edit->gmaps_prefix = $request->gmaps_prefix;
        $edit->gmaps_middle = $request->gmaps_middle;
        $edit->gmaps_suffix = $request->gmaps_suffix;
        $edit->save();
        return Redirect::back()->with('success','Data berhasil diedit');
    }
    public function master_penawaran_rule_hapus(Request $request)
    {
        $hapus = Rule::find($request->id);
        $hapus->delete();
        return Redirect::back()->with('success','Data berhasil dihapus');
    }
    public function master_penawaran_rule_hapus_semua(Request $request)
    {
        $hapus = Rule::truncate();
        return Redirect::back()->with('success','Semua data berhasil dihapus');
    }
}
