@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Surat Perjalanan Dinas</h4>
                        <a href="{{ route('pengadministrasi-umum.permohonan-spd.create') }}"
                            class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                            Permohonan Surat Perjalanan Dinas</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Tipe</th>
                                    <th>Pembuat Disposisi</th>
                                    <th>Tujuan Disposisi</th>
                                    <th>Catatan</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->perihal }}</td>
                                        <td>{{ $item->disposisi->tipe ?? '-' }}</td>
                                        <td>{{ $item->disposisi->pembuat->nama ?? '-' }}</td>
                                        <td>{{ $item->disposisi->tujuan->nama ?? '-' }}</td>
                                        <td>{{ $item->disposisi->catatan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('pengadministrasi-umum.permohonan-spd.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('pengadministrasi-umum.permohonan-spd.destroy', $item->id) }}">Hapus</button>
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
