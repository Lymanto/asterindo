@extends('main.index')

@section('title','List Buku Ekspedisi')

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
<h3 class="mx-auto judul-mobile" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Buku Ekspedisi</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#8f4426;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Buku Ekspedisi</i></h3>
@endsection
@section('container')
<div class="container-fluid">
    <div class="row my-3">
        <div class="col-4">
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
                        <option value="<=5" {{($filter['status'] == '<=5') ? 'selected' : ''}}>Kecuali 6 & 7</option>
                        <option value="<=4" {{($filter['status'] == '<=4') ? 'selected' : ''}}>Kecuali 5-7</option>
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
            <div class="col-3">
                <div class="form-group">
                    <label for="nama_pengirim">Nama Pengirim</label>
                    <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ekspedisi">Ekspedisi</label>
                    <input type="text" name="ekspedisi" id="ekspedisi" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary cari" type="submit">Cari</button>
                    <a class="btn btn-info" style="background-color:#ffdc34;color:black;border:none;" href="/buku-ekspedisi">Go To Input Buku Ekspedisi</a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-hover table-bordered table-striped" id="table" width="100%">
                <thead>
                    <tr>
                        <th scope="col">No Urut<br>TGL<br>Jam</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Nama<br>Ekspedisi</th>
                        <th scope="col" class="text-center">QTY<br>Coli</th>
                        <th scope="col">Nama Pengirim<br>No Telp<br>Alamat Pengirim<br>Kota Pengirim</th>
                        <th scope="col">Untuk</th>
                        <th scope="col" class="text-center">Penerima<br>Barang</th>
                        <th scope="col">No PO</th>
                        <th scope="col">Deskripsi Barang</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                @foreach($buku as $b)
                    <tr>
                        <td>{{ substr($b->no_urut,3,6) }}<br>{{ date('d-m-Y',strtotime($b->tgl)) }}<br>{{ date('H:i',strtotime($b->jam)) }}</td>
                        <td>{{ $b->status }}</td>
                        <td>{!! wordwrap($b->nama_ekspedisi,15,"<br>\n") !!}</td>
                        <td class="text-center">{{ $b->jumlah_coli }}</td>
                        <td>{{ $b->nama_pengirim }}<br>{{$b->no_telp_pengirim}}<br>{!! wordwrap($b->alamat_pengirim,30,"<br>\n") !!}<br>{{ $b->kota_pengirim }}</td>
                        <td>{{ ($b->untuk == 'DLL') ? $b->untuk_dll : $b->untuk }}</td>
                        <td>{{ $b->penerima_barang }}</td>
                        <td>{{ ($b->no_po == 'Isi') ? $b->no_po_dll : $b->no_po }}</td>
                        <td>{!! wordwrap($b->jenis_barang,35,"<br>\n") !!}</td>
                        <td>
                            <a class="btn btn-secondary mr-1" href="/list/buku-ekspedisi/edit/{{$b->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button><br>
                            <button type="button" class="btn btn-danger" data-target="#hapus{{ $b->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($buku as $b)
<div class="modal fade" id="hapus{{ $b->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('buku_ekspedisi.hapus')}}" method="post">
                <div class="modal-body">
                @csrf
                <input type="hidden" name="id" id="id" value="{{$b->id}}">
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
            url:"{{route('filter.buku_ekspedisi')}}",
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
                td += '<th scope="col">No Urut<br>TGL<br>Jam</th>';
                td += '<th scope="col">Status</th>';
                td += '<th scope="col" class="text-center">Nama<br>Ekspedisi</th>';
                td += '<th scope="col" class="text-center">QTY<br>Coli</th>';
                td += '<th scope="col">Nama Pengirim<br>No Telp<br>Alamat Pengirim<br>Kota Pengirim</th>';
                td += '<th scope="col">Untuk</th>';
                td += '<th scope="col" class="text-center">Penerima<br>Barang</th>';
                td += '<th scope="col">No PO</th>';
                td += '<th scope="col">Deskripsi Barang</th>';
                td += '<th scope="col">Action</th>';
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
                    td += '<td>'+value.no_urut.substring(3,6)+'<br>'+newdate+'<br>'+value.jam+'</td>';
                    td += '<td>'+value.status['status']+'</td>';
                    td += '<td>'+wordWrap(value.nama_ekspedisi,15)+'</td>';
                    td += '<td class="text-center">'+value.jumlah_coli+'</td>';
                    td += '<td>'+value.nama_pengirim+'<br>'+value.no_telp_pengirim+'<br>'+wordWrap(value.alamat_pengirim,30)+'<br>'+value.kota_pengirim+'</td>';
                    if(value.untuk == 'DLL'){
                        td += '<td>'+value.untuk_dll+'</td>';
                    }else{
                        td += '<td>'+value.untuk+'</td>';
                    }
                    td += '<td>'+value.penerima_barang+'</td>';
                    if(value.no_po == 'Isi'){
                        td += '<td>'+value.no_po_dll+'</td>';
                    }else{
                        td += '<td>'+value.no_po+'</td>';
                    }
                    td += '<td>'+wordWrap(value.jenis_barang,35)+'</td>';
                    td += '<td class="text-center">';
                    td += '    <a href="/list/buku-ekspedisi/edit/'+value.id+'" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    @if(Session::get('role_id') == '1')
                    td += '    <button type="button" class="btn btn-danger" data-target="#hapus'+ value.id+'" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>';
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