@extends('main.index')

@section('title','List Tanda Terima Barang')

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
<h3 class="mx-auto judul-mobile" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Tanda Terima Barang</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#151965;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Tanda Terima Barang</i></h3>
@endsection
@section('container')
<div class="container-fluid py-3">
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
                    <option value="<=6" {{($filter['status'] == "<=6") ? 'selected' : ''}}>Kecuali 7 & 8</option>
                    <option value="<=5" {{($filter['status'] == "<=5") ? 'selected' : ''}}>Kecuali 6-8</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="form-group">
                <label for="id_customer">Nama Perusahaan Customer</label>
                <select name="id_customer" id="id_customer" class="id_customer form-control">
                    <option></option>
                @foreach($customer as $c)
                    <option value="{{$c->id}}" {{($filter['id_customer'] == $c->id) ? 'selected' : ''}}>{{$c->nama_perusahaan}}</option>
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
                    <option value="{{$p->id}}" {{($filter['id_perusahaan'] == $p->id) ? 'selected' : ''}}>{{$p->nama_perusahaan}}</option>
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
                    <option value="{{$s->id}}" {{($filter['id_sales'] == $s->id) ? 'selected' : ''}}>{{$s->nama}}</option>
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
        <div class="col-sm-12 col-md-6 col-lg-1">
            <label for="tahun">Tahun</label>
            <input  type="text" pattern="\d*" name="tahun" id="tahun" class="form-control" minlength="4" maxlength="4" autocomplete="off" value="{{$filter['tahun']}}" required>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary cari" type="submit">Cari</button>
                <a class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/tanda-terima-barang">Go To Input Tanda Terima Barang</a>
            </div>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-hover table-striped table-bordered" id="table" width="100%">
                <thead>
                    <tr>
                        <th>No Urut<br>TGL<br>NO DO</th>
                        <th>Status</th>
                        <th>Nama Perusahaan Customer<br>Nama Penerima Barang</th>
                        <th>Nama Perusahaan</th>
                        <th>Nama Sales</th>
                        <th>Item <br>QTY BRG
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{substr($d->no_urut,3,6)}}<br>{{date('d-m-Y',strtotime($d->tgl))}}<br>{{$d->no_do}}</td>
                        <td>{{$d->status}}</td>
                        <td>
                            @if($d->id_customer == "Isi")
                                {{$d->nama_customer_isi}}
                            @else
                                {{$d->nama_customer}}
                            @endif
                            <br>
                            {{$d->nama_penerima}}
                        </td>
                        <td>
                            @if($d->id_perusahaan == "Isi")
                                {{$d->nama_perusahaan_isi}}
                            @else
                                {{$d->nama_perusahaan}}
                            @endif
                        </td>
                        <td>{{$d->nama}}</td>
                        <td>{{count($d->barang)}}<br>
                            <?php 
                                $sum = 0;
                                foreach($d->barang as $num => $values) {
                                    $sum += $values[ 'qty' ];
                                }
                            ?>
                            {{$sum}}
                            </td>
                        <td class="text-center">
                            <a href="/list/tanda-terima-barang/edit/{{ $d->no_do }}" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info" onclick="window.open('/preview/tanda-terima-barang/{{$d->no_do}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-primary" onclick="window.open('/print/tanda-terima-barang/{{$d->no_do}}');return false"><i class="fa fa-print" aria-hidden="true"></i></button><br>
                            @if(Session::get('role_id') == '1')
                            <button type="button" class="btn btn-danger" data-target="#hapus{{ $d->no_do }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            @else
                            
                            @endif
                            <a class="btn btn-dark" href="#"><i class="fa fa-globe" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($data as $d)
<div class="modal fade" id="hapus{{$d->no_do}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('list_ttb.hapus')}}" method="post">
      @csrf
      <input type="hidden" name="id" value="{{$d->id}}">
      <div class="modal-body">
        Yakin mau di hapus?
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
    $('.status,.id_customer,.id_perusahaan,.id_sales').select2({
        placeholder: "-- Pilih --",
        allowClear: true,
        theme: "bootstrap"
    });
    $('#table').DataTable({
        'order' : [],
        "scrollY":"500px",
        "scrollX":true,
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
        const tahun = $('#tahun').val();
        const formData ={
            status: status,
            id_perusahaan:id_perusahaan,
            id_customer:id_customer,
            id_sales:id_sales,
            tgl_awal:tgl_awal,
            tgl_akhir:tgl_akhir,
            tahun:tahun
        }
        $.ajax({
            url:"{{route('filter.tanda')}}",
            method:"POST",
            data:formData,
            dataType: 'json',
            // complete: function (data){
            //     // $.get("{{route('table.ttb')}}", function (data) {
            //     //     $('.filter').html(data);
            //     // });
            // },
            success: function (data) {
                // $.get("{{route('table.ttb')}}", function (data) {
                //     $('.filter').html(data);
                // });
                // $('.filter').html(data);
                let td = '<table class="table table-hover table-striped table-bordered filter" id="filter" width="100%">';
                td += '<thead>';
                td += '<tr>';
                td += '    <th>No Urut<br>TGL<br>NO DO</th>';
                td += '    <th>Status</th>';
                td += '    <th>Nama Perusahaan Customer<br>Nama Penerima Barang</th>';
                td += '    <th>Nama Perusahaan</th>';
                td += '    <th>Nama Sales</th>';
                td += '    <th>Item<br>QTY BRG</th>';
                td += '    <th class="text-center">Action</th>';
                td += '</tr>';
                td += '</thead>';
                td += '<tbody>';
                $.each(data,function (key,value){
                    var date= value.tgl;
                    var d=new Date(date.split("/").reverse().join("-"));
                    var dd=d.getDate();
                    var mm=d.getMonth()+1;
                    var yy=d.getFullYear();
                    var newdate=dd+"-"+mm+"-"+yy;
                    td += '<tr>';
                    td += '<td>'+value.no_urut.substring(3,6)+'<br>'+newdate+'<br>'+value.no_do+'</td>';
                    td += '<td>'+value.status+'</td>';
                    if(value.id_customer != 'Isi'){
                        td += '<td>'+value.nama_customer+'<br>'+value.nama_penerima+'</td>';
                    }else{
                        td += '<td>'+value.nama_customer_isi+'<br>'+value.nama_penerima+'</td>';
                    }
                    if(value.id_perusahaan != 'Isi'){
                        td += '<td>'+value.nama_perusahaan+'</td>';
                    }else{
                        td += '<td>'+value.nama_perusahaan_isi+'</td>';
                    }
                    td += '<td>'+value.nama+'</td>';
                    let sum = 0;
                    $.each(value.barang,function(a,nilai){
                        sum += nilai['qty'];
                    });
                    td += '<td>'+value.barang.length+'<br>'+sum+'</td>';
                    td += '<td class="text-center">';
                    td += '    <a href="/list/tanda-terima-barang/edit/'+value.no_do+'" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-info" href="/preview/tanda-terima-barang/'+value.no_do+'")" target="_balnk"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-primary" href="/print/tanda-terima-barang/'+value.no_do+'")" target="_balnk"><i class="fa fa-print" aria-hidden="true"></i></a><br>';
                    @if(Session::get('role_id') == '1')
                    td += '    <button type="button" class="btn btn-danger" data-target="#hapus'+ value.no_do+'" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    @else
                    
                    @endif
                    td += '    <a class="btn btn-dark" href="#"><i class="fa fa-globe" aria-hidden="true"></i></a>';
                    td += '</td>';
                    td += '</tr>';
                }); 
                    td += '</tbody>';
                    td += '</table>';
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
});
</script>
@endsection