@extends('main.index')

@section('title','Master Pelanggan')

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
    @media screen and (max-width: 992px) {
        .judul {
            display:none;
        }
    }
    @media screen and (min-width: 992px) {
        .judul-mobile {
            display:none;
        }
        .judul{
            display:block;
        }
    }
    </style>
@endsection
@section('judul_mobile')
<h3 class="mx-auto judul-mobile" style="background-color:#007944;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Customer</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#007944;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Customer</i></h3>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">
                Tambah Pelanggan
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 table-responsive text-nowrap">
            <table class="table table-bordered table-hover table-striped" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode - Nama Perusahaan<br>Alamat</th>
                        <th>Nama Kota</th>
                        <th>Nama Pemilik<br>No HP</th>
                        <th>Email<br>No Telp</th>
                        <th>Nama Bank<br>Nomor Rekening<br>Nama Rekening</th>
                        <th>Status<br>Payment<br>Perusahaan</th>
                        <th>W</th>
                        <th>S</th>
                        <th>B</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pelanggan as $p)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <td>
                            {{ $p->kode_pelanggan }} - {{ $p->nama_perusahaan }}<br>{{ $p->alamat }}
                        </td>
                        <td>{{ $p->nama_kota }}</td>
                        <td>{{ $p->nama_pemilik }}<br>{{ $p->no_hp }}</td>
                        <td>{{ $p->email }}<br>{{ $p->no_telp }}</td>
                        <td>
                            <a href="{{asset('assets/images/upload/bank/'.$p->gambar)}}" target="_blank">{{$p->nama_bank}}</a><br>
                            {!! $p->nomor_rekening.'<br>'.$p->nama_rekening !!}
                        </td>
                        <td>{{ $p->payment }}<br>{{ $p->status_perusahaan }}</td>
                        <td>W</td>
                        <td>S</td>
                        <td>B</td>
                        <td>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $p->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-secondary" onclick="window.open('/master/penawaran/pelanggan/view/{{$p->kode_pelanggan}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button><br>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $p->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a class="btn btn-info" href="{{$rule['gmaps_prefix'].$p->gps_latitude.$rule['gmaps_middle'].$p->gps_longtitude.$rule['gmaps_suffix']}}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                
        </div>
    </div>
</div>
@foreach($pelanggan as $p)
<div class="modal fade" id="edit{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master/penawaran/pelanggan/edit" method="POST">
      @csrf
        <input type="hidden" name="id" value="{{ $p->id }}">
        <div class="modal-body">
            <div class="form-group">
                <label for="kode_pelanggan_edit">Kode pelanggan (*)</label>
                @if(Session::get('role_id') == '1')
                    <input type="text" name="kode_pelanggan" id="kode_pelanggan_edit{{$p->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $p->kode_pelanggan }}" maxlength="1" required />                
                @else 
                    <input type="text" name="kode_pelanggan" id="kode_pelanggan_edit{{$p->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $p->kode_pelanggan }}" disabled />                
                @endif
                <div id="kode_pelanggan_list_edit{{$p->id}}"></div>
            </div>
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan (*)</label>
                <input type="text" class="form-control" value="{{ $p->nama_perusahaan }}" id="nama_perusahaan" name="nama_perusahaan" required>
            </div>
            <div class="form-group">
                <label for="nama_pemilik">Nama Pemilik (*)</label>
                <input type="text" class="form-control" value="{{ $p->nama_pemilik }}" id="nama_pemilik" name="nama_pemilik" required>
            </div>
            <div class="form-group">
                <label for="no_telp">No Telp (*)</label>
                <input type="text" class="form-control" value="{{ $p->no_telp }}" id="no_telp" name="no_telp" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" value="{{ $p->alamat }}" id="alamat" name="alamat">
            </div>
            <div class="form-group">
                <label for="nama_kota">Nama Kota</label>
                <input type="text" class="form-control" value="{{ $p->nama_kota }}" id="nama_kota" name="nama_kota">
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    @foreach($kelamin as $k)
                        <option value="{{ $k->id }}" {{($k->id == $p->jenis_kelamin) ? 'selected' : ''}}>{{ $k->jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status_perusahaan">Status Perusahaan</label>
                <select name="status_perusahaan" id="status_perusahaan" class="form-control">
                    <option value="">--pilih--</option>
                    @foreach($status as $s)
                        <option {{($s->status_perusahaan == $p->status_perusahaan) ? 'selected' : ''}}>{{ $s->status_perusahaan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="bank_transfer">Bank Transfer</label>
                <select name="bank_transfer" id="bank_transfer" class="form-control">
                    <option value="">--pilih--</option>
                    @foreach($bank as $b)
                        <option value="{{$b->id}}" {{($b->id == $p->id_bank) ? 'selected' : ''}}>{{ $b->nama_bank.' - '.$b->nomor_rekening.' - '.$b->nama_rekening }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="payment">Payment</label>
                <select name="payment" id="payment" class="form-control">
                    <option value="">--pilih--</option>
                    @foreach($payment as $pay)
                        <option {{($pay->payment == $p->payment) ? 'selected' : ''}}>{{ $pay->payment }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="no_hp">No Hp</label>
                <input type="text" class="form-control" value="{{ $p->no_hp }}" id="no_hp" name="no_hp">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" value="{{ $p->email }}" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="gps_latitude">GPS Latitude</label>
                <input type="text" class="form-control" id="gps_latitude" name="gps_latitude" value="{{ $p->gps_latitude }}">
            </div>
            <div class="form-group">
                <label for="gps_longtitude">GPS Longtitude</label>
                <input type="text" class="form-control" id="gps_longtitude" name="gps_longtitude" value="{{ $p->gps_longtitude }}">
            </div>
            <div class="form-group">
                <label for="memo">Memo</label>
                <textarea class="form-control" id="memo" name="memo" rows="13">{{ $p->memo }}</textarea>
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
@endforeach

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="/master/penawaran/pelanggan/tambah" method="post">
        {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="kode_pelanggan">Kode pelanggan (*)</label>
                    <input type="text" name="kode_pelanggan" id="kode_pelanggan" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" maxlength="1" required />
                    <div id="kode_pelanggan_list"></div>
                </div>
                <div class="form-group">
                    <label for="nama_perusahaan">Nama Perusahaan (*)</label>
                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
                </div>
                <div class="form-group">
                    <label for="nama_pemilik">Nama Pemilik (*)</label>
                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" required>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp (*)</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="form-group">
                    <label for="nama_kota">Nama Kota</label>
                    <input type="text" class="form-control" id="nama_kota" name="nama_kota">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="">--pilih--</option>
                        @foreach($kelamin as $k)
                            <option value="{{ $k->id }}">{{ $k->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_perusahaan">Status Perusahaan</label>
                    <select name="status_perusahaan" id="status_perusahaan" class="form-control">
                        <option value="">--pilih--</option>
                        @foreach($status as $s)
                            <option>{{ $s->status_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="bank_transfer">Bank Transfer</label>
                    <select name="bank_transfer" id="bank_transfer" class="form-control">
                        <option value="">--pilih--</option>
                        @foreach($bank as $b)
                            <option value="{{$b->id}}">{{ $b->nama_bank.' - '.$b->nomor_rekening.' - '.$b->nama_rekening }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment">Payment</label>
                    <select name="payment" id="payment" class="form-control">
                        <option value="">--pilih--</option>
                        @foreach($payment as $pay)
                            <option>{{ $pay->payment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="no_hp">No Hp</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="gps_latitude">GPS Latitude</label>
                    <input type="text" class="form-control" id="gps_latitude" name="gps_latitude">
                </div>
                <div class="form-group">
                    <label for="gps_longtitude">GPS Longtitude</label>
                    <input type="text" class="form-control" id="gps_longtitude" name="gps_longtitude">
                </div>
                <div class="form-group">
                    <label for="memo">Memo</label>
                    <textarea class="form-control" id="memo" name="memo" rows="13"></textarea>
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
@foreach($pelanggan as $p)
<div class="modal fade" id="delete{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau dihapus?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <form action="/master/penawaran/pelanggan/hapus">
            <input type="hidden" name="id" value="{{ $p->id }}">
            <button type="submit" class="btn btn-danger">Yakin</button>
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
    $('#table').DataTable();
    
});
</script>
<script>
$(document).ready(function(){

 $('#kode_pelanggan').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#kode_pelanggan_list').fadeIn();  
            $('#kode_pelanggan_list').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#kode_pelanggan').val($(this).text());  
        $('#kode_pelanggan_list').fadeOut();  
    });  

});
</script>
@foreach($pelanggan as $p)
<script>
$(document).ready(function(){

 $('#kode_pelanggan_edit{{$p->id}}').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch_edit') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#kode_pelanggan_list_edit{{$p->id}}').fadeIn();  
            $('#kode_pelanggan_list_edit{{$p->id}}').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#kode_pelanggan_edit{{$p->id}}').val($(this).text());  
        $('#kode_pelanggan_list_edit{{$p->id}}').fadeOut();  
    });  

});
</script>
@endforeach
@endsection