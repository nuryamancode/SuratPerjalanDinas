@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Permohonan Surat Perjalanan Dinas</h4>
                        @if (is_pengadministrasiumum())
                            <a href="{{ route('permohonan-surat-perjalanan-dinas.create') }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Permohonan Surat Perjalanan Dinas</a>
                        @endif
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
                                        {{-- <td>{{ $item->status }}</td> --}}
                                        {{-- <th>Acc</th> --}}
                                        <td>
                                            @can('Surat Perjalanan Dinas Create')
                                                <a href="{{ route('surat-perjalanan-dinas.generate', [
                                                    'surat_perjalanan_dinas_id' => $item->id,
                                                ]) }}"
                                                    class="btn btn-sm py-2 btn-success">Buatkan SPD</a>
                                            @endcan
                                            @can('Disposisi Create')
                                                @if ($item->disposisi->pembuat_karyawan_id != auth()->user()->karyawan->id)
                                                    <a href="{{ route('disposisi.index', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-warning">Disposisi</a>
                                                @endif
                                            @endcan
                                            {{-- @can('Disposisi Verifikasi')
                                                @if ($item->disposisi->pembuat_karyawan_id == auth()->user()->karyawan->id && $item->disposisi->acc_tujuan_karyawan_id == 0)
                                                    <a href="{{ route('disposisi.acc', [
                                                        'surat_perjalanan_dinas_id' => $item->id,
                                                        'status' => 1,
                                                    ]) }}"
                                                        class="btn btn-sm py-2 btn-success">Setujui</a>
                                                    <a href="{{ route('disposisi.acc', [
                                                        'surat_perjalanan_dinas_id' => $item->id,
                                                        'status' => 2,
                                                    ]) }}"
                                                        class="btn btn-sm py-2 btn-danger">Tolak</a>
                                                @endif
                                            @endcan --}}
                                            <a href="{{ route('permohonan-surat-perjalanan-dinas.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            @if (is_pengadministrasiumum())
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('permohonan-surat-perjalanan-dinas.destroy', $item->id) }}">Hapus</button>
                                                </form>
                                            @endif
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
