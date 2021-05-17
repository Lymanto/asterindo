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
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control">
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="nama">Nama (*)</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <label for="berita">Berita</label>
                <input type="text" name="berita" id="berita" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
    @foreach($golongan as $g)
        <div class="col-6 text-center">
            <div class="form-group">
                <button value="{{$g->id}}" type="button" class="form-control btn golongan" style="background-color:{{$g->background}};color:{{$g->color}};">{{$g->golongan}}</button>
            </div>
        </div>
    @endforeach
        <div class="col-12">
            <div id="golongan_dlls"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function go(e){
        const no_hp = $('#no_hp').val();
        const nama = $('#nama').val();
        const berita = $('#berita').val();
        const golongan = 7;
        const golongan_dll = $("#golongan_dll").val();
        if(nama == ''){
            alert('Nama Harus diisi')
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const formData ={
                no_hp:no_hp,
                nama:nama,
                berita:berita,
                golongan:golongan,
                golongan_dll:golongan_dll
            }
            $.ajax({
                url:"{{route('helpdesk.input')}}",
                method:"POST",
                data:formData,
                dataType: 'json',
                success: function (data) {
                    if(data === true){
                        alert('berhasil');
                        $('#nama').val(null);
                        $('#berita').val(null);
                        $('#no_hp').val(null);
                        $('#golongan_dll').remove();
                    }
                },
                error: function (data) {
                    
                    console.log('Error:', data);
                }
            });
        }
    }
$(document).ready(function(){
    $('.golongan').each(function(i){
        $(this).on('click',function(e){
            let golongan = $(this).val();
            if(golongan == 7){
                let form = '<div class="form-group">';
                form += '<input type="text" class="form-control" name="golongan_dll" id="golongan_dll" maxlength="20"><br>';
                form += '<button type="button" onclick="go()" id="golong" name="golong" value="GO" class="btn btn-primary">GO</button>';
                form += '</div>';
                $('#golongan_dlls').html(form);
            }else{
                $('#golongan_dll').remove();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                const no_hp = $('#no_hp').val();
                const nama = $('#nama').val();
                const berita = $('#berita').val();
                const golongan = $(this).val();
                if(nama == ''){
                    alert('Nama Harus diisi');
                }else{
                    const formData ={
                        no_hp:no_hp,
                        nama:nama,
                        berita:berita,
                        golongan:golongan
                    }
                    $.ajax({
                        url:"{{route('helpdesk.input')}}",
                        method:"POST",
                        data:formData,
                        dataType: 'json',
                        success: function (data) {
                            if(data === true){
                                alert('berhasil');
                                $('#nama').val(null);
                                $('#berita').val(null);
                                $('#no_hp').val(null);
                            }
                        },
                        error: function (data) {
                            
                            console.log('Error:', data);
                        }
                    });
                }
            }
        });
    });
})
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