@extends('main.index')

@section('title','List Penawaran')

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
<h3 class="mx-auto judul-mobile" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Penawaran</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#0b8457;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Penawaran</i></h3>
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
    <form class="search">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                <label for="status">Status</label>
                    <select name="status" id="status" class="status form-control">
                    <option></option>
                    @foreach($status as $s)
                        <option value="={{$s->id}}" {{($filter['status'] == "=$s->id") ? 'selected' : ''}}>{{$s->id}}. {{$s->status}}</option>
                    @endforeach
                        <option value="<=16" {{($filter['status'] == '<=16') ? 'selected' : ''}}>Kecuali 17 & 18</option>
                        <option value="<=15" {{($filter['status'] == '<=15') ? 'selected' : ''}}>Kecuali 16-18</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="id_customer">Nama Perusahaan Pelanggan</label>
                    <select name="id_customer" id="id_customer" class="id_customer form-control">
                        <option></option>
                    @foreach($customer as $c)
                        <option value="{{$c->id}}" {{($c->id == $filter['id_pelanggan']) ? 'selected' : ''}}>{{$c->nama_perusahaan}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="id_perusahaan">Nama Perusahaan</label>
                    <select name="id_perusahaan" id="id_perusahaan" class="id_perusahaan form-control">
                        <option></option>
                    @foreach($perusahaan as $p)
                        <option value="{{$p->id}}" {{($p->id == $filter['id_perusahaan']) ? 'selected' : ''}}>{{$p->nama_perusahaan}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="id_sales">Nama Sales</label>
                    <select name="id_sales" id="id_sales" class="id_sales form-control">
                        <option></option>
                    @foreach($sales as $s)
                        <option value="{{$s->kode_po}}" {{($s->kode_po == $filter['id_sales']) ? 'selected' : ''}}>{{$s->nama.' - '.$s->jabatan.' - '.$s->nama_perusahaan}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4">
                <label for="tgl">TGL</label>
                <div class="d-flex flex-row">
                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="{{$filter['tgl_awal']}}">
                    <div class="align-self-center mx-2">S/D</div>
                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{$filter['tgl_akhir']}}">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-2">
                <label for="masa_berlaku">Masa Berlaku</label>
                <div class="d-flex flex-row justify-content-between">
                    <select name="operator" id="operator" class="form-control mr-3 operator">
                        <option></option>
                        <option value="<=" {{($filter['operator'] == "<=") ? 'selected' : ''}}><=</option>
                        <option value=">=" {{($filter['operator'] == ">=") ? 'selected' : ''}}>>=</option>
                    </select>
                    <input type="number" name="masa_berlaku" id="masa_berlaku" class="form-control ml-3" value="{{$filter['masa_berlaku']}}">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-1">
                <label for="tahun">Tahun</label>
                <input  type="text" pattern="\d*" name="tahun" id="tahun" class="form-control" minlength="4" maxlength="4" autocomplete="off" value="{{$filter['tahun']}}" required>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <label for="pajak">Pajak</label>
                <select name="pajak" id="pajak" class="form-control pajak">
                    <option></option>
                    <option value="1" {{($filter['pajak'] == '1') ? 'selected' : ''}}>termasuk pajak</option>
                    <option value="2" {{($filter['pajak'] == '2') ? 'selected' : ''}}>tidak termasuk pajak</option>
                    <option value="3" {{($filter['pajak'] == '3') ? 'selected' : ''}}>kosongin</option>
                </select>
            </div>
        </div>
        <div class="row py-3">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary cari" type="submit">Cari</button>
                    <a class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/penawaran">Go To Input Penawaran</a>
                    <label>W = Waiting, S = Success, B = Batal</label>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-hover table-striped table-bordered" id="table" width="100%">
              <thead>
                <tr>
                  <th>No Urut<br>Tanggal<br>Kode Pen</th>
                  <th>Status</th>
                  <th>Pelanggan</th>
                  <th>Nama Sales</th>
                  <th>Batas<br>Penawaran</th>
                  <th>Over</th>
                  <th>Nilai<br>Penawaran</th>
                  <th class="text-center">W</th>
                  <th class="text-center">S</th>
                  <th class="text-center">B</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($pelanggan as $p)
                <tr>
                  <td>{{ substr($p->no_urut,3,6) }}<br>{{ date('d-m-Y',strtotime($p->tgls)) }}<br>{{ $p->kode_penawaran }}</td>
                  <td>{{ $p->status }}</td>
                    @if($p->nama_perusahaan != '')
                    <td>{{ $p->nama_perusahaan }}</td>
                    @elseif($p->nama_sekolah != '')
                    <td>{{ $p->nama_sekolah }}</td>
                    @endif
                  <td class="text-center">{{ $p->nama_sales }}<br>{{ $p->kode_sales  }}</td>
                  <td class="text-center"><span id="tgl_penawaran{{$p->kode_penawaran}}">{{ date('d-m-Y',strtotime($p->tgl_penawaran)) }}</span><br>{{ $p->lama_penawaran.'   '.'hari' }}</td>
                  <td id="lewat{{$p->kode_penawaran}}" class="text-center">
                  <!-- @if( Carbon\Carbon::now()->toDateString() == $p->tgl_penawaran )
                    H
                  @elseif($p->tgl_penawaran > Carbon\Carbon::now()->toDateString() )
                    H-{{ $diff = Carbon\Carbon::parse($p->tgl_penawaran)->diffInDays(Carbon\Carbon::now()) }}
                  @elseif( $p->tgl_penawaran < Carbon\Carbon::now()->toDateString())
                    H+{{ $diff = Carbon\Carbon::parse($p->tgl_penawaran)->diffInDays(Carbon\Carbon::now()) }}
                  @endif -->
                  </td>
                  <td>{{ "Rp " . str_replace(',','.',number_format($p->total)) }}</td>
                  <td>W</td>
                  <td>S</td>
                  <td>B</td>
                  <td>
                    <a href="/list/penawaran/edit/{{ $p->kode_penawaran }}" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-info" onclick="window.open('/preview/{{$p->kode_penawaran}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-primary" onclick="window.open('/print/{{$p->kode_penawaran}}');return false"><i class="fa fa-print" aria-hidden="true"></i></button><br>
                    @if(Session::get('role_id') == '1')
                    <button type="button" class="btn btn-danger" data-target="#hapus{{ $p->kode_penawaran }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    @else
                    
                    @endif
                    <a class="btn btn-dark" href="{{$rule['gmaps_prefix'].$p->gps_latitude.$rule['gmaps_middle'].$p->gps_longtitude.$rule['gmaps_suffix']}}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($pelanggan as $p)
<div class="modal fade" id="hapus{{ $p->kode_penawaran }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/list/penawaran/delete" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $p->kode_penawaran }}">
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
<script src="/assets/js/moment.js"></script>
<div id="script_hapus">
@foreach($pelanggan as $p)
<script>
    var now = new Date();
    var tgl = String(now.getDate()).padStart(2, '0');
    var bulan = String(now.getMonth() + 1).padStart(2, '0'); //January is 0!
    var tahun = now.getFullYear();
    now = tahun+'/'+bulan+'/'+tgl;
    now = moment(now);
    var tgl_penawaran = document.getElementById('tgl_penawaran{{$p->kode_penawaran}}').innerHTML;
    tgl_penawaran = tgl_penawaran.split('-');
    tgl_penawaran = tgl_penawaran[2]+'/'+tgl_penawaran[1]+'/'+tgl_penawaran[0];
    tgl_penawaran = moment(tgl_penawaran);
    if(now['_i'] == tgl_penawaran['_i']){
        document.getElementById('lewat{{$p->kode_penawaran}}').innerHTML = "H";
    }
    else if(tgl_penawaran > now){
        document.getElementById('lewat{{$p->kode_penawaran}}').innerHTML = "H"+ now.diff(tgl_penawaran,'days');
    }
    else if(tgl_penawaran < now){
        document.getElementById('lewat{{$p->kode_penawaran}}').innerHTML = "H+"+ now.diff(tgl_penawaran,'days');
    }
</script>
@endforeach
</div>
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
    $('.status,.id_customer,.id_perusahaan,.id_sales,.pajak,.operator').select2({
        placeholder: "-- Pilih --",
        allowClear: true,
        theme: "bootstrap"
    });
    $('#table').DataTable({
        'order' : [],
        "scrollY":        "500px",
        "scrollX":        true,
    });
    $('.search').submit(function(e){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        const status = $('#status').val();
        const id_perusahaan = $('#id_perusahaan').val();
        const id_customer = $('#id_customer').val();
        const id_sales = $('#id_sales').val();
        const tgl_awal = $('#tgl_awal').val();
        const tgl_akhir = $('#tgl_akhir').val();
        const masa_berlaku = $('#masa_berlaku').val();
        const operator = $('#operator').val();
        const tahun = $('#tahun').val();
        const pajak = $('#pajak').val();
        const formData ={
            status: status,
            id_perusahaan:id_perusahaan,
            id_customer:id_customer,
            id_sales:id_sales,
            tgl_awal:tgl_awal,
            tgl_akhir:tgl_akhir,
            masa_berlaku:masa_berlaku,
            operator:operator,
            tahun:tahun,
            pajak:pajak,
        }
        $.ajax({
            url:"{{route('filter.penawaran')}}",
            method:"POST",
            data:formData,
            dataType: 'json',
            // complete: function (data){
            //     // $.get("{{route('table.ttb')}}", function (data) {
            //     //     $('.filter').html(data);
            //     // });
            // },
            success: function (data) {
                console.log(data);
                let td = '<table class="table table-hover table-striped table-bordered filter" id="filter" width="100%">';
                td += '<thead>';
                td += '<tr>';
                td += '    <th>No<br>Urut<br>Tanggal<br>Kode Pen</th>';
                td += '    <th>Status</th>';
                td += '    <th>Pelanggan</th>';
                td += '    <th>Nama Sales</th>';
                td += '    <th>Batas Penawaran</th>';
                td += '    <th>Over</th>';
                td += '    <th>Nilai Penawaran</th>';
                td += '<th class="text-center">W</th>';
                td += '<th class="text-center">S</th>';
                td += '<th class="text-center">B</th>';
                td += '    <th class="text-center">Action</th>';
                td += '</tr>';
                td += '</thead>';
                td += '<tbody>';
                $.each(data,function (key,value){
                    var date= value.tgls;
                    var d=new Date(date.split("/").reverse().join("-"));
                    var dd=d.getDate();
                    var mm=d.getMonth()+1;
                    var yy=d.getFullYear();
                    var newdate=dd+"-"+mm+"-"+yy;

                    var tgl_penawaran= value.tgl_penawaran;
                    var ds=new Date(tgl_penawaran.split("/").reverse().join("-"));
                    var dds=ds.getDate();
                    var mms=ds.getMonth()+1;
                    var yys=ds.getFullYear();
                    tgl_penawaran=dds+"-"+mms+"-"+yys;
                    var tgl_pen=yys+"-"+mms+"-"+dds;
                    tgl_pen = moment(tgl_pen);
                    var today = new Date();
                    var tgl_sekarang = String(today.getDate()).padStart(2, '0');
                    var mm_sekarang = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy_sekarang = today.getFullYear();
                    today = yyyy_sekarang + '-' + mm_sekarang + '-' + tgl_sekarang;
                    today = moment(today);
                    
                    td += '<tr>';
                    td += '<td>'+value.no_urut.substring(3,6)+'<br>'+newdate+'<br>'+value.kode_penawaran+'</td>';
                    td += '<td>'+value.status+'</td>';
                    // td += '<td>'+newdate+'</td>';
                    if(value.nama_perusahaan != null){
                        td += '<td>'+value.nama_perusahaan+'</td>';
                    }else if(value.nama_sekolah != null){
                        td += '<td>'+value.nama_sekolah+'</td>';
                    }
                    td += '<td class="text-center">'+value.nama_sales+'<br>'+value.kode_sales+'</td>';
                    td += '<td class="text-center">'+tgl_penawaran+'<br>'+value.lama_penawaran+' hari'+'</td>';
                    if(today['_i'] == tgl_pen['_i']){
                        td += '<td class="text-center">H</td>';
                    }
                    else if(tgl_pen > today){
                        td += '<td class="text-center">H'+ today.diff(tgl_pen,'days')+'</td>';
                    }
                    else if(tgl_pen < today){
                        td += '<td class="text-center">H+'+ today.diff(tgl_pen,'days')+'</td>';
                    }
                    var total = value.total;
                    var bilangan = total;
                    var	number_string = bilangan.toString(),
                        sisa 	= number_string.length % 3,
                        rupiah 	= number_string.substr(0, sisa),
                        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    td += '<td>Rp '+rupiah+'</td>';
                    td += '<td class="text-center">W'+'</td>';
                    td += '<td class="text-center">S'+'</td>';
                    td += '<td class="text-center">B'+'</td>';
                    td += '<td class="text-center">';
                    td += '    <a href="/list/penawaran/edit/'+value.kode_penawaran+'" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-info" href="/preview/'+value.kode_penawaran+'")" target="_balnk"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-primary" href="/print/'+value.kode_penawaran+'")" target="_balnk"><i class="fa fa-print" aria-hidden="true"></i></a>';
                    @if(Session::get('role_id') == '1')
                    td += '    <button type="button" class="btn btn-danger" data-target="#hapus'+ value.kode_penawaran+'" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    @else
                    
                    @endif
                    td += '    <a class="btn btn-dark" href="#"><i class="fa fa-globe" aria-hidden="true"></i></a>';
                    td += '</td>';
                    td += '</tr>';
                }); 
                    td += '</tbody>';
                    td += '</table>';
                    $('#script_hapus').remove();
                    $('#table').remove();
                    $('#table_wrapper').remove();
                    $('#filter').remove();
                    $('#filter_wrapper').remove();
                    $('.filter').append(td);
                    $('#filter').DataTable({
                        'order' : [],
                        "scrollY":        "500px",
                        "scrollX":        true,
                    });
            },
            error: function (data) {
                // $.get("{{route('table.ttb')}}", function (data) {
                //     $('.filter').html(data);
                // });
                console.log('Error:', data);
            }
        });  
    });
} );
</script>

@endsection