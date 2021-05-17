@extends('main.index')

@section('title','Detail Sales')

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
        <div class="col-12 ">
            <div class="card">
                <div class="card-header">
                    Detail
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $kode['kode_po'] }} - {{ $kode['nama'] }}</h5>
                    <p>Nama Perusahaan: {{ $kode['nama_perusahaan'] }}</p>
                    <p>Jabatan: {{ $kode['jabatan'] }}</p>
                    <p>NIP Sales: {{ $kode['nip_sales'] }}</p>
                    <p>Golongan Darah: {{ $kode['gol'] }}</p>
                    <p>No HP: {{ $kode['no_hp'] }}</p>
                    <p>Nama Saudara: {{ $kode['nama_saudara'] }}</p>
                    <p>No HP Saudara: {{ $kode['no_hp_saudara'] }}</p>
                    <p>Email: {{ $kode['email'] }}</p>
                    <p>Memo: {{ $kode['memo'] }}</p>
                    <p>TTD: <img src="/assets/images/upload/ttd/{{ $kode['ttd'] }}"></p>
                </div>
            </div>
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
    $('#table').DataTable();
    
});
</script>
@endsection