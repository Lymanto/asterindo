@extends('main.index')
@section('title','Buku Ekspedisi')

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
<h3 class="mx-auto judul-mobile" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Buku Ekspedisi</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Buku Ekspedisi</i></h3>
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
        @if(\Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        </div>
    </div>
    <form action="/buku-ekspedisi/submit" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-5">
                <div class="form-group">
                    <label for="ekspedisi">Nama Ekspedisi (*)</label>
                    <select name="ekspedisi" id="ekspedisi" class="form-control" required>
                    <option></option>
                    <option value="tambah_baru">Tambah Baru</option>
                    @foreach($ekspedisi as $e)
                        <option>{{ $e->ekspedisi }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label for="no_resi">No Resi (*)</label>
                    <input type="text" name="no_resi" id="no_resi" class="form-control" required>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="jumlah_coli">Jumlah COLI (*)</label>
                    <input type="number" name="jumlah_coli" id="jumlah_coli" class="form-control" style="width:80px;" min="1" value="1" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="tgl">TGL (*)</label>
                            <input type="date" name="tgl" id="tgl" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="jam">Jam (*)</label>
                            <input type="time" name="jam" id="jam" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="untuk">Untuk (*)</label>
                    <select name="untuk" id="untuk" class="form-control" required>
                    <option value=""></option>
                    <option value="DLL">DLL</option>
                    @foreach($untuk as $u)
                        <option>{{ $u->nama_perusahaan }}</option>
                    @endforeach
                    </select>
                    <div id="untuks"></div>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="penerima_barang">Penerima Barang (*)</label>
                    <input type="text" name="penerima_barang" id="penerima_barang" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="nama_pengirim">Nama Pengirim (*)</label>
                    <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="kota_pengirim">Kota Pengirim</label>
                    <input name="kota_pengirim" id="kota_pengirim" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="alamat_pengirim">Alamat Pengirim</label>
                    <textarea name="alamat_pengirim" id="alamat_pengirim" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="no_telp_pengirim">No Telp Pengirim</label>
                    <input type="text" name="no_telp_pengirim" id="no_telp_pengirim" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                    @foreach($status as $s)
                        <option value="{{ $s->id }}">{{$s->id}}. {{$s->status}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label for="no_po">No PO</label>
                    <select name="no_po" id="no_po" class="form-control">
                    <option value="">Tanpa PO</option>
                    <option value="Isi">Isi</option>
                    @foreach($satuan as $n)
                        <option value="{{ $n->kode_po }}">{{$n->kode_po . ' - ' . $n->nama_perusahaan.' - '.$n->re}}</option>
                    @endforeach
                    </select>
                    <div id="no_pos"></div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="image">Gambar</label><br>
                    <input type="file" name="image[]" id="image" multiple>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar1">Foto Kurir (Saat di Antar)</label>
                    <input type="file" name="gambar1" id="gambar1">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar2">Foto STT 1</label>
                    <input type="file" name="gambar2" id="gambar2">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar3">Foto STT 2</label>
                    <input type="file" name="gambar3" id="gambar3">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar4">Foto STT 3</label>
                    <input type="file" name="gambar4" id="gambar4">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar5">Barang Tampak Depan</label>
                    <input type="file" name="gambar5" id="gambar5">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar6">Barang Tampak Samping Kiri</label>
                    <input type="file" name="gambar6" id="gambar6">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar7">Barang Tampak Samping Kanan</label>
                    <input type="file" name="gambar7" id="gambar7">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar8">Barang Tampak dari Atas</label>
                    <input type="file" name="gambar8" id="gambar8">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar9">Barang Tampak Rusak 1</label>
                    <input type="file" name="gambar9" id="gambar9">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar10">Barang Tampak Rusak 2</label>
                    <input type="file" name="gambar10" id="gambar10">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar11">Barang Tampak Rusak 3</label>
                    <input type="file" name="gambar11" id="gambar11">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="gambar12">Barang Tampak Rusak 4</label>
                    <input type="file" name="gambar12" id="gambar12">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-target="#cancel" data-toggle="modal">Cancel</button>
                    <button type="button" data-toggle="modal" data-target="#goto" class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/list/buku-ekspedisi">Go To List Buku Ekspedisi</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="goto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau di pindah ke list buku ekspedisi?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a class="btn btn-danger" href="/list/buku-ekspedisi">Yakin</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau di cancel?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="location.reload()" type="button" class="btn btn-danger">Yakin</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
$(function() {
    $('#untuk').select2({
        placeholder: "-- Pilih -- ",
        allowClear: true,    
        theme: "bootstrap"
    });
    $('#ekspedisi').select2({
        placeholder: "-- Pilih --",
        allowClear: true,    
        theme: "bootstrap"
    });
    $('#no_po').select2({
        placeholder: "Tanpa PO",
        allowClear: true,    
        theme: "bootstrap"
    });
    document.getElementById('tgl').valueAsDate = new Date();
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
    var d = new Date(),        
        h = d.getHours(),
        m = d.getMinutes();
    if(h < 10) h = '0' + h; 
    if(m < 10) m = '0' + m; 
    $('input[type="time"][id="jam"]').each(function(){ 
        $(this).attr({'value': h + ':' + m});
    });
    $('#ekspedisi').on('change',function(){
        let ekspedisi = $('#ekspedisi').val();
        if(ekspedisi == "tambah_baru"){
            window.open('/master/ekspedisi','_blank');
        }
    });
    $("#untuk").on('change',function(){
        let untuk = $('#untuk').val();
        var new_input="<input type='text' name='untuk_dll' id='untuk_dll' class='form-control mt-1'>";
        if(untuk == 'DLL'){
            $('#untuks').append(new_input);
            
        }else{
            $('#untuk_dll').remove();
        }
    });
    $("#no_po").on('change',function(){
        let no_po = $('#no_po').val();
        var new_input="<input type='text' name='no_po_isi' id='no_po_isi' class='form-control mt-1'>";
        if(no_po == 'Isi'){
            $('#no_pos').append(new_input);
            
        }else{
            $('#no_po_isi').remove();
        }
    });
});
</script>
@endsection