@extends('main.index')

@section('title','Input Penawaran')

@section('css')
    <style>
        .table tr td{
            vertical-align:middle;
        }
        /*
        *
        * ==========================================
        * CUSTOM UTIL CLASSES
        * ==========================================
        *
        */

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
    <link rel="stylesheet" href="/assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/assets/select2/dist/css/select2-bootstrap.min.css">
@endsection
@section('judul_mobile')
<h3 class="mx-auto judul-mobile" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Penawaran</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Penawaran</i></h3>
@endsection
@section('container')
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
<form action="/submit" method="POST">
{{ @csrf_field() }}
    <div class="container-fluid py-3">
            <div class="p-2" style="background-color:#deff8b;">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="perusahaan">Nama Perusahaan (*)</label>
                            <select name="perusahaan" id="perusahaan" class="form-control">
                                @foreach($perusahaan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label for="pelanggan">Nama Perusahaan Pelanggan (*)</label>
                            <select name="pelanggan_pilih" id="pelanggan_pilih" class="form-control" required>
                                <option selected disabled hidden>--Pilih--</option>
                                <option>Sekolah</option>
                                <option>Other</option>
                            </select>
                            <div id="pilihan" class="mt-1"></div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="pelanggan">Tanggal (*)</label>
                            <input type="date" name="tgls" id="tgls" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="kode">Nama Login (*)</label>
                                <div class="d-flex flex-row">
                                    <select name="kode" id="kode" class="form-control" disabled>
                                        @foreach($kode as $k)
                                            <option value="{{ $k->kode_po }}" {{(Session::get('kode_sales') == $k->kode_po) ? 'selected' : ''}}>{{ $k->kode_po.' - '.$k->nama.' - '.$k->jabatan.' - '.$k->nama_perusahaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="kode">Periode Penawaran (*)</label>
                                <input type="month" class="form-control" name="tgl_penawaran" id="tgl_penawaran" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="pajak" class="mb-1">Pajak (*)</label>
                                <select name="pajak" id="pajak" class="form-control">
                                    <option value="1">termasuk pajak</option>
                                    <option value="2">tidak termasuk pajak</option>
                                    <option value="3">kosongin</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="masa" class="mb-1">Masa Berlaku (*)</label>
                                <div class="d-flex flex-row">
                                    <input type="number" name="masa_tgl" class="form-control mr-2" style="width:30%;" value="{{$rule['masa_berlaku_penawaran']}}" required>
                                    <p style="font-size:22px;">Hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="perihal">Perihal (*)</label>
                            <textarea name="perihal" id="perihal" cols="10" rows="4" class="form-control" required>Penawaran</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="ttd" class="mb-1">Tanda Tangan (*)</label>
                            <select name="ttd" id="ttd" class="form-control" disabled>
                                <option value="1">Tampilkan</option>
                                <option value="2" selected>Tidak Tampilkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label for="ttd_sales">Nama Sales (*)</label>
                            <select name="ttd_sales" id="ttd_sales" class="form-control">
                                <option value=""></option>
                                @foreach($kode as $k)
                                    <option value="{{ $k->kode_po }}">{{ $k->kode_po.' - '.$k->nama.' - '.$k->jabatan.' - '.$k->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2" style="background-color:#fbceb5;">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center"  style="min-height:10px;">
                                    <td scope="col" colspan="2" style="width:31%;" class="p-1">Nama Barang (*)</td>
                                    <td scope="col" class="p-1" style="width:10%;">QTY (*)</td>
                                    <td scope="col" class="p-1" style="width:15%;">Satuan (*)</td>
                                    <td scope="col" class="p-1" style="width:17%;">Harga Satuan (*)</td>
                                    <td scope="col" class="p-1" style="width:20%;">Total (*)</td>
                                    <td scope="col" class="p-1" style="width:7%;"><button class="btn btn-primary add_field_button"><b>+</b></button></td>
                                </tr>
                            </thead>
                        <tbody class="input_fields_wrap">
                            <tr>
                                <td colspan="2">
                                    <div class="form-group m-0">
                                        <input type="text" class="form-control nama" name="nama_barang[]" required>
                                    </div>
                                </td>
                                <td class="m-0">
                                    <div class="form-group m-0">
                                        <input type="number" class="form-control qty m-0 m-0" name="qty[]" id="'+x+'" required>
                                    </div>
                                </td>
                                <td>    
                                    <div class="form-group m-0">
                                        <select name="satuan[]" id="satuan" class="form-control satuan">
                                            @foreach($satuan as $a)
                                                <option>{{ $a->satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        <input type="number" class="form-control harga" name="harga_satuan[]" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        <input type="number" class="form-control total" name="total[]" required readonly>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger hapus"><b>x</b></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" rows="2" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel">Cancel</button>
                <button type="button" data-toggle="modal" data-target="#goto" class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;">Go To List Penawaran</button>
            </div>
        </div>
    </div>
</form>
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
        <button type="button" class="btn btn-danger" onclick="location.reload()">Yakin</button>
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
        Yakin mau di pindah ke list penawaran?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a class="btn btn-danger" href="/list/penawaran">Yakin</a>
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
        $('#kode').prop('disabled', false);
        $('#ttd').prop('disabled', false);
    });
    
    $('#pelanggan_pilih').on('change',function(){
        let pilihan = $('#pelanggan_pilih').val();
        
        if(pilihan == "Sekolah"){
            let desain = '<select name="id_sekolah" id="id_sekolah" class="id_sekolah form-control" required>';
            desain += '<option></option>';
            desain += '<option>Tambah Baru</option>';
            @foreach($sekolah as $s)
            desain += '<option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>';
            @endforeach
            desain += '</select>';
            $('#pilihan').html(desain);
            $('.id_sekolah').select2({
                placeholder: "-- Pilih --",
                allowClear: true,    
                theme: "bootstrap"
            });        
            $('#id_sekolah').on('change',function(){
                let isi  = $('#id_sekolah').val();
                if(isi == 'Tambah Baru'){
                    window.open('/master/sekolah');
                }
            });
        }else if(pilihan == "Other"){
            let desain = '<select name="id_pelanggan" id="id_pelanggan" class="id_pelanggan form-control" required>';
            desain += '<option></option>';
            desain += '<option>Tambah Baru</option>';
            @foreach($pelanggan as $p)
            desain += '<option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>';
            @endforeach
            desain += '</select>';
            $('#pilihan').html(desain);
            $('.id_pelanggan').select2({
                placeholder: "-- Pilih --",
                allowClear: true,    
                theme: "bootstrap"
            });
            $('#id_pelanggan').on('change',function(){
                let isi  = $('#id_pelanggan').val();
                if(isi == 'Tambah Baru'){
                    window.open('/master/penawaran/pelanggan');
                }
            });
        }
    });
    $('#ttd_sales').select2({
            placeholder: "-- Pilih --",
            allowClear: true,    
            theme: "bootstrap"
    });
    $('tbody').delegate('.qty,.harga,.total','keyup',function(){
        var tr3 = $(this).parent();
        var tr2 = tr3.parent();
        var tr = tr2.parent();

        var qty = tr.find('.qty').val();
        var harga = tr.find('.harga').val();
        var total = (qty * harga);
        tr.find('.total').val(total);
    });
	// var max_fields= 25; //maximum input boxes allowed
	var x = 1; //initlal text box count
	$('.add_field_button').click(function(e){ //on add input button click
		e.preventDefault();
		 //max input box allowed
			x++; //text box increment
			$('.input_fields_wrap').append('<tr id="row'+x+'"><td colspan="2"><div class="form-group m-0"><input type="text" class="form-control nama" name="nama_barang[]" required></div></td><td><div class="form-group m-0"><input type="number" class="form-control qty m-0" name="qty[]" id="'+x+'" required></div></td><td><div class="form-group m-0"><select name="satuan[]" id="satuan" class="form-control satuan">@foreach($satuan as $a)<option>{{ $a->satuan }}</option>@endforeach</select></div></td><td><div class="form-group m-0"><input type="number" class="form-control harga" name="harga_satuan[]" required></div></td><td><div class="form-group m-0"><input type="number" class="form-control total" name="total[]" required></div></td><td><button type="button" id="'+x+'" class="btn btn-danger hapus"><b>x</b></button></td></tr>'); //add input box
		
	});
	
	$(document).on('click','.hapus', function(){ //user click on remove text
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();

	});
    

});
document.getElementById('tgl_penawaran').valueAsDate = new Date();
document.getElementById('tgls').valueAsDate = new Date();
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