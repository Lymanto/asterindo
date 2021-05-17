@extends('main.index')

@section('title','Master Penawaran Paragraf')

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
<div class="container py-3">
  <div class="row">
    <div class="col-4">
    @if(\Session::has('success'))
    <div class="alert alert-info">
      <b>
        {{ Session::get('success') }}
      </b>
    </div>
    @endif
    </div>
  </div>
<form action="/master/paragraf" method="GET">
@foreach($paragraf as $p)
  <input type="hidden" name="id" value="{{$p->id}}">
  <div class="row">
    <div class="col-md-6">
      <label for="sapaan">Sapaan</label>
      <textarea id="sapaan" name="sapaan" class="form-control" rows="3">{{$p->sapaan}}</textarea>    
    </div>
    <div class="col-md-6">
      <label for="paragraf1">Paragraf 1</label>
      <textarea id="paragraf1" name="paragraf1" class="form-control" rows="3">{{$p->paragraf1}}</textarea>    
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <label for="termasuk_pajak">Termasuk Pajak</label>
      <textarea id="termasuk_pajak" name="termasuk_pajak" class="form-control" rows="3">{{$p->termasuk_pajak}}</textarea>    
    </div>
    <div class="col-md-6">
      <label for="tidak_termasuk_pajak">Belum Termasuk Pajak</label>
      <textarea id="tidak_termasuk_pajak" name="tidak_termasuk_pajak" class="form-control" rows="3">{{$p->tidak_termasuk_pajak}}</textarea>    
    </div>
    
  </div>
  <div class="row">
    <div class="col-md-6">
      <label for="masa">Masa Berlaku</label>
      <textarea id="masa" name="masa" class="form-control" rows="3">{{$p->masa_berlaku}}</textarea>    
    </div>
    <div class="col-md-6">
      <label for="paragraf2">Paragraf 2</label>
      <textarea id="paragraf2" name="paragraf2" class="form-control" rows="4">{{$p->paragraf2}}</textarea>    
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <label for="salam_penutup">Salam Penutup</label>
      <textarea id="salam_penutup" name="salam_penutup" class="form-control" rows="3">{{$p->salam_penutup}}</textarea>    
    </div>
  </div>
  <div class="row py-2">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Ubah</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel">Cancel</button>
    </div>
  </div>
<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau di cancel?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="location.reload()">Yakin</button>
      </div>
    </div>
  </div>
</div>
@endforeach
</form>
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
</script>
@endsection