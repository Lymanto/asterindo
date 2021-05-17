@extends('main.index')

@section('title','List PO Sekolah Edit')

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
<h3 class="mx-auto judul-mobile" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit PO Sekolah</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>Edit PO Sekolah</i></h3>
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
  <form action="{{ route('po_sekolah.edit_submit',$data['kode']) }}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="id" id="id" value="{{$data['id']}}">
  <div class="p-2" style="background-color:#bbe1fa;">
    <div class="row">
      <div class="col-12">
        <h3>{{$data['kode']}}</h3>
      </div>
    </div>
    <div class="row mt-3">
        <div class="col-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                @foreach($status as $s)
                    @if(Session::get('role_id') == '1')
                    <option value="{{ $s->id }}" {{ ( $s->id == $data['id_status']) ? 'selected' : '' }}>{{ $s->id }}. {{ $s->status }}</option>
                    @else
                    <option value="{{ $s->id }}" {{ ( $s->id == $data['id_status']) ? 'selected' : '' }} {{($s->id < $data['id_status']) ? 'disabled' : ''}} {{($s->id == 16) ? 'disabled' : ''}}>{{ $s->id }}. {{ $s->status }}</option>
                    @endif
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-3">
          <div class="form-group">
            <label for="no_surat">No Surat Sekolah</label>
            <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{$data['no_surat']}}"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="id_sekolah">Nama Sekolah</label>
            <div class="d-flex flex-row">
              <select name="id_sekolah" id="id_sekolah" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
              <option value="" selected disabled hidden>Pilih</option>
                @foreach($sekolah as $s)
                  <option value="{{$s->id}}" {{ ($s->id == $data['id_sekolah']) ? 'selected' : '' }}>{{$s->npsn}} - {{ $s->nama_sekolah }}</option>
                @endforeach
              </select>
              <div class="ml-2 align-self-center"><a href="https://google.com" style="color:black;"><i class="fa fa-globe" style="font-size:30px;"></i></a></div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-7">
        <div class="row">
          <div class="col-7">
            <div class="form-group">
              <label for="id_perusahaan">Perusahaan</label>
              <select name="id_perusahaan" id="id_perusahaan" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
                @foreach($perusahaan as $p)
                  <option value="{{$p->id}}" {{ ($p->id == $data['id_perusahaan']) ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-5">
            <div class="form-group">
              <label for="tgl">TGL PO</label>
              <input type="date" name="tgl" id="tgl" class="form-control" value="{{$data['tgl'] }}"   @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif required>
            </div>
          </div>
        </div>
      </div>
      <div class="col-5">
        <div class="form-group">
          <label for="kode_sales">Nama Login</label>
          <select name="kode_sales" id="kode_sales" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
            @foreach($kodepo as $k)
              <option value="{{$k->kode_po}}" {{ ($k->kode_po == $data['kode_sales']) ? 'selected' : '' }}>{{$k->kode_po}} - {{$k->nama}} - {{$k->jabatan}} - {{ $k->nama_perusahaan }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="alamat_pengiriman">Alamat Pengiriman</label>
          <textarea name="alamat_pengiriman" id="alamat_pengiriman" cols="30" rows="2" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif required>{{$data['alamat_pengiriman']}}</textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="judul_project">Nama Project</label>
          <textarea name="judul_project" id="judul_project" cols="30" rows="3" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif required>{{$data['judul_project']}}</textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <a href="{{asset('assets/images/upload/po-sekolah/'.$data['gambar1'])}}" target="_blank" @if($data['gambar1'] != '') style="background-color:yellow;" @endif>Foto PO (Setelah TTD Kepsek)</a>
          <input type="file" name="gambar1" id="gambar1"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <a href="{{asset('assets/images/upload/po-sekolah/'.$data['gambar2'])}}" target="_blank" @if($data['gambar2'] != '') style="background-color:yellow;" @endif>Foto Contoh Barang 1</a>
          <input type="file" name="gambar2" id="gambar2"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <a href="{{asset('assets/images/upload/po-sekolah/'.$data['gambar3'])}}" target="_blank" @if($data['gambar3'] != '') style="background-color:yellow;" @endif>Foto Contoh Barang 2</a>
          <input type="file" name="gambar3" id="gambar3"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <a href="{{asset('assets/images/upload/po-sekolah/'.$data['gambar4'])}}" target="_blank" @if($data['gambar4'] != '') style="background-color:yellow;" @endif>Foto Contoh Barang 3</a>
          <input type="file" name="gambar4" id="gambar4"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
          <div class="form-group">
            <label for="ttd">Tanda Tangan (*)</label>
            <select name="ttd" id="ttd" class="form-control" {{(Session::get('role_id') == '2' || Session::get('role_id') == '3') ? 'disabled' : ''}}>
                <option value="1" {{($data['ttd'] == '1') ? 'selected' : ''}}>Tampilkan</option>
                <option value="2" {{($data['ttd'] == '2') ? 'selected' : ''}}>Tidak Tampilkan</option>
            </select>
          </div>
      </div>
      <div class="col-9">
        <div class="form-group">
          <label for="ttd_sales">Nama Sales (*)</label>
          <select name="ttd_sales" id="ttd_sales" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'disabled' : '' }} @endif>
            <option value=""></option>
            @foreach($kodepo as $k)
              <option value="{{$k->kode_po}}" {{ ($k->kode_po == $data['ttd_id_sales']) ? 'selected' : '' }}>{{$k->kode_po}} - {{$k->nama}} - {{$k->jabatan}} - {{ $k->nama_perusahaan }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
  <div style="background-color:#deff8b;" class="p-2">
    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label for="bank">Bank</label>
          <select name="id_bank" id="id_bank" class="form-control"  @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ) disabled @endif>
          @foreach($bank as $bank)
            <option value="{{$bank->id}}" {{ ($bank->id == $data['id_bank']) ? 'selected' : '' }}>{{$bank->nama_bank}}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="tgl_lunas">TGL LUNAS</label>
          <input type="date" name="tgl_lunas" id="tgl_lunas" class="form-control" value="{{$data['tgl_lunas']}}"   @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ) readonly @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="jumlah_uang_terima">Jumlah Uang Terima</label>
          <input type="number" name="jumlah_uang_terima" id="jumlah_uang_terima" class="form-control" value="{{$data['jumlah_uang_terima']}}"   @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ) disabled @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="selisih_uang">Selisih Uang</label>
          <input type="text" name="selisih_uang" id="selisih_uang" class="form-control" value="{{'Rp ' .str_replace(',','.',number_format($data['jumlah_uang_terima']-$data['grandtotal']))}}" readonly>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="memo">Memo</label>
          <a href="{{route('po_sekolah.memo_view',$kode)}}" target="_blank">[View]</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <div class="form-group">
          <label for="grandtotal">Grand Total</label>
          <input type="number" name="grandtotal" id="grandtotal" value="{{$data['grandtotal']}}" class="form-control" required readonly>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="jumlah_total">Jumlah Total</label>
          <input type="number" name="jumlah_total" id="jumlah_total" value="{{$data['jumlah_total']}}" class="form-control" required readonly>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="ppn">PPn</label>
          <input type="number" name="ppn" id="ppn" value="{{$data['ppn']}}" class="form-control"   @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ) disabled @elseif(Session::get('role_id') == 1) required @endif>
        </div>
      </div>
      <div class="col-3">
        <div class="form-group">
          <label for="pph">Uang Terima</label>
          <input type="text" name="pph" id="pph" value="{{'Rp ' . str_replace(',','.',number_format($data['jumlah_total']*0.985))}}" class="form-control"   @if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ) disabled @endif disabled>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel">Cancel</button>
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#tambah">Tambah Barang</button>
        <button type="button" class="btn btn-info" onclick="window.open('/preview/po-sekolah/{{$data->kode}}');return false">Preview</button>
      </div>
    </div>
  </div>
  </form>
  <div class="row">
    <div class="col-12">
      <table class="table table-hover table-striped table-bordered" id="table">
          <thead>
              <tr>
                  <th scope="col" class="text-center">No</ths>
                  <th scope="col" class="text-center">Description</th>
                  <th scope="col" class="text-center">QTY</th>
                  <th scope="col" class="text-center">Satuan</th>
                  <th scope="col" class="text-center">Harga</th>
                  <th scope="col" class="text-center">Total</th>
                  <th scope="col" class="text-center" style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'display:none;' : '' }} @endif">Action</th>
              </tr>
          </thead>
          <tbody>
          @foreach($barang as $b)
              <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $b->description }}</td>
                  <td class="text-center">{{ $b->qty }}</td>
                  <td class="text-center">{{ $b->satuan }}</td>
                  <td class="text-right">{{ "Rp " . number_format($b->harga) }}</td>
                  <td class="text-right">{{ "Rp " . number_format($b->total) }}</td>
                  <td style="@if(Session::get('role_id') == '2' || Session::get('role_id') == '3' ){{ ($data['id_status'] >= 5) ? 'display:none;' : '' }} @endif" class="text-center">
                      <button class="btn btn-secondary mr-1" type="button" data-target="#edit{{ $b->id }}" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                      <button class="btn btn-danger" type="button" data-target="#hapus{{ $b->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  </td>
              </tr>
          @endforeach
          </tbody>
      </table>
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
        Yakin mau di cancel
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a href="/list/po-sekolah" class="btn btn-danger">Yakin</a>
      </div>
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
            <form action="{{route('po_sekolah.edit_barang',$data['kode'])}}" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$b->id}}">
            <input type="hidden" name="ppn_barang" id="ppn_barang" value="{{$b['total']*0.1}}">
            <input type="hidden" name="ppn" id="ppn" value="{{$data['ppn']}}">
            <input type="hidden" name="total_barang" id="total_barang" value="{{$b['total']}}">
            <input type="hidden" name="jumlah_total" id="jumlah_total" value="{{$data['jumlah_total']}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" value="{{ $b->description }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input type="number" name="qty" id="qty" value="{{ $b->qty }}" class="form-control qty">
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
                        <input type="number" name="harga" id="harga" value="{{ $b->harga }}" class="form-control harga">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" value="{{ $b->total }}" class="form-control total">
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
            <form action="{{route('po_sekolah.hapus_barang',$data['kode'])}}" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$b->id}}">
            <input type="hidden" name="ppn" id="ppn" value="{{$data['ppn']}}">
            <input type="hidden" name="jumlah_total" id="jumlah_total" value="{{$data['jumlah_total']}}">
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
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('po_sekolah.tambah_barang',$data['kode'])}}" method="post">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="ppn" id="ppn" value="{{$data['ppn']}}">
            <input type="hidden" name="jumlah_total" id="jumlah_total" value="{{ $data['jumlah_total'] }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty">QTY</label>
                        <input type="number" name="qty" id="qty" class="form-control qty">
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
                        <input type="number" name="harga" id="harga" class="form-control harga">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" name="total" id="total" class="form-control total">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
$(function() {
  $('form').on('submit', function() {
      $('#ttd').prop('disabled', false);
  });
  $('#ttd_sales').select2({
        placeholder: "-- Pilih --",
        allowClear: true,    
        theme: "bootstrap"
    });
  $('#jumlah_uang_terima').on('keyup',function(){
    let jumlah_uang_terima = $('#jumlah_uang_terima').val();
    let grandtotal = $('#grandtotal').val();
    let selisih = Number(jumlah_uang_terima-grandtotal);
    var bilangan = selisih;
    var	number_string = bilangan.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
            
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    $('#selisih_uang').val('Rp ' + rupiah);
  });
  $('#ppn').on('keyup',function(){
    const jumlah_total = $('#jumlah_total').val();
    const ppn = $('#ppn').val();
    const grandtotal = parseInt(jumlah_total) + parseInt(ppn);
    $('#grandtotal').val(grandtotal);
  });
  $('.modal-content').delegate('.qty,.harga,.total','keyup',function(){
        var tr3 = $(this).parent();
        var tr2 = tr3.parent();
        var tr = tr2.parent();
        var qty = tr.find('.qty').val();
        var harga = tr.find('.harga').val();
        var total = (qty * harga);
        tr.find('.total').val(total);
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
  $('#table').DataTable();
});
</script>
@endsection