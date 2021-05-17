@extends('main.index')

@section('title','Detail Sekolah')

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
                    <h5 class="card-title">{{ $sekolah['npsn'] }} - {{ $sekolah['nama_sekolah'] }}</h5>
                    <p>Alamat: {{ $sekolah['alamat_sekolah'] }}</p>
                    <p>Kecamatan: {{ $sekolah['kecamatan'] }}</p>
                    <p>NPWP Sekolah: {{ $sekolah['npwp_sekolah'] }}</p>
                    <p>Nama Kepala Sekolah: {{ $sekolah['kepala_sekolah'] }}</p>
                    <p>NIP Kepala Sekolah: {{ $sekolah['nip_kepala_sekolah'] }}</p>
                    <p>Jenis Kelamin KepSek: @if($sekolah['kelamin_kepala_sekolah'] == 1) Laki-laki @elseif($sekolah['kelamin_kepala_sekolah'] == 2) Perempuan @endif</p>
                    <p>Email KepSek: {{ $sekolah['email_kepala_sekolah'] }}</p>
                    <p>No HP: {{ $sekolah['no_hp'] }}</p>
                    <p>No Telp: {{ $sekolah['no_telp'] }}</p>
                    <p>Bendahara: {{ $sekolah['bendahara'] }}</p>
                    <p>NIP Bendahara: {{ $sekolah['nip_bendahara'] }}</p>
                    <p>Jenis Kelamin Bendahara: @if($sekolah['kelamin_bendahara'] == 1) Laki-laki @elseif($sekolah['kelamin_bendahara'] == 2) Perempuan @endif</p>
                    <p>Email Bendahara: {{ $sekolah['email_bendahara'] }}</p>
                    <p>No Telp Bendahara: {{ $sekolah['no_telp_bendahara'] }}</p>
                    <p>Nama Operator: {{ $sekolah['nama_operator'] }}</p>
                    <p>Jenis Kelamin Operator: @if($sekolah['kelamin_operator'] == 1) Laki-laki @elseif($sekolah['kelamin_operator'] == 2) Perempuan @endif</p>
                    <p>Email Operator: {{ $sekolah['email_operator'] }}</p>
                    <p>No Telp Operator: {{ $sekolah['no_telp_operator'] }}</p>
                    <p>Guru 1: {{ $sekolah['guru1'] }}</p>
                    <p>Jenis Kelamin Guru 1: @if($sekolah['kelamin_guru1'] == 1) Laki-laki @elseif($sekolah['kelamin_guru1'] == 2) Perempuan @endif</p>
                    <p>Email Guru 1: {{ $sekolah['email_guru1'] }}</p>
                    <p>No Telp Guru 1: {{ $sekolah['no_telp_guru1'] }}</p>
                    <p>Guru 2: {{ $sekolah['guru2'] }}</p>
                    <p>Jenis Kelamin Guru 2: @if($sekolah['kelamin_guru2'] == 1) Laki-laki @elseif($sekolah['kelamin_guru2'] == 2) Perempuan @endif</p>
                    <p>Email Guru 2: {{ $sekolah['email_guru2'] }}</p>
                    <p>No Telp Guru 2: {{ $sekolah['no_telp_guru2'] }}</p>
                    <p>Guru 3: {{ $sekolah['guru3'] }}</p>
                    <p>Jenis Kelamin Guru 3: @if($sekolah['kelamin_guru3'] == 1) Laki-laki @elseif($sekolah['kelamin_guru3'] == 2) Perempuan @endif</p>
                    <p>Email Guru 3: {{ $sekolah['email_guru3'] }}</p>
                    <p>No Telp Guru 3: {{ $sekolah['no_telp_guru3'] }}</p>
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