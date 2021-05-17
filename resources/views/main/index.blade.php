<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/assets/datatables/DataTables-1.10.20/css/jquery.dataTables.min.css">
    @yield('css')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
  <div class="container">
    
    <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
      <span class="navbar-toggler-icon"></span>
    </button>
    @yield('judul_mobile')
    <div id="navbarContent" class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <!-- Level one dropdown -->
          <a href="/helpdesk" class="nav-link"><i class="fa fa-info-circle" style="font-size:30px;"></i></a>
          <a href="/home" class="nav-link"><i class="fa fa-home" style="font-size:30px;"></i></a>
        <li class="nav-item dropdown">
          <a id="dropdownMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Master</a>
          <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
            <!-- Level two dropdown-->
            
            <li class="dropdown-submenu" style="background-color:#ffdc34;">
              <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Paragraf</a>
              <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                <li>
                  <a tabindex="-1" href="/master/penawaran/paragraf" class="dropdown-item">Paragraf Penawaran</a>
                  <a tabindex="-1" href="/master/po/paragraf" class="dropdown-item">Paragraf PO</a>
                  <a tabindex="-1" href="{{route('paragraf_ttb')}}" class="dropdown-item">Paragraf TTB</a>
                </li>
              </ul>
            </li>
            <li style="background-color:#ffbbb4;">
                <a tabindex="-1" href="/master/perusahaan" class="dropdown-item">Perusahaan</a>
            </li>
            <li style="background-color:#ffbbb4;">
                <a tabindex="-1" href="/master/kode" class="dropdown-item">Sales</a>
            </li>
            <li style="background-color:#ffbbb4;">
                <a tabindex="-1" href="/master/bank" class="dropdown-item">Bank</a>
            </li>
            <li style="background-color:#deff8b;">
              <a tabindex="-1" href="/master/penawaran/pelanggan" class="dropdown-item">Nama Customer</a>
            </li>
            <li style="background-color:#deff8b;">
              <a tabindex="-1" href="/master/po/supplier" class="dropdown-item">Vendor</a>
            </li>
            <li style="background-color:#deff8b;">
                <a href="/master/ekspedisi" class="dropdown-item">Ekspedisi</a>
            </li>
            <li style="background-color:#deff8b;">
                <a tabindex="-1" href="/master/sekolah" class="dropdown-item">Sekolah</a>
            </li>
            <li style="background-color:#ffbbb4;">
              <a tabindex="-1" href="{{route('master_penawaran.rule')}}" class="dropdown-item">Rule</a>
            </li>
            <li style="background-color:#ffbbb4;">
              <a tabindex="-1" href="{{route('master_penawaran.kategori')}}" class="dropdown-item">Kategori</a>
            </li>
            <li style="background-color:#ffbbb4;">
              <a tabindex="-1" href="{{route('master_delete_data.index')}}" class="dropdown-item">Delete Data</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Input
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/penawaran">Input Penawaran</a>
                <a class="dropdown-item" href="/po">Input PO</a>
                <a class="dropdown-item" href="/po-sekolah">Input PO Sekolah</a>
                <a class="dropdown-item" href="/buku-ekspedisi">Input Buku Ekspedisi</a>
                <a class="dropdown-item" href="/tanda-terima-barang">Input Tanda Terima Barang</a>
                <a class="dropdown-item" href="/input-surat-jalan">Input Surat Jalan</a>
                <a class="dropdown-item" href="/helpdesk">Input Helpdesk</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            List
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/list/penawaran">Penawaran</a>
                <a class="dropdown-item" href="/list/po">PO</a>
                <a class="dropdown-item" href="/list/po-sekolah">PO Sekolah</a>
                <a class="dropdown-item" href="/list/buku-ekspedisi">Buku Ekspedisi</a>
                <a class="dropdown-item" href="/list/tanda-terima-barang">Tanda Terima Barang</a>
                <a class="dropdown-item" href="/list/surat-jalan">Surat Jalan</a>
                <a class="dropdown-item" href="/list/helpdesk">Helpdesk</a>
            </div>
        </li>
        @yield('peta-lokasi')
        @yield('wsb')
      </ul>
      @yield('judul')
      <a href="/logout">logout</a>
    </div>
  </div>
</nav>
@yield('container')
<script src="/assets/js/jqslim.js"></script>
<script src="/assets/js/popper.js"></script>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
@yield('js')
</body>
</html> 