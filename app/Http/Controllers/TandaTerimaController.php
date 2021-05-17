<?php

namespace App\Http\Controllers;

use App\TandaTerimaBarang;
use App\BarangTTB;
use App\Satuan;
use App\PerusahaanPO;
use App\Pelanggan;
use App\KodePO;
use App\HistoryTTB;
use App\ImageTTB;
use App\StatusTTB;
use App\ParagrafTTB;
use App\FilterTTB;
use Carbon\Carbon;
use File;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
class TandaTerimaController extends Controller
{
    public function index(Request $request)
    {
        $satuan = Satuan::all();
        $perusahaan = PerusahaanPO::all();
        $sales = KodePO::all();
        $customer = Pelanggan::all();
        return view('tanda_terima',[
            'satuan' => $satuan,
            'perusahaan' => $perusahaan,
            'sales' => $sales,
            'customer' => $customer,
        ]);
    }
    public function tanda_terima_barang_tambah(Request $request)
    {
        if($request->id_perusahaan == "-- Pilih --"){
            return redirect('/tanda-terima-barang')->with('alert','Pilih Nama Perusahaannya dulu!');
        }
        if($request->nama_pengantar == "-- Pilih --"){
            return redirect('/tanda-terima-barang')->with('alert','Pilih Nama Pengantarnya dulu!');
        }
        if($request->id_sales == "-- Pilih --"){
            return redirect('/tanda-terima-barang')->with('alert','Pilih Nama Salesnya dulu!');
        }
        if($request->id_customer == "-- Pilih --"){
            return redirect('/tanda-terima-barang')->with('alert','Pilih Nama Perusahaan Customernya dulu!');
        }
        if($request->id_customer == "Tambah Baru"){
            return redirect('/tanda-terima-barang')->with('alert','Pilih Nama Perusahaan Customernya dulu!');
        }
        $request->validate([
            'tgl_no_do' =>'required',
            'tgl' =>'required',
            'id_perusahaan' =>'required',
            'id_customer' =>'required',
            'id_sales' =>'required',
        ]);
        $now = Carbon::now();
        $tahun = substr($request->tgl_no_do,2,2);
        $bulan = substr($request->tgl_no_do,5,2);
        $tahunbulan = $tahun.$bulan;
        $cari = TandaTerimaBarang::select('no_do')->where('no_do', 'LIKE', "$tahunbulan-%")->latest()->first();
        
        if($cari === null){
            $history = HistoryTTB::select('no_do')->where('no_do', 'LIKE', "$tahunbulan-%")->latest()->first();
            if($history != ""){
                $history = substr($history->no_do,5,4);
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }else{
                $urut = "0001";
            }

        }elseif($cari->no_do != ''){
            $history = HistoryTTB::select('no_do')->where('no_do', 'LIKE', "$tahunbulan-%")->latest()->first();
            $history = substr($history->no_do,5,4);
            $number = substr($cari->no_do,5,4);
            if($number != $history){
                $history++;
            }elseif($number == $history){
                $number++;
                $urut = str_pad($number, 4, "0", STR_PAD_LEFT);  //00002
            }
        }
        $tahun2 = substr($request->tgl,2,2);
        $cari2 = TandaTerimaBarang::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
        if($cari2 === null){
            $history2 = HistoryTTB::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            if($history2 != ''){
                $history2 = substr($history2->no_urut,3,6);
                $urut2 = $history2+1;
            }else{
                $urut2 = '1';
            }
        }elseif($cari2->no_urut != ''){
            $history2 = HistoryTTB::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            $history2 = substr($history2->no_urut,3,6); 
            $number2 = substr($cari2->no_urut,3,6); 
            if($number2 != $history2){
                $urut2 = $history2+1;
            }elseif($number2 == $history2){
                $urut2 = $number2+1;
            }
        }
        $ttb = new TandaTerimaBarang;
        $ttb->no_urut = $tahun2. '-' .$urut2;
        $ttb->no_do = $tahun.$bulan. '-' .$urut;
        $ttb->id_perusahaan = $request->id_perusahaan;
        $ttb->nama_kota_perusahaan = $request->nama_kota_perusahaan;
        $ttb->nama_perusahaan_isi = $request->nama_perusahaan_isi;
        $ttb->id_customer = $request->id_customer;
        $ttb->nama_customer_isi = $request->nama_customer_isi;
        $ttb->tgl = $request->tgl;
        $ttb->nama_pengantar = $request->nama_pengantar;
        $ttb->nama_pengantar_isi = $request->nama_pengantar_isi;
        $ttb->id_sales = $request->id_sales;
        $ttb->nama_penerima = $request->nama_penerima;
        $ttb->note = $request->note;
        $ttb->ttd = $request->ttd;
        $ttb->ttd_id_sales = $request->ttd_sales;
        $ttb->id_status = 1;
        if($request->hasFile('gambar1')){
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar1);
            $ttb->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar2);
            $ttb->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar3);
            $ttb->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar4);
            $ttb->gambar4 = $gambar4;
        }
        $ttb->created_at = $now;
        $ttb->updated_at = $now;
        $ttb->save();
        if($ttb != null)
        {
            $historypo = HistoryTTB::insert([
                'no_do' => $tahun.$bulan.'-'.$urut,
                'no_urut' => $tahun2.'-'.$urut2,
                'created_at' => $now,
            ]);
        }
        if($ttb != null){
            foreach($request->jenis_barang as $key => $v){
                $barang = array(
                    'jenis_barang' => $request->jenis_barang [$key],
                    'qty' => $request->qty [$key],
                    'satuan' => $request->satuan [$key],
                    'no_do' => $tahun.$bulan. '-' .$urut,
                    'keterangan' => $request->keterangan [$key],
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                BarangTTB::insert($barang);
            }
        }
        return redirect('/preview/tanda-terima-barang/'.$tahun.$bulan. '-' .$urut)->with('success','Data berhasil ditambahkan');
    }
    public function tanda_terima_barang_preview(Request $request,$no_do)
    {
        $paragraf = ParagrafTTB::find(1);
        // $data = PerusahaanPO::join('tbtandaterimabarang','tbtandaterimabarang.id_perusahaan','=','tbperusahaanpo.id')
        //                     ->join('tbkodepo','tbkodepo.id','=','tbtandaterimabarang.ttd_id_sales')
        //                     ->join('tbpelanggan','tbpelanggan.id','=','tbtandaterimabarang.id_customer')
        //                     ->where('tbtandaterimabarang.no_do',$no_do)
        //                     ->select('tbperusahaanpo.telp','tbkodepo.jabatan','tbkodepo.ttd as ttd_gambar','tbkodepo.nama as nama_sales','tbtandaterimabarang.ttd','tbperusahaanpo.nama_perusahaan','tbperusahaanpo.alamat','tbperusahaanpo.nama_kota','tbtandaterimabarang.no_do','tbtandaterimabarang.note','tbpelanggan.nama_perusahaan as nama_customer','tbtandaterimabarang.tgl','tbtandaterimabarang.nama_penerima','tbtandaterimabarang.nama_pengantar','tbtandaterimabarang.nama_pengantar_isi')
        //                     ->first();
        $data = PerusahaanPO::rightJoin('tbtandaterimabarang','tbtandaterimabarang.id_perusahaan','=','tbperusahaanpo.id')
                            ->join('tbkodepo','tbkodepo.id','=','tbtandaterimabarang.ttd_id_sales')
                            ->leftJoin('tbpelanggan','tbpelanggan.id','=','tbtandaterimabarang.id_customer')
                            ->where('tbtandaterimabarang.no_do',$no_do)
                            ->select('tbtandaterimabarang.nama_kota_perusahaan','tbperusahaanpo.telp','tbkodepo.jabatan','tbkodepo.ttd as ttd_gambar','tbtandaterimabarang.ttd','tbkodepo.nama as nama_sales','tbperusahaanpo.nama_perusahaan','tbperusahaanpo.alamat','tbperusahaanpo.nama_kota','tbtandaterimabarang.no_do','tbtandaterimabarang.note','tbpelanggan.nama_perusahaan as nama_customer','tbtandaterimabarang.tgl','tbtandaterimabarang.nama_penerima','tbtandaterimabarang.nama_pengantar','tbtandaterimabarang.nama_pengantar_isi','tbtandaterimabarang.nama_perusahaan_isi','tbtandaterimabarang.nama_customer_isi','tbtandaterimabarang.id_customer','tbtandaterimabarang.id_perusahaan')
                            ->first();
        $barang = BarangTTB::where('no_do',$no_do)->get();
        return view('preview_tanda_terima_barang',[
            'data' => $data,
            'barang' => $barang,
            'paragraf' => $paragraf,
        ]);
    }
    public function tanda_terima_barang_print(Request $request,$no_do)
    {
        $paragraf = ParagrafTTB::find(1);
        $data = PerusahaanPO::rightJoin('tbtandaterimabarang','tbtandaterimabarang.id_perusahaan','=','tbperusahaanpo.id')
                            ->join('tbkodepo','tbkodepo.id','=','tbtandaterimabarang.ttd_id_sales')
                            ->leftJoin('tbpelanggan','tbpelanggan.id','=','tbtandaterimabarang.id_customer')
                            ->where('tbtandaterimabarang.no_do',$no_do)
                            ->select('tbtandaterimabarang.nama_kota_perusahaan','tbperusahaanpo.telp','tbkodepo.jabatan','tbkodepo.ttd as ttd_gambar','tbtandaterimabarang.ttd','tbkodepo.nama as nama_sales','tbperusahaanpo.nama_perusahaan','tbperusahaanpo.alamat','tbperusahaanpo.nama_kota','tbtandaterimabarang.no_do','tbtandaterimabarang.note','tbpelanggan.nama_perusahaan as nama_customer','tbtandaterimabarang.tgl','tbtandaterimabarang.nama_penerima','tbtandaterimabarang.nama_pengantar','tbtandaterimabarang.nama_pengantar_isi','tbtandaterimabarang.nama_perusahaan_isi','tbtandaterimabarang.nama_customer_isi','tbtandaterimabarang.id_customer','tbtandaterimabarang.id_perusahaan')
                            ->first();
        $barang = BarangTTB::where('no_do',$no_do)->get();
        return view('print_tanda_terima_barang',[
            'data' => $data,
            'barang' => $barang,
            'paragraf' => $paragraf,
        ]);
    }
    public function list_ttb(Request $request)
    {
        $filter = FilterTTB::where('kode_sales',$request->session()->get('kode_sales'))->first();
        if($filter->status == '<=6'){
            $operator = substr($filter->status,0,2);
            $angka = substr($filter->status,2,1);
        }elseif($filter->status == '<=5'){
            $operator = substr($filter->status,0,2);
            $angka = substr($filter->status,2,1);
        }else{
            $operator = substr($filter->status,0,1);
            $angka = substr($filter->status,1,1);
        }
        $data = TandaTerimaBarang::leftJoin('tbperusahaanpo','tbperusahaanpo.id','=','tbtandaterimabarang.id_perusahaan')
                                    ->with('barang')
                                    ->join('tbkodepo','tbkodepo.id','=','tbtandaterimabarang.id_sales')
                                    ->join('tbstatusttb','tbstatusttb.id','=','tbtandaterimabarang.id_status')
                                    ->leftJoin('tbpelanggan','tbpelanggan.id','=','tbtandaterimabarang.id_customer');
        if($filter->id_customer != ''){
            $data->where('tbtandaterimabarang.id_customer',$filter->id_customer);
        }
        if($filter->id_perusahaan != ''){
            $data->where('tbtandaterimabarang.id_perusahaan',$filter->id_perusahaan);
        }
        if($filter->status != ''){
            $data->where('tbtandaterimabarang.id_status',$operator,$angka);
        }
        if($filter->id_sales != ''){
            $data->where('tbtandaterimabarang.id_sales',$filter->id_sales);
        }
        if($filter->tgl_awal != '' && $filter->tgl_akhir != ''){
            $data->whereBetween('tbtandaterimabarang.tgl',[$filter->tgl_awal,$filter->tgl_akhir]);
        }
        if($filter->tgl_awal != '' && $filter->tgl_akhir == ''){
            $data->where('tbtandaterimabarang.tgl',$filter->tgl_awal);
        }
        if($filter->tgl_awal == '' && $filter->tgl_akhir != ''){
            $data->where('tbtandaterimabarang.tgl',$filter->tgl_akhir);
        }
        if($filter->tahun != ''){
            $data->where('tbtandaterimabarang.tgl','LIKE','%'.$filter->tahun.'%');
        }
        $data->select('tbstatusttb.status','tbtandaterimabarang.*','tbperusahaanpo.nama_perusahaan','tbpelanggan.nama_perusahaan as nama_customer','tbkodepo.nama');
        $data->orderBy('tbtandaterimabarang.no_urut','DESC');
        

        $status = StatusTTB::all();
        $customer = Pelanggan::all();
        $perusahaan = PerusahaanPO::all();
        $sales = KodePO::all();
        return view('list_ttb',[
            'data' => $data->get(),
            'status' => $status,
            'customer' => $customer,
            'perusahaan' => $perusahaan,
            'sales' => $sales,
            'filter' => $filter,
        ]);
    }
    public function list_ttb_hapus(Request $request)
    {
        $hapus = TandaTerimaBarang::find($request->id)->delete();
        return redirect('/list/tanda-terima-barang')->with('success','Data berhasil di hapus');
    }
    function list_ttb_search(Request $request)
    {
        $edit = FilterTTB::where('kode_sales',$request->session()->get('kode_sales'))->first();
        $edit->status = $request->status;
        $edit->id_customer = $request->id_customer;
        $edit->id_perusahaan = $request->id_perusahaan;
        $edit->id_sales = $request->id_sales;
        $edit->tgl_awal = $request->tgl_awal;
        $edit->tgl_akhir = $request->tgl_akhir;
        $edit->tahun = $request->tahun;
        $edit->timestamps = false;
        $edit->save();
        if($request->status == '<=6'){
            $operator = substr($request->status,0,2);
            $angka = substr($request->status,2,1);
        }elseif($request->status == '<=5'){
            $operator = substr($request->status,0,2);
            $angka = substr($request->status,2,1);
        }else{
            $operator = substr($request->status,0,1);
            $angka = substr($request->status,1,1);
        }
        $data = TandaTerimaBarang::leftJoin('tbperusahaanpo','tbperusahaanpo.id','=','tbtandaterimabarang.id_perusahaan')
                                    ->with('barang')
                                    ->join('tbkodepo','tbkodepo.id','=','tbtandaterimabarang.id_sales')
                                    ->join('tbstatusttb','tbstatusttb.id','=','tbtandaterimabarang.id_status')
                                    ->leftJoin('tbpelanggan','tbpelanggan.id','=','tbtandaterimabarang.id_customer');
        if($request->id_customer != ''){
            $data->where('tbtandaterimabarang.id_customer',$request->id_customer);
        }
        if($request->id_perusahaan != ''){
            $data->where('tbtandaterimabarang.id_perusahaan',$request->id_perusahaan);
        }
        if($request->status != ''){
            $data->where('tbtandaterimabarang.id_status',$operator,$angka);
        }
        if($request->id_sales != ''){
            $data->where('tbtandaterimabarang.id_sales',$request->id_sales);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir != ''){
            $data->whereBetween('tbtandaterimabarang.tgl',[$request->tgl_awal,$request->tgl_akhir]);
        }
        if($request->tgl_awal != '' && $request->tgl_akhir == ''){
            $data->where('tbtandaterimabarang.tgl',$request->tgl_awal);
        }
        if($request->tgl_awal == '' && $request->tgl_akhir != ''){
            $data->where('tbtandaterimabarang.tgl',$request->tgl_akhir);
        }
        if($request->tahun != ''){
            $data->where('tbtandaterimabarang.tgl','LIKE','%'.$request->tahun.'%');
        }
        $data->select('tbstatusttb.status','tbtandaterimabarang.*','tbperusahaanpo.nama_perusahaan','tbpelanggan.nama_perusahaan as nama_customer','tbkodepo.nama');
        $data->orderBy('tbtandaterimabarang.no_urut','DESC');
        $data =$data->get();
        echo $data;
    }
    public function list_ttb_edit(Request $request,$no_do)
    {
        $perusahaan = PerusahaanPO::all();
        $barang = BarangTTB::where('no_do',$no_do)->get();
        $sales = KodePO::all();
        $customer = Pelanggan::all();
        $status = StatusTTB::all();
        $satuan = Satuan::all();
        $image = ImageTTB::where('no_do',$no_do)->get();
        $data = TandaTerimaBarang::where('no_do',$no_do)->first();
        return view('list_ttb_edit',[
            'status' => $status,
            'data' => $data,
            'perusahaan' => $perusahaan,
            'sales' => $sales,
            'customer' => $customer,
            'barang' => $barang,
            'image' => $image,
            'satuan' => $satuan,
            'no_do' => $no_do,
        ]);
    }
    public function list_ttb_edit_submit(Request $request,$no_do)
    {
        if($request->id_perusahaan == "-- Pilih --"){
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Pilih Nama Perusahaannya dulu!');
        }
        if($request->nama_pengantar == "-- Pilih --"){
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Pilih Nama Pengantarnya dulu!');
        }
        if($request->id_sales == "-- Pilih --"){
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Pilih Nama Salesnya dulu!');
        }
        if($request->id_customer == "-- Pilih --"){
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Pilih Nama Perusahaan Customernya dulu!');
        }
        if($request->id_customer == "Tambah Baru"){
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Pilih Nama Perusahaan Customernya dulu!');
        }
        $request->validate([
            'tgl' =>'required',
            'id_perusahaan' =>'required',
            'id_customer' =>'required',
            'id_sales' =>'required',
        ]);
        $edit = TandaTerimaBarang::find($request->id);
        $edit->id_perusahaan = $request->id_perusahaan;
        $edit->nama_kota_perusahaan = $request->nama_kota_perusahaan;
        $edit->nama_perusahaan_isi = $request->nama_perusahaan_isi;
        $edit->id_customer = $request->id_customer;
        $edit->nama_customer_isi = $request->nama_customer_isi;
        $edit->tgl = $request->tgl;
        $edit->nama_pengantar = $request->nama_pengantar;
        $edit->nama_pengantar_isi = $request->nama_pengantar_isi;
        $edit->id_sales = $request->id_sales;
        $edit->nama_penerima = $request->nama_penerima;
        $edit->note = $request->note;
        $edit->id_status = $request->id_status;
        $edit->ttd = $request->ttd;
        $edit->ttd_id_sales = $request->ttd_sales;
        if($request->hasFile('gambar1')){
            File::delete('assets/images/upload/tanda-terima-barang/'.$edit->gambar1);
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar1);
            $edit->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            File::delete('assets/images/upload/tanda-terima-barang/'.$edit->gambar2);
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar2);
            $edit->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            File::delete('assets/images/upload/tanda-terima-barang/'.$edit->gambar3);
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar3);
            $edit->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            File::delete('assets/images/upload/tanda-terima-barang/'.$edit->gambar4);
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/tanda-terima-barang/'),$gambar4);
            $edit->gambar4 = $gambar4;
        }
        $edit->timestamps = false;
        $edit->save();
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Data berhasil diedit');
    }
    public function list_ttb_memo_view(Request $request,$no_do)
    {
        $memo = TandaTerimaBarang::where('no_do',$no_do)->select('memo')->first();
        return view('list_ttb_memo_view',[
            'no_do' => $no_do,
            'memo' => $memo,
        ]);
    }
    public function list_ttb_memo_submit(Request $request,$no_do)
    {
        $memo = TandaTerimaBarang::where('no_do',$no_do)->update(['memo' => $request->editor]);
        return Redirect::back()->with('success','Memo berhasil diedit');
    }
    public function list_ttb_tambah_gambar(Request $request,$no_do)
    {
        $images = $this->uploadFiles($request);
        foreach($images as $imageFile)
        {
            list($fileName, $title) = $imageFile;
            ImageTTB::insert([
                'gambar' => $fileName,
                'no_do' => $no_do,
            ]);
        }
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Gambar berhasil ditambahkan');
    }
    public function list_ttb_edit_gambar(Request $request,$no_do){
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image'
            ]);
            $images = $request->file('image');
            $originalFileName = $images->getClientOriginalName();
            $extension = $images->getClientOriginalExtension();
            $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
            $fileName = Str::slug($fileNameOnly) . "-" . time() . "." . $extension;
            $uploadedFileName = $images->storeAs('public/ttb', $fileName);
            $edit = ImageTTB::find($request->id);
            $edit->gambar = $uploadedFileName;
            $edit->timestamps = false;
            $edit->save();
            $gambar_lama = str_replace('public/ttb/','',$request->hidden_image);
            Storage::disk('local')->delete("/public/ttb/" . $gambar_lama);
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Gambar berhasil di edit');
        }else{
            return redirect("/list/tanda-terima-barang/edit/$no_do")->with('alert','Upload gambar jika ingin edit');
        }
    }
    public function list_ttb_hapus_gambar(Request $request,$no_do){
        $gambar_lama = str_replace('public/ttb/','',$request->hidden_image);
        Storage::disk('local')->delete("/public/ttb/" . $gambar_lama);
        ImageTTB::where('id',$request->id)->delete();
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Gambar berhasil di hapus');
    }
    public function list_ttb_tambah_barang(Request $request,$no_do)
    {
        $request->validate([
            'jenis_barang' => 'required',
            'qty' => 'required',
        ]);
        BarangTTB::insert([
            'jenis_barang' => $request->jenis_barang,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'no_do' => $no_do,
        ]);
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Barang berhasil di tambahkan');
    }
    public function list_ttb_edit_barang(Request $request,$no_do)
    {
        $request->validate([
            'jenis_barang' => 'required',
            'qty' => 'required',
        ]);
        $edit = BarangTTB::find($request->id);
        $edit->jenis_barang = $request->jenis_barang;
        $edit->qty = $request->qty;
        $edit->satuan = $request->satuan;
        $edit->keterangan = $request->keterangan;
        $edit->timestamps = false;
        $edit->save();
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Barang berhasil diedit');
    }
    public function list_ttb_hapus_barang(Request $request,$no_do)
    {
        BarangTTB::find($request->id)->delete();
        return redirect("/list/tanda-terima-barang/edit/$no_do")->with('success','Barang berhasil dihapus');
    }
    protected function uploadFiles($request){
        $uploadedImages = [];
        if($request->hasFile('image')){
            $images = $request->file('image');
            foreach($images as $image){
                $uploadedImages[]= $this->uploadFile($image);
            }
        }
        return $uploadedImages;
    }

    protected function uploadFile($image)
    {
        $originalFileName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName = Str::slug($fileNameOnly) . "-" . time() . "." . $extension;

        $uploadedFileName = $image->storeAs('public/ttb', $fileName);

        return [$uploadedFileName, $fileNameOnly];
    }

    public function paragraf(Request $request)
    {
        $paragraf = ParagrafTTB::find(1);
        return view('paragraf_ttb',[
            'paragraf' => $paragraf
        ]);
    }
    public function paragraf_edit(Request $request)
    {
        $edit = ParagrafTTB::find(1);
        $edit->paragraf1 = $request->paragraf1;
        $edit->timestamps = false;
        $edit->save();
        return redirect('/master/paragraf/ttb')->with('success','Data berhasil di edit');
    }
}
