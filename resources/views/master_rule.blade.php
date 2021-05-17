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
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.css')}}">
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
            <table class="table table-striped table-bordered table-hover" id="table">
                <thead>
                    <tr>
                        <th>Periode WSB</th>
                        <th>Masa Berlaku Penawaran</th>
                        <th>Prefik GPS NPSN</th>
                        <th>GMaps Prefix</th>
                        <th>GMaps Middle</th>
                        <th>GMaps Suffix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rule as $r)
                        <tr>
                            <td>{{$r->periode_wsb}}</td>
                            <td>{{$r->masa_berlaku_penawaran}}</td>
                            <td>{{$r->prefik_gps_npsn}}</td>
                            <td>{{$r->gmaps_prefix}}</td>
                            <td>{{$r->gmaps_middle}}</td>
                            <td>{{$r->gmaps_suffix}}</td>
                            <td>
                                <button class="btn btn-secondary" data-target="#edit{{$r->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" data-target="#delete{{$r->id}}" data-toggle="modal"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Tambah-->
<!-- <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.rule_tambah')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="periode_wsb">Periode WSB</label>
                        <input type="text" name="periode_wsb" id="periode_wsb" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="masa_berlaku_penawaran">Masa Berlaku Penawaran</label>
                        <input type="text" name="masa_berlaku_penawaran" id="masa_berlaku_penawaran" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prefik_gps_npsn">Prefik GPS NPSN</label>
                        <input type="text" name="prefik_gps_npsn" id="prefik_gps_npsn" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_prefix">GMaps Prefix</label>
                        <input type="text" name="gmaps_prefix" id="gmaps_prefix" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_middle">GMaps Middle</label>
                        <input type="text" name="gmaps_middle" id="gmaps_middle" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_suffix">GMaps Suffix</label>
                        <input type="text" name="gmaps_suffix" id="gmaps_suffix" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div> -->
@foreach($rule as $r)
<!-- Modal Edit -->
<div class="modal fade" id="edit{{$r->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Rule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.rule_edit')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$r->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="periode_wsb">Periode WSB</label>
                        <input type="text" name="periode_wsb" id="periode_wsb_edit" class="form-control" value="{{$r->periode_wsb}}" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="masa_berlaku_penawaran">Masa Berlaku Penawaran</label>
                        <input type="text" name="masa_berlaku_penawaran" id="masa_berlaku_penawaran" class="form-control" value="{{$r->masa_berlaku_penawaran}}">
                    </div>
                    <div class="form-group">
                        <label for="prefik_gps_npsn">Prefik GPS NPSN</label>
                        <input type="text" name="prefik_gps_npsn" id="prefik_gps_npsn" class="form-control" value="{{$r->prefik_gps_npsn}}">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_prefix">GMaps Prefix</label>
                        <input type="text" name="gmaps_prefix" id="gmaps_prefix" class="form-control" value="{{$r->gmaps_prefix}}">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_middle">GMaps Middle</label>
                        <input type="text" name="gmaps_middle" id="gmaps_middle" class="form-control" value="{{$r->gmaps_middle}}">
                    </div>
                    <div class="form-group">
                        <label for="gmaps_suffix">GMaps Suffix</label>
                        <input type="text" name="gmaps_suffix" id="gmaps_suffix" class="form-control" value="{{$r->gmaps_suffix}}">
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
<div class="modal fade" id="delete{{$r->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.rule_hapus')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$r->id}}">
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
<script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>
<script>
$(function() {
    $('#table').DataTable({
        'order' :[]
    });
    $("#periode_wsb").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: "true"
    });
    $("#periode_wsb_edit").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
        autoclose: "true"
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