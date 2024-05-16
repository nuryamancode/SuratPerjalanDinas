@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Surat Non PBJ</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Asal Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Diteruskan Kepada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat_non_pbj->nomor_surat }}</td>
                                        <td>{{ $item->surat_non_pbj->perihal }}</td>
                                        <td>{{ $item->surat_non_pbj->karyawan->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->surat_non_pbj->created_at)->format('d F Y') }}
                                        </td>
                                        <td>
                                            @if ($item->teruskan2 == null || $item->teruskan2->nama == null)
                                                {{ $item->teruskan1->nama }}
                                            @else
                                                {{ $item->teruskan2->nama }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->surat_non_pbj->acc_ppk === '0')
                                                <a href="{{ route('ppk.surat-non-pbj-disposisi.create', $item->id) }}"
                                                    class="btn btn-sm py-2 btnTolak btn-primary">Tambahkan</a>
                                            @endif
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('wakil-direktur-ii.pengajuan-pbj-disposisi.destroy', $item->id) }}">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
