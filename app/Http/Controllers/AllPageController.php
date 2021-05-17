<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\PerusahaanPO;
use App\Pelanggan;
use App\Kode;
use App\Rule;
use App\Satuan;
use App\Barang;
use App\InputPenawaran;
use App\Paragraf;
use App\ParagrafPO;
use Carbon\Carbon;
use PDF;
use File;
use App\KodePO;
use App\Supplier;
use App\Sekolah;
use App\PODetil;
use App\Ekspedisi;
use App\BarangPO;
use App\Kelamin;
use App\Users;
use App\Status;
use App\HistoryPO;
use App\HistoryPenawaran;
use App\BukuEkspedisi;
use App\StatusEkspedisi;
use App\ImageEkspedisi;
use App\FilterPenawaran;
use App\FilterPO;
use App\FilterPOSekolah;
use App\FilterBukuEkspedisi;
use App\FilterTTB;
use App\KategoriStatus;
use App\KategoriPayment;
use App\HistoryEkspedisi;
use App\Bank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class AllPageController extends Controller
{
    public function utama(Request $request){
        if($request->session()->has('role_id') == true){
            return redirect('/home');
        }
        return view('utama');
    }
    public function login_action(Request $request){
        $cari = Users::where('email',$request->email)->first();
        if($cari)
        {   
            if(Hash::check($request->password,$cari->password)){
                Session::put('username',$cari->username);
                Session::put('role_id',$cari->role_id);
                Session::put('kode_sales',$cari->kode_po);
                Session::put('login',TRUE);
                return redirect('/home');
            }
            else{
                return redirect('/')->with('alert','Password atau Email, Salah !');
            }
        }else{
            return redirect('/')->with('alert','Password atau Email, Salah!');
        }
    }
    public function home(Request $request){
        return view('home');
    }
    public function logout(){
        Session::flush();
        return redirect('/')->with('alert-success','Anda sudah logout');
    }
    public function register(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1'){
            return view('register');
        }else{
            return abort(403);       
        }
    }
    public function register_submit(Request $request){
        $this->validate($request,[
            'role' => 'required',
            'username'=>'required|unique:tbuser,username',
            'password'=> 'required|confirmed:password_confirmation',
            'password_confirmation' => 'required',
        ]);
        Users::create([
            'role_id'=>$request->role,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return redirect('/register')->with('success','User telah ditambahkan');
    }
    public function index(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $perusahaan = PerusahaanPO::all();
        $pelanggan = Pelanggan::all();
        $kode = KodePO::all();
        $satuan = Satuan::all();
        $sekolah = Sekolah::all();
        $status_perusahaan = KategoriStatus::all();
        $payment = KategoriPayment::all();
        $rule = Rule::find(1);
        // $id = DB::table('tbpenawarandetil')->latest('id')->select('id');
        // echo $id;die;
        return view('index',[
            'perusahaan' => $perusahaan,
            'pelanggan' => $pelanggan,
            'kode' => $kode,
            'satuan' => $satuan,
            'sekolah' => $sekolah,
            'status_perusahaan' => $status_perusahaan,
            'payment' => $payment,
            'rule' => $rule,
        ]);
    }
    public function submit(Request $request){
        $start = new \Carbon\Carbon($request->tgls);
        $tgl_penawaran = $start->addDays($request->masa_tgl); //tgl jatuh tempo
        $tahun = substr($request->tgl_penawaran,2,2);
        $bulan = substr($request->tgl_penawaran,5,2);
        $tahunbulan = $tahun.$bulan;
        $cari = InputPenawaran::select('kode_penawaran')->where('kode_penawaran', 'LIKE', "%$tahunbulan%")->latest()->first();
        if($cari === null){
            $history = HistoryPenawaran::select('kode_penawaran')->where('kode_penawaran', 'LIKE', "$tahunbulan%")->latest()->first();
            if($history != ''){
                $history = substr($history->kode_penawaran,7,4);
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }else{
                $urut = "0001";
            }
        }elseif($cari->kode_penawaran != ''){
            $history = HistoryPenawaran::select('kode_penawaran')->where('kode_penawaran', 'LIKE', "%$tahunbulan%")->latest()->first();
            $history = substr($history->kode_penawaran,7,4);
            $number = substr($cari->kode_penawaran,7,4);
            if($number != $history){
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }elseif($number == $history){
                $number++;
                $urut = str_pad($number, 4, "0", STR_PAD_LEFT);  //00002
            }
        }
        $tahun2 = substr($request->tgls,2,2);
        $cari2 = InputPenawaran::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
        if($cari2 === null){
            $history2 = HistoryPenawaran::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            if($history2 != ''){
                $history2 = substr($history2->no_urut,3,6);
                $urut2 = $history2+1;
            }else{
                $urut2 = '1';
            }
        }elseif($cari2->no_urut != ''){
            $history2 = HistoryPenawaran::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            $history2 = substr($history2->no_urut,3,6); 
            $number2 = substr($cari2->no_urut,3,6); 
            if($number2 != $history2){
                $urut2 = $history2+1;
            }elseif($number2 == $history2){
                $urut2 = $number2+1;
            }
        }
        $now = Carbon::now();

        $validation = $request->validate([
            'perihal' => 'required',
        ],[
            'perihal.required' => 'perihal harus diisi!!',
        ]);
        $historypenawaran = HistoryPenawaran::insert([
            'kode_penawaran' => $request->kode.$tahun.$bulan.$urut,
            'no_urut' => $tahun2.'-'.$urut2,
            'created_at' => $now,
            ]); 
        $penawaran = InputPenawaran::create([
            'kode_sales' => $request->kode,
            'no_urut' => $tahun2.'-'.$urut2,
            'kode_penawaran' => $request->kode.$tahun.$bulan.$urut,
            'perihal' => $request->perihal,
            'pilihan_pajak' => $request->pajak,
            'note' => $request->note,
            'lama_penawaran' => $request->masa_tgl,
            'tgl_penawaran' => $tgl_penawaran,
            'id_perusahaan' => $request->perusahaan,
            'pelanggan_pilih' => $request->pelanggan_pilih,
            'id_pelanggan' => $request->id_pelanggan,
            'id_sekolah' => $request->id_sekolah,
            'ttd' => $request->ttd,
            'ttd_id_sales' => $request->ttd_sales,
            'status' => '1',
            'tgls' => $request->tgls,
            'created_at' =>$now,
            'updated_at' =>$now,
        ]);
        if($penawaran != null){
            foreach($request->nama_barang as $key => $v){
                $barang = array(
                    'nama_barang' => $request->nama_barang [$key],
                    'qty' => $request->qty [$key],
                    'satuan' => $request->satuan [$key],
                    'harga_satuan' => $request->harga_satuan [$key],
                    'total' => $request->total [$key],
                    'kode_penawaran' => $request->kode.$tahun.$bulan.$urut,
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                Barang::insert($barang);
            }
        }
        return redirect("/preview/$penawaran->kode_penawaran");
    }
    public function master(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $paragraf = Paragraf::all();
            return view('master',['paragraf' => $paragraf]);
        }else{
            return abort(403);       
        }
    }
    public function paragraf(Request $request){
        Paragraf::where('id',$request->id)->update([
            'sapaan' => $request->sapaan,
            'paragraf1' => $request->paragraf1,
            'termasuk_pajak' => $request->termasuk_pajak,
            'tidak_termasuk_pajak' => $request->tidak_termasuk_pajak,
            'masa_berlaku' => $request->masa,
            'paragraf2' => $request->paragraf2,
            'salam_penutup' => $request->salam_penutup,
        ]);
        return redirect('master')->with('success','Data Berhasil di ubah');
    }
    public function master_penawaran_kategori(Request $request)
    {
        if($request->session()->get('role_id') == '1'){
        $status = KategoriStatus::all();
        $payment = KategoriPayment::all();
        return view('master_penawaran_kategori',[
            'status' => $status,
            'payment' => $payment,
        ]);
        }else{
            return abort(403);
        }
    }
    public function master_penawaran_kategori_status_tambah(Request $request)
    {
        KategoriStatus::insert([
            'status_perusahaan' => $request->status_perusahaan
        ]);
        return Redirect::back()->with('success','Status Perusahaan berhasil ditambahkan');
    }
    public function master_penawaran_kategori_status_hapus(Request $request)
    {
        KategoriStatus::find($request->id)->delete();
        return Redirect::back()->with('success','Status Perusahaan berhasil dihapus');
    }
    public function master_penawaran_kategori_payment_tambah(Request $request)
    {
        KategoriPayment::insert([
            'payment' => $request->payment
            ]);
        return Redirect::back()->with('success','Payment berhasil ditambahkan');
    }
    public function master_penawaran_kategori_payment_hapus(Request $request)
    {
        KategoriPayment::find($request->id)->delete();
        return Redirect::back()->with('success','Payment berhasil dihapus');
    }
    public function master_penawaran_rule(Request $request)
    {
        return view('master_penawaran_rule');
    }
    public function preview(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $penawaran = InputPenawaran::where('kode_penawaran',$kode)->first();
        $barang = Barang::where('kode_penawaran',$kode)->get();
        $perusahaan = PerusahaanPO::join('tbpenawarandetil', 'tbpenawarandetil.id_perusahaan', '=', 'tbperusahaanpo.id')
                                    ->where('kode_penawaran',$kode)
                                    ->select('tbperusahaanpo.nama_perusahaan', 'tbperusahaanpo.alamat', 'tbperusahaanpo.telp','tbperusahaanpo.email')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $pelanggan = Pelanggan::join('tbpenawarandetil', 'tbpenawarandetil.id_pelanggan', '=', 'tbpelanggan.id')
                                    ->join('tbkelamin','tbkelamin.id','=','tbpelanggan.jenis_kelamin')
                                    ->where('kode_penawaran', $kode)
                                    ->select('tbpelanggan.nama_perusahaan', 'tbpelanggan.alamat', 'tbpelanggan.nama_kota','tbpelanggan.nama_pemilik','tbpelanggan.jenis_kelamin','tbpelanggan.no_hp','tbpelanggan.email','tbkelamin.sapaan')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $sekolah = Sekolah::join('tbpenawarandetil', 'tbpenawarandetil.id_sekolah', '=', 'tbsekolah.id')
                            ->leftJoin('tbkelamin','tbkelamin.id','=','tbsekolah.kelamin_kepala_sekolah')
                                    ->where('kode_penawaran', $kode)
                                    ->select('tbsekolah.nama_sekolah', 'tbsekolah.alamat_sekolah', 'tbsekolah.nama_kota','tbsekolah.kepala_sekolah','tbsekolah.no_hp','tbkelamin.sapaan')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $paragraf = Paragraf::first();
        $kode_sales = $penawaran->ttd_id_sales;
        $sales = KodePO::where('kode_po',$kode_sales)->first();
        $grandtotal = Barang::where('kode_penawaran',$kode)->sum('total');
        return view('review',[
            'penawaran' => $penawaran,
            'barang' => $barang,
            'perusahaan' => $perusahaan, 
            'pelanggan' => $pelanggan,
            'paragraf'=> $paragraf,
            'grandtotal' => $grandtotal,    
            'kode' => $kode,
            'sales' => $sales,
            'sekolah' => $sekolah
        ]);
    }
    public function print(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $penawaran = InputPenawaran::where('kode_penawaran',$kode)->first();
        $barang = Barang::where('kode_penawaran',$kode)->get();
        $perusahaan = PerusahaanPO::join('tbpenawarandetil', 'tbpenawarandetil.id_perusahaan', '=', 'tbperusahaanpo.id')
                                    ->where('kode_penawaran',$kode)
                                    ->select('tbperusahaanpo.nama_perusahaan', 'tbperusahaanpo.alamat', 'tbperusahaanpo.telp','tbperusahaanpo.email')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $pelanggan = Pelanggan::join('tbpenawarandetil', 'tbpenawarandetil.id_pelanggan', '=', 'tbpelanggan.id')
                                    ->join('tbkelamin','tbkelamin.id','=','tbpelanggan.jenis_kelamin')
                                    ->where('kode_penawaran', $kode)
                                    ->select('tbpelanggan.nama_perusahaan', 'tbpelanggan.alamat', 'tbpelanggan.nama_kota','tbpelanggan.nama_pemilik','tbpelanggan.jenis_kelamin','tbpelanggan.no_hp','tbpelanggan.email','tbkelamin.sapaan')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $sekolah = Sekolah::join('tbpenawarandetil', 'tbpenawarandetil.id_sekolah', '=', 'tbsekolah.id')
                            ->leftJoin('tbkelamin','tbkelamin.id','=','tbsekolah.kelamin_kepala_sekolah')
                                    ->where('kode_penawaran', $kode)
                                    ->select('tbsekolah.nama_sekolah', 'tbsekolah.alamat_sekolah', 'tbsekolah.nama_kota','tbsekolah.kepala_sekolah','tbsekolah.no_hp','tbkelamin.sapaan')
                                    ->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                                    ->get();
        $paragraf = Paragraf::first();
        $kode_sales = $penawaran->ttd_id_sales;
        $sales = KodePO::where('kode_po',$kode_sales)->first();
        $grandtotal = Barang::where('kode_penawaran',$kode)->sum('total');
        return view('penawaran_print',[
            'penawaran' => $penawaran,
            'barang' => $barang,
            'perusahaan' => $perusahaan, 
            'pelanggan' => $pelanggan,
            'paragraf'=> $paragraf,
            'grandtotal' => $grandtotal,    
            'kode' => $kode,
            'sales' => $sales,
            'sekolah' => $sekolah
        ]);
    }
    public function po(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $kode_po = KodePO::all();
        $supplier = Supplier::all();
        $perusahaan = PerusahaanPO::all();
        $satuan = Satuan::all();
        $ekspedisi = Ekspedisi::all();
        return view('po',['kode_po' => $kode_po,'supplier' => $supplier,'perusahaan' => $perusahaan,'satuan' => $satuan,'ekspedisi' => $ekspedisi,]);
    }
    public function po_id_supplier(Request $request)
    {
        $id = $request->get('query');
        $attn = Supplier::where('id',$id)->first();
        echo $attn;
    }
    public function submit_po(Request $request){
        $tahun = substr($request->tgl_po,2,2);
        $bulan = substr($request->tgl_po,5,2);
        $tahunbulan = $tahun.$bulan;
        $cari = PODetil::select('kode_po')->where('kode_po', 'LIKE', "%$tahunbulan%")->latest()->first();
        
        if($cari === null){
            $history = HistoryPO::select('kode_po')->where('kode_po', 'LIKE', "%$tahunbulan%")->latest()->first();
            if($history != ''){
                $history = substr($history->kode,11,4);
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }else{
                $urut = "0001";
            }
        }elseif($cari->kode_po != ''){
            $history = HistoryPO::select('kode_po')->where('kode_po', 'LIKE', "%$tahunbulan%")->latest()->first();
            $history = substr($history->kode_po,11,4);
            $number = substr($cari->kode_po,11,4);
            if($number != $history){
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }elseif($number == $history){
                $number++;
                $urut = str_pad($number, 4, "0", STR_PAD_LEFT);  //00002
            }
        }
        $tahun2 = substr($request->tgl,2,2);
        $cari2 = PODetil::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
        if($cari2 === null){
            $history2 = HistoryPO::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            if($history2 != ''){
                $history2 = substr($history2->no_urut,3,6);
                $urut2 = $history2+1;
            }else{
                $urut2 = '1';
            }
        }elseif($cari2->no_urut != ''){
            $history2 = HistoryPO::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            $history2 = substr($history2->no_urut,3,6); 
            $number2 = substr($cari2->no_urut,3,6); 
            if($number2 != $history2){
                $urut2 = $history2+1;
            }elseif($number2 == $history2){
                $urut2 = $number2+1;
            }
        }
        $now = Carbon::now();

        
        $historypo = HistoryPO::insert([
            'kode_po' => 'PO'. '-' .$request->kode_po.$tahun.$bulan.'-'.$urut,
            'no_urut' => $tahun2.'-'.$urut2,
            'created_at' => $now,
        ]);
        $po = PODetil::create([
            'no_urut' => $tahun2.'-'.$urut2,
            'kode_sales' => $request->kode_po,
            'kode_po' => 'PO'. '-' .$request->kode_po.$tahun.$bulan.'-'.$urut,
            'paket' => $request->paket,
            'attn' => $request->attn,
            'cc' => $request->cc,
            'id_supplier' => $request->supplier,
            'id_perusahaan' => $request->perusahaan,
            'tgl' => $request->tgl,
            're' => $request->re,
            'pajak' => $request->pajak,
            'id_ekspedisi' => $request->ekspedisi,
            'ekspedisi_dll' => $request->ekspedisi_dll,
            'note' => $request->note,
            'npwp' => $request->npwp,
            'ttd' => $request->ttd,
            'ttd_id_sales' => $request->ttd_sales,
            'status' => '1',
            'created_at' =>$now,
            'updated_at' =>$now,
        ]);
        if($po != null){
            foreach($request->nama_barang as $key => $v){
                $barang = array(
                    'kode_po' => 'PO'. '-' .$request->kode_po.$tahun.$bulan.'-'.$urut,
                    'nama_barang' => $request->nama_barang [$key],
                    'qty' => $request->qty [$key],
                    'satuan' => $request->satuan [$key],
                    'harga' => $request->harga_satuan [$key],
                    'total' => $request->total [$key],
                    'keterangan' => $request->keterangan [$key],
                    'created_at' => $now,
                    'updated_at' => $now,
                );
                BarangPO::insert($barang);
            }
        }
        return redirect("/preview/po/$po->kode_po");
    }
    public function po_preview(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        
        $po = PODetil::where("kode_po",$kode)->first();
        $kodesales = $po->ttd_id_sales;
        $supplier = Supplier::join('tbpodetil', 'tbpodetil.id_supplier', '=', 'tbsupplier.id')
                                ->join('tbkelamin','tbkelamin.id','=','tbsupplier.jenis_kelamin')
                                ->where('kode_po', $kode)
                                ->select('tbsupplier.nama_perusahaan','tbsupplier.attn','tbsupplier.email','tbkelamin.sapaan')
                                ->first();
        $perusahaan = PerusahaanPO::join('tbpodetil', 'tbpodetil.id_perusahaan', '=', 'tbperusahaanpo.id')
                                ->where('kode_po', $kode)
                                ->select('tbperusahaanpo.nama_perusahaan','tbperusahaanpo.npwp')
                                ->first();
        $ekspedisi = Ekspedisi::join('tbpodetil', 'tbpodetil.id_ekspedisi', '=', 'tbekspedisi.id')
                                ->where('kode_po', $kode)
                                ->select('tbekspedisi.ekspedisi','tbekspedisi.no_hp','tbekspedisi.no_telp')
                                ->first();
        $attn = PODetil::where('kode_po',$kode)->select('attn')->first();
        $npwp = KodePO::where('kode_po',$kodesales)->first();
        $barang = BarangPO::where('kode_po',$kode)->get();
        $grandtotal = BarangPO::where('kode_po',$kode)->sum('total');
        $paragraf = ParagrafPO::first();
        return view('po_preview', ['po' => $po,'supplier' => $supplier,'perusahaan' => $perusahaan,'barang' => $barang,'grandtotal' => $grandtotal,'paragraf'=>$paragraf,'ekspedisi'=>$ekspedisi,'npwp'=>$npwp,'attn' => $attn]);
    }
    public function po_print(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        
        $po = PODetil::where("kode_po",$kode)->first();
        $kodesales = $po->ttd_id_sales;
        $attn = PODetil::where('kode_po',$kode)->select('attn')->first();
        $supplier = Supplier::join('tbpodetil', 'tbpodetil.id_supplier', '=', 'tbsupplier.id')
                                ->join('tbkelamin','tbkelamin.id','=','tbsupplier.jenis_kelamin')
                                ->where('kode_po', $kode)
                                ->select('tbsupplier.nama_perusahaan','tbsupplier.attn','tbsupplier.email','tbkelamin.sapaan')
                                ->first();
        $perusahaan = PerusahaanPO::join('tbpodetil', 'tbpodetil.id_perusahaan', '=', 'tbperusahaanpo.id')
                                ->where('kode_po', $kode)
                                ->select('tbperusahaanpo.nama_perusahaan','tbperusahaanpo.npwp')
                                ->first();
        $ekspedisi = Ekspedisi::join('tbpodetil', 'tbpodetil.id_ekspedisi', '=', 'tbekspedisi.id')
                                ->where('kode_po', $kode)
                                ->select('tbekspedisi.ekspedisi','tbekspedisi.no_hp','tbekspedisi.no_telp')
                                ->first();
        $npwp = KodePO::where('kode_po',$kodesales)->first();
        $barang = BarangPO::where('kode_po',$kode)->get();
        $grandtotal = BarangPO::where('kode_po',$kode)->sum('total');
        $paragraf = ParagrafPO::first();
        return view('po_print', ['attn' => $attn,'po' => $po,'supplier' => $supplier,'perusahaan' => $perusahaan,'barang' => $barang,'grandtotal' => $grandtotal,'paragraf'=>$paragraf,'ekspedisi'=>$ekspedisi,'npwp'=>$npwp]);
    }
    public function ekspedisi(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $ekspedisi = Ekspedisi::all();
            return view('ekspedisi',['ekspedisi'=>$ekspedisi]);
        }else{
            return abort(403);       
        }
    }
    public function ekspedisi_memo(Request $request,$id)
    {
        $memo = Ekspedisi::find($id);
        return view('ekspedisi_memo',['memo' => $memo,'id'=>$id]);
    }
    public function ekspedisi_memo_submit(Request $request,$id)
    {
        $memo = Ekspedisi::find($id);
        $memo->memo2 = $request->editor;
        $memo->timestamps = false;
        $memo->save();
        
        return Redirect::back()->with('success','Memo Berhasil di edit');
    }
    public function ekspedisi_tambah(Request $request){
        $data = [
            'ekspedisi' => $request->ekspedisi,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'no_hp' => $request->no_hp,
            'nama_pic' => $request->nama_pic,
            'email' => $request->email,
            'memo' => $request->memo,
            'nama_pic_gudang' => $request->nama_pic_gudang,
            'no_telp_gudang' => $request->no_telp_gudang,
            'no_hp_gudang' => $request->no_hp_gudang,
            'nama_keuangan' => $request->nama_keuangan,
            'no_telp_keuangan' => $request->no_telp_keuangan,
            'no_hp_keuangan' => $request->no_hp_keuangan,
            'nama_kurir' => $request->nama_kurir,
            'no_telp_kurir' => $request->no_telp_kurir,
            'no_hp_kurir' => $request->no_hp_kurir,
        ];
        Ekspedisi::insert($data);
        return redirect('/master/ekspedisi')->with('success','Data berhasil ditambahkan!');
    }
    public function ekspedisi_edit(Request $request)
    {
        $ekspedisi = Ekspedisi::find($request->id);
        $ekspedisi->ekspedisi = $request->ekspedisi;
        $ekspedisi->alamat = $request->alamat;
        $ekspedisi->no_telp = $request->no_telp;
        $ekspedisi->no_hp = $request->no_hp;
        $ekspedisi->nama_pic = $request->nama_pic;
        $ekspedisi->email = $request->email;
        $ekspedisi->memo = $request->memo;
        $ekspedisi->nama_pic_gudang = $request->nama_pic_gudang;
        $ekspedisi->no_telp_gudang = $request->no_telp_gudang;
        $ekspedisi->no_hp_gudang = $request->no_hp_gudang;
        $ekspedisi->nama_keuangan = $request->nama_keuangan;
        $ekspedisi->no_telp_keuangan = $request->no_telp_keuangan;
        $ekspedisi->no_hp_keuangan = $request->no_hp_keuangan;
        $ekspedisi->nama_kurir = $request->nama_kurir;
        $ekspedisi->no_telp_kurir = $request->no_telp_kurir;
        $ekspedisi->no_hp_kurir = $request->no_hp_kurir;
        $ekspedisi->timestamps = false;
        
        $ekspedisi->save();
        return redirect('/master/ekspedisi')->with('success','Data berhasil diedit!');
    }
    public function ekspedisi_hapus(Request $request)
    {
        Ekspedisi::find($request->id)->delete();
        return redirect('/master/ekspedisi')->with('success','Data berhasil dihapus!');
    }
    public function perusahaan_pelanggan(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $pelanggan = Pelanggan::leftJoin('tbbank','tbbank.id','=','tbpelanggan.bank_transfer')
                                    ->select('tbpelanggan.*','tbbank.nomor_rekening','tbbank.nama_rekening','tbbank.nama_bank','tbbank.gambar')
                                    ->get();
            $kelamin = Kelamin::all();
            $status = KategoriStatus::all();
            $payment = KategoriPayment::all();
            $bank = Bank::all();
            $rule = Rule::find(1);
            return view('perusahaan_pelanggan',[
                'pelanggan' => $pelanggan,
                'kelamin' => $kelamin,
                'status' => $status,
                'payment' => $payment,
                'bank' => $bank,
                'rule' => $rule,
            ]);
        }else{
            return abort(403);       
        }
    }
    public function perusahaan_pelanggan_view(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $pelanggan = Pelanggan::join('tbkelamin','tbkelamin.id','=','tbpelanggan.jenis_kelamin')
                                    ->where('kode_pelanggan',$kode)
                                    ->select('tbpelanggan.*','tbkelamin.sapaan')
                                    ->first();
            return view('perusahaan_pelanggan_view',[
                'pelanggan' => $pelanggan
            ]);
        }else{
            return abort(403);       
        }
    }
    public function perusahaan_pelanggan_tambah(Request $request){
        $request->validate([
            'kode_pelanggan' => 'required|unique:tbpelanggan,kode_pelanggan',
            'nama_perusahaan' => 'required',
            'nama_pemilik' => 'required',
            'no_telp' => 'required',
        ]);
        $data = [
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'nama_kota' => $request->nama_kota,
            'nama_pemilik' => $request->nama_pemilik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'memo' => $request->memo,
            'gps_latitude' => $request->gps_latitude,
            'gps_longtitude' => $request->gps_longtitude,
            'status_perusahaan' => $request->status_perusahaan,
            'payment' => $request->payment,
            'bank_transfer' => $request->bank_transfer,
        ];
        Pelanggan::insert($data);
        return redirect('/master/penawaran/pelanggan')->with('success','Data berhasil ditambahkan!!');
    }
    public function perusahaan_pelanggan_edit(Request $request){
        $pelanggan = Pelanggan::find($request->id);
        if($pelanggan->kode_pelanggan != $request->kode_pelanggan){
            $request->validate([
                'kode_pelanggan' => 'required|unique:tbpelanggan,kode_pelanggan',
                'nama_perusahaan' => 'required',
                'nama_pemilik' => 'required',
                'no_telp' => 'required',
            ]);
        }else{
            $request->validate([
                'kode_pelanggan' => 'required|',
                'nama_perusahaan' => 'required',
                'nama_pemilik' => 'required',
                'no_telp' => 'required',
            ]);
        }
        $pelanggan->kode_pelanggan = $request->kode_pelanggan;
        $pelanggan->nama_perusahaan = $request->nama_perusahaan;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->nama_kota = $request->nama_kota;
        $pelanggan->nama_pemilik = $request->nama_pemilik;
        $pelanggan->jenis_kelamin = $request->jenis_kelamin;
        $pelanggan->no_telp = $request->no_telp;
        $pelanggan->no_hp = $request->no_hp;
        $pelanggan->email = $request->email;
        $pelanggan->memo = $request->memo;
        $pelanggan->gps_latitude = $request->gps_latitude;
        $pelanggan->gps_longtitude = $request->gps_longtitude;
        $pelanggan->status_perusahaan = $request->status_perusahaan;
        $pelanggan->payment = $request->payment;
        $pelanggan->bank_transfer = $request->bank_transfer;
        $pelanggan->timestamps = false;
        $pelanggan->save();
        return redirect('/master/penawaran/pelanggan')->with('success','Data berhasil diedit!!');
    }
    public function perusahaan_pelanggan_hapus(Request $request){
        Pelanggan::where('id',$request->id)->delete();
        return redirect('/master/penawaran/pelanggan')->with('success','Data berhasil dihapus!');
    }

    public function paragraf_po(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $paragraf = ParagrafPO::first();
            return view('paragraf_po',['paragraf'=>$paragraf]);
        }else{
            return abort(403);       
        }
    }
    public function paragraf_po_edit(Request $request){
        $request->validate([
            'include_pajak' => 'required',
            'exclude_pajak' => 'required',
            'penutup' => 'required',
        ]);
        $paragraf = ParagrafPO::find(1);
        
        $paragraf->include_pajak = $request->include_pajak;
        $paragraf->exclude_pajak = $request->exclude_pajak;
        $paragraf->penutup = $request->penutup;
        $paragraf->timestamps = false;
        $paragraf->save();
        return redirect('/master/po/paragraf')->with('success','Data berhasil diedit');
    }
    public function kode_po(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1'){
            $kode = KodePO::all();
            $perusahaan = PerusahaanPO::all();
            return view('kode_po',['kode' => $kode,'perusahaan' => $perusahaan]);
        }else{
            return abort(403);       
        }
    }
    public function kode_po_tambah(Request $request){
        $request->validate([
            'kode_po' => 'required|unique:tbkodepo,kode_po|max:3',
            'nama' => 'required',
            'ttd' => 'image',
            'nip_sales' => 'max:5',
            'nama_perusahaan' => 'required',
            'gol' => 'max:2',
            'email' => 'required|unique:tbkodepo,email',
            'password' => 'required|confirmed:password_confirmation',
            'password_confirmation' => 'required',
            'role_id' => 'required',
        ],[
            'kode_po.unique' => 'Kode Sales sudah ada',
            'email.unique' => 'Email sudah ada dipakai',
            'password.confirmed' => 'Field Password harus sama dengan Confirm Password'

        ]);
        if($request->hasFile('ttd')){
            $image = $request->file('ttd');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/assets/images/upload/ttd/'),$new_name);
        }else{
            $new_name ="";
        }
        $tambah = new KodePO;
        $tambah->kode_po = strtoupper($request->kode_po);
        $tambah->nama = $request->nama;
        $tambah->ttd = $new_name;
        $tambah->nip_sales = $request->nip_sales;
        $tambah->nama_perusahaan = $request->nama_perusahaan;
        $tambah->jabatan = $request->jabatan;
        $tambah->gol = $request->gol;
        $tambah->no_hp = $request->no_hp;
        $tambah->email = $request->email;
        $tambah->nama_saudara = $request->nama_saudara;
        $tambah->no_hp_saudara = $request->no_hp_saudara;
        $tambah->memo = $request->memo;
        $tambah->password = Hash::make($request->password_confirmation);
        $tambah->role_id = $request->role_id;
        if($request->hasFile('gambar1')){
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/sales/'),$gambar1);
            $tambah->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/sales/'),$gambar2);
            $tambah->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/sales/'),$gambar3);
            $tambah->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/sales/'),$gambar4);
            $tambah->gambar4 = $gambar4;
        }
        $tambah->timestamps = false;
        $tambah->save();
        if($tambah != ''){
            FilterPenawaran::insert([
                'kode_sales' => $request->kode_po
            ]);
            FilterPO::insert([
                'kode_sales' => $request->kode_po
            ]);
            FilterPOSekolah::insert([
                'kode_sales' => $request->kode_po
            ]);
            FilterBukuEkspedisi::insert([
                'kode_sales' => $request->kode_po
            ]);
            FilterTTB::insert([
                'kode_sales' => $request->kode_po
            ]);
        }
        return redirect('/master/kode')->with('success','Data berhasil ditambahkan');
    }
    public function kode_po_edit(Request $request){
        $kode = KodePO::find($request->id);
        $image_name = $request->hidden_ttd;
        $image = $request->file('ttd');
        if($image != '')
        {
            if($kode->kode_po == $request->kode_po){
                $request->validate([
                    'kode_po' => 'required|',
                    'nama' => 'required',
                    'ttd' => 'image',
                    'nama_perusahaan' => 'required',
                    'email' => 'required|unique:tbkodepo,email,'.$kode->id,
                    'password' => 'required|confirmed:password_confirmation',
                    'password_confirmation' => 'required',
                    'role_id' => 'required',
                ]);
            }else{
                $request->validate([
                    'kode_po' => 'required|unique:tbkodepo,kode_po',
                    'nama' => 'required',
                    'ttd' => 'image',
                    'nama_perusahaan' => 'required',
                    'email' => 'required|unique:tbkodepo,email,'.$kode->id,
                    'password' => 'required|confirmed:password_confirmation',
                    'password_confirmation' => 'required',
                    'role_id' => 'required',
                ]);
            }
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/assets/images/upload/ttd/'), $image_name);
        }else{
            if($kode->kode_po == $request->kode_po){
                $request->validate([
                    'kode_po' => 'required|',
                    'nama' => 'required',
                    'nama_perusahaan' => 'required',
                    'email' => 'required|unique:tbkodepo,email,'.$kode->id,
                    'password' => 'required|confirmed:password_confirmation',
                    'password_confirmation' => 'required',
                    'role_id' => 'required',
                ]);
            }else{
                $request->validate([
                    'kode_po' => 'required|unique:tbkodepo,kode_po',
                    'nama' => 'required',
                    'nama_perusahaan' => 'required',
                    'email' => 'required|unique:tbkodepo,email,'.$kode->id,
                    'password' => 'required|confirmed:password_confirmation',
                    'password_confirmation' => 'required',
                    'role_id' => 'required',
                ]);
            }
        }
        $kode->kode_po = strtoupper($request->kode_po);
        $kode->nama = $request->nama;
        $kode->ttd = $image_name;
        $kode->nip_sales = $request->nip_sales;
        $kode->nama_perusahaan = $request->nama_perusahaan;
        $kode->jabatan = $request->jabatan;
        $kode->gol = $request->gol;
        $kode->no_hp = $request->no_hp;
        $kode->email = $request->email;
        $kode->nama_saudara = $request->nama_saudara;
        $kode->no_hp_saudara = $request->no_hp_saudara;
        $kode->memo = $request->memo;
        $kode->password = Hash::make($request->password);
        $kode->role_id = $request->role_id;
        if($request->hasFile('gambar1')){
            File::delete('assets/images/upload/sales/'.$kode->gambar1);
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/sales/'),$gambar1);
            $kode->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            File::delete('assets/images/upload/sales/'.$kode->gambar2);
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/sales/'),$gambar2);
            $kode->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            File::delete('assets/images/upload/sales/'.$kode->gambar3);
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/sales/'),$gambar3);
            $kode->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            File::delete('assets/images/upload/sales/'.$kode->gambar4);
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/sales/'),$gambar4);
            $kode->gambar4 = $gambar4;
        }
        $kode->timestamps = false;
        $kode->save();
        return redirect('/master/kode')->with('success','Data berhasil diedit');
    }
    public function kode_po_hapus(Request $request){
        KodePO::where('id',$request->id)->delete();
        return redirect('/master/kode')->with('success','Data berhasil dihapus!');   
    }
    public function kode_po_view(Request $request, $kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $kode = KodePO::where('kode_po',$kode)->first();
            return view('kode_po_view',['kode' => $kode]);
        }else{
            return abort(403);       
        }
    }
    public function supplier(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $supplier = Supplier::all()->sortBy('kode_vendor');
            $kelamin = Kelamin::all();
            $status = KategoriStatus::all();
            $payment = KategoriPayment::all();
            return view('supplier',[
                'supplier' => $supplier,
                'kelamin' => $kelamin,
                'status' => $status,
                'payment' => $payment,
            ]);
        }else{
            return abort(403);       
        }
    }
    public function supplier_tambah(Request $request){
        $request->validate([
            'kode_vendor' => 'required|unique:tbsupplier,kode_vendor',
            'nama_perusahaan' => 'required',
            'attn' => 'required',
            'email' => 'required',
            'produk' => 'required',
        ],
        [
            'kode_vendor.required' => 'Kode vendor harus diisi..',
            'nama_perusahaan.required' => 'Nama Perusahaan harus diisi..',
            'kota.required' => 'Kota Perusahaan harus diisi..',
            'attn.required' => 'Attn Perusahaan harus diisi..',
            'no_telp.required' => 'no_telp Perusahaan harus diisi..',
            'email.required' => 'Email Perusahaan harus diisi..',
        ]);
        $no_npwp = str_split($request->no_npwp);
        array_splice($no_npwp,2,0,'.');
        array_splice($no_npwp,6,0,'.');
        array_splice($no_npwp,10,0,'.');
        array_splice($no_npwp,12,0,'-');
        array_splice($no_npwp,16,0,'.');

        Supplier::insert([
            'kode_vendor' => $request->kode_vendor,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'attn' => $request->attn,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'no_hp' => $request->no_hp,
            'no_npwp' => implode($no_npwp),
            'email' => $request->email,
            'nama_bank' => $request->nama_bank,
            'cabang_bank' => $request->cabang_bank,
            'nama_rek' => $request->nama_rek,
            'nomor_rek' => $request->nomor_rek,
            'memo' => $request->memo,
            'status_perusahaan' => $request->status_perusahaan,
            'payment' => $request->payment,
            'produk' => $request->produk,
        ]);
        return redirect('/master/po/supplier')->with('success','Data berhasil ditambahkan');
    }
    public function supplier_edit(Request $request){
        $titik = ['.'];
        $minus = '-';
        $no_npwp = str_split($request->no_npwp);
        array_splice($no_npwp,2,0,'.');
        array_splice($no_npwp,6,0,'.');
        array_splice($no_npwp,10,0,'.');
        array_splice($no_npwp,12,0,'-');
        array_splice($no_npwp,16,0,'.');
        
        $supplier = Supplier::find($request->id);
        if($supplier->kode_vendor == $request->kode_vendor){
            $request->validate([
                'kode_vendor' => 'required',
                'nama_perusahaan' => 'required',
                'attn' => 'required',
                'email' => 'required',
                'produk' => 'required',
            ],
            [
                'kode_vendor.required' => 'Kode vendor harus diisi..',
                'nama_perusahaan.required' => 'Nama Perusahaan harus diisi..',
                'kota.required' => 'Kota Perusahaan harus diisi..',
                'attn.required' => 'Attn Perusahaan harus diisi..',
                'no_telp.required' => 'no_telp Perusahaan harus diisi..',
                'email.required' => 'Email Perusahaan harus diisi..',
            ]);
        }else{
            $request->validate([
                'kode_vendor' => 'required|unique:tbsupplier,kode_vendor',
                'nama_perusahaan' => 'required',
                'attn' => 'required',
                'email' => 'required',
            ],
            [
                'kode_vendor.required' => 'Kode vendor harus diisi..',
                'nama_perusahaan.required' => 'Nama Perusahaan harus diisi..',
                'kota.required' => 'Kota Perusahaan harus diisi..',
                'attn.required' => 'Attn Perusahaan harus diisi..',
                'no_telp.required' => 'no_telp Perusahaan harus diisi..',
                'email.required' => 'Email Perusahaan harus diisi..',
            ]);
        }
        $supplier->kode_vendor = $request->kode_vendor;
        $supplier->nama_perusahaan = $request->nama_perusahaan;
        $supplier->alamat = $request->alamat;
        $supplier->kota = $request->kota;
        $supplier->attn = $request->attn;
        $supplier->jenis_kelamin = $request->jenis_kelamin;
        $supplier->no_telp = $request->no_telp;
        $supplier->no_hp = $request->no_hp;
        $supplier->no_npwp = implode($no_npwp);
        $supplier->email = $request->email;
        $supplier->nama_bank = $request->nama_bank;
        $supplier->cabang_bank = $request->cabang_bank;
        $supplier->nama_rek = $request->nama_rek;
        $supplier->nomor_rek = $request->nomor_rek;
        $supplier->memo = $request->memo;
        $supplier->status_perusahaan = $request->status_perusahaan;
        $supplier->payment = $request->payment;
        $supplier->produk = $request->produk;
        $supplier->timestamps = false;
        $supplier->save();
        return redirect('/master/po/supplier')->with('success','Data berhasil di edit..');
    }
    public function supplier_hapus(Request $request){
        Supplier::where('id',$request->id)->delete();
        return redirect('/master/po/supplier')->with('success','Data berhasil dihapus!');   
    }
    public function supplier_view(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $supplier = Supplier::join('tbkelamin','tbkelamin.id','=','tbsupplier.jenis_kelamin')
                                    ->where('kode_vendor',$kode)
                                    ->select('tbsupplier.*','tbkelamin.sapaan')
                                    ->first();
            return view('supplier_view',[
                'supplier' => $supplier
            ]);
        }else{
            return abort(403);       
        }
    }
    public function po_perusahaan(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1'){
            $perusahaan = PerusahaanPO::all();
            return view('po_perusahaan',['perusahaan' => $perusahaan]);
        }else{
            return abort(403);       
        }
    }

    public function po_perusahaan_view(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1'){
            $perusahaan = PerusahaanPO::where('kode_perusahaan',$kode)->first();
            return view('po_perusahaan_view',['perusahaan' => $perusahaan]);
        }else{
            return abort(403);       
        }
    }
    
    public function po_perusahaan_tambah(Request $request){
        $request->validate([
            'nama_perusahaan' => 'required',
            'npwp' => 'required|image',
            'email' => 'required',
            ]);
            if($request->hasFile('npwp')){
                $image = $request->file('npwp');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/assets/images/upload/npwp/'),$new_name);
            }else{
                $new_name = '';
            }
            if($request->hasFile('logo')){
                $image_logo = $request->file('logo');
                $new_name_logo = rand() . '.' . $image_logo->getClientOriginalExtension();
                $image_logo->move(public_path('/assets/images/upload/logo/'),$new_name_logo);
            }else{
                $new_name_logo = '';
            }
            if($request->hasFile('kop_surat')){
                $image_kop = $request->file('kop_surat');
                $new_name_kop = rand() . '.' . $image_kop->getClientOriginalExtension();
                $image_kop->move(public_path('/assets/images/upload/kopsurat/'),$new_name_kop);
            }else{
                $new_name_kop = '';
            }

            $form_data = [
                'kode_perusahaan' => $request->kode_perusahaan, 
                'nama_perusahaan' => $request->nama_perusahaan, 
                'npwp' => $new_name,
                'email' => $request->email,
                'alamat' => $request->alamat, 
                'nama_kota' => $request->nama_kota, 
                'telp' => $request->no_telp, 
                'logo' => $new_name_logo, 
                'kop_surat' => $new_name_kop, 
            ];
            PerusahaanPO::insert($form_data);
            return redirect('/master/perusahaan')->with('success','Data berhasil ditambahkan');
        }
        
    public function po_perusahaan_hapus(Request $request){
        PerusahaanPO::where('id',$request->id)->delete();
        return redirect('/master/perusahaan')->with('success','Data berhasil dihapus');
    }

    public function po_perusahaan_edit(Request $request){
        $perusahaan = PerusahaanPO::find($request->id);
        $image_name = $request->hidden_npwp;
        $image_logo = $request->hidden_logo;
        $image_kop_surat = $request->hidden_kop_surat;
        $image = $request->file('npwp');
        $image2 = $request->file('logo');
        $image3 = $request->file('kop_surat');
        if($perusahaan->kode_perusahaan != $request->kode_perusahaan){
            $request->validate([
                'kode_perusahaan' => 'required|unique:tbperusahaanpo,kode_perusahaan',
                'nama_perusahaan' => 'required',
            ]);
        }else{
            $request->validate([
                'kode_perusahaan' => 'required|',
                'nama_perusahaan' => 'required'
            ]);
        }
        if($image != '')
        {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/assets/images/upload/npwp/'), $image_name);
        }
        if($image2 != ''){
            $image_logo = rand() . '.' . $image2->getClientOriginalExtension();
            $image2->move(public_path('/assets/images/upload/logo/'), $image_logo);
        }
        if($image3 != ''){
            $image_kop_surat = rand() . '.' . $image3->getClientOriginalExtension();
            $image3->move(public_path('/assets/images/upload/kopsurat/'), $image_kop_surat);
        }
        $perusahaan->kode_perusahaan = $request->kode_perusahaan;
        $perusahaan->nama_perusahaan = $request->nama_perusahaan;
        $perusahaan->npwp = $image_name;
        $perusahaan->email = $request->email;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->nama_kota = $request->nama_kota;
        $perusahaan->telp = $request->no_telp;
        $perusahaan->logo = $image_logo;
        $perusahaan->kop_surat = $image_kop_surat;
        $perusahaan->timestamps = false;
        $perusahaan->save();
        return redirect('/master/perusahaan')->with('success','Data berhasil diedit');
    }

    public function list_penawaran(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
            $status = Status::all();
            $customer = Pelanggan::all();
            $perusahaan = PerusahaanPO::all();
            $sales = KodePO::all();
            $filter = FilterPenawaran::where('kode_sales',$request->session()->get('kode_sales'))->first();
            if($filter->status == '<=16'){
                $angka1 = 1;
                $angka2 = 16;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }elseif($filter->status == '<=15'){
                $angka1 = 1;
                $angka2 = 15;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }else{
                $operator = substr($filter->status,0,1);
                $angka = substr($filter->status,1,2);
            }
            
            $pelanggan = InputPenawaran::leftJoin('tbpelanggan', 'tbpelanggan.id', '=', 'tbpenawarandetil.id_pelanggan')
                                        ->leftJoin('tbsekolah','tbsekolah.id','=','tbpenawarandetil.id_sekolah')
                                        ->join('tbkodepo', 'tbkodepo.kode_po', '=', 'tbpenawarandetil.kode_sales')
                                        ->join('tbbarang', 'tbbarang.kode_penawaran', '=', 'tbpenawarandetil.kode_penawaran')
                                        ->join('tbstatus','tbstatus.id','=','tbpenawarandetil.status');
            if($filter->id_customer != ''){
                $pelanggan->where('tbpenawarandetil.id_pelanggan',$filter->id_customer);
            }
            if($filter->id_perusahaan != ''){
                $pelanggan->where('tbpenawarandetil.id_perusahaan',$filter->id_perusahaan);
            }
            if($filter->status == '<=15' || $filter->status == '<=16'){
                $pelanggan->whereBetween('tbpenawarandetil.status',[$angka1,$angka2]);
            }elseif($filter->status != ''){
                $pelanggan->where('tbpenawarandetil.status',$operator,$angka);
            }
            if($filter->id_sales != ''){
                $pelanggan->where('tbpenawarandetil.kode_sales',$filter->id_sales);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir != ''){
                $pelanggan->whereBetween('tbpenawarandetil.tgls',[$filter->tgl_awal,$filter->tgl_akhir]);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir == ''){
                $pelanggan->where('tbpenawarandetil.tgls',$filter->tgl_awal);
            }
            if($filter->tgl_awal == '' && $filter->tgl_akhir != ''){
                $pelanggan->where('tbpenawarandetil.tgls',$filter->tgl_akhir);
            }
            if($filter->tahun != ''){
                $pelanggan->where('tbpenawarandetil.tgls','LIKE','%'.$filter->tahun.'%');
            }
            if($filter->masa_berlaku != ''){
                $pelanggan->where('tbpenawarandetil.lama_penawaran',$filter->operator,$filter->masa_berlaku);
            }
            if($filter->pajak != ''){
                $pelanggan->where('tbpenawarandetil.pilihan_pajak',$filter->pajak);
            }
            $pelanggan->select('tbpenawarandetil.kode_penawaran','tbpelanggan.gps_longtitude','tbpelanggan.gps_latitude','tbpelanggan.nama_perusahaan', 'tbpenawarandetil.created_at','tbkodepo.kode_po as kode_sales','tbkodepo.nama as nama_sales','tbpenawarandetil.lama_penawaran','tbpenawarandetil.tgl_penawaran',DB::raw('SUM(tbbarang.total) as total'),'tbstatus.status','tbpenawarandetil.tgls','tbpenawarandetil.no_urut','tbsekolah.nama_sekolah');
            $pelanggan->groupBy('tbpenawarandetil.kode_penawaran','tbpelanggan.gps_longtitude','tbpelanggan.gps_latitude','tbpelanggan.nama_perusahaan', 'tbpenawarandetil.created_at','kode_sales','nama_sales','tbpenawarandetil.lama_penawaran','tbpenawarandetil.tgl_penawaran','tbpenawarandetil.status','tbpenawarandetil.tgls','tbpenawarandetil.no_urut','tbsekolah.nama_sekolah');
            $pelanggan->orderBy('tbpenawarandetil.no_urut','DESC');
            $rule = Rule::find(1);
            return view("list_penawaran",[
                'pelanggan' => $pelanggan->get(),
                'status' => $status,
                'customer' => $customer,
                'perusahaan' => $perusahaan,
                'sales' => $sales,
                'filter' => $filter,
                'rule' => $rule,
            ]);
    }
    public function list_penawaran_edit($kode){
        $status = Status::all();
        $sales = KodePO::all();
        $satuan = Satuan::all();
        $pelanggan = Pelanggan::all();
        $perusahaan = PerusahaanPO::all();
        $penawaran = InputPenawaran::where('kode_penawaran', $kode)->first();
        $barang = Barang::where('kode_penawaran',$kode)->get();
        return view('list_penawaran_edit',[
            'status' => $status,
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'perusahaan' => $perusahaan,
            'penawaran' => $penawaran,
            'barang' => $barang,
            'satuan' => $satuan,
        ]);
    }

    public function list_penawaran_submit(Request $request,$kode)
    {
        $start = new \Carbon\Carbon($request->tgls);
        $tgl_penawaran = $start->addDays($request->masa_tgl); //tgl jatuh tempo
        $edit = InputPenawaran::find($request->id);
        if($request->session()->get('role_id') == '1'){
            $edit->kode_sales = $request->sales;
            $edit->perihal = $request->perihal;
            $edit->pilihan_pajak = $request->pajak;
            $edit->note = $request->note;
            $edit->lama_penawaran = $request->masa_tgl;
            $edit->tgl_penawaran = $tgl_penawaran;
            $edit->id_perusahaan = $request->perusahaan;
            $edit->id_pelanggan = $request->pelanggan;
            $edit->status = $request->status;
            $edit->tgls = $request->tgls;
            $edit->ttd = $request->ttd_status;
            $edit->ttd_id_sales = $request->ttd_sales;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/penawaran/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/penawaran/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/penawaran/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/penawaran/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            $edit->timestamps = false;
            $edit->save();
        }elseif($request->status <= 4 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit->kode_sales = $request->sales;
            $edit->perihal = $request->perihal;
            $edit->pilihan_pajak = $request->pajak;
            $edit->note = $request->note;
            $edit->lama_penawaran = $request->masa_tgl;
            $edit->tgl_penawaran = $tgl_penawaran;
            $edit->id_perusahaan = $request->perusahaan;
            $edit->id_pelanggan = $request->pelanggan;
            $edit->status = $request->status;
            $edit->tgls = $request->tgls;
            $edit->ttd = $request->ttd_status;
            $edit->ttd_id_sales = $request->ttd_sales;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/penawaran/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/penawaran/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/penawaran/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/penawaran/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            $edit->timestamps = false;
            $edit->save();
        }elseif($request->status >= 5 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit->status = $request->status;
            $edit->timestamps = false;
            $edit->save();
        }
        return redirect("/list/penawaran/edit/$kode");
    }

    public function list_penawaran_edit_barang(Request $request, $kode)
    {
        $barang = Barang::find($request->id);
        $barang->nama_barang = $request->nama_barang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->harga_satuan = $request->harga;
        $barang->total = $request->total;
        $barang->timestamps = false;
        $barang->save();
        return redirect("/list/penawaran/edit/$kode");
    }
    public function list_penawaran_tambah_barang(Request $request,$kode){
        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->harga_satuan = $request->harga;
        $barang->total = $request->total;
        $barang->kode_penawaran = $kode;
        $barang->save();
        return redirect("/list/penawaran/edit/$kode");
    }
    public function list_penawaran_hapus_barang(Request $request,$kode)
    {
        Barang::where('id',$request->id)->delete();
        return redirect("/list/penawaran/edit/$kode");
    }

    public function list_penawaran_delete(Request $request){
        InputPenawaran::where('kode_penawaran',$request->id)->delete();
        return redirect('/list/penawaran');
    }

    public function list_po(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
            $status = Status::all();
            $filter = FilterPO::where('kode_sales',$request->session()->get('kode_sales'))->first();
            if($filter->status == '<=16'){
                $angka1 = 1;
                $angka2 = 16;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }elseif($filter->status == '<=15'){
                $angka1 = 1;
                $angka2 = 15;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }else{
                $operator = substr($filter->status,0,1);
                $angka = substr($filter->status,1,2);
            }
            $supplier = Supplier::join('tbpodetil', 'tbpodetil.id_supplier', '=', 'tbsupplier.id')
                                ->join('tbkodepo', 'tbpodetil.kode_sales', '=', 'tbkodepo.kode_po')
                                ->join('tbperusahaanpo', 'tbpodetil.id_perusahaan', '=', 'tbperusahaanpo.id')
                                ->join('tbbarangpo', 'tbpodetil.kode_po', '=', 'tbbarangpo.kode_po')
                                ->join('tbstatus','tbpodetil.status','=','tbstatus.id');
            if($filter->status == '<=15' || $filter->status == '<=16'){
                $supplier->whereBetween('tbpodetil.status',[$angka1,$angka2]);
            }elseif($filter->status != ''){
                $supplier->where('tbpodetil.status',$operator,$angka);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir != ''){
                $supplier->whereBetween('tbpodetil.tgl',[$filter->tgl_awal,$filter->tgl_akhir]);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir == ''){
                $supplier->where('tbpodetil.tgl',$filter->tgl_awal);
            }
            if($filter->tgl_awal == '' && $filter->tgl_akhir != ''){
                $supplier->where('tbpodetil.tgl',$filter->tgl_akhir);
            }
            if($filter->tahun != ''){
                $supplier->where('tbpodetil.tgl','LIKE','%'.$filter->tahun.'%');
            }
            $supplier->select('tbpodetil.re','tbpodetil.status','tbpodetil.kode_po','tbpodetil.tgl','tbsupplier.nama_perusahaan','tbsupplier.attn','tbsupplier.email','tbkodepo.nama','tbperusahaanpo.nama_perusahaan as perusahaan',DB::raw('SUM(tbbarangpo.total) as total'),'tbstatus.status','tbpodetil.no_urut');
            $supplier->groupBy('tbpodetil.re','tbpodetil.status','tbpodetil.kode_po','tbpodetil.tgl','tbsupplier.nama_perusahaan','tbsupplier.attn','tbsupplier.email','tbkodepo.nama','perusahaan','tbstatus.status','tbpodetil.no_urut');
            $supplier->orderBy('tbpodetil.no_urut','DESC');
            return view('list_po',['supplier' => $supplier->get(),'status' => $status,'filter'=>$filter]);
    }
    public function list_po_edit($kode)
    {
        $status = Status::all();
        $ekspedisi = Ekspedisi::all();
        $sales = KodePO::all();
        $vendor = Supplier::all();
        $perusahaan = PerusahaanPO::all();
        $satuan = Satuan::all();
        $barang = BarangPO::where('kode_po',$kode)->get();
        $statuspo = Status::join('tbpodetil','tbpodetil.status','=','tbstatus.id')
                            ->where('kode_po',$kode)
                            ->select('tbstatus.status')
                            ->first();
        $po = PODetil::where('kode_po',$kode)->first();
        return view('list_po_edit',[
            'po' => $po,
            'status' => $status,
            'statuspo'=>$statuspo,
            'sales'=>$sales,
            'vendor'=>$vendor,
            'perusahaan' => $perusahaan,
            'ekspedisi' => $ekspedisi,
            'barang' => $barang,
            'satuan' => $satuan,
            'kode' => $kode
            ]);
    }
    public function list_po_memo_view(Request $request,$kode)
    {
        $memo = PODetil::where('kode_po',$kode)->select('memo')->first();
        return view('list_po_memo_view',[
            'memo' => $memo,
            'kode' => $kode
        ]);
    }
    public function list_po_memo_submit(Request $request,$kode)
    {
        $memo = PODetil::where('kode_po',$kode)->update(['memo'=>$request->editor]);
        return Redirect::back()->with('success','Memo berhasil diedit');
    }
    public function list_po_submit(Request $request,$kode)
    {
        
        if($request->session()->get('role_id') == '1'){
            $edit = PODetil::find($request->id);
            $edit->kode_sales = $request->sales;
            $edit->paket = $request->paket;
            $edit->attn = $request->attn;
            $edit->cc = $request->cc;
            $edit->id_supplier = $request->vendor;
            $edit->id_perusahaan = $request->perusahaan;
            $edit->tgl = $request->tgl;
            $edit->re = $request->re;
            $edit->pajak = $request->pajak;
            $edit->id_ekspedisi = $request->ekspedisi;
            $edit->ekspedisi_dll = $request->ekspedisi_dll;
            $edit->note = $request->note;
            $edit->ttd = $request->ttd;
            $edit->ttd_id_sales = $request->ttd_sales;
            $edit->status = $request->status;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/po/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/po/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/po/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/po/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            $edit->timestamps = false;
            $edit->save();
        }elseif($request->status <= 4 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit = PODetil::find($request->id);
            $edit->kode_sales = $request->sales;
            $edit->paket = $request->paket;
            $edit->cc = $request->cc;
            $edit->id_supplier = $request->vendor;
            $edit->id_perusahaan = $request->perusahaan;
            $edit->tgl = $request->tgl;
            $edit->re = $request->re;
            $edit->pajak = $request->pajak;
            $edit->id_ekspedisi = $request->ekspedisi;
            $edit->ekspedisi_dll = $request->ekspedisi_dll;
            $edit->note = $request->note;
            $edit->ttd = $request->ttd;
            $edit->ttd_id_sales = $request->ttd_sales;
            $edit->status = $request->status;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/po/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/po/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/po/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/po/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            $edit->timestamps = false;
            $edit->save();
        }elseif($request->status >= 5 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit = PODetil::find($request->id);
            $edit->status = $request->status;
            $edit->timestamps = false;
            $edit->save();
        }
        return redirect("/list/po/edit/$kode");
    }

    public function list_po_edit_barang(Request $request,$kode)
    {
        $barang = BarangPO::find($request->id);
        $barang->nama_barang = $request->nama_barang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;
        $barang->total = $request->total;
        $barang->keterangan = $request->keterangan;
        $barang->timestamps = false;
        $barang->save();
        return redirect("/list/po/edit/$kode");
    }

    public function list_po_tambah_barang(Request $request,$kode)
    {
        $barang = new BarangPO();
        $barang->nama_barang = $request->nama_barang;
        $barang->qty = $request->qty;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;
        $barang->total = $request->total;
        $barang->keterangan = $request->keterangan;
        $barang->kode_po = $kode;
        
        $barang->save();
        return redirect("/list/po/edit/$kode");
    }
    public function list_po_hapus_barang(Request $request,$kode)
    {
        BarangPO::where('id',$request->id)->delete();
        return redirect("/list/po/edit/$kode");
    }
    public function list_po_delete(Request $request){
        PODetil::where('kode_po',$request->id)->delete();
        return redirect('/list/po');
    }

    public function buku_ekspedisi(Request $request)    
    {
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $ekspedisi =  Ekspedisi::all();
        $untuk =  PerusahaanPO::all();
        $status =  StatusEkspedisi::all();
        $satuan = Status::join('tbpodetil','tbpodetil.status','=','tbstatus.id')
                        ->join('tbsupplier','tbpodetil.id_supplier','=','tbsupplier.id')
                        ->where('tbpodetil.status', '=' , 16)
                        ->select('tbstatus.status','tbpodetil.kode_po','tbpodetil.id','tbsupplier.nama_perusahaan','tbpodetil.re')
                        ->get();
        return view('buku_ekspedisi',[
            'ekspedisi' => $ekspedisi,
            'untuk' => $untuk,
            'satuan' => $satuan,
            'status' => $status,
        ]);
    }
    public function buku_ekspedisi_edit_gambar(Request $request,$id){
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image'
            ]);
            $images = $request->file('image');
            $originalFileName = $images->getClientOriginalName();
            $extension = $images->getClientOriginalExtension();
            $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
            $fileName = Str::slug($fileNameOnly) . "-" . time() . "." . $extension;
            $uploadedFileName = $images->storeAs('public/ekspedisi', $fileName);
            $edit = ImageEkspedisi::find($request->id);
            $edit->gambar = $uploadedFileName;
            $edit->timestamps = false;
            $edit->save();
            $gambar_lama = str_replace('public/ekspedisi/','',$request->hidden_image);
            Storage::disk('local')->delete("/public/ekspedisi/" . $gambar_lama);
            return redirect("/list/buku-ekspedisi/edit/$id")->with('success','Gambar berhasil di edit');
        }else{
            return redirect("/list/buku-ekspedisi/edit/$id")->with('alert','Upload gambar jika ingin edit');
        }
    }
    public function buku_ekspedisi_hapus_gambar(Request $request,$id){
        $gambar_lama = str_replace('public/ekspedisi/','',$request->hidden_image);
        Storage::disk('local')->delete("/public/ekspedisi/" . $gambar_lama);
        ImageEkspedisi::where('id',$request->id)->delete();
        return redirect("/list/buku-ekspedisi/edit/$id")->with('success','Gambar berhasil di hapus');
    }
    public function buku_ekspedisi_tambah_gambar(Request $request,$id){
        if($request->hasFile('image')){
            $request->validate([
                'image.*' => 'required|image'
            ]);
            $images = $this->uploadFiles($request);
            foreach($images as $imageFile)
            {
                list($fileName, $title) = $imageFile;
                ImageEkspedisi::insert([
                    'id_ekspedisi' => $id,
                    'gambar' => $fileName
                ]);
            }
            return redirect("/list/buku-ekspedisi/edit/$id")->with('success','Gambar berhasil di tambahkan');
        }else{
            return redirect("/list/buku-ekspedisi/edit/$id")->with('alert','Upload gambar jika ingin edit');
        }
    }
    public function buku_ekspedisi_submit(Request $request){
        $request->validate([
            'tgl'=> 'required',
            'jam'=> 'required',
            'ekspedisi'=> 'required',
            'jumlah_coli'=> 'required',
            'nama_pengirim'=> 'required',
            'penerima_barang'=> 'required',
            'no_resi'=> 'required',
        ]);
        $tahun = substr($request->tgl,2,2);
        $cari2 = BukuEkspedisi::select('no_urut')->where('no_urut', 'LIKE', "$tahun-%")->latest()->first();
        if($cari2 === null){
            $history2 = HistoryEkspedisi::select('no_urut')->where('no_urut', 'LIKE', "$tahun-%")->latest()->first();
            if($history2 != ''){
                $history2 = substr($history2->no_urut,3,6);
                $urut2 = $history2+1;
            }else{
                $urut2 = '1';
            }
        }elseif($cari2->no_urut != ''){
            $history2 = HistoryEkspedisi::select('no_urut')->where('no_urut', 'LIKE', "$tahun-%")->latest()->first();
            $history2 = substr($history2->no_urut,3,6); 
            $number2 = substr($cari2->no_urut,3,6); 
            if($number2 != $history2){
                $urut2 = $history2+1;
            }elseif($number2 == $history2){
                $urut2 = $number2+1;
            }
        }
        $id = new BukuEkspedisi;
        $id->no_urut = $tahun.'-'.$urut2;
        $id->tgl = $request->tgl;
        $id->jam = $request->jam;
        $id->nama_ekspedisi = $request->ekspedisi;
        $id->jumlah_coli = $request->jumlah_coli;
        $id->nama_pengirim = $request->nama_pengirim;
        $id->alamat_pengirim = $request->alamat_pengirim;
        $id->untuk = $request->untuk;
        $id->untuk_dll = $request->untuk_dll;
        $id->penerima_barang = $request->penerima_barang;
        $id->no_po = $request->no_po;
        $id->no_po_dll = $request->no_po_isi;
        $id->status = $request->status;
        $id->memo = $request->memo;
        $id->no_resi = $request->no_resi;
        $id->kota_pengirim = $request->kota_pengirim;
        $id->jenis_barang = $request->jenis_barang;
        $id->no_telp_pengirim = $request->no_telp_pengirim;
        $id->ttd = "2";
        if($request->hasFile('gambar1')){
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar1);
            $id->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar2);
            $id->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar3);
            $id->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar4);
            $id->gambar4 = $gambar4;
        }
        if($request->hasFile('gambar5')){
            $file5 = $request->file('gambar5');
            $gambar5 = rand() . '.' . $file5->getClientOriginalExtension();
            $file5->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar5);
            $id->gambar5 = $gambar5;
        }
        if($request->hasFile('gambar6')){
            $file6 = $request->file('gambar6');
            $gambar6 = rand() . '.' . $file6->getClientOriginalExtension();
            $file6->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar6);
            $id->gambar6 = $gambar6;
        }
        if($request->hasFile('gambar7')){
            $file7 = $request->file('gambar7');
            $gambar7 = rand() . '.' . $file7->getClientOriginalExtension();
            $file7->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar7);
            $id->gambar7 = $gambar7;
        }
        if($request->hasFile('gambar8')){
            $file8 = $request->file('gambar8');
            $gambar8 = rand() . '.' . $file8->getClientOriginalExtension();
            $file8->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar8);
            $id->gambar8 = $gambar8;
        }
        if($request->hasFile('gambar9')){
            $file9 = $request->file('gambar9');
            $gambar9 = rand() . '.' . $file9->getClientOriginalExtension();
            $file9->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar9);
            $id->gambar9 = $gambar9;
        }
        if($request->hasFile('gambar10')){
            $file10 = $request->file('gambar10');
            $gambar10 = rand() . '.' . $file10->getClientOriginalExtension();
            $file10->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar10);
            $id->gambar10 = $gambar10;
        }
        if($request->hasFile('gambar11')){
            $file11 = $request->file('gambar11');
            $gambar11 = rand() . '.' . $file11->getClientOriginalExtension();
            $file11->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar11);
            $id->gambar11 = $gambar11;
        }
        if($request->hasFile('gambar12')){
            $file12 = $request->file('gambar12');
            $gambar12 = rand() . '.' . $file12->getClientOriginalExtension();
            $file12->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar12);
            $id->gambar12 = $gambar12;
        }
        $id->timestamps = false;
        $id->save();
        if($id != ""){
            HistoryEkspedisi::insert([
                'no_urut' => $tahun.'-'.$urut2
            ]);
        }
        return redirect('/buku-ekspedisi')->with('success','Data Berhasil ditambahkan');
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

        $uploadedFileName = $image->storeAs('public/ekspedisi', $fileName);

        return [$uploadedFileName, $fileNameOnly];
    }

    public function list_buku_ekspedisi(Request $request)
    {
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
            $status =  StatusEkspedisi::all();
            $filter = FilterBukuEkspedisi::where('kode_sales',$request->session()->get('kode_sales'))->first();
            if($filter->status == '<=5'){
                $angka1 = 1;
                $angka2 = 5;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }elseif($filter->status == '<=4'){
                $angka1 = 1;
                $angka2 = 4;
                // $operator = substr($filter->status,0,2);
                // $angka = substr($filter->status,2,2);
            }else{
                $operator = substr($filter->status,0,1);
                $angka = substr($filter->status,1,2);
            }
            
            $buku = BukuEkspedisi::join('tbstatusekspedisi','tbstatusekspedisi.id','=','tbbukuekspedisi.status');
            if($filter->status == '<=5' || $filter->status == '<=4'){
                $buku->whereBetween('tbbukuekspedisi.status',[$angka1,$angka2]);
            }elseif($filter->status != ''){
                $buku->where('tbbukuekspedisi.status',$operator,$angka);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir != ''){
                $buku->whereBetween('tbbukuekspedisi.tgl',[$filter->tgl_awal,$filter->tgl_akhir]);
            }
            if($filter->tgl_awal != '' && $filter->tgl_akhir == ''){
                $buku->where('tbbukuekspedisi.tgl',$filter->tgl_awal);
            }
            if($filter->tgl_awal == '' && $filter->tgl_akhir != ''){
                $buku->where('tbbukuekspedisi.tgl',$filter->tgl_akhir);
            }
            if($filter->tahun != ''){
                $buku->where('tbbukuekspedisi.tgl','LIKE','%'.$filter->tahun.'%');
            }
            $buku->select('tbbukuekspedisi.*','tbstatusekspedisi.status');
            $buku->orderBy('tbbukuekspedisi.no_urut','DESC');
            return view('list_buku_ekspedisi',[
                'buku' => $buku->get(),
                'status' => $status,
                'filter' => $filter,

            ]);
    }
    public function list_buku_ekspedisi_edit(Request $request,$id)
    {
        $ekspedisi =  Ekspedisi::all();
        $untuk =  PerusahaanPO::all();
        $status =  StatusEkspedisi::all();
        $satuan = Status::join('tbpodetil','tbpodetil.status','=','tbstatus.id')
                        ->join('tbsupplier','tbpodetil.id_supplier','=','tbsupplier.id')
                        ->where('tbpodetil.status', '=' , 16)
                        ->select('tbstatus.status','tbpodetil.kode_po','tbpodetil.id','tbsupplier.nama_perusahaan','tbpodetil.re')
                        ->get();
        $buku = BukuEkspedisi::where('id',$id)->first();
        $image = ImageEkspedisi::where('id_ekspedisi',$id)->get();
        return view('list_buku_ekspedisi_edit',[
            'ekspedisi' => $ekspedisi,
            'untuk' => $untuk,
            'satuan' => $satuan,
            'status' => $status,
            'buku' => $buku,
            'image' => $image,
            'id' => $id
        ]);
    }
    public function list_buku_ekspedisi_submit(Request $request,$id)
    {
        $edit = BukuEkspedisi::find($id);
        $edit->status = $request->status;
        $edit->tgl = $request->tgl;
        $edit->jam = $request->jam;
        $edit->nama_ekspedisi = $request->ekspedisi;
        $edit->jumlah_coli = $request->jumlah_coli;
        $edit->nama_pengirim = $request->nama_pengirim;
        $edit->alamat_pengirim = $request->alamat_pengirim;
        $edit->untuk =  $request->untuk;
        $edit->untuk_dll = $request->untuk_dll;
        $edit->penerima_barang = $request->penerima_barang;
        $edit->no_po = $request->no_po;
        $edit->no_po_dll = $request->no_po_dll;
        $edit->status = $request->status;
        $edit->no_resi = $request->no_resi;
        $edit->kota_pengirim = $request->kota_pengirim;
        $edit->jenis_barang = $request->jenis_barang;
        $edit->no_telp_pengirim = $request->no_telp_pengirim;
        if($request->hasFile('gambar1')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar1);
            $file1 = $request->file('gambar1');
            $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar1);
            $edit->gambar1 = $gambar1;
        }
        if($request->hasFile('gambar2')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar2);
            $file2 = $request->file('gambar2');
            $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar2);
            $edit->gambar2 = $gambar2;
        }
        if($request->hasFile('gambar3')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar3);
            $file3 = $request->file('gambar3');
            $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar3);
            $edit->gambar3 = $gambar3;
        }
        if($request->hasFile('gambar4')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar4);
            $file4 = $request->file('gambar4');
            $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar4);
            $edit->gambar4 = $gambar4;
        }
        if($request->hasFile('gambar5')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar5);
            $file5 = $request->file('gambar5');
            $gambar5 = rand() . '.' . $file5->getClientOriginalExtension();
            $file5->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar5);
            $edit->gambar5 = $gambar5;
        }
        if($request->hasFile('gambar6')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar6);
            $file6 = $request->file('gambar6');
            $gambar6 = rand() . '.' . $file6->getClientOriginalExtension();
            $file6->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar6);
            $edit->gambar6 = $gambar6;
        }
        if($request->hasFile('gambar7')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar7);
            $file7 = $request->file('gambar7');
            $gambar7 = rand() . '.' . $file7->getClientOriginalExtension();
            $file7->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar7);
            $edit->gambar7 = $gambar7;
        }
        if($request->hasFile('gambar8')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar8);
            $file8 = $request->file('gambar8');
            $gambar8 = rand() . '.' . $file8->getClientOriginalExtension();
            $file8->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar8);
            $edit->gambar8 = $gambar8;
        }
        if($request->hasFile('gambar9')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar9);
            $file9 = $request->file('gambar9');
            $gambar9 = rand() . '.' . $file9->getClientOriginalExtension();
            $file9->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar9);
            $edit->gambar9 = $gambar9;
        }
        if($request->hasFile('gambar10')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar10);
            $file10 = $request->file('gambar10');
            $gambar10 = rand() . '.' . $file10->getClientOriginalExtension();
            $file10->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar10);
            $edit->gambar10 = $gambar10;
        }
        if($request->hasFile('gambar11')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar11);
            $file11 = $request->file('gambar11');
            $gambar11 = rand() . '.' . $file11->getClientOriginalExtension();
            $file11->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar11);
            $edit->gambar11 = $gambar11;
        }
        if($request->hasFile('gambar12')){
            File::delete('assets/images/upload/buku-ekspedisi/'.$edit->gambar12);
            $file12 = $request->file('gambar12');
            $gambar12 = rand() . '.' . $file12->getClientOriginalExtension();
            $file12->move(public_path('/assets/images/upload/buku-ekspedisi/'),$gambar12);
            $edit->gambar12 = $gambar12;
        }
        $edit->timestamps = false;
        $edit->save();
        return redirect("/list/buku-ekspedisi/edit/$id")->with('success','Data berhasil diedit');
    }
    public function list_buku_ekspedisi_memo_view(Request $request,$id)
    {
        $memo = BukuEkspedisi::where('id',$id)->select('memo')->first();
        return view('list_buku_ekspedisi_memo_view',[
            'id' => $id,
            'memo' => $memo,
        ]);
    }
    public function list_buku_ekspedisi_memo_submit(Request $request,$id)
    {
        $memo = BukuEkspedisi::find($id);
        $memo->memo = $request->editor;
        $memo->timestamps = false;
        $memo->save();
        return Redirect::back()->with('success','Memo berhasil diedit');
    }
    public function list_buku_ekspedisi_hapus(Request $request)
    {
        BukuEkspedisi::where('id',$request->id)->delete();
        return redirect('/list/buku-ekspedisi')->with('success','Data berhasil di hapus');
    }
    public function list_penawaran_memo_view(Request $request,$kode){
        $memo = InputPenawaran::where('kode_penawaran',$kode)->select('memo')->first();
        return view('list_penawaran_memo_view',[
            'kode' => $kode,
            'memo' => $memo
        ]);
    }
    public function list_penawaran_memo_submit(Request $request,$kode){
        InputPenawaran::where('kode_penawaran',$kode)->update(['memo'=>$request->editor]);
        return Redirect::back()->with('success','Memo berhasil di edit');
    }
}

