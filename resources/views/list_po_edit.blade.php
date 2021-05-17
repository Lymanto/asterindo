@extends('main.index')

@section('title','List PO Edit')

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
<h3 class="mx-auto judul-mobile" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Purchase Order</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit Purchase Order</i></h3>
@endsection
@section('container')
<div class="container-fluid py-3">
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
    <div style="background-color:#ffba5a;" class="p-2">
        <div class="row">
            <div class="col-12">
                <h5>{{ $po['kode_po'] }}</h5>
            </div>
        </div>
        <form action="/list/po/edit/{{ $po['kode_po']}}/submit" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $po['id'] }}">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                    
                    @foreach($status as $s)
                        @if(Session::get('role_id') == '1')
                        <option value="{{ $s->id }}" {{ ( $s->id == $po['status']) ? 'selected' : '' }}>{{ $s->id }}. {{ $s->status }}</option>
                        @else
                        <option value="{{ $s->id }}" {{ ( $s->id == $po['status']) ? 'selected' : '' }} {{($s->id < $po['status']) ? 'disabled' : ''}} {{($s->id == 16) ? 'disabled' : ''}}>{{ $s->id }}. {{ $s->status }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="sales">Nama Login</label>
                    <select type="text" class="form-control" name="sales" id="sales" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                        @foreach($sales as $l)
                            <option value="{{ $l->kode_po }}" {{ ($l->kode_po == $po['kode_sales']) ? 'selected' : '' }}>{{ $l->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <label for="vendor">Vendor</label>
                <select name="vendor" id="vendor" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                @foreach($vendor as $v)
                    <option value="{{ $v->id }}" {{ ($v->id == $po['id_supplier']) ? 'selected' : '' }}>{{ $v->nama_perusahaan }}</option>
                @endforeach
                </select>
            </div>
            <div class="col-3">
                <label for="vendor">Perusahaan</label>
                <select name="perusahaan" id="perusahaan" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                @foreach($perusahaan as $p)
                    <option value="{{ $p->id }}" {{ ($p->id == $po['id_perusahaan']) ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group m-0">
                    <label for="paket">No Paket Pekerjaan</label>
                    <textarea name="paket" id="paket" rows="1" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>{{ $po['paket'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="attn">Attn</label>
                    <input type="text" name="attn" id="attn" class="form-control" value="{{$po['attn']}}" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                </div>
                
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="cc">CC</label>
                    <textarea name="cc" id="cc" rows="3" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>{{ $po['cc'] }}</textarea>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="re">Re</label>
                    <textarea name="re" id="re" rows="3" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>{{ $po['re'] }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="tgl">TGL (MM/DD/YYYY)</label>
                    <input type="date" value="{{ $po['tgl'] }}" class="form-control" name="tgl" id="tgl" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label for="ekspedisi">Ekspedisi</label>
                    <select name="ekspedisi" id="ekspedisi" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                            <option value="other" {{($po['id_ekspedisi'] == "other" && $po['id_ekspedisi'] != '') ? 'selected' : '' }}>Other</option>
                            <option value="" {{($po['id_ekspedisi'] == '') ? 'selected' : ''}}>None</option>
                        @foreach($ekspedisi as $e)
                            <option value="{{ $e->id }}" {{ ($e->id == $po['id_ekspedisi'] ? 'selected' : '') }}>{{ $e->ekspedisi }}</option>
                        @endforeach
                    </select>
                    
                    <div id="ekspedisis">
                        @if($po['id_ekspedisi'] == "other" && $po['id_ekspedisi'] != '')
                        <input type='text' name='ekspedisi_dll' id='ekspedisi_dll' class='form-control mt-1' value="{{$po['ekspedisi_dll']}}">
                        @else

                        @endif
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <label for="pajak">Pajak</label>
                    <select name="pajak" id="pajak" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                        <option value="1" {{ ( $po['pajak'] == '1' ? 'selected' : '') }}>Termasuk Pajak</option>
                        <option value="2" {{ ( $po['pajak'] == '2' ? 'selected' : '') }}>Tidak Termasuk Pajak</option>
                        <option value="3" {{ ( $po['pajak'] == '3' ) ? 'selected' : '' }}>Kosongin</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="npwp">NPWP</label>
                    <select name="npwp" id="npwp" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                        <option value="1" {{ ( $po['npwp'] == '1' ? 'selected' : '') }}>Tampilkan</option>
                        <option value="2" {{ ( $po['npwp'] == '2' ? 'selected' : '') }}>Tidak Tampilkan</option>
                    </select>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="ttd">TTD</label>
                    <select name="ttd" id="ttd" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                        <option value="1" {{ ( $po['ttd'] == '1' ? 'selected' : '') }}>Tampilkan</option>
                        <option value="2" {{ ( $po['ttd'] == '2' ? 'selected' : '') }}>Tidak Tampilkan</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="ttd_sales">Nama Sales</label>
                    <select type="text" class="form-control" name="ttd_sales" id="ttd_sales" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>
                        <option value=""></option>
                        @foreach($sales as $l)
                            <option value="{{ $l->kode_po }}" {{ ($l->kode_po == $po['ttd_id_sales']) ? 'selected' : '' }}>{{ $l->kode_po.' - '.$l->nama.' - '.$l->jabatan.' - '.$l->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" cols="30" rows="2" class="form-control" @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'disabled' : '' }} @endif>{{ $po['note'] }}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <a href="{{route('list_po.memo_view',$kode)}}" target="_blank">[View]</a>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/po/'.$po['gambar1'])}}" target="_blank" @if($po['gambar1'] != '') style="background-color:yellow;" @endif>Foto Arsip PO 1</a>
                    <input type="file" name="gambar1" id="gambar1">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <a href="{{asset('assets/images/upload/po/'.$po['gambar2'])}}" target="_blank" @if($po['gambar2'] != '') style="background-color:yellow;" @endif>Foto Arsip PO 2</a>
                    <input type="file" name="gambar2" id="gambar2">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-12">
            <button class="btn btn-primary" type="button" data-target="#save" data-toggle="modal">Save</button>
            <button class="btn btn-danger" type="button" data-target="#cancel" data-toggle="modal">Cancel</button>
            <button class="btn btn-dark" type="button" data-target="#tambah_barang" data-toggle="modal">Tambah barang</button>
            <button type="button" class="btn btn-info" onclick="window.open('/preview/po/{{$kode}}');return false">Preview</button>
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
</form>
    <div style="background-color:#deff8b;" class="p-2">
        <div class="row">
            <div class="col-12 table-responsive text-nowrap">
                <table class="table table-hover table-striped table-bordered" id="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</ths>
                            <th scope="col" class="text-center">Nama Barang </th>
                            <th scope="col" class="text-center">QTY</th>
                            <th scope="col" class="text-center">Satuan</th>
                            <th scope="col" class="text-center">Harga</th>
                            <th scope="col" class="text-center">Total</th>
                            <th scope="col" class="text-center">Keterangan</th>
                            <th scope="col" class="text-center" style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'display:none;' : '' }} @endif">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($barang as $b)
                        <tr>
                            <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $b->nama_barang }}</td>
                            <td class="text-center">{{ $b->qty }}</td>
                            <td class="text-center">{{ $b->satuan }}</td>
                            <td class="text-right">{{ "Rp " . number_format($b->harga) }}</td>
                            <td class="text-right">{{ "Rp " . number_format($b->total) }}</td>
                            <td>{{ $b->keterangan }}</td>
                            <td style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($po['status'] >= 5) ? 'display:none;' : '' }} @endif" class="text-center">
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
                <a href="/list/po" class="btn btn-danger">Yakin</a>
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
            <form action="/list/po/edit/{{$po['kode_po']}}/barang/tambah" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$b->id}}">
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
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
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
            <form action="/list/po/edit/{{$po['kode_po']}}/barang/edit" method="post">
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
                        <input type="number" name="harga" id="harga" value="{{ $b->harga }}" class="form-control harga" onkeyup="kali()">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" value="{{ $b->total }}" class="form-control total" onkeyup="kali()">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control">{{ $b->keterangan }}</textarea>
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
            <form action="/list/po/edit/{{$po['kode_po']}}/barang/hapus" method="post">
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
    $('#vendor').on('change',function(){
        var _token = $('input[name="_token"]').val();
        var query = $('#vendor').val();
        $.ajax({
        url:"{{ route('po.id_supplier') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
            var wow = JSON.parse(data);
            $('#attn').val(wow['email']);
        }
        });
    });
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
    $("#ekspedisi").on('change',function(){
        let untuk = $('#ekspedisi').val();
        var new_input="@if($po['id_ekspedisi'] == 'other' && $po['id_ekspedisi'] != '')<input type='text' name='ekspedisi_dll' id='ekspedisi_dll' class='form-control mt-1' value='{{$po['ekspedisi_dll']}}'>@else <input type='text' name='ekspedisi_dll' id='ekspedisi_dll' class='form-control mt-1'> @endif";
        if(untuk == 'other'){
            $('#ekspedisis').append(new_input);
            
        }else{
            $('#ekspedisi_dll').remove();
        }
    });
} );
</script>
@endsection