@extends('main.index')

@section('title','Master Perusahaan')

@section('css')
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
    </style>
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
    <div class="row my-2">
        <div class="col-12">
            <button class="btn btn-primary" data-target="#tambah" data-toggle="modal">Tambah Perusahaan</button>
        </div>  
    </div>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap">
            <table class="table table-bordered table-hover table-striped" id="table">
                <thead>
                    <tr>
                        <td scope="col" class="text-center">No</td>
                        <td scope="col">Nama Perusahaan</td>
                        <td scope="col">Npwp</td>
                        <td scope="col">Email</td>
                        <td scope="col">Alamat</td>
                        <td scope="col">Telp</td>
                        <td scope="col"class="text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($perusahaan as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_perusahaan }}</td>
                        <td style="width:200px;"><img src="/assets/images/upload/npwp/{{ $p->npwp }}" width="100%"></td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->telp }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary" data-target="#edit{{ $p->id }}" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button class="btn btn-danger" data-target="#hapus{{ $p->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button> 
                            <button type="button" class="btn btn-secondary" onclick="window.open('/master/perusahaan/view/{{$p->kode_perusahaan}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="/master/perusahaan/tambah" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_perusahaan">Kode Perusahaan</label>
                        <input type="text" name="kode_perusahaan" id="kode_perusahaan" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" maxlength="1" required />
                        <div id="kode_perusahaan_list"></div>
                    </div>
                    <div class="form-group">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" />
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label><br>
                        <input type="file" name="npwp" id="npwp" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" />
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nama_kota">Nama Kota</label>
                        <input type="text" class="form-control" name="nama_kota" id="nama_kota">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No telp</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp">
                    </div>
                    <div class="form-group">
                        <label for="logo">logo</label><br>
                        <input type="file" name="logo" id="logo" />
                    </div>
                    <div class="form-group">
                        <label for="kop_surat">Kop Surat</label><br>
                        <input type="file" name="kop_surat" id="kop_surat" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($perusahaan as $p)
<div class="modal fade" id="edit{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="/master/perusahaan/edit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $p->id }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_perusahaan_edit{{$p->id}}">Kode Perusahaan</label>
                        @if(Session::get('role_id') == '1')
                            <input type="text" name="kode_perusahaan" id="perusahaan_edit{{$p->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $p->kode_perusahaan }}" maxlength="1" />                
                        @else 
                            <input type="text" name="kode_perusahaan" id="perusahaan_edit{{$p->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $p->kode_perusahaan }}" disabled />                
                        @endif
                        <div id="perusahaan_list_edit{{$p->id}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="{{$p->nama_perusahaan}}" >
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label><br>
                        <input type="file" name="npwp" id="npwp" />
                        <input type="hidden" name="hidden_npwp" id="npwp" value="{{$p->npwp}}" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{$p->email}}" />
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat">{{$p->alamat}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="nama_kota">Nama Kota</label>
                        <input type="text" class="form-control" name="nama_kota" id="nama_kota" value="{{$p->nama_kota}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No telp</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{$p->telp}}">
                    </div>
                    <div class="form-group">
                        <label for="logo">logo</label><br>
                        <input type="file" name="logo" id="logo" />
                        <input type="hidden" name="hidden_logo" id="logo" value="{{ $p->logo }}" />
                    </div>
                    <div class="form-group">
                        <label for="kop_surat">Kop Surat</label><br>
                        <input type="file" name="kop_surat" id="kop_surat" />
                        <input type="hidden" name="hidden_kop_surat" id="kop_surat" value="{{ $p->kop_surat }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <form action="/master/perusahaan/hapus" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $p->id }}" />
                <div class="modal-body">
                    Yakin mau dihapus?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-danger">Yakin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('js')
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
    $(document).ready( function () {
        $('#table').DataTable();  
    });
});
</script>
<script>
$(document).ready(function(){

 $('#kode_perusahaan').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('perusahaan.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#kode_perusahaan_list').fadeIn();  
            $('#kode_perusahaan_list').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#kode_perusahaan').val($(this).text());  
        $('#kode_perusahaan_list').fadeOut();  
    });  

});
</script>
@foreach($perusahaan as $p)
<script>
$(document).ready(function(){

 $('#perusahaan_edit{{$p->id}}').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('perusahaan.fetch_edit') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#perusahaan_list_edit{{$p->id}}').fadeIn();  
            $('#perusahaan_list_edit{{$p->id}}').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#perusahaan_edit{{$p->id}}').val($(this).text());  
        $('#perusahaan_list_edit{{$p->id}}').fadeOut();  
    });  

});
</script>
@endforeach
@endsection