@extends('main.index')
@section('title','Master Penawaran Kategori')

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
<div class="container">
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
        @if(\Session::has('alert'))
            <div class="alert alert-danger">
                {{ Session::get('alert') }}
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
        <div class="col-6">
            <div class="form-group">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah_status"><i class="fa fa-plus"></i> Status Perusahaan</button>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <button class="btn btn-info" data-toggle="modal" data-target="#tambah_payment"><i class="fa fa-plus"></i> Status Payment</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <ul class="list-group">
                <li class="list-group-item list-group-item-info ">
                    Status Perusahaan
                </li>
                @foreach($status as $s)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{$s->status_perusahaan}}
                    <a data-target="#hapus_status{{$s->id}}" data-toggle="modal">
                        <span class="badge badge-danger badge-pill">Hapus</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-6">
            <ul class="list-group">
                <li class="list-group-item list-group-item-info ">
                    Status Payment
                </li>
                @foreach($payment as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{$p->payment}}
                    <a data-target="#hapus_payment{{$p->id}}" data-toggle="modal">
                        <span class="badge badge-danger badge-pill">Hapus</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Status Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.kategori_status_tambah')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_perusahaan">Status Perusahaan</label>
                        <input type="text" name="status_perusahaan" id="status_perusahaan" class="form-control">
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
<div class="modal fade" id="tambah_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Status Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.kategori_payment_tambah')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment">Status Payment</label>
                        <input type="text" name="payment" id="payment" class="form-control">
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
@foreach($status as $s)
<div class="modal fade" id="hapus_status{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.kategori_status_hapus')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$s->id}}">
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
@foreach($payment as $p)
<div class="modal fade" id="hapus_payment{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('master_penawaran.kategori_payment_hapus')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$p->id}}">
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
    </script>
@endsection