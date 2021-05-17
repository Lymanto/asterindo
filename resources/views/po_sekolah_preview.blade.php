@extends('main.index')

@section('title','PO Sekolah Preview')

@section('css')
    <style>
        #data-sekolah tr td{
            padding:0;
            margin:0;
        }
        p{
            font-size:15pt;
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
        }
    @media print {
            
        body {
            margin: 0;
            position: relative;
            font-family: "Times New Roman", Times, serif;
        }
        
        .thead {display: table-header-group;} 
        .header {
            position: fixed;
            top: 0mm;
            display:block;
        } 
        .btn {display: none;} 
        .header, .page-header-space {
        height: 230px;
        width:100%;
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
        <div class="col-12">
            <img src="/assets/images/upload/kopsurat/{{$data['kop_surat']}}" width="100%">
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
                                <div class="col-12 text-center py-3">
                                    <h2><span style="border-bottom:solid;font-weight:bold;">SURAT PEMESANAN BARANG</span></h2>
                                    <h4>No. {{$data['no_surat']}}</h4>
                                </div>
                                <div class="col-12 ml-2 mb-3">
                                    <p>Kepada Yth:</p>
                                    <p>{{$data['nama_perusahaan']}}</p>
                                    <p>{{$data['alamat']}}</p>
                                </div>
                                <div class="col-12 ml-2 mb-3">
                                    <p>Yang bertanda tangan dibawah ini:</p>
                                    <table id="data-sekolah">
                                        <tr>
                                            <td><p>NPSN</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['npsn']}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p>Nama Sekolah</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['nama_sekolah']}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p>NPWP Sekolah</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['npwp_sekolah']}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p>Alamat Pengiriman</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['alamat_pengiriman']}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p>Nama Kepala Sekolah</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['kepala_sekolah']}}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p>No. Handphone</p></td>
                                            <td class="px-2"><p>:</p></td>
                                            <td><p>{{$data['no_hp']}}</p></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <p>Dengan ini, kami memesan barang sebagai berikut:</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table border="1" width="100%">
                                        <thead>
                                            <tr>
                                                <td class="text-center"><p>NO</p></td>
                                                <td class="text-center"><p>DESCRIPTION</p></td>
                                                <td class="text-center">
                                                    <div class="d-flex flex-row justify-content-around">
                                                        <p>
                                                            <span>QTY</span>
                                                        </p>
                                                        <p>
                                                            <span>SATUAN</span>
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="text-center"><p>HARGA</p></td>
                                                <td class="text-center"><p>TOTAL HARGA</p></td>
                                            </tr>
                                            
                                        </thead>
                                            @foreach($barang as $b)
                                            <tr>
                                                <td class="text-center"><p>{{ $loop->iteration }}</p></td>
                                                <td><p>{{ $b->description }}</p></td>
                                                <td class="text-center">
                                                    <div class="d-flex flex-row justify-content-around">
                                                        <p>
                                                            <span>{{$b->qty}}</span>
                                                        </p>
                                                        <p>
                                                            <span>{{$b->satuan}}</span>
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap text-right"><p>{{ "Rp " . str_replace(',','.',number_format($b->harga)) }}</p></td>
                                                <td class="text-nowrap text-right"><p>{{ "Rp " . str_replace(',','.',number_format($b->total)) }}</p></td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" style="visibility:hidden;"></td>
                                                <td class="text-right"><p>Jumlah</p></td>
                                                <td class="text-nowrap text-right"><p>{{ "Rp " . str_replace(',','.',number_format($data['jumlah_total'])) }}</p></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="visibility:hidden;"></td>
                                                <td class="text-right"><p>PPN 10%</p></td>
                                                <td class="text-nowrap text-right"><p>{{ "Rp " . str_replace(',','.',number_format($data['ppn'])) }}</p></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="visibility:hidden;"></td>
                                                <td class="text-right"><p><b>Grand Total</b></p></td>
                                                <td class="text-nowrap text-right"><b><p>{{ "Rp " . str_replace(',','.',number_format($data['grandtotal'])) }}</b></p></td>
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
                                    <div class="col-12 mt-5">
                                        <p>Demikian Surat Pesanan ini Kami sampaikan dan dapat di pergunakan sebagaimana mestinya. Atas Perhatiannya Kami ucapkan Terima Kasih.</p>
                                    </div> 
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6 mt-4">
                                        <p>Pihak Penyedia</p>
                                        <p>{{$data['nama_perusahaan']}}</p>
                                        @if($data['ttd'] == '1')
                                            <div style="width:50%;height:150px;" class="d-flex">
                                                <img src="{{asset('assets/images/upload/ttd/'.$data['ttd_gambar'])}}" class="align-self-center">
                                            </div>
                                        @elseif($data['ttd'] == '2')
                                            <div style="width:100%;height:150px;">
                                                
                                            </div>
                                        @endif
                                        <p><span style="border-bottom:1px solid;">{{$data['nama']}}</span></p>
                                        <p>{{$data['jabatan']}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{!! $data['nama_kota'] !!}, {{date('d F Y',strtotime($data['tgl']))}}</p>
                                        <p>Pemesan</p>
                                        <p style="font-size:15px;">Kepala Sekolah {{$data['nama_sekolah']}}</p>
                                        <div style="width:100%;height:150px;"></div>
                                        <p><span style="border-bottom:1px solid;">{{$data['kepala_sekolah']}}</span></p>
                                        <p>NIP : {{$data['nip_kepala_sekolah']}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <a href="/list/po-sekolah" class="btn btn-primary">Close</a>
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
