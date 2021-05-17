<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font/css/font-awesome.min.css">
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
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
  <div class="container">
    
    <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
              <span class="navbar-toggler-icon"></span>
          </button>
    <div id="navbarContent" class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <!-- Level one dropdown -->
        <li class="nav-item dropdown">
          <a id="dropdownMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Master</a>
          <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
            <!-- Level two dropdown-->
            <li class="dropdown-submenu">
              <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Penawaran</a>
              <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                <li>
                  <a tabindex="-1" href="/master/penawaran/paragraf" class="dropdown-item">Paragraf</a>
                  <a tabindex="-1" href="/master/penawaran/pelanggan" class="dropdown-item">Perusahaan Pelanggan</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a id="dropdownMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">PO</a>
              <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                <li>
                  <a tabindex="-1" href="/master/po/paragraf" class="dropdown-item">Paragraf</a>
                  <a tabindex="-1" href="/master/po/supplier" class="dropdown-item">Vendor</a>
                </li>
              </ul>
            </li>
            <li>
                <a tabindex="-1" href="/master/perusahaan" class="dropdown-item">Perusahaan</a>
            </li>
            <li>
                <a href="/master/ekspedisi" class="dropdown-item">Ekspedisi</a>
            </li>
            <li>
                <a tabindex="-1" href="/master/kode" class="dropdown-item">Sales</a>
            </li>
            <li>
                <a tabindex="-1" href="/master/sekolah" class="dropdown-item">Sekolah</a>
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
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="/buku-ekspedisi" class="nav-link">Buku Ekspedisi</a>
        </li>
      </ul>
      <a href="/logout">logout</a>
    </div>
  </div>
</nav>

<div class="container py-3">
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">
                Tambah Sales
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Kode Sales</th>
                        <th scope="col">Nama Sales</th>
                        <th class="text-center" scope="col">Jabatan</th>
                        <th scope="col" class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kode as $k)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $k->kode_penawaran }}</td>
                        <td>{{ $k->nama_sales }}</td>
                        <td class="text-center">{{ $k->jabatan }}</td>
                        <td class="text-center"><button class="btn btn-info" data-toggle="modal" data-target="#edit{{ $k->id }}">Edit</button></td>
                        <td class="text-center"><button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $k->id }}">Delete</button></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/penawaran/kode/tambah" method="post">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="kode" class="col-form-label">Kode Sales</label>
                    <input type="text" class="form-control" name="kode" id="kode">
                </div>
                <div class="form-group">
                    <label for="nama" class="col-form-label">Nama Sales</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                </div>
                <div class="form-group">
                    <label for="jabatan" class="col-form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" id="jabatan">
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
@foreach($kode as $k)
<div class="modal fade" id="edit{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/penawaran/kode/edit" method="post">
            <div class="modal-body">
                @csrf
                <input type="hidden" value="{{ $k->id }}" name="id" id="id">
                <div class="form-group">
                    <label for="kode" class="col-form-label">Kode Sales</label>
                    <input type="text" class="form-control" name="kode" id="kode" value="{{ $k->kode_penawaran }}">
                </div>
                <div class="form-group">
                    <label for="nama" class="col-form-label">Nama Sales</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{ $k->nama_sales }}">
                </div>
                <div class="form-group">
                    <label for="jabatan" class="col-form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ $k->jabatan }}">
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
<div class="modal fade" id="hapus{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Sales</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/master/penawaran/kode/hapus" method="post">
            <div class="modal-body">
                @csrf
                <input type="hidden" value="{{ $k->id }}" name="id" id="id">
                Yakin mau di hapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Yakin</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endforeach
<script src="/assets/js/jqslim.js"></script>
<script src="/assets/js/popper.js"></script>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
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
</body>
</html>