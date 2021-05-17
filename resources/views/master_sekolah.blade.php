@extends('main.index')

@section('title','Master Sekolah')

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
    
    <div class="row mb-3 ml-3">
        <button class="btn btn-primary" data-target="#tambah" data-toggle="modal">Tambah Sekolah</button>
    </div>
    <div class="row">
        <div class="col-12 table-responsive text-nowrap">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NPSN</th>
                        <th>Nama Sekolah<br>Alamat Sekolah</th>
                        <th>Kota<br>Kecamatan</th>
                        <th>Kepala Sekolah<br>No HP</th>
                        <th>Bendahara<br>No HP</th>
                        <th>Operator<br>No HP OP</th>
                        <th>Guru 1<br>No HP Guru 1</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($sekolah as $s)
                    <tr>
                        <th class="text-center">{{$loop->iteration}}</th>
                        <td><a href="{{$rule['prefik_gps_npsn'].$s->npsn}}" target="_blank">{{$s->npsn}}</a></th>
                        <td>
                            <a href="{{route('master_sekolah.memo',$s->id)}}" target="_blank">
                                {!! wordwrap($s->nama_sekolah,35,"<br>") !!}
                            </a>
                                <br>{!! wordwrap($s->alamat_sekolah,35,"<br>") !!}
                        </th>
                        <td>{{$s->nama_kota}}<br>{{ $s->kecamatan }}</th>
                        <td>{{$s->kepala_sekolah}}<br>{{$s->no_hp}}</th>
                        <td>{{$s->bendahara}}<br>{{ $s->no_telp_bendahara }}</th>
                        <td>{{$s->nama_operator}}<br>{{ $s->no_telp_operator }}</th>
                        <td>{{$s->guru1}}<br>{{ $s->no_telp_guru1 }}</th>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $s->id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $s->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button><br>
                            <button type="button" class="btn btn-secondary" onclick="window.open('/master/sekolah/view/{{$s->npsn}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <a class="btn btn-info" href="{{$s->alamat_gps}}" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                            
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sekolah.tambah') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="npsn">NPSN / Kode Sekolah (*)</label>
                        <input type="text" name="npsn" maxlength="8" minlength="8" id="npsn" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah (*)</label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_sekolah">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" id="alamat_sekolah" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kode_pos">Kode POS</label>
                        <input type="text" class="form-control" name="kode_pos" id="kode_pos">
                    </div>
                    <div class="form-group">
                        <label for="kelurahan">Kelurahan</label>
                        <input type="text" name="kelurahan" id="kelurahan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_kota">Nama Kota</label>
                        <input type="text" name="nama_kota" id="nama_kota" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status_sekolah">Status Sekolah</label>
                        <select name="status_sekolah" id="status_sekolah" class="form-control">
                            <option value="SWASTA">SWASTA</option>
                            <option value="NEGERI">NEGERI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="npwp_sekolah">NPWP Sekolah</label>
                        <input type="text" name="npwp_sekolah" id="npwp_sekolah" class="form-control" maxlength="15" minlength="15">
                    </div>
                    <div class="form-group">
                        <label for="kepala_sekolah">Kepala Sekolah</label>
                        <input type="text" name="kepala_sekolah" id="kepala_sekolah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nip_kepala_sekolah">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_kepala_sekolah">Jenis Kelamin Kepala Sekolah</label>
                        <select name="kelamin_kepala_sekolah" id="kelamin_kepala_sekolah" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email_kepala_sekolah">Email Kepala Sekolah</label>
                        <input type="text" name="email_kepala_sekolah" id="email_kepala_sekolah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telp Kepala Sekolah</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP Kepala Sekolah</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="bendahara">Bendahara</label>
                        <input type="text" name="bendahara" id="bendahara" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nip_bendahara">NIP Bendahara</label>
                        <input type="text" name="nip_bendahara" id="nip_bendahara" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_bendahara">Jenis Kelamin Bendahara</label>
                        <select name="kelamin_bendahara" id="kelamin_bendahara" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_bendahara">No HP Bendahara</label>
                        <input type="text" name="no_telp_bendahara" id="no_telp_bendahara" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_bendahara">Email Bendahara</label>
                        <input type="text" name="email_bendahara" id="email_bendahara" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_operator">Nama Operator</label>
                        <input type="text" name="nama_operator" id="nama_operator" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_operator">Jenis Kelamin Operator</label>
                        <select name="kelamin_operator" id="kelamin_operator" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_operator">No Telp Operator</label>
                        <input type="text" name="no_telp_operator" id="no_telp_operator" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_operator">Email Operator</label>
                        <input type="text" name="email_operator" id="email_operator" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="guru1">Guru 1</label>
                        <input type="text" name="guru1" id="guru1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru1">Jenis Kelamin Guru 1</label>
                        <select name="kelamin_guru1" id="kelamin_guru1" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru1">No Telp Guru 1</label>
                        <input type="text" name="no_telp_guru1" id="no_telp_guru1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_guru1">Email Guru 1</label>
                        <input type="text" name="email_guru1" id="email_guru1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="guru2">Guru 2</label>
                        <input type="text" name="guru2" id="guru2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru2">Jenis Kelamin Guru 2</label>
                        <select name="kelamin_guru2" id="kelamin_guru2" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru2">No Telp Guru 2</label>
                        <input type="text" name="no_telp_guru2" id="no_telp_guru2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_guru2">Email Guru 2</label>
                        <input type="text" name="email_guru2" id="email_guru2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="guru3">Guru 3</label>
                        <input type="text" name="guru3" id="guru3" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru3">Jenis Kelamin Guru 3</label>
                        <select name="kelamin_guru3" id="kelamin_guru3" class="form-control">
                            <option hidden selected disabled>--pilih--</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru3">No Telp Guru 3</label>
                        <input type="text" name="no_telp_guru3" id="no_telp_guru3" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_guru3">Email Guru 3</label>
                        <input type="text" name="email_guru3" id="email_guru3" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat_gps">Alamat GPS</label>
                        <input type="text" name="alamat_gps" id="alamat_gps" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kop_surat">Kop Surat</label><br>
                        <input type="file" name="kop_surat" id="kop_surat">
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label><br>
                        <input type="file" name="gambar" id="gambar">
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
@foreach($sekolah as $s)
<div class="modal fade" id="edit{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sekolah.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$s->id}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="npsn">NPSN / Kode Sekolah</label>
                        <input type="text" name="npsn" maxlength="8" minlength="8" id="npsn" class="form-control" value="{{$s->npsn}}" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah (*)</label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" value="{{$s->nama_sekolah}}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_sekolah">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" id="alamat_sekolah" class="form-control">{{$s->alamat_sekolah}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="kode_pos">Kode POS</label>
                        <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{$s->kode_pos}}">
                    </div>
                    <div class="form-group">
                        <label for="kelurahan">Kelurahan</label>
                        <input type="text" name="kelurahan" id="kelurahan" class="form-control" value="{{$s->kelurahan}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_kota">Nama Kota</label>
                        <input type="text" name="nama_kota" id="nama_kota" class="form-control" value="{{$s->nama_kota}}">
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{$s->kecamatan}}">
                    </div>
                    <div class="form-group">
                        <label for="status_sekolah">Status Sekolah</label>
                        <select name="status_sekolah" id="status_sekolah" class="form-control">
                            <option value="SWASTA" {{($s->status_sekolah == "SWASTA") ? 'selected' : ''}}>SWASTA</option>
                            <option value="NEGERI" {{($s->status_sekolah == "NEGERI") ? 'selected' : ''}}>NEGERI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="npwp_sekolah">NPWP Sekolah</label>
                        <input type="text" name="npwp_sekolah" id="npwp_sekolah" class="form-control" maxlength="15" minlength="15" value="{{str_replace('-','',str_replace('.','',$s->npwp_sekolah))}}">
                    </div>
                    <div class="form-group">
                        <label for="kepala_sekolah">Kepala Sekolah</label>
                        <input type="text" name="kepala_sekolah" id="kepala_sekolah" class="form-control" value="{{$s->kepala_sekolah}}">
                    </div>
                    <div class="form-group">
                        <label for="nip_kepala_sekolah">NIP Kepala Sekolah</label>
                        <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah" class="form-control" value="{{$s->nip_kepala_sekolah}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_kepala_sekolah">Jenis Kelamin Kepala Sekolah</label>
                        <select name="kelamin_kepala_sekolah" id="kelamin_kepala_sekolah" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_kepala_sekolah == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_kepala_sekolah == '2') ? 'selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email_kepala_sekolah">Email Kepala Sekolah</label>
                        <input type="text" name="email_kepala_sekolah" id="email_kepala_sekolah" class="form-control" value="{{$s->email_kepala_sekolah}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telp Kepala Sekolah</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{$s->no_telp}}">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP Kepala Sekolah</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{$s->no_hp}}">
                    </div>
                    <div class="form-group">
                        <label for="bendahara">Bendahara</label>
                        <input type="text" name="bendahara" id="bendahara" class="form-control" value="{{$s->bendahara}}">
                    </div>
                    <div class="form-group">
                        <label for="nip_bendahara">NIP Bendahara</label>
                        <input type="text" name="nip_bendahara" id="nip_bendahara" class="form-control" value="{{$s->nip_bendahara}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_bendahara">Jenis Kelamin Bendahara</label>
                        <select name="kelamin_bendahara" id="kelamin_bendahara" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_bendahara == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_bendahara == '2') ? 'selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_bendahara">No HP Bendahara</label>
                        <input type="text" name="no_telp_bendahara" id="no_telp_bendahara" class="form-control" value="{{$s->no_telp_bendahara}}">
                    </div>
                    <div class="form-group">
                        <label for="email_bendahara">Email Bendahara</label>
                        <input type="text" name="email_bendahara" id="email_bendahara" class="form-control" value="{{$s->email_bendahara}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_operator">Nama Operator</label>
                        <input type="text" name="nama_operator" id="nama_operator" class="form-control" value="{{$s->nama_operator}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_operator">Jenis Kelamin Operator</label>
                        <select name="kelamin_operator" id="kelamin_operator" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_operator == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_operator == '2') ? 'selected' : ''}}>Perempuan</option>    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_operator">No Telp Operator</label>
                        <input type="text" name="no_telp_operator" id="no_telp_operator" class="form-control" value="{{$s->no_telp_operator}}">
                    </div>
                    <div class="form-group">
                        <label for="email_operator">Email Operator</label>
                        <input type="text" name="email_operator" id="email_operator" class="form-control" value="{{$s->email_operator}}">
                    </div>
                    <div class="form-group">
                        <label for="guru1">Guru 1</label>
                        <input type="text" name="guru1" id="guru1" class="form-control" value="{{$s->guru1}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru1">Jenis Kelamin Guru 1</label>
                        <select name="kelamin_guru1" id="kelamin_guru1" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_guru1 == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_guru1 == '2') ? 'selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru1">No Telp Guru 1</label>
                        <input type="text" name="no_telp_guru1" id="no_telp_guru1" class="form-control" value="{{$s->no_telp_guru1}}">
                    </div>
                    <div class="form-group">
                        <label for="email_guru1">Email Guru 1</label>
                        <input type="text" name="email_guru1" id="email_guru1" class="form-control" value="{{$s->email_guru1}}">
                    </div>
                    <div class="form-group">
                        <label for="guru2">Guru 2</label>
                        <input type="text" name="guru2" id="guru2" class="form-control" value="{{$s->guru2}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru2">Jenis Kelamin Guru 2</label>
                        <select name="kelamin_guru2" id="kelamin_guru2" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_guru2 == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_guru2 == '2') ? 'selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru2">No Telp Guru 2</label>
                        <input type="text" name="no_telp_guru2" id="no_telp_guru2" class="form-control" value="{{$s->no_telp_guru2}}">
                    </div>
                    <div class="form-group">
                        <label for="email_guru2">Email Guru 2</label>
                        <input type="text" name="email_guru2" id="email_guru2" class="form-control" value="{{$s->email_guru2}}">
                    </div>
                    <div class="form-group">
                        <label for="guru3">Guru 3</label>
                        <input type="text" name="guru3" id="guru3" class="form-control" value="{{$s->guru3}}">
                    </div>
                    <div class="form-group">
                        <label for="kelamin_guru3">Jenis Kelamin Guru 3</label>
                        <select name="kelamin_guru3" id="kelamin_guru3" class="form-control">
                            <option value="">--pilih--</option>
                            <option value="1" {{($s->kelamin_kepala_sekolah == '1') ? 'selected' : ''}}>Laki-Laki</option>
                            <option value="2" {{($s->kelamin_kepala_sekolah == '2') ? 'selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_guru3">No Telp Guru 3</label>
                        <input type="text" name="no_telp_guru3" id="no_telp_guru3" class="form-control" value="{{$s->no_telp_guru3}}">
                    </div>
                    <div class="form-group">
                        <label for="email_guru3">Email Guru 3</label>
                        <input type="text" name="email_guru3" id="email_guru3" class="form-control" value="{{$s->email_guru3}}">
                    </div>
                    <div class="form-group">
                        <label for="alamat_gps">Alamat GPS</label>
                        <input type="text" name="alamat_gps" id="alamat_gps" class="form-control" value="{{$s->alamat_gps}}">
                    </div>
                    <div class="form-group">
                        <label for="kop_surat">Kop Surat <a href="/assets/images/upload/kopsurat/{{$s->kop_surat}}" target="_blank">[View]</a></label><br>
                        <input type="file" name="kop_surat" id="kop_surat">
                        <input type="hidden" name="kop_surat_hidden" id="kop_surat_hidden" value="{{$s->kop_surat}}">
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar <a href="/assets/images/upload/sekolah/{{$s->gambar}}" target="_blank">[View]</a></label><br>
                        <input type="file" name="gambar" id="gambar">
                        <input type="hidden" name="gambar_hidden" id="gambar_hidden" value="{{$s->gambar}}">
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
<div class="modal fade" id="hapus{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sekolah.hapus') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="gambar" id="gambar" value="{{$s->gambar}}">
            <input type="hidden" name="kop_surat" id="kop_surat" value="{{$s->kop_surat}}">
            <input type="hidden" name="id" id="id" value="{{$s->id}}">
                <div class="modal-body">
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
});
$(document).ready( function () {
    $('#table').DataTable();  
    // $('#npsn').on('keyup',function(){
    //     let npsn = $('$npsn').val();
    // });
  });
</script>
@endsection