@extends('main.index')

@section('title','PO Preview')

@section('css')
    <style>
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
        
        @media print {
            
        body {
            margin: 0;
            position: relative;
        }
        .thead {display: table-header-group;} 
        .header {
            position: fixed;
            top: 0mm;
        } 
        
        .btn {display: none;} 
        .header, .page-header-space {
        height: 280px;
        margin-bottom:10px;
        }
        #footer {
            width:100%;
        }
        nav{
            display:none;
        }
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

    </style>
@endsection

@section('container')
    <div class="container">
        <div class="row header">
            <div class="col-12 px-5">
                        <h2>PURCHASE ORDER</h2>
                <div class="row">
                    <!-- <div class="col-6">
                        
                    </div> -->
                    @if($po['paket'] != '')
                    <div class="col-6">
                        <p>PAKET <span style="margin-left:78px;">:</span> {{ $po['paket'] }} </p>
                    </div>
                    @else

                    @endif
                </div>
            </div>
            <div class="col-12 px-5" style="border-top:2px solid;border-bottom:2px solid;">
                <div class="row">
                    <div class="col-6">
                        <p>NO PO <span class="ml-5">:</span> {{ $po['kode_po'] }} </p>
                        <br>
                        <!-- <p>fax/Email <span style="margin-left:30px;">:</span> {{ $supplier['email'] }}</p> -->
                        <p>to <span style="margin-left:90px;">:</span> {{ $supplier['nama_perusahaan'] }}</p>
                        <p>attn<span style="margin-left:80px;">:</span> {{ $attn['attn'] }}</p>
                    </div>
                    <div class="col-6">
                        <p><span id="page-number"></span></p>
                        <p>from <span style="margin-left:90px;">:</span> {{ $perusahaan['nama_perusahaan'] }}</p>
                        <p>date<span style="margin-left:98px;">:</span> {{ date('d F Y',strtotime($po['tgl'])) }}</p>
                    </div>
                    <div class="col-12">
                        <p>cc <span style="margin-left:90px;">:</span> {{ $po['cc'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 px-5">
                <p>re <span style="margin-left:90px;">:</span> {{ $po['re'] }}</p>
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
                                <div class="row">
                                    <div class="col-12">
                                        <table border="1" width="100%">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">NO</td>
                                                    <td class="text-center">NAMA BARANG</td>
                                                    <td class="text-center">QTY</td>
                                                    <td class="text-center">SATUAN</td>
                                                    <td class="text-center">HARGA</td>
                                                    <td class="text-center">TOTAL</td>
                                                    <td class="text-center">KETERANGAN</td>
                                                </tr>
                                            </thead>
                                                @foreach($barang as $b)
                                                <tr id="{{ $loop->iteration }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $b->nama_barang }}</td>
                                                    <td class="text-center">{{ $b->qty }}</td>
                                                    <td class="text-center">{{ $b->satuan }}</td>
                                                    <td class="text-nowrap text-right">{{ "Rp " . str_replace(',','.',number_format($b->harga)) }}</td>
                                                    <td class="text-nowrap text-right">{{ "Rp " . str_replace(',','.',number_format($b->total)) }}</td>
                                                    <td>{{ $b->keterangan }}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="4" style="visibility:hidden;"></td>
                                                    <td class="text-right"><b>GRAND TOTAL<b></td>
                                                    <td class="text-nowrap text-right">{{ "Rp " . str_replace(',','.',number_format($grandtotal)) }}</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    </div>
                    <tbody>
                        <tr>
                            <td>
                                <div id="footer">
                                    <div class="row">
                                        <div class="col-12">
                                            @if($po['pajak'] == '1')
                                                <p>{{ $paragraf['include_pajak'] }}</p>
                                            @elseif($po['pajak'] == '2')
                                                <p>{{ $paragraf['exclude_pajak'] }}</p>
                                            @elseif($po['pajak'] == '3')

                                            @endif
                                            @if($po['id_ekspedisi'] == '')

                                            @elseif($ekspedisi == null && $po['id_ekspedisi'] == 'other' )
                                                <p>Pengiriman Via Ekspedisi: {{ $po['ekspedisi_dll'] }}</p>
                                            @elseif($ekspedisi != '')
                                                <p>Pengiriman Via Ekspedisi: {{ $ekspedisi['ekspedisi'] }} - Telp {{ $ekspedisi['no_telp'] }} - HP {{ $ekspedisi['no_hp'] }}</p>
                                            @endif
                                            @if($po['note'] == '')
                                            @else
                                                <p>Note: {{ $po['note'] }}</p>
                                            @endif
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            @if($po['npwp'] == '1')
                                                <p>NPWP: </p>
                                                <div style="width:300px;">
                                                    <img src="/assets/images/upload/npwp/{{ $perusahaan['npwp'] }}" width="100%">
                                                </div>
                                            @elseif($po['npwp'] == '2')

                                            @endif
                                        </div>
                                        <div class="col-4 text-center">
                                            <p>{{ $paragraf['penutup'] }}</p>
                                            <p>{{ $perusahaan['nama_perusahaan'] }}</p>
                                                @if( $po['ttd'] == '1' )
                                                <div style="width:200px;" class="m-auto py-4">
                                                    <img src="/assets/images/upload/ttd/{{ $npwp['ttd'] }}" width="100%">
                                                </div>
                                                @elseif( $po['ttd'] == '2' )
                                                    <div class="py-5"></div>
                                                @endif
                                            <p>{{ $npwp['nama'] }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <a href="/list/po" class="btn btn-primary">Close</a>
                                    </div>
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