@extends('main.index')

@section('title','List Tanda Terima Barang Edit')

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
<h3 class="mx-auto judul-mobile" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Tanda Terima Barang</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Tanda Terima Barang</i></h3>
@endsection
@section('container')
<div class="container py-4">
    <div class="row">
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
    <div class="p-2" style="background-color:#dff6f0;">
        <div class="row">
            <div class="col-12">
                <h3>{{$data['no_do']}}</h3>
            </div>
        </div>
        <form action="{{route('tanda.edit',$data['no_do'])}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$data['id']}}">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="id_status">Status</label>
                        <select name="id_status" id="id_status" class="form-control">
                        @foreach($status as $s)
                            <option value="{{$s->id}}" {{($s->id == $data['id_status']) ? 'selected' : ''}}>{{$s->id}}. {{$s->status}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="id_perusahaan">Nama Perusahaan</label>
                        <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                            <option hidden selected>-- Pilih --</option>
                            <option value="Isi" {{($data['id_perusahaan'] == "Isi") ? 'selected' : ''}}>Isi Nama Kop Surat & Kota</option>
                            @foreach($perusahaan as $perusahaan)
                                <option value="{{$perusahaan->id}}" {{($perusahaan->id == $data['id_perusahaan']) ? 'selected' : ''}}>{{$perusahaan->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                        <div id="nama_perusahaan_div">
                            @if($data['id_perusahaan'] == "Isi")
                                <input type='text' name='nama_perusahaan_isi' id='nama_perusahaan_isi' class='form-control mt-1' value="{{$data['nama_perusahaan_isi']}}" placeholder="Nama Perusahaan">
                                <input type='text' name='nama_kota_perusahaan' id='nama_kota_perusahaan' class='form-control mt-1' value="{{$data['nama_kota_perusahaan']}}" placeholder="Nama Kota">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="id_sales">Nama Login</label>
                        <select name="id_sales" id="id_sales" class="form-control" disabled>
                        <option hidden selected>-- Pilih --</option>
                            @foreach($sales as $s)
                                <option value="{{$s->id}}" {{($s->id == $data['id_sales']) ? 'selected' : ''}}>{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="tgl">TGL</label>
                        <input type="date" name="tgl" id="tgl" class="form-control" value="{{$data['tgl']}}" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="id_customer">Nama Perusahaan Customer</label>
                        <select name="id_customer" id="id_customer" class="form-control">
                            <option hidden selected>-- Pilih --</option>
                            <option value="Isi" {{($data['id_customer'] == "Isi") ? 'selected' : ''}}>Isi</option>
                            <option value="Tambah Baru">Tambah Baru</option>
                            @foreach($customer as $customer)
                                <option value="{{$customer->id}}" {{($customer->id == $data['id_customer']) ? 'selected' : ''}}>{{$customer->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                        <div id="nama_customer_div">
                            @if($data['id_customer'] == "Isi")
                                <input type='text' name='nama_customer_isi' id='nama_customer_isi' class='form-control mt-1' value="{{$data['nama_customer_isi']}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="nama_pengantar">Nama Pengantar</label>
                        <select name="nama_pengantar" id="nama_pengantar" class="form-control">
                            <option hidden selected>-- Pilih --</option>
                            @foreach($sales as $s)
                                <option value="{{$s->nama}}" {{($s->nama == $data['nama_pengantar']) ? 'selected' : ''}}>{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                            <option value="Isi" {{($data['nama_pengantar'] == 'Isi') ? 'selected' : ''}}>Isi</option>
                            <option value="" {{($data['nama_pengantar'] == '' && $data['nama_pengantar_isi'] == '') ? 'selected' : ''}}>Kosong</option>
                        </select>
                        <div id="nama_pengantars">
                        @if($data['nama_pengantar'] == "Isi" && $data['nama_pengantar_isi'] != '')
                            <input type='text' name='nama_pengantar_isi' id='nama_pengantar_isi' value="{{$data['nama_pengantar_isi']}}" class='form-control mt-1'>
                        @else

                        @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="nama_penerima">Nama Penerima Barang</label>
                    <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" value="{{$data['nama_penerima']}}">
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" rows="2" class="form-control">{{$data['note']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/tanda-terima-barang/'.$data['gambar1'])}}" target="_blank" @if($data['gambar1']) style="background-color:yellow;" @endif>STT (Setelah User Terima)</a>
                        <input type="file" name="gambar1" id="gambar1">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/tanda-terima-barang/'.$data['gambar2'])}}" target="_blank" @if($data['gambar2']) style="background-color:yellow;" @endif>Tampak Depan</a>
                        <input type="file" name="gambar2" id="gambar2">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/tanda-terima-barang/'.$data['gambar3'])}}" target="_blank" @if($data['gambar3']) style="background-color:yellow;" @endif>Tampak Kiri</a>
                        <input type="file" name="gambar3" id="gambar3">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/tanda-terima-barang/'.$data['gambar4'])}}" target="_blank" @if($data['gambar4']) style="background-color:yellow;" @endif>Tampak Kanan</a>
                        <input type="file" name="gambar4" id="gambar4">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="ttd" class="mb-1">Tanda Tangan (*)</label>
                        <select name="ttd" id="ttd" class="form-control" {{(Session::get('role_id') == '2' || Session::get('role_id') == '3') ? 'disabled' : ''}}>
                            <option value="1" {{($data['ttd'] == '1') ? 'selected' : ''}}>Tampilkan</option>
                            <option value="2" {{($data['ttd'] == '2') ? 'selected' : ''}}>Tidak Tampilkan</option>
                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="ttd_sales">Nama Sales</label>
                        <select name="ttd_sales" id="ttd_sales" class="form-control">
                        <option hidden selected>-- Pilih --</option>
                            @foreach($sales as $s)
                                <option value="{{$s->id}}" {{($s->id == $data['ttd_id_sales']) ? 'selected' : ''}}>{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="memo">Memo</label>
                        <a href="{{route('list_ttb.memo_view',$no_do)}}" target="_blank">[View]</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="button" data-target="#simpan" data-toggle="modal">Simpan</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel">Cancel</button>
                    <button class="btn btn-secondary" type="button" data-target="#tambah_barang" data-toggle="modal">Tambah Barang</button>
                    <button type="button" class="btn btn-info" onclick="window.open('/preview/tanda-terima-barang/{{$data->no_do}}');return false">Preview</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="simpan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Yakin mau disimpan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
                        <button type="submit" class="btn btn-primary">Yakin</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2" style="background-color:#f1fa3c;">
        <div class="row">
            <div class="col-6 mb-3">
                <ul class="list-group">
                    @foreach($image as $i)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Gambar {{$loop->iteration}} <a href="{{$i->src}}" target="_blank">[View]</a></span>
                            <div>
                            <a data-target="#edit_gambar{{$i->id}}" data-toggle="modal"><span class="badge badge-primary badge-pill">Edit</span></a>
                            <a data-target="#hapus_gambar{{$i->id}}" data-toggle="modal"><span class="badge badge-danger badge-pill">hapus</span></a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-striped table-bordered" id="table">
                    <thead>
                        <tr>
                            <th width="20px">No</th>
                            <th>Jenis Barang</th>
                            <th width="30px">QTY</th>
                            <th width="50px">Satuan</th>
                            <th>Keterangan</th>
                            <th width="70px" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($barang as $b)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>{{$b->jenis_barang}}</td>
                            <td class="text-center">{{$b->qty}}</td>
                            <td class="text-center">{{$b->satuan}}</td>
                            <td>{{$b->keterangan}}</td>
                            <td style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'display:none;' : '' }} @endif" class="text-center">
                                <button class="btn btn-secondary mr-1" type="button" data-target="#edit_barang{{ $b->id }}" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                <button class="btn btn-danger" type="button" data-target="#hapus_barang{{ $b->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
                <a href="/list/tanda-terima-barang" class="btn btn-danger">Yakin</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('tanda.tambah_barang',$data['no_do'])}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang</label>
                        <input type="text" name="jenis_barang" id="jenis_barang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input type="number" name="qty" id="qty" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <select name="satuan" id="satuan" class="form-control">
                        @foreach($satuan as $s)
                            <option value="{{$s->satuan}}">{{$s->satuan}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($image as $i)
<div class="modal fade" id="edit_gambar{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="{{route('tanda.edit_gambar',$data['no_do'])}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="hidden_image" id="hidden_image" value="{{$i->gambar}}">
                <input type="hidden" name="id" id="id" value="{{$i->id}}">
                <input type="file" name="image" id="image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="modal fade" id="hapus_gambar{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="{{route('tanda.hapus_gambar',$data['no_do'])}}" method="post">
    @csrf
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="hidden_image" id="hidden_image" value="{{$i->gambar}}">
                <input type="hidden" name="id" id="id" value="{{$i->id}}">
                Yakin mau dihapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yakin</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endforeach
@foreach($barang as $b)
<div class="modal fade" id="edit_barang{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="{{route('tanda.edit_barang',$data['no_do'])}}" method="post">
    @csrf
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="{{$b->id}}">
                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang</label>
                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" value="{{$b->jenis_barang}}">
                </div>
                <div class="form-group">
                    <label for="qty">QTY</label>
                    <input type="number" name="qty" id="qty" class="form-control" value="{{$b->qty}}">
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <select name="satuan" id="satuan" class="form-control">
                    @foreach($satuan as $s)
                        <option value="{{$s->satuan}}" {{($s->satuan == $b->satuan) ? 'selected' : ''}}>{{$s->satuan}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{$b->keterangan}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="modal fade" id="hapus_barang{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form action="{{route('tanda.hapus_barang',$data['no_do'])}}" method="post">
    @csrf
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="{{$b->id}}">
                Yakin mau dihapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yakin</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endforeach
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
$(function() {
  // ------------------------------------------------------- //
  // Multi Level dropdowns
  // ------------------------------------------------------ //
  $('form').on('submit', function() {
        $('#id_sales').prop('disabled', false);
        $('#ttd').prop('disabled', false);
    });
    $('#ttd_sales').select2({
            placeholder: "-- Pilih --",
            allowClear: true,    
            theme: "bootstrap"
    });
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
});
$(document).ready( function () {
    $('#table').DataTable({
        'order': []
    });
    $("#nama_pengantar").on('change',function(){
        let nama_pengantar = $('#nama_pengantar').val();
        var new_input='@if($data["nama_pengantar"] == "Isi" && $data["nama_pengantar_isi"] != "")<input type="text" name="nama_pengantar_isi" id="nama_pengantar_isi" value="{{$data["nama_pengantar_isi"]}}" class="form-control mt-1">@else<input type="text" name="nama_pengantar_isi" id="nama_pengantar_isi" class="form-control mt-1">@endif';
        if(nama_pengantar == 'Isi'){
            $('#nama_pengantars').append(new_input);
            
        }else{
            $('#nama_pengantar_isi').remove();
        }
    });
    $('#id_customer').on('change',function(){
        const customer = $('#id_customer').val();
        var new_input='@if($data["id_customer"] == "Isi" && $data["nama_customer_isi"] != "")<input type="text" name="nama_customer_isi" id="nama_customer_isi" value="{{$data["nama_customer_isi"]}}" class="form-control mt-1">@else<input type="text" name="nama_customer_isi" id="nama_customer_isi" class="form-control mt-1">@endif';
        if(customer == 'Tambah Baru'){
            window.open('/master/penawaran/pelanggan', '_blank');
        }
        if(customer == 'Isi'){
            $('#nama_customer_div').append(new_input);
        }else{
            $('#nama_customer_isi').remove();
        }
    });
    $('#id_perusahaan').on('change',function(){
        const perusahaan = $('#id_perusahaan').val();
        var new_input='@if($data["id_perusahaan"] == "Isi" && $data["nama_perusahaan_isi"] != "")<input type="text" name="nama_perusahaan_isi" id="nama_perusahaan_isi" value="{{$data["nama_perusahaan_isi"]}}" class="form-control mt-1" placeholder="Nama Perusahaan"><input type="text" name="nama_kota_perusahaan" id="nama_kota_perusahaan" class="form-control mt-1" value="{{$data["nama_kota_perusahaan"]}}" placeholder="Nama Kota">@else<input type="text" name="nama_perusahaan_isi" id="nama_perusahaan_isi" class="form-control mt-1" placeholder="Nama Perusahaan"><input type="text" name="nama_kota_perusahaan" id="nama_kota_perusahaan" class="form-control mt-1" placeholder="Nama Kota">@endif'
        if(perusahaan == 'Isi'){
            $('#nama_perusahaan_div').append(new_input);
        }else{
            $('#nama_perusahaan_isi').remove();
        }
    });
});
</script>
@endsection