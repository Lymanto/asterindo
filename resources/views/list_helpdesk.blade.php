@extends('main.index')

@section('title','Helpdesk')

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
    <div class="row">
        <div class="col-12">

        </div>
    </div>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap filter">
            <table class="table table-hover table-striped table-bordered" id="table" width="100%">
                <thead>
                    <tr>
                        <th>TGL<br>Jam</th>
                        <th>Status</th>
                        <th>Golongan</th>
                        <th>Nama<br>No HP</th>
                        <th>Berita<br>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($helpdesk as $h)
                    <tr>
                        <td>{!!wordwrap($h->created_at,10,"<br>")!!}</td>
                        <td>{{$h->status}}</td>
                        <td>
                            @if($h->golongan == "DLL")
                                {{$h->golongan_dll}}
                            @else
                                {{$h->golongan}}
                            @endif
                        </td>
                        <td>{{$h->nama}}<br>{{$h->no_hp}}</td>
                        <td>{{$h->berita}}<br>{{$h->note}}</td>
                        <td>
                            <a href="#" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @if(Session::get('role_id') == '1')
                            <button type="button" class="btn btn-danger" data-target="#hapus{{ $h->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
@endsection

@section('js')
<script>

$(function() {
    $('#table').DataTable({
        'order' : [],
        "scrollY":        "500px",
        "scrollX":        true,
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