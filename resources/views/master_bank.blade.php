@extends('main.index')

@section('title','Master Rule')

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
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah">Tambah Bank</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover" id="table">
                <thead>
                    <tr>
                        <th>Nama Bank<br>No Telp</th>
                        <th>Cabang Rekening<br>Jenis Tabungan</th>
                        <th>Nama Rekening</th>
                        <th>Nomor Rekening</th>
                        <th>Nama CS 1<br>No Telp</th>
                        <th>Nama CS 2<br>No Telp</th>
                        <th>Nama Teller 1<br>No Telp</th>
                        <th>Nama Teller 2<br>No Telp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bank as $b)
                        <tr>
                            <td>{{$b->nama_bank}}<br>{{$b->nomor_telp_bank}}</td>
                            <td>{{$b->cabang_bank}}<br>{{$b->jenis_tabungan}}</td>
                            <td>{{$b->nama_rekening}}</td>
                            <td>{{$b->nomor_rekening}}</td>
                            <td>{{$b->pic_bank}}<br>{{$b->nomor_hp_pic}}</td>
                            <td>{{$b->nama_cs2}}<br>{{$b->no_telp_cs2}}</td>
                            <td>{{$b->nama_teller1}}<br>{{$b->no_telp_teller1}}</td>
                            <td>{{$b->nama_teller2}}<br>{{$b->no_telp_teller2}}</td>
                            <td>
                                <button class="btn btn-secondary" data-target="#edit{{$b->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" data-target="#delete{{$b->id}}" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Tambah-->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_bank.tambah')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_bank">Nama Bank (*)</label>
                        <input type="text" name="nama_bank" id="nama_bank" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_rekening">Nama Rekening (*)</label>
                        <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekening">Nomor Rekening (*)</label>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_tabungan">Jenis Tabungan</label>
                        <input type="text" name="jenis_tabungan" id="jenis_tabungan" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="cabang_bank">Cabang Rekening</label>
                        <input type="text" name="cabang_bank" id="cabang_bank" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="nomor_telp_bank">Nomor Telp Bank</label>
                        <input type="text" name="nomor_telp_bank" id="nomor_telp_bank" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="alamat_bank">Alamat Bank</label>
                        <textarea name="alamat_bank" id="alamat_bank" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pic_bank">Nama CS 1</label>
                        <input type="text" name="pic_bank" id="pic_bank" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="nomor_hp_pic">Nomor HP CS 1</label>
                        <input type="text" name="nomor_hp_pic" id="nomor_hp_pic" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="nama_cs2">Nama CS 2</label>
                        <input type="text" name="nama_cs2" id="nama_cs2" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="no_telp_cs2">Nomor HP CS 2</label>
                        <input type="text" name="no_telp_cs2" id="no_telp_cs2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_teller1">Nama Teller 1</label>
                        <input type="text" name="nama_teller1" id="nama_teller1" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="no_telp_teller1">Nomor HP Teller 1</label>
                        <input type="text" name="no_telp_teller1" id="no_telp_teller1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_teller2">Nama Teller 2</label>
                        <input type="text" name="nama_teller2" id="nama_teller2" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="no_telp_teller2">Nomor HP Teller 2</label>
                        <input type="text" name="no_telp_teller2" id="no_telp_teller2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gambar">Foto Rekening</label>
                        <input type="file" name="gambar" id="gambar">
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
@foreach($bank as $b)
<!-- Modal Edit -->
<div class="modal fade" id="edit{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_bank.edit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$b->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_bank">Nama Bank (*)</label>
                        <input type="text" name="nama_bank" id="nama_bank" class="form-control" required value="{{$b->nama_bank}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_rekening">Nama Rekening (*)</label>
                        <input type="text" name="nama_rekening" id="nama_rekening" class="form-control" required value="{{$b->nama_rekening}}">
                    </div>
                    <div class="form-group">
                        <label for="nomor_rekening">Nomor Rekening (*)</label>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" required value="{{$b->nomor_rekening}}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_tabungan">Jenis Tabungan</label>
                        <input type="text" name="jenis_tabungan" id="jenis_tabungan" class="form-control" value="{{$b->jenis_tabungan}}">
                    </div>
                    <div class="form-group">
                        <label for="cabang_bank">Cabang Rekening</label>
                        <input type="text" name="cabang_bank" id="cabang_bank" class="form-control" value="{{$b->cabang_bank}}">
                    </div>
                    <div class="form-group">
                        <label for="nomor_telp_bank">Nomor Telp Bank</label>
                        <input type="text" name="nomor_telp_bank" id="nomor_telp_bank" class="form-control" value="{{$b->nomor_telp_bank}}">
                    </div>
                    <div class="form-group">
                        <label for="alamat_bank">Alamat Bank</label>
                        <textarea name="alamat_bank" id="alamat_bank" class="form-control">{{$b->alamat_bank}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="pic_bank">Nama CS 1</label>
                        <input type="text" name="pic_bank" id="pic_bank" class="form-control" value="{{$b->pic_bank}}">
                    </div>
                    <div class="form-group">
                        <label for="nomor_hp_pic">Nomor HP CS 1</label>
                        <input type="text" name="nomor_hp_pic" id="nomor_hp_pic" class="form-control" value="{{$b->nomor_hp_pic}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_cs2">Nama CS 2</label>
                        <input type="text" name="nama_cs2" id="nama_cs2" class="form-control" value="{{$b->nama_cs2}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp_cs2">Nomor HP CS 2</label>
                        <input type="text" name="no_telp_cs2" id="no_telp_cs2" class="form-control" value="{{$b->no_telp_cs2}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_teller1">Nama Teller 1</label>
                        <input type="text" name="nama_teller1" id="nama_teller1" class="form-control" value="{{$b->nama_teller1}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp_teller1">Nomor HP Teller 1</label>
                        <input type="text" name="no_telp_teller1" id="no_telp_teller1" class="form-control" value="{{$b->no_telp_teller1}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_teller2">Nama Teller 2</label>
                        <input type="text" name="nama_teller2" id="nama_teller2" class="form-control" value="{{$b->nama_teller2}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp_teller2">Nomor HP Teller 2</label>
                        <input type="text" name="no_telp_teller2" id="no_telp_teller2" class="form-control" value="{{$b->no_telp_teller2}}">
                    </div>
                    <div class="form-group">
                        <label for="gambar">Foto Rekening</label>
                        <input type="file" name="gambar" id="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Hapus -->
<div class="modal fade" id="delete{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_bank.hapus')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$b->id}}">
                <div class="modal-body">
                    Yakin mau dihapus
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
<div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.rule_hapus_semua')}}" method="post">
                @csrf
                <div class="modal-body">
                    Yakin mau dihapus
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yakin</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
});
$(document).ready( function () {
    $('#table').DataTable({
        order:[]
    });
    
});
</script>
@endsection