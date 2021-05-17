@extends('main.index')

@section('title','Master Vendor')

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
<h3 class="mx-auto judul-mobile" style="background-color:#192965;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Vendor</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#192965;color:#fff;border-radius:3px;padding:0px 10px;"><i>List Vendor</i></h3>
@endsection
@section('container')
<div class="container-fluid">
  <div class="row mt-3">
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
      <button class="btn btn-primary" data-target="#tambah" data-toggle="modal">Tambah Perusahaan</button>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 table-respomsive text-nowrap">
      <table class="table table-bordered table-hover table-striped" id="table">
        <thead>
          <tr>
            <th scope="col" class="text-center m-0 p-0">No</th>
            <th scope="col" class="text-center">Kode - Nama Perusahaan</th>
            <th scope="col" class="text-center">Kota</th>
            <th scope="col" class="text-center">Attn<br>No Hp<br>Email</th>
            <th scope="col" class="text-center">Produk</th>
            <th scope="col" class="text-center">Status Payment<br>Status Perusahaan</th>
            <th scope="col" class="text-center">Nama Bank<br>Nama Rek<br>Nomor Rek</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($supplier as $s)
          <tr>
            <td class="text-center m-0 p-0">{{ $loop->iteration }}</td>
            <td>{{$s->kode_vendor}} - {{ $s->nama_perusahaan }}</td>
            <td>{{ $s->kota }}</td>
            <td>{{ $s->attn }}<br>{{ $s->no_hp }}<br>{{ $s->email }}</td>
            <td>{!! wordwrap($s->produk,25,"<br>") !!}</td>
            <td>{{ $s->payment }}<br>{{$s->status_perusahaan}}</td>
            <td>{{ $s->nama_bank }}<br>{{ $s->nama_rek }}<br>{{ $s->nomor_rek }}</td>
            <td class="text-center">
              <button class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $s->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
              <button type="button" class="btn btn-secondary" onclick="window.open('/master/po/supplier/view/{{$s->kode_vendor}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button><br>
              <button class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $s->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master/po/supplier/tambah" method="post">
      {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group">
              <label for="kode_vendor">Kode Vendor (*)</label>
              <input type="text" name="kode_vendor" id="kode_vendor" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" maxlength="1" required />
              <div id="kode_vendor_list"></div>
          </div>
          <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan (*)</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
          </div>
          <div class="form-group">
            <label for="produk">Produk (*)</label>
            <textarea class="form-control" id="produk" name="produk" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat"></textarea>
          </div>
          <div class="form-group">
            <label for="kota">Kota</label>
            <input type="text" class="form-control" id="kota" name="kota" required>
          </div>
          <div class="form-group">
            <label for="attn">Attn</label>
            <input type="text" class="form-control" id="attn" name="attn" required>
          </div>
          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
              @foreach($kelamin as $k)
                <option value="{{$k->id}}">{{ $k->jenis }}</option>
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
              <label for="payment">Payment</label>
              <select name="payment" id="payment" class="form-control">
                  <option value="">--pilih--</option>
                  @foreach($payment as $pay)
                      <option>{{ $pay->payment }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="no_telp">No Telp</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp">
          </div>
          <div class="form-group">
            <label for="no_hp">No Hp</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
          </div>
          <div class="form-group">
            <label for="no_npwp">No NPWP</label>
            <input type="text" class="form-control" id="no_npwp" name="no_npwp" minlength="15" maxlength="15">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="nama_bank">Nama Bank</label>
            <input type="text" class="form-control" id="nama_bank" name="nama_bank">
          </div>
          <div class="form-group">
            <label for="cabang_bank">Cabang Rekening</label>
            <input type="text" class="form-control" id="cabang_bank" name="cabang_bank">
          </div>
          <div class="form-group">
            <label for="nomor_rek">Nomor Rekening</label>
            <input type="text" class="form-control" id="nomor_rek" name="nomor_rek">
          </div>
          <div class="form-group">
            <label for="nama_rek">Nama Rekening</label>
            <input type="text" class="form-control" id="nama_rek" name="nama_rek">
          </div>
          <div class="form-group">
            <label for="memo">Memo</label>
            <textarea class="form-control" id="memo" name="memo" rows="3"></textarea>
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
@foreach($supplier as $s)
<div class="modal fade" id="edit{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master/po/supplier/edit" method="post">
      @csrf
      <input type="hidden" name="id" id="id" value="{{$s->id}}">
      <div class="modal-body">
          <div class="form-group">
            <label for="kode_vendor_edit">Kode Vendor (*)</label>
            @if(Session::get('role_id') == '1')
                <input type="text" name="kode_vendor" id="kode_vendor_edit{{$s->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $s->kode_vendor }}" maxlength="1" required />                
            @else 
                <input type="text" name="kode_vendor" id="kode_vendor_edit{{$s->id}}" class="form-control input-lg" style="text-transform:uppercase" autocomplete="off" value="{{ $s->kode_vendor }}" disabled />                
            @endif
            <div id="kode_vendor_list_edit{{$s->id}}"></div>
          </div>
          <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan (*)</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required value="{{$s->nama_perusahaan}}">
          </div>
          <div class="form-group">
            <label for="produk">Produk (*)</label>
            <textarea class="form-control" id="produk" name="produk" rows="3" required>{{$s->produk}}</textarea>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{$s->alamat}}</textarea>
          </div>
          <div class="form-group">
            <label for="kota">Kota</label>
            <input type="text" class="form-control" id="kota" name="kota" required value="{{$s->kota}}">
          </div>
          <div class="form-group">
            <label for="attn">Attn</label>
            <input type="text" class="form-control" id="attn" name="attn" required value="{{$s->attn}}">
          </div>
          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
              @foreach($kelamin as $k)
                <option value="{{$k->id}}" {{($k->id == $s->jenis_kelamin) ? 'selected' : ''}}>{{ $k->jenis }}</option>
              @endforeach 
            </select>
          </div>
          <div class="form-group">
              <label for="status_perusahaan">Status Perusahaan</label>
              <select name="status_perusahaan" id="status_perusahaan" class="form-control">
                  <option value="">--pilih--</option>
                  @foreach($status as $sta)
                      <option {{($sta->status_perusahaan == $s->status_perusahaan) ? 'selected' : ''}}>{{ $sta->status_perusahaan }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label for="payment">Payment</label>
              <select name="payment" id="payment" class="form-control">
                  <option value="">--pilih--</option>
                  @foreach($payment as $pay)
                      <option {{($pay->payment == $s->payment) ? 'selected' : ''}}>{{ $pay->payment }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="no_telp">No Telp</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{$s->no_telp}}">
          </div>
          <div class="form-group">
            <label for="no_hp">No Hp</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" required value="{{$s->no_hp}}">
          </div>
          <div class="form-group">
            <label for="no_npwp">No NPWP</label>
            <input type="text" class="form-control" id="no_npwp" name="no_npwp" minlength="15" maxlength="15" value="{{str_replace('-','',str_replace('.','',$s->no_npwp))}}">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{$s->email}}">
          </div>
          <div class="form-group">
            <label for="nama_bank">Nama Bank</label>
            <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="{{$s->nama_bank}}">
          </div>
          <div class="form-group">
            <label for="cabang_bank">Cabang Rekening</label>
            <input type="text" class="form-control" id="cabang_bank" name="cabang_bank" value="{{$s->cabang_bank}}">
          </div>
          <div class="form-group">
            <label for="nomor_rek">Nomor Rekening</label>
            <input type="text" class="form-control" id="nomor_rek" name="nomor_rek" value="{{$s->nomor_rek}}">
          </div>
          <div class="form-group">
            <label for="nama_rek">Nama Rekening</label>
            <input type="text" class="form-control" id="nama_rek" name="nama_rek" value="{{$s->nama_rek}}">
          </div>
          <div class="form-group">
            <label for="memo">Memo</label>
            <textarea class="form-control" id="memo" name="memo" rows="3">{{$s->memo}}</textarea>
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
<div class="modal fade" id="hapus{{ $s->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master/po/supplier/hapus" method="post">
      @csrf
        <div class="modal-body">
          <input type="hidden" name="id" value="{{ $s->id }}">
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
  $(document).ready( function () {
    $('#table').DataTable({
      order:[]
    });  
  });
});
</script>
<script>
$(document).ready(function(){

 $('#kode_vendor').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('vendor.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#kode_vendor_list').fadeIn();  
            $('#kode_vendor_list').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#kode_vendor').val($(this).text());  
        $('#kode_vendor_list').fadeOut();  
    });  

});
</script>
@foreach($supplier as $s)
<script>
$(document).ready(function(){

 $('#kode_vendor_edit{{$s->id}}').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('vendor.fetch_edit') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#kode_vendor_list_edit{{$s->id}}').fadeIn();  
            $('#kode_vendor_list_edit{{$s->id}}').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#kode_vendor_edit{{$s->id}}').val($(this).text());  
        $('#kode_vendor_list_edit{{$s->id}}').fadeOut();  
    });  

});
</script>
@endforeach
@endsection