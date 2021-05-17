@extends('main.index')

@section('title','Master Sales')

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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">Tambah Sales</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 table-responsive text-nowrap">
            <table class="table table-hover table-bordered table-striped" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Kode - Nama Sales<br>Email</th>
                        <th scope="col" class="text-center">Nama Perusahaan</th>
                        <th scope="col" class="text-center">Jabatan</th>
                        <th scope="col" class="text-center">NIP Sales</th>
                        <th scope="col" class="text-center">No HP</th>
                        <th scope="col" class="text-center">Gol.<br>Darah</th>
                        <th scope="col" class="text-center">Nama Saudara<br>No Hp</th>
                        <th scope="col" class="text-center">TTD</th>
                        <th scope="col"class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($kode as $k)
                    <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $k->kode_po }} - {{ $k->nama }}<br>{{$k->email}}</td>
                        <td>{{ $k->nama_perusahaan }}</td>
                        <td>{{ $k->jabatan }}</td>
                        <td>{{ $k->nip_sales }}</td>
                        <td>{{ $k->no_hp }}</td>
                        <td>{{ $k->gol }}</td>
                        <td>{!! $k->nama_saudara.'<br>'.$k->no_hp_saudara !!}</td>
                        <td style="width:200px;">
                        @if($k->ttd != '')
                          <img src="/assets/images/upload/ttd/{{ $k->ttd }}" width="100%">
                        @else
                          Tidak ada TTD
                        @endif
                        </td>
                        <td class="text-center">
                          <button class="btn btn-primary" data-target="#edit{{ $k->id }}" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                          <button type="button" class="btn btn-secondary" onclick="window.open('/master/kode/view/{{$k->kode_po}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                          <button class="btn btn-danger" data-target="#hapus{{$k->id}}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master/kode/tambah" method="post" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="kode_po">Kode Sales (*)</label>
            <input type="text" class="form-control" id="kode_po" name="kode_po" maxlength="3" minlength="3">
          </div>
          <div class="form-group">
            <label for="nama">Nama Sales (*)</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{old('nama')}}" required>
          </div>
          <div class="form-group">
            <label for="ttd">TTD</label><br>
            <input type="file" id="ttd" name="ttd">
          </div>
          <div class="form-group">
            <label for="nip_sales">NIP Sales</label><br>
            <input type="text" class="form-control" id="nip_sales" name="nip_sales" maxlength="5" value="{{old('nip_sales')}}" required>
          </div>
          <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan (*)</label><br>
            <select class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
              @foreach($perusahaan as $p)
                <option>{{$p->nama_perusahaan}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label><br>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{old('jabatan')}}" required>
          </div>
          <div class="form-group">
            <label for="gol">Golongan Darah</label><br>
            <input type="text" class="form-control" id="gol" name="gol" maxlength="2" value="{{old('gol')}}" required>
          </div>
          <div class="form-group">
            <label for="no_hp">No Hp</label><br>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{old('no_hp')}}" required>
          </div>
          <div class="form-group">
            <label for="email">Email (*)</label><br>
            <input type="text" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="nama_saudara">Nama Saudara</label><br>
            <input type="text" class="form-control" id="nama_saudara" name="nama_saudara" value="{{old('nama_saudara')}}">
          </div>
          <div class="form-group">
            <label for="no_hp_saudara">No Hp Saudara</label><br>
            <input type="text" class="form-control" id="no_hp_saudara" name="no_hp_saudara" value="{{old('no_hp_saudara')}}">
          </div>
          <div class="form-group">
              <label for="gambar1">Pas Foto</label>
              <input type="file" name="gambar1" id="gambar1">
          </div>
          <div class="form-group">
              <label for="gambar2">Foto 1 Badan</label>
              <input type="file" name="gambar2" id="gambar2">
          </div>
          <div class="form-group">
              <label for="gambar3">Foto Kiri</label>
              <input type="file" name="gambar3" id="gambar3">
          </div>
          <div class="form-group">
              <label for="gambar4">Foto Kanan</label>
              <input type="file" name="gambar4" id="gambar4">
          </div>
          <div class="form-group">
            <label for="memo">Memo</label><br>
            <textarea class="form-control" id="memo" name="memo" value="{{old('memo')}}"></textarea>
          </div>
          <div class="form-group">
            <label for="password">Password (*)</label><br>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="password_confirm">Password Confirm (*)</label><br>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>
          <div class="form-group">
            <label for="role_id">Role (*)</label><br>
            <select class="form-control" id="role_id" name="role_id">
              <option value="1">Supervisor</option>
              <option value="3">Admin</option>
              <option value="2">Sales</option>
            </select>
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
@foreach($kode as $k)
  <div class="modal fade" id="edit{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        <form action="/master/kode/edit" method="post" enctype="multipart/form-data">
        </div>
        @csrf
          <input type="hidden" name="id" value="{{ $k->id }}">
          <div class="modal-body">
            <div class="form-group">
              <label for="kode_po">Kode Sales (*)</label>
              <input type="text" class="form-control" id="kode_po" name="kode_po" value="{{ $k->kode_po }}" maxlength="3" minlength="3">
            </div>
            <div class="form-group">
              <label for="nama">Nama Sales (*)</label>
              <input type="text" class="form-control" id="nama" name="nama" value="{{ $k->nama }}">
            </div>
            <div class="form-group">
              <label for="ttd">TTD</label><br>
              <input type="hidden" id="hidden_ttd" name="hidden_ttd"  value="{{ $k->ttd }}">
              <input type="file" id="ttd" name="ttd">
            </div>
            <div class="form-group">
              <label for="nip_sales">NIP Sales</label><br>
              <input type="text" class="form-control" id="nip_sales" name="nip_sales" maxlength="5" value="{{ $k->nip_sales }}">
            </div>
            <div class="form-group">
              <label for="nama_perusahaan">Nama Perusahaan (*)</label><br>
              <select class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
                @foreach($perusahaan as $p)
                  <option {{($p->nama_perusahaan == $k->nama_perusahaan) ? 'selected' : ''}}>{{$p->nama_perusahaan}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="jabatan">Jabatan</label><br>
              <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $k->jabatan }}">
            </div>
            <div class="form-group">
              <label for="gol">Golongan Darah</label><br>
              <input type="text" class="form-control" id="gol" name="gol" maxlength="2" value="{{ $k->gol }}">
            </div>
            <div class="form-group">
              <label for="no_hp">No Hp</label><br>
              <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $k->no_hp }}">
            </div>
            <div class="form-group">
              <label for="nama_saudara">Nama Saudara</label><br>
              <input type="text" class="form-control" id="nama_saudara" name="nama_saudara" value="{{ $k->nama_saudara }}">
            </div>
            <div class="form-group">
              <label for="no_hp_saudara">No Hp Saudara</label><br>
              <input type="text" class="form-control" id="no_hp_saudara" name="no_hp_saudara" value="{{ $k->no_hp_saudara }}">
            </div>
            <div class="form-group">
              <label for="email">Email (*)</label><br>
              <input type="text" class="form-control" id="email" name="email" value="{{ $k->email }}" required>
            </div>
            <div class="form-group">
              <label for="password">Edit Password (*)</label><br>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="password_confirm">Password Confirm (*)</label><br>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-group">
              <label for="memo">Memo</label><br>
              <textarea class="form-control" id="memo" name="memo" value="{{$k->memo}}"></textarea>
            </div>
            <div class="form-group">
                <label for="gambar1">Pas Foto</label>
                <input type="file" name="gambar1" id="gambar1">
            </div>
            <div class="form-group">
                <label for="gambar2">Foto 1 Badan</label>
                <input type="file" name="gambar2" id="gambar2">
            </div>
            <div class="form-group">
                <label for="gambar3">Foto Kiri</label>
                <input type="file" name="gambar3" id="gambar3">
            </div>
            <div class="form-group">
                <label for="gambar4">Foto Kanan</label>
                <input type="file" name="gambar4" id="gambar4">
            </div>
            <div class="form-group">
            <label for="role_id">Role (*)</label><br>
            <select class="form-control" id="role_id" name="role_id">
              <option value="1" {{ ($k->role_id == '1') ? 'selected' : '' }}>Supervisor</option>
              <option value="2" {{ ($k->role_id == '2') ? 'selected' : '' }}>Sales</option>
              <option value="3" {{ ($k->role_id == '3') ? 'selected' : '' }}>Admin</option>
            </select>
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
  <div class="modal fade" id="hapus{{ $k->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Sales</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <input type="hidden" name="id" value="{{ $k->id }}">
          <div class="modal-body">
            Yakin mau di hapus?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <form action="/master/kode/hapus" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $k->id }}">
              <button type="submit" class="btn btn-primary">Yakin</button>
            </form>
          </div>
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
$(document).ready( function () {
    $('#table').DataTable({
      order:[]
    });
} );
</script>
@endsection