@extends('main.index')

@section('title','Penawaran Print')

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
        margin: 20mm
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
        
        .header, .page-header-space {
        height: 120px;
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
        <div class="row header" style="border-bottom:solid;">
            <div class="col-12 text-center">
            @foreach($perusahaan as $per)
                <h2>{{ $per->nama_perusahaan }}</h2>
                <h5>{{ $per->alamat }}</h5>
                <h5>Telp {{ $per->telp }}, Email : {{ $per->email }}</h5>
            @endforeach
            </div>
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
                                    <div class="row mt-2 mx-4">
                                        <div class="col-6 offset-6">
                                            <p>Pontianak, {{ date('d F Y',strtotime($penawaran['tgls'])) }}</p>
                                            <p>Kepada Yth:</p>
                                        </div>
                                    </div>
                                    <div class="row mx-4">
                                        <div class="col-6">
                                            <p>No. Penawaran : {{ $penawaran['kode_penawaran'] }}</p>
                                            <p>Perihal:</p>
                                            <div style="max-height:65%; min-height:65%;">
                                                <p style="width:100%;text-align:justify;" class="px-1">{{ $penawaran['perihal'] }}</p>
                                            </div>
                                        </div>
                                        @if($penawaran['pelanggan_pilih'] == "Other")
                                            @foreach($pelanggan as $pel)
                                                <div class="col-6">
                                                    <p>{{ $pel->nama_perusahaan }}</p>
                                                    <p>{{ $pel->alamat }}</p>
                                                    <p>{{ $pel->nama_kota }}</p>
                                                    <p>Up : {{$pel->sapaan}} {{ $pel->nama_pemilik }}</p>
                                                    <p>Telp {{ $pel->no_hp }}</p>
                                                    <p>Email: {{ $pel->email }}</p>
                                                </div>
                                            @endforeach
                                        @elseif($penawaran['pelanggan_pilih'] == "Sekolah")
                                            @foreach($sekolah as $sekolah)
                                                <div class="col-6">
                                                    <p>{{ $sekolah->nama_sekolah }}</p>
                                                    <p>{{ $sekolah->alamat_sekolah }}</p>
                                                    <p>{{ $sekolah->nama_kota }}</p>
                                                    @if($sekolah->kepala_sekolah != '')
                                                        <p>Up : {{$sekolah->sapaan}} {{ $sekolah->kepala_sekolah }}</p>
                                                    @else

                                                    @endif
                                                    @if($sekolah->no_hp != '')
                                                        <p>Telp {{ $sekolah->no_hp }}</p>
                                                    @else

                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row mx-4">
                                        <div class="col-12">
                                            <p>{{ $paragraf['sapaan'] }}</p>
                                            <p>{{ $paragraf['paragraf1'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <table border="1" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA BARANG</th>
                                                        <th>QTY</th>
                                                        <th>SATUAN</th>
                                                        <th>HARGA SATUAN</th>
                                                        <TH>TOTAL</TH>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($barang as $b)

                                                        <tr id="{{$loop->iteration}}">
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $b->nama_barang }}</td>
                                                            <td class="text-center">{{ $b->qty }}</td>
                                                            <td class="text-center">{{ $b->satuan }}</td>
                                                            
                                                            <td class="text-nowrap text-right">{{ "Rp " . number_format($b->harga_satuan) }}</td>
                                                            <td class="text-nowrap text-right">{{ "Rp " . number_format($b->total) }}</td>
                                                        </tr>
                                                    @endforeach
                                                        <tr>
                                                            <td colspan="4" style="visibility:hidden;"></td>
                                                            <td class="text-right"><b>GRAND TOTAL</b></td>
                                                            <td class="text-nowrap text-right">{{ "Rp " . number_format($grandtotal) }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="footer">
                                        <div class="row">
                                            <div class="col-5 offset-7 d-flex flex-row justify-content-between">
                                                <div class="font-weight-bold ml-5">GRAND TOTAL</div>
                                                <div class="mr-3">{{ "Rp " . number_format($grandtotal) }}</div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>
                            <div style="display:block;">
                                <div class="row">
                                        <div class="col-12">
                                        @if($penawaran['pilihan_pajak'] == '1')
                                            <p>{{ $paragraf['termasuk_pajak'] }}</p>
                                        @elseif($penawaran['pilihan_pajak'] == '2')
                                            <p>{{ $paragraf['tidak_termasuk_pajak'] }}</p>
                                        @elseif($penawaran['pilihan_pajak'] == '3')
                                            <p></p>
                                        @endif
                                        @if($penawaran['note'] != '')
                                            <p>Note:</p>
                                            <p>{{ $penawaran['note'] }}</p>
                                        @else

                                        @endif
                                            <p>Masa berlaku penawaran s/d {{ $penawaran['lama_penawaran'] }} hari ({{ date('d F Y',strtotime($penawaran['tgl_penawaran'])) }})</p>
                                            <p>{{ $paragraf['paragraf2'] }}</p>
                                            <br>
                                            <p>{{ $paragraf['salam_penutup'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if($penawaran['ttd'] == '1')
                                        <div class="col-3">
                                            <img src="{{asset('assets/images/upload/ttd/'.$sales['ttd'])}}" class="my-1 w-100">
                                        </div>
                                        @elseif($penawaran['ttd'] == '2')
                                        <br><br><br><p style="visibility:hidden;">s</p>
                                        @endif
                                        <div class="col-12">
                                            <div>
                                                <span style="border-bottom:1px solid;font-weight:500;font-size:14pt;">{{$sales['nama']}}</span>
                                            </div>
                                            <span style="font-weight:500;font-size:14pt;">{{$sales['jabatan']}}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <button class="btn btn-primary print">Print this page</button>
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
