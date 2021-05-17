@extends('main.index')

@section('title','Input PO')

@section('css')
    <style>
        .table tr td{
            vertical-align:middle;
        }
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
    <link rel="stylesheet" href="/assets/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/assets/select2/dist/css/select2-bootstrap.min.css">
@endsection
@section('judul_mobile')
<h3 class="mx-auto judul-mobile" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Purchase Order</i></h3>
@endsection
@section('judul')
<h3 class="mr-5 judul" style="background-color:#ff8b00;color:#fff;border-radius:3px;padding:0px 10px;"><i>Input Purchase Order</i></h3>
@endsection
@section('container')
<form action="/po/submit" method="post">
@csrf
<div class="container-fluid py-3">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div style="background-color:#ffba5a;" class="p-2">
        <div class="row">
            <div class="col-7">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="kode_po">Nama Login (*)</label>
                            <select name="kode_po" id="kode_po" class="form-control" disabled>
                                @foreach($kode_po as $p)
                                <option value="{{$p->kode_po}}" {{ (Session::get('kode_sales') == $p->kode_po) ? 'selected' : '' }}>{{ $p->kode_po.' - '.$p->nama.' - '.$p->jabatan.' - '.$p->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="tgl_po">Periode PO (*)</label>
                            <input type="month" class="form-control" name="tgl_po" id="tgl_po" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label for="perusahaan">Paket</label>
                    <input type="text" class="form-control" name="paket">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="supplier">To (*)</label>
                    <select name="supplier" id="supplier" class="form-control" required>
                        <option value="">--pilih--</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex flex-row">
                    <div id="status_perusahaan"></div>
                    <div class="ml-2" id="payment"></div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="perusahaan">From (*)</label>
                    <select name="perusahaan" id="perusahaan" class="form-control">
                        @foreach($perusahaan as $per)
                            <option value="{{ $per->id }}">{{ $per->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="tgl">TGL (*)</label>
                    <input type="date" class="form-control" name="tgl" id="tgl" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="attn">Attn</label>
                    <textarea name="attn" id="attn" class="form-control" cols="2"></textarea>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group my-0">
                    <label for="cc">CC</label>
                    <textarea name="cc" id="cc" class="form-control" cols="2"></textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="re">Re</label>
                    <textarea name="re" id="re" class="form-control" cols="2">PO</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="pajak" class="mb-1">Pajak (*)</label>
                    <select name="pajak" id="pajak" class="form-control">
                        <option value="1">termasuk pajak</option>
                        <option value="2">tidak termasuk pajak</option>
                        <option value="3">kosongin</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="npwp" class="mb-1">NPWP (*)</label>
                    <select name="npwp" id="npwp" class="form-control">
                        <option value="1">Tampilkan</option>
                        <option value="2">Tidak Tampilkan</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="ekspedisi">Ekspedisi (*)</label>
                    <select name="ekspedisi" id="ekspedisi" class="form-control">
                            <option value="">None</option>
                            <option value="other">Other</option>
                        @foreach($ekspedisi as $re)
                            <option value="{{ $re->id }}">{{ $re->ekspedisi }}</option>
                        @endforeach
                    </select>
                    <div id="ekspedisis">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="ttd" class="mb-1">Tanda Tangan (*)</label>
                    <select name="ttd" id="ttd" class="form-control" {{(Session::get('role_id') == '2' || Session::get('role_id') == '3') ? 'disabled' : ''}}>
                        <option value="1">Tampilkan</option>
                        <option value="2" selected>Tidak Tampilkan</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="ttd">Nama Sales</label>
                    <select name="ttd_sales" id="ttd_sales" class="form-control">
                        <option></option>
                        @foreach($kode_po as $p)
                        <option value="{{$p->kode_po}}">{{ $p->kode_po.' - '.$p->nama.' - '.$p->jabatan.' - '.$p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div style="background-color:#deff8b;" class="p-2">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center"  style="min-height:10px;">
                            <td scope="col" colspan="2" style="width:28%;" class="p-1">Nama Barang (*)</td>
                            <td scope="col" class="p-1" style="width:10%;">QTY (*)</td>
                            <td scope="col" class="p-1" style="width:13%;">Satuan (*)</td>
                            <td scope="col" class="p-1" style="width:14%;">Harga Satuan (*)</td>
                            <td scope="col" class="p-1" style="width:18%;">Total</td>
                            <td scope="col" class="p-1" style="width:10%x;">Keterangan</td>
                            <td scope="col" class="p-1" style="width:7%;"><button class="btn btn-primary add_field_button"><b>+</b></button></td>
                        </tr>
                    </thead>
                    <tbody class="input_fields_wrap">
                        <tr>
                            <td scope="row" colspan="2">
                                <div class="form-group m-0">
                                    <input type="text" class="form-control nama" name="nama_barang[]" required>
                                </div>
                            </td>
                            <td scope="row" class="m-0">
                                <div class="form-group m-0">
                                    <input type="number" class="form-control qty m-0 m-0" name="qty[]" id="'+x+'" required>
                                </div>
                            </td>
                            <td scope="row">    
                                <div class="form-group m-0">
                                    <select name="satuan[]" id="satuan" class="form-control satuan">
                                        @foreach($satuan as $a)
                                            <option>{{ $a->satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td scope="row">
                                <div class="form-group m-0">
                                    <input type="number" class="form-control harga" name="harga_satuan[]" required>
                                </div>
                            </td>
                            <td scope="row">
                                <div class="form-group m-0">
                                    <input type="number" class="form-control total" name="total[]" readonly>
                                </div>
                            </td>
                            <td scope="row">
                                <div class="form-group m-0">
                                    <textarea rows="2" class="form-control keterangan" name="keterangan[]"></textarea>
                                </div>
                            </td>
                            <td scope="row">
                                <button type="button" class="btn btn-danger hapus"><b>x</b></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" cols="30" rows="2" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit</button>
            <button type="button" class="btn btn-danger" data-target="#cancel" data-toggle="modal">Cancel</button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#goto" style="background-color:#ffdc34;color:black;border:none;">Go To List PO</button>
        </div>
    </div>
</div>
</form>
<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau di cancel
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <button type="button" onclick="location.reload()" class="btn btn-danger">Yakin</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="goto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin mau di pindah ke list po?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Yakin</button>
        <a class="btn btn-danger" href="/list/po">Yakin</a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="/assets/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#supplier').on('change',function(){
            var _token = $('input[name="_token"]').val();
            var query = $('#supplier').val();
            $.ajax({
            url:"{{ route('po.id_supplier') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
                var wow = JSON.parse(data);
                $('#attn').val(wow['email']);
                $('#status_perusahaan').html('<p style="background-color:#fafafa;color:#192965;"><b>'+wow['status_perusahaan']+'</b></p>');
                $('#payment').html('<p style="background-color:#fafafa;color:#192965;"><b>'+wow['payment']+'</b></p>');
            }
            });
        });
        $('form').on('submit', function() {
            $('#kode_po').prop('disabled', false);
            $('#ttd').prop('disabled', false);
        });
        $('#ttd_sales').select2({
            placeholder: "-- Pilih --",
            allowClear: true,    
            theme: "bootstrap"
        });
        $('tbody').delegate('.qty,.harga,.total','keyup',function(){
            var tr3 = $(this).parent();
            var tr2 = tr3.parent();
            var tr = tr2.parent();

            var qty = tr.find('.qty').val();
            var harga = tr.find('.harga').val();
            var total = (qty * harga);
            tr.find('.total').val(total);
        });
        // var max_fields= 25; //maximum input boxes allowed
        var x = 1; //initlal text box count
        $('.add_field_button').click(function(e){ //on add input button click
            e.preventDefault();
            //max input box allowed
                x++; //text box increment
                $('.input_fields_wrap').append('<tr id="row'+x+'"><td scope="row" colspan="2"><div class="form-group m-0"><input type="text" class="form-control nama" name="nama_barang[]" required></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control qty m-0" name="qty[]" id="'+x+'" required></div></td><td scope="row"><div class="form-group m-0"><select name="satuan[]" id="satuan" class="form-control satuan">@foreach($satuan as $a)<option>{{ $a->satuan }}</option>@endforeach</select></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control harga" name="harga_satuan[]" required></div></td><td scope="row"><div class="form-group m-0"><input type="number" class="form-control total" name="total[]"></div></td><td scope="row"><div class="form-group m-0"><textarea rows="2" class="form-control keterangan" name="keterangan[]"></textarea></div></td><td scope="row"><button type="button" id="'+x+'" class="btn btn-danger hapus"><b>x</b></button></td></tr>'); //add input box
            
        });
        
        $(document).on('click','.hapus', function(){ //user click on remove text
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();

        });
        

    });
    document.getElementById('tgl_po').valueAsDate= new Date();
    document.getElementById('tgl').valueAsDate= new Date();
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
    $("#ekspedisi").on('change',function(){
        let untuk = $('#ekspedisi').val();
        var new_input="<input type='text' name='ekspedisi_dll' id='ekspedisi_dll' class='form-control mt-1'>";
        if(untuk == 'other'){
            $('#ekspedisis').append(new_input);
            
        }else{
            $('#ekspedisi_dll').remove();
        }
    });
});
</script>
@endsection