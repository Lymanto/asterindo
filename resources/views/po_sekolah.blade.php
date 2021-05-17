@extends('main.index')

@section('title','Input PO Sekolah')

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
<h3 class="mx-auto judul-mobile" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input PO Sekolah</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input PO Sekolah</i></h3>
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
  <form action="{{ route('po_sekolah.submit') }}" method="post" enctype="multipart/form-data">
  <div class="p-2" style="background-color:#bbe1fa;">
    <div class="row mt-3">
    @csrf
      <div class="col-4">
        <div class="form-group">
          <label for="no_surat">No Surat</label>
          <input type="text" name="no_surat" id="no_surat" class="form-control">
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label for="id_sekolah">Nama Sekolah (*)</label>
          <select name="id_sekolah" id="id_sekolah" class="form-control">
          <option value=""></option>
            @foreach($sekolah as $s)
              <option value="{{$s->id}}">{{ $s->nama_sekolah }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-2">
        <div class="form-group">
          <div class="d-flex flex-row">
            <div class="form-group">
              <label for="">NPSN</label>
              <input type="text" class="form-control mr-1" id="npsn" name="npsn" readonly required>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label for="">Periode PO Sekolah (*)</label>
          <input type="month" class="form-control ml-1" id="bulan" name="bulan">
        </div>
      </div>
      <div class="col-9">
        <div class="form-group">
          <label for="kode_sales">Nama Login (*)</label>
          <select name="kode_sales" id="kode_sales" class="form-control" disabled>
            @foreach($kodepo as $k)
              <option value="{{$k->kode_po}}" {{(Session::get('kode_sales') == $k->kode_po) ? 'selected' : ''}}>{{$k->kode_po}} - {{$k->nama}} - {{$k->jabatan}} - {{ $k->nama_perusahaan }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-5">
            <div class="form-group">
              <label for="id_perusahaan">Perusahaan (*)</label>
              <select name="id_perusahaan" id="id_perusahaan" class="form-control">
                @foreach($perusahaan as $p)
                  <option value="{{$p->id}}">{{ $p->nama_perusahaan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-4">
            <div class="form-group">
              <label for="tgl">TGL (*)</label>
              <input type="date" name="tgl" id="tgl" class="form-control" required>
            </div>
          </div>
          <div class="col-3">
            <div class="form-group">
              <label for="bank">Bank (*)</label>
              <select name="id_bank" id="id_bank" class="form-control">
              @foreach($bank as $bank)
                <option value="{{$bank->id}}">{{$bank->nama_bank}}</option>
              @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="alamat_pengiriman">Alamat Pengiriman (*)</label>
          <textarea name="alamat_pengiriman" id="alamat_pengiriman" cols="30" rows="2" class="form-control" required></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="judul_project">Nama Project (*)</label>
          <textarea name="judul_project" id="judul_project" cols="30" rows="1" class="form-control" required></textarea>
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
          <select name="ttd_sales" id="ttd_sales" class="form-control">
            <option value=""></option>
            @foreach($kodepo as $k)
              <option value="{{$k->kode_po}}">{{$k->kode_po}} - {{$k->nama}} - {{$k->jabatan}} - {{ $k->nama_perusahaan }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
  <div style="background-color:#deff8b;" class="p-2">
    <div class="row">
      <div class="col-12">
          <table class="table table-bordered">
              <thead>
                  <tr class="text-center"  style="min-height:10px;">
                      <td scope="col" colspan="2" style="width:25%;" class="p-1">Description (*)</td>
                      <td scope="col" class="p-1" style="width:10%">QTY (*)</td>
                      <td scope="col" class="p-1" style="width:13%">Satuan (*)</td>
                      <td scope="col" class="p-1" style="width:20%">Harga Satuan (*)</td>
                      <td scope="col" class="p-1" style="width:20%">Total</td>
                      <td scope="col" class="p-1" style="width:5%"><button class="btn btn-primary add_field_button"><b>+</b></button></td>
                  </tr>
              </thead>
              <tbody class="input_fields_wrap">
                  <tr>
                      <td scope="row" colspan="2">
                          <div class="form-group m-0">
                              <input type="text" class="form-control nama" name="nama_barang[]" required>
                          </div>
                      </td>
                      <td scope="row" class="m-0">
                          <div class="form-group m-0">
                              <input style="width:100px" type="number" class="form-control qty m-0 m-0" name="qty[]" id="'+x+'" required>
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
                              <input type="number" class="form-control harga" name="harga_satuan[]" required>
                          </div>
                      </td>
                      <td scope="row">
                          <div class="form-group m-0">
                              <input type="number" class="form-control total" name="total[]" required readonly>
                          </div>
                      </td>
                      <td scope="row">
                          <button type="button" class="btn btn-danger hapus"><b>x</b></button>
                      </td>
                  </tr>
              </tbody>
              <tbody>
                <tr>
                  <td colspan="4" style="border:none;"></td>
                  <td class="text-right">Jumlah</td>
                  <td colspan="2">
                    <input type="number" name="jumlah" id="jumlah" class="form-control" readonly required>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" style="border:none;"></td>
                  <td class="text-right">PPN 10%</td>
                  <td colspan="2">
                    <input type="number" name="ppn" id="ppn" class="form-control" min="1" required>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" style="border:none;"></td>
                  <td class="text-right">Grand Total</td>
                  <td colspan="2">
                    <input type="number" name="grandtotal" id="grandtotal" class="form-control" readonly required>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" style="border:none;"></td>
                  <td class="text-right">PPh</td>
                  <td colspan="2">
                    <input type="text" name="pph" id="pph" class="form-control" readonly required>
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
        <button type="button" data-toggle="modal" data-target="#goto" class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;">Go To List PO Sekolah</button>
      </div>
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
        <button type="button" onclick="location.reload()" class="btn btn-danger">Yakin</button>
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
        Yakin mau di pindah ke list po sekolah?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a class="btn btn-danger" href="/list/po-sekolah">Yakin</a>
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
        $('#kode_sales').prop('disabled', false);
        $('#ttd').prop('disabled', false);
    });
    $('#ttd_sales,#id_sekolah').select2({
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
      var sum = 0;
      $('.total').each(function(){
        sum += parseInt(this.value);
      });
      $('#jumlah').val(sum);
      var ppn = parseInt(sum) * 0.1;
      $('#ppn').val(Math.ceil(ppn));
      var grandtotal = parseInt(sum) + parseInt(ppn);
      $('#grandtotal').val(grandtotal);
      var jum = $('#jumlah').val();
      var pph = parseInt(jum)*0.985;
      var bilangan = Math.ceil(pph);
      var	number_string = bilangan.toString(),
          sisa 	= number_string.length % 3,
          rupiah 	= number_string.substr(0, sisa),
          ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }
      $('#pph').val('Rp '+rupiah);
    });
    $('#ppn').on('keyup',function(){
      var grandtotal = parseInt($('#ppn').val()) + parseInt($('#jumlah').val());
      $('#grandtotal').val(grandtotal);
    });
	// var max_fields= 25; //maximum input boxes allowed
	var x = 1; //initlal text box count
	$('.add_field_button').click(function(e){ //on add input button click
		e.preventDefault();
		 //max input box allowed
			x++; //text box increment
			$('.input_fields_wrap').append('<tr id="row'+x+'"><td scope="row" colspan="2"><div class="form-group m-0"><input type="text" class="form-control nama" name="nama_barang[]" required></div></td><td scope="row"><div class="form-group m-0" style="width:100px"><input type="number" class="form-control qty m-0" name="qty[]" id="'+x+'" required></div></td><td scope="row"><div class="form-group m-0"><select name="satuan[]" id="satuan" class="form-control satuan">@foreach($satuan as $a)<option>{{ $a->satuan }}</option>@endforeach</select></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control harga" name="harga_satuan[]" required></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control total" name="total[]" required></div></td><td scope="row"><button type="button" id="'+x+'" class="btn btn-danger hapus"><b>x</b></button></td></tr>'); //add input box
		
	});
	
	$(document).on('click','.hapus', function(){ //user click on remove text
    var button_id = $(this).attr("id");
    $('#row'+button_id+'').remove();
	});
});
$(function() {
  document.getElementById('tgl').valueAsDate = new Date();
  document.getElementById('bulan').valueAsDate = new Date();
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

  $('#id_sekolah').on('change',function(){
    var _token = $('input[name="_token"]').val();
    var query = $('#id_sekolah').val();
    $.ajax({
      url:"{{ route('po_sekolah.id') }}",
      method:"POST",
      data:{query:query, _token:_token},
      success:function(data){
        var wow = JSON.parse(data);
        $('#npsn').val(wow['npsn']);
        $('#alamat_pengiriman').val(wow['alamat_sekolah']);
      }
    });
  });
});
</script>
@endsection