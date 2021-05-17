@extends('main.index')

@section('title','List Buku Ekspedisi Edit')

@section('css')
<link rel="stylesheet" href="/assets/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="/assets/select2/dist/css/select2-bootstrap.min.css">
    <style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>a:after {
        content: "\f0da";
        float: right;
        border: none;
        font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: 0px;
        margin-left: 0px;
    }
    @media screen and (max-width: 992px) {
        .judul {
            display:none;
        }
    }
    @media screen and (min-width: 992px) {
        .judul-mobile {
            display:none;
        }
        .judul{
            display:block;
        }
    }
    </style>
@endsection
@section('judul_mobile')
<h3 class="mx-auto judul-mobile" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Buku Ekspedisi</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Buku Ekspedisi</i></h3>
@endsection
@section('container')
<div class="container">
    <div class="row my-3">
        <div class="col-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(\Session::has('alert'))
            <div class="alert alert-danger">
                {{ Session::get('alert') }}
            </div>
        @endif
        @if(\Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        </div>
    </div>
    <form action="{{route('list_buku_ekspedisi.submit',$buku['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-12">
                <h2>{{substr($buku['no_urut'],3,6)}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                    @foreach($status as $s)
                        <option value="{{ $s->id }}" {{ ($s->id == $buku['status']) ? 'selected' : '' }}>{{$s->id}}. {{$s->status}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="tgl">TGL</label>
                    <input type="date" name="tgl" id="tgl" class="form-control" value="{{$buku['tgl']}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="jam">Jam</label>
                    <input type="time" name="jam" id="jam" class="form-control" value="{{$buku['jam']}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="nama_pengirim">Nama Pengirim</label>
                    <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" value="{{$buku['nama_pengirim']}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="kota_pengirim">Kota Pengirim</label>
                    <input type="text" name="kota_pengirim" id="kota_pengirim" class="form-control" value="{{$buku['kota_pengirim']}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ekspedisi">Nama Ekspedisi</label>
                    <select name="ekspedisi" id="ekspedisi" class="form-control">
                    <option value="tambah_baru">Tambah Baru</option>
                    @foreach($ekspedisi as $e)
                        <option {{($e->ekspedisi == $buku['nama_ekspedisi']) ? 'selected' : ''}}>{{ $e->ekspedisi }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="jumlah_coli">Jumlah COLI</label>
                    <input type="number" name="jumlah_coli" id="jumlah_coli" class="form-control" value="{{$buku['jumlah_coli']}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="alamat_pengirim">Alamat Pengirim</label>
                    <textarea name="alamat_pengirim" id="alamat_pengirim" class="form-control" rows="2"> {{$buku['alamat_pengirim']}}</textarea>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="untuk">Untuk</label>
                    <select name="untuk" id="untuk" class="form-control">
                    @foreach($untuk as $u)
                        <option {{($u->nama_perusahaan == $buku->untuk) ? 'selected' : ''}}>{{ $u->nama_perusahaan }}</option>
                    @endforeach
                        <option value="DLL" {{($buku->untuk == 'DLL') ? 'selected' : ''}}>DLL</option>
                    </select>
                    <div id="untuks">
                    @if($buku->untuk == 'DLL')
                        <input type='text' name='untuk_dll' id='untuk_dll' class='form-control mt-1' value="{{$buku['untuk_dll']}}">
                    @endif
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="penerima_barang">Penerima Barang</label>
                    <input type="text" name="penerima_barang" id="penerima_barang" class="form-control" value="{{$buku['penerima_barang']}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" value="{{$buku['jenis_barang']}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="no_telp_pengirim">No Telp Pengirim</label>
                    <input type="text" name="no_telp_pengirim" id="no_telp_pengirim" class="form-control" value="{{$buku['no_telp_pengirim']}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="no_resi">No Resi</label>
                    <input type="text" name="no_resi" id="no_resi" class="form-control" value="{{$buku['no_resi']}}">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label for="no_po">No PO</label>
                    <select name="no_po" id="no_po" class="form-control">
                        <option value="" {{($buku['no_po'] == '') ? 'selected' : ''}}>Tanpa PO</option>
                        <option value="Isi" {{($buku['no_po'] == 'Isi') ? 'selected' : ''}}>Isi</option>
                    @foreach($satuan as $n)
                        <option value="{{ $n->kode_po }}" {{ ($n->kode_po == $buku['no_po']) ? 'selected' : '' }}>{{$n->kode_po . ' - ' . $n->nama_perusahaan.' - '.$n->re}}</option>
                    @endforeach
                    </select>
                    <div id="no_pos">
                    @if($buku['no_po'] == 'Isi')
                        <input type='text' name='no_po_dll' id='no_po_dll' class='form-control mt-1' value="{{$buku['no_po_dll']}}">
                    @endif
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <a href="{{route('buku_ekspedisi.memo_view',$id)}}" target="_blank">[View]</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar1'])}}" @if($buku['gambar1'] != '') style="background-color:yellow;" @endif target="_blank">Foto Kurir (Saat di Antar)</a>
                    <input type="file" name="gambar1" id="gambar1">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar2'])}}" @if($buku['gambar2'] != '') style="background-color:yellow;" @endif target="_blank">Foto STT Ekspedisi</a>
                    <input type="file" name="gambar2" id="gambar2">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar3'])}}" @if($buku['gambar3'] != '') style="background-color:yellow;" @endif target="_blank">Foto SJ Vendor 1</a>
                    <input type="file" name="gambar3" id="gambar3">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar4'])}}" @if($buku['gambar4'] != '') style="background-color:yellow;" @endif target="_blank">Foto SJ Vendor 2</a>
                    <input type="file" name="gambar4" id="gambar4">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar5'])}}" @if($buku['gambar5'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Depan</a>
                    <input type="file" name="gambar5" id="gambar5">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar6'])}}" @if($buku['gambar6'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Samping Kiri</a>
                    <input type="file" name="gambar6" id="gambar6">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar7'])}}" @if($buku['gambar7'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Samping Kanan</a>
                    <input type="file" name="gambar7" id="gambar7">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar8'])}}" @if($buku['gambar8'] != '') style="background-color:yellow;" @endif target="_blank">Foto Nota 1</a>
                    <input type="file" name="gambar8" id="gambar8">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar9'])}}" @if($buku['gambar9'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Rusak 1</a>
                    <input type="file" name="gambar9" id="gambar9">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar10'])}}" @if($buku['gambar10'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Rusak 2</a>
                    <input type="file" name="gambar10" id="gambar10">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar11'])}}" @if($buku['gambar11'] != '') style="background-color:yellow;" @endif target="_blank">Barang Tampak Rusak 3</a>
                    <input type="file" name="gambar11" id="gambar11">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/buku-ekspedisi/'.$buku['gambar12'])}}" @if($buku['gambar12'] != '') style="background-color:yellow;" @endif target="_blank">Foto Nota 2</a>
                    <input type="file" name="gambar12" id="gambar12">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-target="#cancel" data-toggle="modal">Cancel</button>
                    <button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin mau di cancel?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
                <a href="/list/buku-ekspedisi" class="btn btn-danger">Yakin</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
$(function() {
    $('#no_po').select2({
        placeholder: "Tanpa PO",
        allowClear: true,    
        theme: "bootstrap"
    });
  // ------------------------------------------------------- //
  // Multi Level dropdowns
  // ------------------------------------------------------ //
    $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).siblings().toggleClass("show");
        if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });
    });

    $("#untuk").on('change',function(){
        let untuk = $('#untuk').val();
        var new_input="@if($buku->untuk == 'DLL')<input type='text' name='untuk_dll' id='untuk_dll' class='form-control mt-1' value='{{$buku['untuk_dll']}}'>@else <input type='text' name='untuk_dll' id='untuk_dll' class='form-control mt-1'}}'> @endif";
        if(untuk == 'DLL'){
            $('#untuks').append(new_input);
            
        }else{
            $('#untuk_dll').remove();
        }
    });
    $("#no_po").on('change',function(){
        let no_po = $('#no_po').val();
        var new_input="@if($buku->no_po == 'Isi')<input type='text' name='no_po_dll' id='no_po_dll' class='form-control mt-1' value='{{$buku['no_po_dll']}}'>@else <input type='text' name='no_po_dll' id='no_po_dll' class='form-control mt-1'}}'> @endif";
        if(no_po == 'Isi'){
            $('#no_pos').append(new_input);
            
        }else{
            $('#no_po_dll').remove();
        }
    });
    $('#ekspedisi').on('change',function(){
        let ekspedisi = $('#ekspedisi').val();
        if(ekspedisi == "tambah_baru"){
            window.open('/master/ekspedisi','_blank');
        }
    })
});
</script>
@endsection