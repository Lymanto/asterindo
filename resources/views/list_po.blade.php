@extends('main.index')

@section('title','List PO')

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
<h3 class="mx-auto judul-mobile" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Purchase Order</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Purchase Order</i></h3>
@endsection
@section('container')
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
                    <a class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/po">Go To Input PO</a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-bordered table-hover table-striped" id="table" width="100%">
                <thead>
                    <tr>
                        <th>No Urut<br>Tanggal<br>Kode PO</th>
                        <th>Status</th>
                        <th>Vendor</th>
                        <th>Sales</th>
                        <th>Perusahaan</th>
                        <th>Nilai PO</th>
                        <th>Re</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($supplier as $s)
                    <tr>
                        <td>{{substr($s->no_urut,3,6)}}<br>{{ date('d-m-Y',strtotime($s->tgl)) }}<br>{{$s->kode_po}}</td>
                        <td>{{ $s->status }}</td>
                        <td>{!!wordwrap($s->nama_perusahaan,15,"<br>\n")!!}</td>
                        <td>{{$s->nama}}</td>
                        <td>{!! wordwrap($s->perusahaan,15,"<br>\n")!!}</td>
                        <td>{{ "Rp " . str_replace(',','.',number_format($s->total)) }}</td>
                        <td>{!!wordwrap($s->re,30,"<br>\n")!!}</td>
                        <td>
                            <a href="/list/po/edit/{{ $s->kode_po }}" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info" onclick="window.open('/preview/po/{{$s->kode_po}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button><br>
                            <button type="button" class="btn btn-primary" onclick="window.open('/print/po/{{$s->kode_po}}');return false"><i class="fa fa-print" aria-hidden="true"></i></button>
                            @if(Session::get('role_id') == '1')
                            <button type="button" class="btn btn-danger" data-target="#hapus{{ $s->kode_po }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
@foreach($supplier as $s)
<div class="modal fade" id="hapus{{ $s->kode_po }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/list/po/delete" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $s->kode_po }}">
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
    $('.status').select2({
        placeholder: "-- Pilih --",
        allowClear: true,    
        theme: "bootstrap"
    });
    $('#table').DataTable({
        'order' : [],
        "scrollX":        true,
        "scrollY":        "500px",
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
            url:"{{route('filter.po')}}",
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
                td += '    <th>No Urut<br>Tanggal<br>Kode PO</br>';
                td += '    <th>Status</th>';
                td += '    <th>Vendor</th>';
                td += '    <th>Sales</th>';
                td += '    <th>Perusahaan</th>';
                td += '    <th>Nilai PO</th>';
                td += '    <th>Re</th>';
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
                    td += '<td>'+value.no_urut.substring(3,6)+'<br>'+newdate+'<br>'+value.kode_po+'</br>';
                    td += '<td>'+value.status['status']+'</td>';
                    td += '<td>'+wordWrap(value.vendor['nama_perusahaan'],15)+'</td>';
                    td += '<td>'+value.sales['nama']+'</td>';
                    td += '<td>'+wordWrap(value.perusahaan['nama_perusahaan'],15)+'</td>';
                    var total = 0;
                    $.each(value.barang,function(){
                        total += parseInt(this.total);
                    });
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
                    td += '<td>'+wordWrap(value.re,30)+'</td>';
                    td += '<td class="text-center">';
                    td += '    <a href="/list/po/edit/'+value.kode_po+'" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    td += '    <a class="btn btn-info" href="/preview/po/'+value.kode_po+'")" target="_balnk"><i class="fa fa-eye" aria-hidden="true"></i></a><br>';
                    td += '    <a class="btn btn-primary" href="/print/po/'+value.kode_po+'")" target="_balnk"><i class="fa fa-print" aria-hidden="true"></i></a>';
                    @if(Session::get('role_id') == '1')
                    td += '    <button type="button" class="btn btn-danger" data-target="#hapus'+ value.kode_po+'" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>';
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
} );
</script>
@endsection