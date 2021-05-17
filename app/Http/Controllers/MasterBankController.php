<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Bank;
use File;
class MasterBankController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('role_id') == '1'){
            $bank = Bank::all();
            return view('master_bank',[
                'bank' => $bank
            ]);
        }else{
            return abort(403);
        }
    }
    public function tambah(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ],[
            'nama_bank.required' => 'Nama Bank harus diisi',
            'nama_rekening.required' => 'Nama Bank harus diisi',
            'nomor_rekening.required' => 'Nama Bank harus diisi',
        ]);
        $tambah = new Bank;
        $tambah->nama_bank = $request->nama_bank;
        $tambah->nama_rekening = $request->nama_rekening;
        $tambah->nomor_rekening = $request->nomor_rekening;
        $tambah->jenis_tabungan = $request->jenis_tabungan;
        $tambah->cabang_bank = $request->cabang_bank;
        $tambah->alamat_bank = $request->alamat_bank;
        $tambah->pic_bank = $request->pic_bank;
        $tambah->nomor_telp_bank = $request->nomor_telp_bank;
        $tambah->nomor_hp_pic = $request->nomor_hp_pic;
        $tambah->nama_cs2 = $request->nama_cs2;
        $tambah->no_telp_cs2 = $request->no_telp_cs2;
        $tambah->nama_teller1 = $request->nama_teller1;
        $tambah->no_telp_teller1 = $request->no_telp_teller1;
        $tambah->nama_teller2 = $request->nama_teller2;
        $tambah->no_telp_teller2 = $request->no_telp_teller2;
        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $gambar = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/upload/bank/'),$gambar);
            $tambah->gambar = $gambar;
        }
        $tambah->save();
        return Redirect::back()->with('success','Data berhasil ditambahkan');
    }
    public function edit(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ],[
            'nama_bank.required' => 'Nama Bank harus diisi',
            'nama_rekening.required' => 'Nama Bank harus diisi',
            'nomor_rekening.required' => 'Nama Bank harus diisi',
        ]);
        $edit = Bank::find($request->id);
        $edit->nama_bank = $request->nama_bank;
        $edit->nama_rekening = $request->nama_rekening;
        $edit->nomor_rekening = $request->nomor_rekening;
        $edit->jenis_tabungan = $request->jenis_tabungan;
        $edit->cabang_bank = $request->cabang_bank;
        $edit->alamat_bank = $request->alamat_bank;
        $edit->pic_bank = $request->pic_bank;
        $edit->nomor_telp_bank = $request->nomor_telp_bank;
        $edit->nomor_hp_pic = $request->nomor_hp_pic;
        $edit->nama_cs2 = $request->nama_cs2;
        $edit->no_telp_cs2 = $request->no_telp_cs2;
        $edit->nama_teller1 = $request->nama_teller1;
        $edit->no_telp_teller1 = $request->no_telp_teller1;
        $edit->nama_teller2 = $request->nama_teller2;
        $edit->no_telp_teller2 = $request->no_telp_teller2;
        if($request->hasFile('gambar')){
            File::delete('assets/images/upload/bank/'.$edit->gambar);
            $file = $request->file('gambar');
            $gambar = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/upload/bank/'),$gambar);
            $edit->gambar = $gambar;
        }
        $edit->save();
        return Redirect::back()->with('success','Data berhasil diedit');
    }
    public function hapus(Request $request)
    {
        $hapus = Bank::find($request->id);
        $hapus->delete();
        return Redirect::back()->with('success','Data berhasil dihapus');
    }
}
