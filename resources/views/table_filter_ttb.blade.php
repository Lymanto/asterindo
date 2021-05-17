<table class="table table-hover table-striped table-bordered filter" id="table">
    <thead>
        <tr>
            <th>NO DO</th>
            <th>TGL</th>
            <th>Nama Perusahaan Customer</th>
            <th>Nama Perusahaan</th>
            <th>Nama Sales</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{$d->no_do}}</td>
            <td>{{date('d-m-Y',strtotime($d->tgl))}}</td>
            <td>{{$d->customer['nama_perusahaan']}}</td>
            <td>{{$d->perusahaan['nama_perusahaan']}}</td>
            <td>{{$d->sales['nama']}}</td>
            <td>{{$d->status['status']}}</td>
            <td class="text-center">
                <a href="/list/tanda-terima-barang/edit/{{ $d->no_do }}" class="btn btn-secondary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @if(Session::get('role_id') == '1')
                <button type="button" class="btn btn-danger" data-target="#hapus{{ $d->no_do }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                @else
                
                @endif
                <button type="button" class="btn btn-info" onclick="window.open('/preview/tanda-terima-barang/{{$d->no_do}}');return false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-primary" onclick="window.open('/print/tanda-terima-barang/{{$d->no_do}}');return false"><i class="fa fa-print" aria-hidden="true"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>