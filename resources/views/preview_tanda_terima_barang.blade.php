@extends('main.index')

@section('title','Preview Tanda Terima Barang')

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

        p{
            font-size:14pt;
            font-weight:500;
            margin-bottom:0;
        }
        thead th{
            padding:12px 0px;
            text-align:center;
        }
        tbody td{
            padding:0px 10px;
        }
        /* Styles go here */
        .page {
        page-break-after: always;
        }

        @page {
            margin: 20mm;
        }

        .header{
            display:none;
            margin-top:20px;
        }
        @media print {
        .thead {display: table-header-group;} 
        tfoot {display: table-footer-group;}
        .header {
        position: fixed;
        top: 0mm;
        width: 100%;
        } 
        .btn {display: none;}
        .header {
            position: fixed;
            top: 0mm;
            display:block;
            margin-top:-15px;
        } 
        .header, .page-header-space {
        height: 60px;
        margin-bottom:10px;
        }
        
        body {margin: 0;}
        nav{
            display:none;
        }
    }
    </style>
@endsection

@section('container')
    <div class="container">
        <div class="row header d-flex justify-content-between flex-row" style="border-bottom:solid;">
            @if($data['id_perusahaan'] != "Isi" && $data['nama_perusahaan_isi'] == '')
                <div class="align-self-end">
                    <h3>{{$data['nama_perusahaan']}}</h3>
                </div>
                <div class="align-self-end">
                    {{$data['alamat'].', '.$data['nama_kota'].', Telp: '.$data['telp']}}
                </div>
            @elseif($data['id_perusahaan'] == "Isi" && $data['nama_perusahaan_isi'] != '')
                <div class="align-self-end">
                    <h3>{{$data['nama_perusahaan_isi']}}</h3>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <table style="width:100%;">
                    <thead class="thead">
                        <tr>
                            <td>
                                <div class="page-header-space"></div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="page">
                                    <div class="row p-0">
                                        <div class="col-12 text-right p-0">
                                            <p>NO DO: {{$data['no_do']}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h1>TANDA TERIMA BARANG</h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table border="1" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="p-0" style="width:50px;">No.</th>
                                                        <th scope="col" class="p-0">Jenis Barang</th>
                                                        <th scope="col" class="p-0" style="width:85px;">QTY</th>
                                                        <th scope="col" class="p-0" style="width:85px;">Satuan</th>
                                                        <th class="p-0" scope="col">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($barang as $b)
                                                    <tr>
                                                        <td class="text-center">{{$loop->iteration}}</td>
                                                        <td>{{$b->jenis_barang}}</td>
                                                        <td class="text-center p-0">{{$b->qty}}</td>
                                                        <td class="text-center p-0">{{$b->satuan}}</td>
                                                        <td>{{$b->keterangan}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>
                            <div style="display:block;">
                                <div class="row my-3">
                                    <div class="col-12">
                                    @if($data['note'] != '')
                                        <p>
                                            NB: {{$data['note']}}
                                        </p>
                                    @else

                                    @endif
                                    <p>{{$paragraf->paragraf1}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex flex-row justify-content-between">
                                        <div>
                                            <p>
                                                Yang Menerima,<br>
                                                @if($data['id_customer'] != "Isi" && $data['nama_customer_isi'] == '')
                                                {{$data['nama_customer']}}
                                                @elseif($data['id_customer'] == "Isi" && $data['nama_customer_isi'] != '')
                                                {{$data['nama_customer_isi']}}
                                                @endif
                                            </p>
                                            <div style="height:100px;"></div>
                                            @if($data['nama_penerima'] == '')
                                                <p>(.......................................)</p>
                                            @else
                                                <p>{{$data['nama_penerima']}}</p>
                                            @endif
                                        </div>
                                        @if($data['nama_pengantar'] == '')

                                        @else
                                        <div>
                                            <div style="height:25px;"></div>
                                            <p>
                                                Yang Antar,
                                            </p>
                                            <div style="height:100px;"></div>
                                            @if($data['nama_pengantar_isi'] != '')
                                                <p>{{$data['nama_pengantar_isi']}}</p>
                                            @elseif($data['nama_pengantar'] != 'Isi' && $data['nama_pengantar'] != '')
                                                <p>{{$data['nama_pengantar']}}</p>
                                            @endif
                                        </div>
                                        @endif
                                        <div>
                                            @if(($data['id_customer'] == "Isi" && $data['nama_customer_isi'] != "") || ($data['id_perusahaan'] == "Isi" && $data['nama_perusahaan_isi'] != ""))
                                                <p>{{$data['nama_kota_perusahaan'].', '.date('d F Y',strtotime($data['tgl']))}}</p>
                                            @else
                                                <p>{{$data['nama_kota'].', '.date('d F Y',strtotime($data['tgl']))}}</p>
                                            @endif
                                            <p>Yang Menyerahkan,</p>
                                            @if($data['ttd'] == '1')
                                                <div style="height:100px;">
                                                    <img src="{{asset('assets/images/upload/ttd/'.$data['ttd_gambar'])}}">
                                                </div>
                                            @elseif($data['ttd'] == '2')
                                                <div style="height:100px;">
                                                    
                                                </div>
                                            @endif
                                            <p><span style="border-bottom:1px solid;">{{$data['nama_sales']}}</span></p>
                                            <p>{{$data['jabatan']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <a href="/list/tanda-terima-barang" class="btn btn-primary">Close</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            
            $('.print').on('click',function(){
                window.print();
            });
            
        });
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