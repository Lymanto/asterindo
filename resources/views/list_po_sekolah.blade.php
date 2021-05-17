@extends('main.index')

@section('title','List PO Sekolah')

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
<h3 class="mx-auto judul-mobile" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>List PO Sekolah</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#617be3;color:#fff;border-radius:3px;padding:0px 10px;"><i>List PO Sekolah</i></h3>
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
                        <option value="<=11" {{($filter['status'] == '<=11') ? 'selected' : ''}}>Kecuali 12 & 13</option>
                        <option value="<=10" {{($filter['status'] == '<=10') ? 'selected' : ''}}>Kecuali 11-13</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-1">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input  type="text" pattern="\d*" name="tahun" id="tahun" class="form-control" minlength="4" maxlength="4" autocomplete="off" value="{{ $filter['tahun'] }}" required>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3">
                <div class="form-group">
                    <label for="tgl">TGL</label>
                    <div class="d-flex flex-row">
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="{{$filter->tgl_awal}}">
                        <div class="align-self-center mx-2">S/D</div>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{$filter->tgl_akhir}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary cari" type="submit">Cari</button>
                    <a class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/po-sekolah">Go To Input PO Sekolah</a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-striped table-bordered table-hover" id="table" width="100%">
                <thead>
                    <tr>
                        <th>No Urut<br>TGL Order<br>TGL Lunas<br>No PO</th>
                        <th>Status<br>Bank</th>
                        <th>NPSN - Nama Sekolah<br>Alamat<br>Judul Project</th>
                        <th>Nama Kepala Sekolah<br>No HP KepSek<br>Nama Bendahara<br>No HP Bend</th>
                        <th>Grand Total</th>
                        <th>Uang Terima</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{!! substr($d->no_urut,3,6) !!}<br>{!! date('d-m-Y',strtotime($d->tgl)) !!}<br>@if($d->tgl_lunas != ''){!! date('d-m-Y',strtotime($d->tgl_lunas)) !!}@else @endif<br>{!! $d->kode !!}</td>
                        <td>{{$d->status}}<br>{{$d->nama_bank}}</td>
                        <td>{!! $d->npsn !!} - {!! $d->nama_sekolah !!}<br />{!! wordwrap($d->alamat_sekolah,40,"<br>\n") !!}<br>{!! wordWrap($d->judul_project,40,"<br>\n") !!}</td>
                        <td>{!! $d->kepala_sekolah !!}<br>{!! $d->no_hp !!}<br>{!! $d->bendahara !!}<br>{!! $d->no_telp_bendahara !!}</td>
                        <td>{!! 'Rp' . ' ' . str_replace(',','.',number_format($d->grandtotal)) !!}</td>
                        <td>{!! 'Rp' . ' ' . str_replace(',','.',number_format($d->jumlah_uang_terima)) !!}</td>
                        <td>
                            <a href="/list/po-sekolah/edit/{{ $d->kode }}" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info" onclick="window.open('/preview/po-sekolah/{{$d->kode}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button><br>
                            <button type="button" class="btn btn-primary" onclick="window.open('/print/po-sekolah/{{$d->kode}}');return false"><i class="fa fa-print" aria-hidden="true"></i></button>
                            @if(Session::get('role_id') == '1')
                            <button type="button" class="btn btn-danger" data-target="#hapus{{ $d->kode }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            @else
                            
                            @endif
                        </td>
                    </tr>
                      
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($data as $d)
<div class="modal fade" id="hapus{{$d->kode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('po_sekolah.hapus')}}" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @csrf
          <input type="hidden" name="kode" id="kode" value="{{$d->kode}}">
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
    $('.status').select2({
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
        const tgl_awal = $('#tgl_awal').val();
        const tgl_akhir = $('#tgl_akhir').val();
        const tahun = $('#tahun').val();
        const formData ={
            status: status,
            tgl_awal:tgl_awal,
            tgl_akhir:tgl_akhir,
            tahun:tahun
        }
        $.ajax({
            url:"{{route('filter.po_sekolah')}}",
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
                td += '    <th>No Urut<br>TGL Order <br>TGL Lunas<br>No PO</th>';
                td += '    <th>Status<br>Bank</th>';
                td += '    <th>NPSN - Nama Sekolah<br>Alamat<br>Judul Project</th>';
                td += '    <th>Nama Kepala Sekolah<br>No HP KepSek<br>Nama Bendahara<br>No HP Bend</th>';
                td += '    <th>Grand Total</th>';
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
                    var tgl_lunas = '';
                    if(value.tgl_lunas != null){
                      tgl_lunas = value.tgl_lunas;
                      var d_tgl_lunas=new Date(tgl_lunas.split("/").reverse().join("-"));
                      var dd_tgl_lunas=d_tgl_lunas.getDate();
                      var mm_tgl_lunas=d_tgl_lunas.getMonth()+1;
                      var yy_tgl_lunas=d_tgl_lunas.getFullYear();
                      tgl_lunas = dd_tgl_lunas+"-"+mm_tgl_lunas+"-"+yy_tgl_lunas;
                    }
                    td += '<tr>';
                    td += '<td>'+value.no_urut.substring(3,6)+'<br>'+newdate+'<br>'+tgl_lunas+'<br>'+value.kode+'</td>';
                    td += '<td>'+value.status['status']+'<br>'+value.bank['nama_bank']+'</td>';
                    td += '<td>'+value.sekolah['npsn']+'-'+value.sekolah['nama_sekolah']+'<br>'+wordWrap(value.alamat_pengiriman,40)+'<br>'+wordWrap(value.judul_project,40)+'</td>';
                    td += '<td>'+value.sekolah['kepala_sekolah']+'</br>'+value.sekolah['no_hp']+'<br>'+value.sekolah['bendahara']+'</br>'+value.sekolah['no_telp_bendahara']+'</td>';
                    var bilangan = value.grandtotal;
                    var	number_string = bilangan.toString(),
                        sisa 	= number_string.length % 3,
                        rupiah 	= number_string.substr(0, sisa),
                        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                            
                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    td += '<td>Rp '+rupiah+'</td>';
                    td += '<td class="text-center">';
                    td += '    <a href="/list/po-sekolah/edit/'+value.kode+'" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-info" href="/preview/po-sekolah/'+value.kode+'")" target="_balnk"><i class="fa fa-eye" aria-hidden="true"></i></a><br>';
                    td += '    <a class="btn btn-primary" href="/print/po-sekolah/'+value.kode+'")" target="_balnk"><i class="fa fa-print" aria-hidden="true"></i></a>';
                    @if(Session::get('role_id') == '1')
                    td += '    <button type="button" class="btn btn-danger" data-target="#hapus'+ value.kode+'" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    @else
                    
                    @endif
                    td += '</td>';
                    td += '</tr>';
                }); 
                    td += '</tbody>';
                    td += '</table>';
                    function wordWrap(str, maxWidth) {
                        var newLineStr = "<br>"; done = false; res = '';
                        while (str.length > maxWidth) {                 
                            found = false;
                            // Inserts new line at first whitespace of the line
                            for (i = maxWidth - 1; i >= 0; i--) {
                                if (testWhite(str.charAt(i))) {
                                    res = res + [str.slice(0, i), newLineStr].join('');
                                    str = str.slice(i + 1);
                                    found = true;
                                    break;
                                }
                            }
                            // Inserts new line at maxWidth position, the word is too long to wrap
                            if (!found) {
                                res += [str.slice(0, maxWidth), newLineStr].join('');
                                str = str.slice(maxWidth);
                            }

                        }

                        return res + str;
                    }

                    function testWhite(x) {
                        var white = new RegExp(/^\s$/);
                        return white.test(x.charAt(0));
                    };
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