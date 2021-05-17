<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Sekolah;
use App\PerusahaanPO;
use App\Satuan;
use App\POSekolah;
use App\HistorySekolah;
use App\BarangSekolah;
use App\KodePO;
use App\Bank;
use App\StatusSekolah;
use App\FilterPOSekolah;
use File;
use App\Rule;
class POSekolahController extends Controller
{
    public function po_sekolah_id(Request $request){
        $id = $request->get('query');
        $npsn = Sekolah::where('id',$id)->first();
        echo $npsn;
    }
    public function po_sekolah(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $sekolah = Sekolah::all();
        $perusahaan = PerusahaanPO::all();
        $satuan = Satuan::all();
        $kodepo = KodePO::all();
        $bank = Bank::all();
        return view('po_sekolah',[
            'sekolah' => $sekolah,
            'perusahaan' => $perusahaan,
            'satuan' => $satuan,
            'kodepo' => $kodepo,
            'bank' => $bank,
        ]);
    }

    public function po_sekolah_submit(Request $request)
    {
        $tahun = substr($request->bulan,2,2);
        $bulan = substr($request->bulan,5,2);
        $tahunbulan = $tahun.$bulan;
        $kode = $request->npsn.'-'.$tahunbulan;
        $cari = POSekolah::select('kode')->where('kode', 'LIKE', "$kode%")->latest()->first();
        if($cari === null){
            $history = HistorySekolah::select('kode')->where('kode', 'LIKE', "$kode%")->latest()->first();
            if($history != ''){
                $history = substr($history->kode,15,4);
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }else{
                $urut = "0001";
            }
        }elseif($cari->kode != ''){
            $history = HistorySekolah::select('kode')->where('kode', 'LIKE', "$kode%")->latest()->first();
            $history = substr($history->kode,15,4);
            $number = substr($cari->kode,15,4);
            if($number != $history){
                $history++;
                $urut = str_pad($history, 4, "0", STR_PAD_LEFT);  //00002
            }elseif($number == $history){
                $number++;
                $urut = str_pad($number, 4, "0", STR_PAD_LEFT);  //00002
            }
        }
        $tahun2 = substr($request->tgl,2,2);
        $cari2 = POSekolah::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
        if($cari2 === null){
            $history2 = HistorySekolah::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            if($history2 != ''){
                $history2 = substr($history2->no_urut,3,6);
                $urut2 = $history2+1;
            }else{
                $urut2 = '1';
            }
        }elseif($cari2->no_urut != ''){
            $history2 = HistorySekolah::select('no_urut')->where('no_urut', 'LIKE', "$tahun2-%")->latest()->first();
            $history2 = substr($history2->no_urut,3,6); 
            $number2 = substr($cari2->no_urut,3,6); 
            if($number2 != $history2){
                $urut2 = $history2+1;
            }elseif($number2 == $history2){
                $urut2 = $number2+1;
            }
        }
        if($request->hasFile('gambar')){
            $file_gambar = $request->file('gambar');
            $nama_gambar = rand() . '.' . $file_gambar->getClientOriginalExtension();
            $file_gambar->move(public_path('/assets/images/upload/gambar/'),$nama_gambar);
        }else{
            $nama_gambar = '';
        }
        $request->validate([
            'npsn' => 'required',
            'id_sekolah' => 'required',
            'id_perusahaan' => 'required',
            'kode_sales' => 'required',
            'bulan' => 'required',
            'alamat_pengiriman' => 'required',
            'tgl' => 'required',
            'jumlah' => 'required',
            'ppn' => 'required',
            'grandtotal' => 'required',
            'judul_project' => 'required',
            'id_bank' => 'required',
        ]);
        $posekolah = POSekolah::insert([
            'no_urut' => $tahun2.'-'.$urut2,
            'kode' => $kode.'-'.$urut,
            'kode_sales' => $request->kode_sales,
            'id_sekolah' => $request->id_sekolah,
            'id_perusahaan' => $request->id_perusahaan,
            'tgl' => $request->tgl,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'judul_project' => $request->judul_project,
            'no_surat' => $request->no_surat,
            'jumlah_total' => $request->jumlah,
            'ppn' => $request->ppn,
            'grandtotal' => $request->grandtotal,
            'id_status' => 1,
            'id_bank' => $request->id_bank,
            'ttd' => $request->ttd,
            'ttd_id_sales' => $request->ttd_sales,
        ]);
        if($posekolah != null){
            HistorySekolah::insert([
                'no_urut' => $tahun2.'-'.$urut2,
                'kode' => $kode.'-'.$urut,
            ]);
            foreach($request->nama_barang as $key => $v){
                $barang = array(
                    'description' => $request->nama_barang [$key],
                    'qty' => $request->qty [$key],
                    'satuan' => $request->satuan [$key],
                    'harga' => $request->harga_satuan [$key],
                    'total' => $request->total [$key],
                    'kode' => $kode.'-'.$urut,
                );
                BarangSekolah::insert($barang);
            }
        }
        return redirect("/preview/po-sekolah/".$kode.'-'.$urut);
    }

    public function master_sekolah(Request $request){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $sekolah = Sekolah::all();
            $rule = Rule::find(1);
            return view('master_sekolah',[
                'sekolah' => $sekolah,
                'rule' => $rule
            ]);
        }else{
            return abort(403);       
        }
    }
    public function master_sekolah_memo(Request $request,$id)
    {
        $memo = Sekolah::where('id',$id)->first();
        return view('master_sekolah_memo',[
            'memo' => $memo,
            'id' => $id
        ]);
    }
    public function master_sekolah_memo_edit(Request $request,$id)
    {
        $edit = Sekolah::find($id);
        $edit->memo = $request->editor;
        $edit->timestamps = false;
        $edit->save();
        return redirect("master/sekolah/memo/$id/")->with('success','Memo berhasil di edit');
    }
    public function master_sekolah_view(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        if($request->session()->get('role_id') == '1' || $request->session()->get('role_id') == '3'){
            $sekolah = Sekolah::where('npsn',$kode)->first();
            return view('master_sekolah_view',[
                'sekolah' => $sekolah,
            ]);
        }else{
            return abort(403);       
        }
    }
    public function master_sekolah_tambah(Request $request){
        $request->validate([
            'npsn' => 'required|unique:tbsekolah,npsn',
            'nama_sekolah' => 'required',
            'kop_surat' => 'image',
            'gambar' => 'image',
        ]);

        $npwp_sekolah = str_split($request->npwp_sekolah);
        array_splice($npwp_sekolah,2,0,'.');
        array_splice($npwp_sekolah,6,0,'.');
        array_splice($npwp_sekolah,10,0,'.');
        array_splice($npwp_sekolah,12,0,'-');
        array_splice($npwp_sekolah,16,0,'.');

        if($request->hasFile('kop_surat')){
            $kop_surat = $request->file('kop_surat');
            $kop_surat_nama = rand() . '.' . $kop_surat->getClientOriginalExtension();
            $kop_surat->move(public_path('/assets/images/upload/kopsurat/'),$kop_surat_nama);
        }else{
            $kop_surat_nama = '';
        }

        if($request->hasFile('gambar')){
            $gambar = $request->file('gambar');
            $nama_gambar = rand() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('/assets/images/upload/sekolah/'),$nama_gambar);
        }else{
            $nama_gambar = '';
        }

        Sekolah::insert([
            'npsn' => $request->npsn,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'kode_pos' => $request->kode_pos,
            'kelurahan' => $request->kelurahan,
            'nama_kota' => $request->nama_kota,
            'kecamatan' => $request->kecamatan,
            'status_sekolah' => $request->status_sekolah,
            'npwp_sekolah' => implode($npwp_sekolah),
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
            'no_telp' => $request->no_telp,
            'no_hp' => $request->no_hp,
            'bendahara' => $request->bendahara,
            'nip_bendahara' => $request->nip_bendahara,
            'no_telp_bendahara' => $request->no_telp_bendahara,
            'nama_operator' => $request->nama_operator,
            'no_telp_operator' => $request->no_telp_operator,
            'guru1' => $request->guru1,
            'no_telp_guru1' => $request->no_telp_guru1,
            'guru2' => $request->guru2,
            'no_telp_guru2' => $request->no_telp_guru2,
            'guru3' => $request->guru3,
            'no_telp_guru3' => $request->no_telp_guru3,
            'alamat_gps' => $request->alamat_gps,
            'kop_surat' => $kop_surat_nama,
            'gambar' => $nama_gambar,
            'kelamin_kepala_sekolah' => $request->kelamin_kepala_sekolah,
            'email_kepala_sekolah' => $request->email_kepala_sekolah,
            'kelamin_bendahara' => $request->kelamin_bendahara,
            'email_bendahara' => $request->email_bendahara,
            'kelamin_operator' => $request->kelamin_operator,
            'email_operator' => $request->email_operator,
            'kelamin_guru1' => $request->kelamin_guru1,
            'email_guru1' => $request->email_guru1,
            'kelamin_guru2' => $request->kelamin_guru2,
            'email_guru2' => $request->email_guru2,
            'kelamin_guru3' => $request->kelamin_guru3,
            'email_guru3' => $request->email_guru3,
        ]);
        return redirect('/master/sekolah')->with('success','Data berhasil ditambah');
    }
    public function master_sekolah_edit(Request $request)
    {
        $edit = Sekolah::find($request->id);
        $npwp_sekolah = str_split($request->npwp_sekolah);
        array_splice($npwp_sekolah,2,0,'.');
        array_splice($npwp_sekolah,6,0,'.');
        array_splice($npwp_sekolah,10,0,'.');
        array_splice($npwp_sekolah,12,0,'-');
        array_splice($npwp_sekolah,16,0,'.');
        $kop_surat_lama = $request->kop_surat_hidden;
        $gambar_lama = $request->gambar_hidden;
        $kop_surat = $request->kop_surat_hidden;
        $gambar = $request->gambar_hidden;
        $request->validate([
            'npsn' => 'required|unique:tbsekolah,npsn,'.$edit->id,
            'nama_sekolah' => 'required',
            'kop_surat' => 'image',
            'gambar' => 'image',
        ]);
        if($request->hasFile('kop_surat')){

            $kop = $request->file('kop_surat');
            $kop_surat = rand() . '.' . $kop->getClientOriginalExtension();
            $kop->move(public_path('/assets/images/upload/kopsurat/'),$kop_surat);
        }
        if($request->hasFile('gambar')){
            $gam = $request->file('gambar');
            $gambar = rand() . '.' . $gam->getClientOriginalExtension();
            $gam->move(public_path('/assets/images/upload/sekolah/'),$gambar);
        }
        if($kop_surat_lama != $kop_surat){
            File::delete('assets/images/upload/kopsurat/'.$kop_surat_lama);
        }
        if($gambar_lama != $gambar){
            File::delete('assets/images/upload/sekolah/'.$gambar_lama);
        }
        $edit->npsn = $request->npsn;
        $edit->nama_sekolah = $request->nama_sekolah;
        $edit->alamat_sekolah = $request->alamat_sekolah;
        $edit->kode_pos = $request->kode_pos;
        $edit->kelurahan = $request->kelurahan;
        $edit->kecamatan = $request->kecamatan;
        $edit->nama_kota = $request->nama_kota;
        $edit->status_sekolah = $request->status_sekolah;
        $edit->npwp_sekolah = implode($npwp_sekolah);
        $edit->kepala_sekolah = $request->kepala_sekolah;
        $edit->nip_kepala_sekolah = $request->nip_kepala_sekolah;
        $edit->no_telp = $request->no_telp;
        $edit->no_hp = $request->no_hp;
        $edit->bendahara = $request->bendahara;
        $edit->nip_bendahara = $request->nip_bendahara;
        $edit->no_telp_bendahara = $request->no_telp_bendahara;
        $edit->nama_operator = $request->nama_operator;
        $edit->no_telp_operator = $request->no_telp_operator;
        $edit->guru1 = $request->guru1;
        $edit->no_telp_guru1 = $request->no_telp_guru1;
        $edit->guru2 = $request->guru2;
        $edit->no_telp_guru2 = $request->no_telp_guru2;
        $edit->guru3 = $request->guru3;
        $edit->no_telp_guru3 = $request->no_telp_guru3;
        $edit->alamat_gps = $request->alamat_gps;
        $edit->kop_surat = $kop_surat;
        $edit->gambar = $gambar;
        $edit->kelamin_kepala_sekolah = $request->kelamin_kepala_sekolah;
        $edit->email_kepala_sekolah = $request->email_kepala_sekolah;
        $edit->kelamin_bendahara = $request->kelamin_bendahara;
        $edit->email_bendahara = $request->email_bendahara;
        $edit->kelamin_operator = $request->kelamin_operator;
        $edit->email_operator = $request->email_operator;
        $edit->kelamin_guru1 = $request->kelamin_guru1;
        $edit->email_guru1 = $request->email_guru1;
        $edit->kelamin_guru2 = $request->kelamin_guru2;
        $edit->email_guru2 = $request->email_guru2;
        $edit->kelamin_guru3 = $request->kelamin_guru3;
        $edit->email_guru3 = $request->email_guru3;
        $edit->timestamps = false;
        $edit->save();
        return redirect('/master/sekolah')->with('success','Data berhasil diedit');
    }
    public function master_sekolah_hapus(Request $request)
    {
        Sekolah::where('id',$request->id)->delete();
        File::delete('assets/images/upload/kopsurat/'.$request->kop_surat);
        File::delete('assets/images/upload/sekolah/'.$request->gambar);
        return redirect('/master/sekolah')->with('success','Data berhasil dihapus');
    }
    public function po_sekolah_preview(Request $request,$kode)
    {
        $data = POSekolah::join('tbperusahaanpo','tbperusahaanpo.id','=','tbsekolahpo.id_perusahaan')
                            ->join('tbkodepo','tbkodepo.kode_po','=','tbsekolahpo.ttd_id_sales')
                            ->join('tbsekolah','tbsekolah.id','=','tbsekolahpo.id_sekolah')
                            ->where('kode',$kode)
                            ->select('tbsekolahpo.*','tbsekolah.*','tbperusahaanpo.kop_surat','tbperusahaanpo.alamat','tbperusahaanpo.nama_perusahaan','tbkodepo.ttd as ttd_gambar','tbkodepo.nama','tbkodepo.jabatan')
                            ->first();
        $barang = BarangSekolah::where('kode',$kode)->get();
        return view('po_sekolah_preview',[
            'data' => $data,
            'barang' => $barang
        ]);
    }
    public function po_sekolah_print(Request $request,$kode)
    {
        $data = POSekolah::join('tbperusahaanpo','tbperusahaanpo.id','=','tbsekolahpo.id_perusahaan')
                            ->join('tbkodepo','tbkodepo.kode_po','=','tbsekolahpo.ttd_id_sales')
                            ->join('tbsekolah','tbsekolah.id','=','tbsekolahpo.id_sekolah')
                            ->where('kode',$kode)
                            ->select('tbsekolahpo.*','tbsekolah.*','tbperusahaanpo.kop_surat','tbperusahaanpo.alamat','tbperusahaanpo.nama_perusahaan','tbkodepo.nama','tbkodepo.ttd as ttd_gambar','tbkodepo.jabatan')
                            ->first();
        $barang = BarangSekolah::where('kode',$kode)->get();
        return view('po_sekolah_print',[
            'data' => $data,
            'barang' => $barang
        ]);
    }
    public function list_po_sekolah(Request $request){
        $status = StatusSekolah::all();
        $filter = FilterPOSekolah::where('kode_sales',$request->session()->get('kode_sales'))->first();
        if($filter->status == '<=11'){
            $angka1 = 1;
            $angka2 = 11;
            // $operator = substr($filter->status,0,2);
            // $angka = substr($filter->status,2,2);
        }elseif($filter->status == '<=10'){
            $angka1 = 1;
            $angka2 = 10;
            // $operator = substr($filter->status,0,2);
            // $angka = substr($filter->status,2,2);
        }else{
            $operator = substr($filter->status,0,1);
            $angka = substr($filter->status,1,2);
        }
        $data = POSekolah::join('tbsekolah','tbsekolah.id','=','tbsekolahpo.id_sekolah')
                            ->join('tbbank','tbbank.id','=','tbsekolahpo.id_bank')
                            ->join('tbstasekolah','tbstasekolah.id','=','tbsekolahpo.id_status');
                            
        if($filter->status == '<=11' || $filter->status == '<=10'){
            $data->whereBetween('tbsekolahpo.id_status',[$angka1,$angka2]);
        }elseif($filter->status != ''){
            $data->where('tbsekolahpo.id_status',$operator,$angka);
        }
        if($filter->tgl_awal != '' && $filter->tgl_akhir != ''){
            $data->whereBetween('tbsekolahpo.tgl',[$filter->tgl_awal,$filter->tgl_akhir]);
        }
        if($filter->tgl_awal != '' && $filter->tgl_akhir == ''){
            $data->where('tbsekolahpo.tgl',$filter->tgl_awal);
        }
        if($filter->tgl_awal == '' && $filter->tgl_akhir != ''){
            $data->where('tbsekolahpo.tgl',$filter->tgl_akhir);
        }
        if($filter->tahun != ''){
            $data->where('tbsekolahpo.tgl','LIKE','%'.$filter->tahun.'%');
        }
        $data->select('tbsekolahpo.*','tbsekolah.*','tbbank.*','tbstasekolah.status');
        $data->orderBy('tbsekolahpo.no_urut','DESC');
        $rule = Rule::find(1);
        return view('list_po_sekolah',[
            'data' => $data->get(),
            'status' => $status,
            'filter' => $filter,
            'rule' => $rule,
        ]);
    }
    public function list_po_sekolah_edit(Request $request,$kode){
        if($request->session()->has('role_id') == null){
            return redirect('/')->with('alert','login dulu!!');
        }
        $data = POSekolah::where('kode',$kode)->first();
        $sekolah = Sekolah::all();
        $perusahaan = PerusahaanPO::all();
        $satuan = Satuan::all();
        $kodepo = KodePO::all();
        $bank = Bank::all();
        $status = StatusSekolah::all();
        $barang = BarangSekolah::where('kode',$kode)->get();
        return view('list_po_sekolah_edit',[
            'data' => $data,
            'status' => $status,
            'sekolah' => $sekolah,
            'perusahaan' => $perusahaan,
            'satuan' => $satuan,
            'kodepo' => $kodepo,
            'bank' => $bank,
            'barang' => $barang,
            'kode' => $kode,
        ]);
    }
    public function list_po_sekolah_memo_view(Request $request,$kode)
    {
        $memo = POSekolah::where('kode',$kode)->select('memo')->first();
        return view('list_po_sekolah_memo_view',[
            'kode' => $kode,
            'memo' => $memo
        ]);
    }
    public function list_po_sekolah_memo_submit(Request $request,$kode)
    {
        $memo = POSekolah::where('kode',$kode)->update(['memo'=>$request->editor]);
        return Redirect::back()->with('success','Memo berhasil diedit');
    }
    public function list_po_sekolah_edit_submit(Request $request,$kode)
    {
        $edit = POSekolah::find($request->id);
        if($request->session()->get('role_id') == '1'){
            $edit->kode_sales = $request->kode_sales;
            $edit->id_sekolah = $request->id_sekolah;
            $edit->id_perusahaan = $request->id_perusahaan;
            $edit->alamat_pengiriman = $request->alamat_pengiriman;
            $edit->tgl = $request->tgl;
            $edit->tgl_lunas = $request->tgl_lunas;
            $edit->no_surat = $request->no_surat;
            $edit->ppn = $request->ppn;
            $edit->judul_project = $request->judul_project;
            $edit->grandtotal = $request->grandtotal;
            $edit->jumlah_uang_terima = $request->jumlah_uang_terima;
            $edit->id_bank = $request->id_bank;
            $edit->id_status = $request->status;
            $edit->ttd = $request->ttd;
            $edit->ttd_id_sales = $request->ttd_sales;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/po-sekolah/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/po-sekolah/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            if($request->hasFile('gambar3')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar3);
                $file3 = $request->file('gambar3');
                $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
                $file3->move(public_path('/assets/images/upload/po-sekolah/'),$gambar3);
                $edit->gambar3 = $gambar3;
            }
            if($request->hasFile('gambar4')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar4);
                $file4 = $request->file('gambar4');
                $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
                $file4->move(public_path('/assets/images/upload/po-sekolah/'),$gambar4);
                $edit->gambar4 = $gambar4;
            }
            $edit->timestamps = false;
            $edit->save();
            return redirect("list/po-sekolah/edit/$kode");
        }elseif($request->status <= 4 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit->kode_sales = $request->kode_sales;
            $edit->id_sekolah = $request->id_sekolah;
            $edit->id_perusahaan = $request->id_perusahaan;
            $edit->alamat_pengiriman = $request->alamat_pengiriman;
            $edit->tgl = $request->tgl;
            $edit->no_surat = $request->no_surat;
            $edit->judul_project = $request->judul_project;
            $edit->id_status = $request->status;
            $edit->ttd = $request->ttd;
            $edit->ttd_id_sales = $request->ttd_sales;
            if($request->hasFile('gambar1')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar1);
                $file1 = $request->file('gambar1');
                $gambar1 = rand() . '.' . $file1->getClientOriginalExtension();
                $file1->move(public_path('/assets/images/upload/po-sekolah/'),$gambar1);
                $edit->gambar1 = $gambar1;
            }
            if($request->hasFile('gambar2')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar2);
                $file2 = $request->file('gambar2');
                $gambar2 = rand() . '.' . $file2->getClientOriginalExtension();
                $file2->move(public_path('/assets/images/upload/po-sekolah/'),$gambar2);
                $edit->gambar2 = $gambar2;
            }
            if($request->hasFile('gambar3')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar3);
                $file3 = $request->file('gambar3');
                $gambar3 = rand() . '.' . $file3->getClientOriginalExtension();
                $file3->move(public_path('/assets/images/upload/po-sekolah/'),$gambar3);
                $edit->gambar3 = $gambar3;
            }
            if($request->hasFile('gambar4')){
                File::delete('assets/images/upload/po-sekolah/'.$edit->gambar4);
                $file4 = $request->file('gambar4');
                $gambar4 = rand() . '.' . $file4->getClientOriginalExtension();
                $file4->move(public_path('/assets/images/upload/po-sekolah/'),$gambar4);
                $edit->gambar4 = $gambar4;
            }
            $edit->timestamps = false;
            $edit->save();
            return redirect("list/po-sekolah/edit/$kode");
        }elseif($request->status >= 5 && ($request->session()->get('role_id') == '3' || $request->session()->get('role_id') == '2')){
            $edit->id_status = $request->status;
            $edit->timestamps = false;
            return redirect("list/po-sekolah/edit/$kode");
            $edit->save();
        }
        return redirect("/list/po-sekolah/edit/$kode")->with('success','Data berhasil diedit');
    }

    public function list_po_sekolah_edit_barang(Request $request,$kode)
    {
        
        $edit = BarangSekolah::find($request->id);
        $edit->description = $request->description;
        $edit->qty = $request->qty;
        $edit->satuan = $request->satuan;
        $edit->harga = $request->harga;
        $edit->total = $request->total;
        $edit->timestamps = false;
        $edit->save();
        $ppn_barang_awal = $request->ppn_barang;
        $ppn_total = $request->ppn;
        $ppn = $ppn_total-$ppn_barang_awal;
        $ppn_barang_sekarang = $request->total*0.1;
        $ppn_final = $ppn+$ppn_barang_sekarang;
        $jumlah_total = $request->jumlah_total-$request->total_barang;
        $jumlah_final = $jumlah_total + $request->total;
        $grandtotal = $jumlah_final + $ppn_final;
        $edit_ppn = POSekolah::where('kode',$kode)
                    ->update([
                        'jumlah_total' => $jumlah_final,
                        'ppn'=>$ppn_final,
                        'grandtotal'=>$grandtotal
                    ]);
        return redirect("/list/po-sekolah/edit/$kode")->with('success','Barang berhasil diedit');
    }
    public function list_po_sekolah_hapus_barang(Request $request,$kode)
    {
        $data = BarangSekolah::find($request->id);
        $ppn_barang = $data->total*0.1;
        $ppn = $request->ppn-$ppn_barang;
        $jumlah_total = $request->jumlah_total-$data->total;
        $grandtotal = $ppn+$jumlah_total;
        POSekolah::where('kode',$kode)
                    ->update([
                        'jumlah_total' => $jumlah_total,
                        'ppn'=>$ppn,
                        'grandtotal'=>$grandtotal
                    ]);
        BarangSekolah::find($request->id)->delete();
        return redirect("/list/po-sekolah/edit/$kode")->with('success','Barang berhasil di hapus');
    }
    public function list_po_sekolah_tambah_barang(Request $request,$kode)
    {
        $ppn_barang = $request->total*0.1;
        $ppn = $request->ppn+$ppn_barang;
        $jumlah_total = $request->jumlah_total+$request->total;
        $grandtotal = $ppn+$jumlah_total;
        $tambah = new BarangSekolah();
        $tambah->description = $request->description;
        $tambah->qty = $request->qty;
        $tambah->satuan = $request->satuan;
        $tambah->harga = $request->harga;
        $tambah->total = $request->total;
        $tambah->kode = $kode;
        $tambah->save();
        POSekolah::where('kode',$kode)
                    ->update([
                        'jumlah_total' => $jumlah_total,
                        'ppn'=>$ppn,
                        'grandtotal'=>$grandtotal
                    ]);
        return redirect("/list/po-sekolah/edit/$kode")->with('success','Barang berhasil ditambahkan');
    }
    public function list_po_sekolah_hapus(Request $request)
    {
        POSekolah::where('kode',$request->kode)->delete();
        return redirect('/list/po-sekolah')->with('success','Data berhasil di hapus');
    }
    
}
