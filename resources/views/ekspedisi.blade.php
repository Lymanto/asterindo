@extends('main.index')

@section('title','Master Ekspedisi')

@section('css')<style>
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
    <div class="row my-3">
        <div class="col-12">
            <button class="btn btn-primary" data-target="#tambah" data-toggle="modal">Tambah Ekspedisi</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-hover table-bordered table-striped" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ekspedisi</th>
                        <th>Alamat</th>
                        <th>Nama Admin<br>No Telp Admin<br>No HP Admin</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($ekspedisi as $e)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td><a href="{{route('master_ekspedisi.memo',"$e->id")}}" target="_blank">{{ $e->ekspedisi }}</a></td>
                        <td>{!! wordwrap($e->alamat,20,"<br>") !!}</td>
                        <td>{{ $e->nama_pic }}<br>{{ $e->no_telp }}<br>{{ $e->no_hp }}</td>
                        <td>{{ $e->email }}</td>
                        <td>
                            <button class="btn btn-primary" data-target="#edit{{ $e->id }}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-info"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-danger" data-target="#delete{{ $e->id }}" data-toggle="modal"><i class="fa fa-trash"></i></button>
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
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/ekspedisi/tambah" method="post">
        @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="ekspedisi">Nama Ekspedisi (*)</label>
                    <input type="text" class="form-control" id="ekspedisi" name="ekspedisi" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp</label><br>
                    <input type="text" class="form-control" id="no_telp" name="no_telp">
                </div>
                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp">
                </div>
                <div class="form-group">
                    <label for="nama_pic">Nama PIC</label>
                    <input type="text" class="form-control" id="nama_pic" name="nama_pic">
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="nama_pic_gudang">Nama PIC Gudang</label>
                    <input type="text" class="form-control" id="nama_pic_gudang" name="nama_pic_gudang">
                </div>
                <div class="form-group">
                    <label for="no_telp_gudang">No Telp Gudang</label>
                    <input type="text" class="form-control" id="no_telp_gudang" name="no_telp_gudang">
                </div>
                <div class="form-group">
                    <label for="no_hp_gudang">No HP Gudang</label>
                    <input type="text" class="form-control" id="no_hp_gudang" name="no_hp_gudang">
                </div>
                <div class="form-group">
                    <label for="nama_keuangan">Nama Keuangan</label>
                    <input type="text" class="form-control" id="nama_keuangan" name="nama_keuangan">
                </div>
                <div class="form-group">
                    <label for="no_telp_keuangan">No Telp keuangan</label>
                    <input type="text" class="form-control" id="no_telp_keuangan" name="no_telp_keuangan">
                </div>
                <div class="form-group">
                    <label for="no_hp_keuangan">No HP keuangan</label>
                    <input type="text" class="form-control" id="no_hp_keuangan" name="no_hp_keuangan">
                </div>
                <div class="form-group">
                    <label for="nama_kurir">Nama kurir</label>
                    <input type="text" class="form-control" id="nama_kurir" name="nama_kurir">
                </div>
                <div class="form-group">
                    <label for="no_telp_kurir">No Telp kurir</label>
                    <input type="text" class="form-control" id="no_telp_kurir" name="no_telp_kurir">
                </div>
                <div class="form-group">
                    <label for="no_hp_kurir">No HP kurir</label>
                    <input type="text" class="form-control" id="no_hp_kurir" name="no_hp_kurir">
                </div>
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <textarea class="form-control" id="memo" name="memo" cols="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>
@foreach($ekspedisi as $e)
<div class="modal fade" id="edit{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/ekspedisi/edit" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $e->id }}">
            <div class="modal-body">
                <div class="form-group">
                    <label for="ekspedisi">Nama Ekspedisi</label>
                    <input type="text" class="form-control" id="ekspedisi" name="ekspedisi" value="{{ $e->ekspedisi }}">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $e->alamat }}">
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp</label><br>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $e->no_telp }}">
                </div>
                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $e->no_hp }}">
                </div>
                <div class="form-group">
                    <label for="nama_pic">Nama PIC</label>
                    <input type="text" class="form-control" id="nama_pic" name="nama_pic" value="{{ $e->nama_pic }}">
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $e->email }}">
                </div>
                <div class="form-group">
                    <label for="nama_pic_gudang">Nama PIC Gudang</label>
                    <input type="text" class="form-control" id="nama_pic_gudang" name="nama_pic_gudang" value="{{$e->nama_pic_gudang}}">
                </div>
                <div class="form-group">
                    <label for="no_telp_gudang">No Telp Gudang</label>
                    <input type="text" class="form-control" id="no_telp_gudang" name="no_telp_gudang" value="{{$e->no_telp_gudang}}">
                </div>
                <div class="form-group">
                    <label for="no_hp_gudang">No HP Gudang</label>
                    <input type="text" class="form-control" id="no_hp_gudang" name="no_hp_gudang" value="{{$e->no_hp_gudang}}">
                </div>
                <div class="form-group">
                    <label for="nama_keuangan">Nama Keuangan</label>
                    <input type="text" class="form-control" id="nama_keuangan" name="nama_keuangan" value="{{$e->nama_keuangan}}">
                </div>
                <div class="form-group">
                    <label for="no_telp_keuangan">No Telp keuangan</label>
                    <input type="text" class="form-control" id="no_telp_keuangan" name="no_telp_keuangan" value="{{$e->no_telp_keuangan}}">
                </div>
                <div class="form-group">
                    <label for="no_hp_keuangan">No HP keuangan</label>
                    <input type="text" class="form-control" id="no_hp_keuangan" name="no_hp_keuangan" value="{{$e->no_hp_keuangan}}">
                </div>
                <div class="form-group">
                    <label for="nama_kurir">Nama kurir</label>
                    <input type="text" class="form-control" id="nama_kurir" name="nama_kurir" value="{{$e->nama_kurir}}">
                </div>
                <div class="form-group">
                    <label for="no_telp_kurir">No Telp kurir</label>
                    <input type="text" class="form-control" id="no_telp_kurir" name="no_telp_kurir" value="{{$e->no_telp_kurir}}">
                </div>
                <div class="form-group">
                    <label for="no_hp_kurir">No HP kurir</label>
                    <input type="text" class="form-control" id="no_hp_kurir" name="no_hp_kurir" value="{{$e->no_hp_kurir}}">
                </div>
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <textarea class="form-control" id="memo" name="memo" cols="2">{{ $e->Memo }}</textarea>
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
<div class="modal fade" id="delete{{ $e->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/ekspedisi/hapus" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $e->id }}">
            <div class="modal-body">
                Yakin Mau dihapus?
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
<script>
$(function() {
    $('#table').DataTable({
        'order':[]
    });
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