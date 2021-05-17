@extends('main.index')

@section('title','List Penawaran Edit')

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
<h3 class="mx-auto judul-mobile" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Penawaran</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Penawaran</i></h3>
@endsection
@section('container')
<div class="container py-3">
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
        @if(\Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        </div>
    </div>
    <div class="p-2" style="background-color:#deff8b;">
        <div class="row">
            <div class="col-12">
                <h5>{{ $penawaran['kode_penawaran'] }}</h5>
            </div>
        </div>
        <form action="/list/penawaran/edit/{{ $penawaran['kode_penawaran'] }}/submit" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $penawaran['id'] }}">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">        
                        @foreach($status as $s)
                            @if(Session::get('role_id') == '1')
                            <option value="{{ $s->id }}" {{ ( $s->id == $penawaran['status']) ? 'selected' : '' }}>{{ $s->id }}. {{ $s->status }}</option>
                            @else
                                @if($penawaran['status'] >= 4)
                                    <option value="{{ $s->id }}" {{ ( $s->id == $penawaran['status']) ? 'selected' : '' }} {{($s->id < $penawaran['status']) ? 'disabled' : ''}} {{($s->id == 16) ? 'disabled' : ''}}>{{ $s->id }}. {{ $s->status }}</option>
                                @elseif($penawaran['status'] <= 3)
                                    <option value="{{ $s->id }}" {{ ( $s->id == $penawaran['status']) ? 'selected' : '' }} {{($s->id < $penawaran['status']) ? 'disabled' : ''}} {{($s->id > 3) ? 'disabled' : ''}} {{($s->id == 16) ? 'disabled' : ''}}>{{ $s->id }}. {{ $s->status }}</option>
                                @endif
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="sales">Nama Sales</label>
                        <select type="text" class="form-control" name="sales" id="sales" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                            @foreach($sales as $l)
                                <option value="{{ $l->kode_po }}" {{ ($l->kode_po == $penawaran['kode_sales']) ? 'selected' : '' }}>{{$l->kode_po}} - {{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="pelanggan">Pelanggan</label>
                        <select name="pelanggan" id="pelanggan" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ ($p->id == $penawaran['id_pelanggan']) ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="perusahaan">Perusahaan</label>
                        <select name="perusahaan" id="perusahaan" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                            @foreach($perusahaan as $p)
                                <option value="{{ $p->id }}" {{ ($p->id == $penawaran['id_perusahaan']) ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="tgls">TGL</label>
                        <input type="date" name="tgls" id="tgls" value="{{ $penawaran['tgls'] }}" class="form-control"@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                    </div>
                    <div class="form-group">
                        <label for="pajak" class="mb-1">Pajak</label>
                        <select name="pajak" id="pajak" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                            <option value="1" {{($penawaran['pilihan_pajak'] == 1) ? 'selected' : ''}}>termasuk pajak</option>
                            <option value="2" {{($penawaran['pilihan_pajak'] == 2) ? 'selected' : ''}}>tidak termasuk pajak</option>
                            <option value="3" {{($penawaran['pilihan_pajak'] == 3) ? 'selected' : ''}}>kosongin</option>
                            </select>
                    </div>
                </div>
                <div class="col-3">
                    <label for="masa" class="mb-1">Masa Berlaku</label>
                    <div class="d-flex flex-row">
                        <input type="number" name="masa_tgl" style="width:50%;"  class="form-control mr-2" value="{{ $penawaran['lama_penawaran'] }}" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>
                        <p style="font-size:22px;">Hari</p>   
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <textarea name="perihal" id="perihal" class="form-control" cols="30" rows="4" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>{{ $penawaran['perihal'] }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" cols="30" rows="2" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'disabled' : '' }} @endif>{{ $penawaran['note'] }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="memo">Memo</label>
                        <a href="{{route('list_penawaran.memo_view',$penawaran['kode_penawaran'])}}" target="_blank">[View]</a>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="ttd_status">TTD</label>
                        <select name="ttd_status" id="ttd_status" class="form-control mr-3">
                            <option value="1" {{($penawaran['ttd'] == '1') ? 'selected' : ''}}>Tampilkan</option>
                            <option value="2" {{($penawaran['ttd'] == '2') ? 'selected' : ''}}>Tidak Tampilkan</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="ttd_sales">Nama Sales</label>
                        <select name="ttd_sales" id="ttd_sales" class="form-control">
                            <option value=""></option>
                            @foreach($sales as $l)
                                <option value="{{ $l->kode_po }}" {{($l->kode_po == $penawaran['ttd_id_sales']) ? 'selected' : ''}}>{{$l->kode_po}} - {{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/penawaran/'.$penawaran['gambar1'])}}" target="_blank" @if($penawaran['gambar1'] != '') style="background-color:yellow;" @endif>Foto Arsip Penawaran 1</a>
                        <input type="file" name="gambar1">
                    </div>
                    <div class="form-group">
                        <a href="{{asset('assets/images/upload/penawaran/'.$penawaran['gambar2'])}}" target="_blank" @if($penawaran['gambar2'] != '') style="background-color:yellow;" @endif>Foto Arsip Penawaran 2</a>
                        <input type="file" name="gambar2">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#save">Save</button>
                    <button class="btn btn-danger" type="button" data-target="#cancel" data-toggle="modal">Cancel</button>
                    <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#tambah_barang">Tambah barang</button>
                    <a href="/preview/{{$penawaran['kode_penawaran']}}" target="_blank" type="button" class="btn btn-info">Preview</a>
                </div>
            </div>
            <div class="modal fade" id="save" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Yakin mau disave?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Yakin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="p-2" style="background-color:#fbceb5;">
        <div class="row">
            <div class="col-12 table-responsive text-nowrap">
                <table class="table table-hover table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</ths>
                            <th scope="col" class="text-center">Nama Barang </th>
                            <th scope="col" class="text-center">QTY</th>
                            <th scope="col" class="text-center">Satuan</th>
                            <th scope="col" class="text-center">Harga</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center" style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'display:none;' : '' }} @endif">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($barang as $b)
                        <tr>
                            <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $b->nama_barang }}</td>
                            <td class="text-center">{{ $b->qty }}</td>
                            <td class="text-center">{{ $b->satuan }}</td>
                            <td class="text-right">{{ "Rp " . number_format($b->harga_satuan) }}</td>
                            <td class="text-right">{{ "Rp " . number_format($b->total) }}</td>
                            <td style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($penawaran['status'] >= 4) ? 'display:none;' : '' }} @endif" class="text-center">
                                <button class="btn btn-secondary mr-1" data-target="#edit{{ $b->id }}" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                <button class="btn btn-danger" data-target="#hapus{{ $b->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                <a href="/list/penawaran" class="btn btn-danger">Yakin</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/list/penawaran/edit/{{$penawaran['kode_penawaran']}}/barang/tambah" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input type="number" name="qty" id="qty" class="form-control qty" onkeyup="kali()">
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
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control harga" onkeyup="kali()">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" class="form-control total" onkeyup="kali()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($barang as $b)
<div class="modal fade" id="edit{{ $b->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/list/penawaran/edit/{{$penawaran['kode_penawaran']}}/barang/edit" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$b->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ $b->nama_barang }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input type="number" name="qty" id="qty" value="{{ $b->qty }}" class="form-control qty" onkeyup="kali()">
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <select name="satuan" id="satuan" class="form-control">
                        @foreach($satuan as $s)
                            <option value="{{$s->satuan}}" {{ ($s->satuan == $b->satuan ? 'selected' : '') }}>{{$s->satuan}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" value="{{ $b->harga_satuan }}" class="form-control harga" onkeyup="kali()">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" value="{{ $b->total }}" class="form-control total" onkeyup="kali()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus{{ $b->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/list/penawaran/edit/{{$penawaran['kode_penawaran']}}/barang/hapus" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$b->id}}">
                <div class="modal-body">
                    Yakin mau dihapus?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yakin</button>
                </div>
            </form>
        </div>
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
    $('#ttd_sales').select2({
        placeholder: "-- Pilih --",
        allowClear: true,    
        theme: "bootstrap"
    });
    $('#table').DataTable();
    $('.modal-content').delegate('.qty,.harga,.total','keyup',function(){
        var tr3 = $(this).parent();
        var tr2 = tr3.parent();
        var tr = tr2.parent();
        var qty = tr.find('.qty').val();
        var harga = tr.find('.harga').val();
        var total = (qty * harga);
        tr.find('.total').val(total);
    });
} );
</script>
@endsection