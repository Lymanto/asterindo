@extends('main.index')
@section('title','Input Tanda Terima Barang')

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
<h3 class="mx-auto judul-mobile" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Tanda Terima Barang</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Tanda Terima Barang</i></h3>
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
    <form action="{{route('tanda.submit')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="p-2" style="background-color:#dff6f0;">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="no_do">Periode DO (*)</label>
                        <input type="month" name="tgl_no_do" id="tgl_no_do" class="form-control" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="id_perusahaan">Nama Perusahaan (*)</label>
                        <select name="id_perusahaan" id="id_perusahaan" class="form-control" required>
                            <option hidden disabled selected value="">--Pilih--</option>
                            <option value="Isi">Isi</option>
                            @foreach($perusahaan as $perusahaan)
                                <option value="{{$perusahaan->id}}">{{$perusahaan->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                        <div id="nama_perusahaan_div"></div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="id_sales">Nama Login (*)</label>
                        <select name="id_sales" id="id_sales" class="form-control" {{(Session::get('role_id') == '2' || Session::get('role_id') == '3') ? 'disabled' : ''}} required>
                        <option hidden disabled selected value="">--Pilih--</option>
                            @foreach($sales as $s)
                                <option value="{{$s->id}}" {{(Session::get('kode_sales') == $s->kode_po) ? 'selected': ''}} >{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="tgl">TGL Input (*)</label>
                        <input type="date" name="tgl" id="tgl" class="form-control" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="id_customer">Nama Perusahaan Customer (*)</label>
                        <select name="id_customer" id="id_customer" class="form-control" required>
                            <option option="">--Pilih--</option>
                            <option value="Tambah Baru">Tambah Baru</option>
                            <option value="Isi">Isi</option>
                            @foreach($customer as $customer)
                                <option value="{{$customer->id}}">{{$customer->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                        <div id="nama_customer_div"></div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="nama_pengantar">Nama Pengantar (*)</label>
                        <select name="nama_pengantar" id="nama_pengantar" class="form-control" required>
                            <option value=""></option>
                            <option value="Isi">Isi</option>
                            <option value="kosong">Kosong</option>
                            @foreach($sales as $s)
                                <option value="{{$s->nama}}">{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                        <div id="nama_pengantars"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="nama_penerima">Nama Penerima Barang</label>
                    <input type="text" name="nama_penerima" id="nama_penerima" class="form-control">
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="gambar1">STT (Setelah User Terima)</label>
                        <input type="file" name="gambar1" id="gambar1">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="gambar2">Tampak Depan</label>
                        <input type="file" name="gambar2" id="gambar2">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="gambar3">Tampak Kiri</label>
                        <input type="file" name="gambar3" id="gambar3">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="gambar4">Tampak Kanan</label>
                        <input type="file" name="gambar4" id="gambar4">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="ttd" class="mb-1">Tanda Tangan (*)</label>
                        <select name="ttd" id="ttd" class="form-control" {{(Session::get('role_id') == '2' || Session::get('role_id') == '3') ? 'disabled' : ''}}>
                            <option value="1">Tampilkan</option>
                            <option value="2" selected>Tidak Tampilkan</option>
                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="ttd_sales">Nama Sales (*)</label>
                        <select name="ttd_sales" id="ttd_sales" class="form-control" required>
                        <option hidden disabled selected value="">--Pilih--</option>
                            @foreach($sales as $s)
                                <option value="{{$s->id}}">{{$s->kode_po}} - {{$s->nama}} - {{$s->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2" style="background-color:#f1fa3c;">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center"  style="min-height:10px;">
                                <td scope="col" colspan="2" class="p-1">Jenis Barang (*)</td>
                                <td scope="col" class="p-1" style="width:125px;">QTY (*)</td>
                                <td scope="col" class="p-1">Satuan (*)</td>
                                <td scope="col" class="p-1">Keterangan</td>
                                <td scope="col" class="p-1"><button class="btn btn-primary add_field_button"><b>+</b></button></td>
                            </tr>
                        </thead>
                        <tbody class="input_fields_wrap">
                            <tr>
                                <td scope="row" colspan="2">
                                    <div class="form-group m-0">
                                        <input type="text" class="form-control nama" name="jenis_barang[]" required>
                                    </div>
                                </td>
                                <td scope="row" class="m-0">
                                    <div class="form-group m-0">
                                        <input type="number" class="form-control qty m-0 m-0" name="qty[]" id="'+x+'" required>
                                    </div>
                                </td>
                                <td scope="row">    
                                    <div class="form-group m-0">
                                        <select name="satuan[]" id="satuan" class="form-control satuan">
                                            @foreach($satuan as $a)
                                                <option>{{ $a->satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td scope="row">
                                    <div class="form-group m-0">
                                        <textarea rows="2" class="form-control keterangan" name="keterangan[]"></textarea>
                                    </div>
                                </td>
                                <td scope="row" class="text-center">
                                    <button type="button" class="btn btn-danger hapus"><b>x</b></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-target="#cancel" data-toggle="modal">Cancel</button>
                    <a type="button" data-toggle="modal" data-target="#goto" class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;">Go To List Tanda Terima Barang</a>
                </div>
            </div>
        </div>
    </form>
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
        Yakin mau di cancel
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <button type="button" class="btn btn-danger" onClick="window.location.reload();">Yakin</button>
      </div>
    </div>
  </div>
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
        Yakin mau di pindah ke list tanda terima barang?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a class="btn btn-danger" href="/list/tanda-terima-barang">Yakin</a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('form').on('submit', function() {
        $('#id_sales').prop('disabled', false);
        $('#ttd').prop('disabled', false);
    });
    $('#ttd_sales,#id_customer,#nama_pengantar').select2({
            placeholder: "-- Pilih --",
            allowClear: true,    
            theme: "bootstrap"
    });
    document.getElementById('tgl_no_do').valueAsDate= new Date();
    document.getElementById('tgl').valueAsDate= new Date();
    $('tbody').delegate('.qty,.harga,.total','keyup',function(){
        var tr3 = $(this).parent();
        var tr2 = tr3.parent();
        var tr = tr2.parent();

        var qty = tr.find('.qty').val();
        var harga = tr.find('.harga').val();
        var total = (qty * harga);
        tr.find('.total').val(total);
    });
    var max_fields= 40; //maximum input boxes allowed
    var x = 1; //initlal text box count
    $('.add_field_button').click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){
        //max input box allowed
            x++; //text box increment
            $('.input_fields_wrap').append('<tr id="row'+x+'"><td scope="row" colspan="2"><div class="form-group m-0"><input type="text" class="form-control nama" name="jenis_barang[]" required></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control qty m-0" name="qty[]" id="'+x+'" required></div></td><td scope="row"><div class="form-group m-0"><select name="satuan[]" id="satuan" class="form-control satuan">@foreach($satuan as $a)<option>{{ $a->satuan }}</option>@endforeach</select></div></td><td scope="row"><div class="form-group m-0"><textarea rows="2" class="form-control keterangan" name="keterangan[]"></textarea></div></td><td scope="row" class="text-center"><button type="button" id="'+x+'" class="btn btn-danger hapus"><b>x</b></button></td></tr>'); //add input box
        }
        
    });
    $(document).on('click','.hapus', function(){ //user click on remove text
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });
    $("#nama_pengantar").on('change',function(){
        let nama_pengantar = $('#nama_pengantar').val();
        var new_input="<input type='text' name='nama_pengantar_isi' id='nama_pengantar_isi' class='form-control mt-1'>";
        if(nama_pengantar == 'Isi'){
            $('#nama_pengantars').append(new_input);
            
        }else{
            $('#nama_pengantar_isi').remove();
        }
    });
    $('#id_customer').on('change',function(){
        const customer = $('#id_customer').val();
        var new_input="<input type='text' name='nama_customer_isi' id='nama_customer_isi' class='form-control mt-1'>";
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
        var new_input="<input type='text' name='nama_perusahaan_isi' id='nama_perusahaan_isi' placeholder='Nama Perusahaan' class='form-control mt-1'><input type='text' name='nama_kota_perusahaan' id='nama_kota_perusahaan' placeholder='Nama Kota' class='form-control mt-1'>";
        if(perusahaan == 'Isi'){
            $('#nama_perusahaan_div').append(new_input);
        }else{
            $('#nama_perusahaan_isi').remove();
        }
    });
});
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
</script>
@endsection