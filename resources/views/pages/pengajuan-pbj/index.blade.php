@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Pengajuan PBJ</h4>
                        @can('Pengajuan PBJ Create')
                            <a href="{{ route('pengajuan-pbj.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Pengajuan PBJ</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Nomor Agenda</th>
                                    <th>Tanggal Surat</th>
                                    <th>Perihal</th>
                                    <th>Pelaksana</th>
                                    <th>Status Surat</th>
                                    <th>Status Verifikasi</th>
                                    <th>Acc Wadir 2</th>
                                    <th>Acc PPK</th>
                                    @canany([
                                        'Pengajuan PBJ Show',
                                        'Pengajuan PBJ Edit',
                                        'Pengajuan PBJ Delete',
                                        'Pengajuan
                                        PBJ Disposisi',
                                        ])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->nomor_agenda }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($item->pelaksana as $pelaksana)
                                                    <li>{{ $pelaksana->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->status() }}</td>
                                        <td>{{ $item->statusVerifikasi() }}</td>
                                        <td>{{ $item->statusAccWadir2() }}</td>
                                        <td>{{ $item->statusAccPpk() }}</td>
                                        @canany(['Pengajuan PBJ Show', 'Pengajuan PBJ Edit', 'Pengajuan PBJ Delete',
                                            'Pengajuan PBJ Disposisi'])
                                            <td>
                                                @can('Pengajuan PBJ Verifikasi')
                                                    @if ($item->acc_karyawan == 0)
                                                        <a href="{{ route('pengajuan-pbj.verifikasi', [
                                                            'pengajuan_pbj_uuid' => $item->uuid,
                                                            'status' => 2,
                                                        ]) }}"
                                                            class="btn  py-2  btn-danger">Tolak</a>
                                                        <a href="{{ route('pengajuan-pbj.verifikasi', [
                                                            'pengajuan_pbj_uuid' => $item->uuid,
                                                            'status' => 1,
                                                        ]) }}"
                                                            class="btn  py-2  btn-success">Setujui</a>
                                                    @elseif($item->acc_karyawan == 2)
                                                        <a href="{{ route('pengajuan-pbj.verifikasi', [
                                                            'pengajuan_pbj_uuid' => $item->uuid,
                                                            'status' => 1,
                                                        ]) }}"
                                                            class="btn  py-2  btn-success">Setujui</a>
                                                    @endif
                                                @endcan
                                                @can('Pengajuan PBJ Acc')
                                                    @if ($item->acc_wadir2 == 1)
                                                        @role('Pejabat Pembuat Komitmen')
                                                            @if ($item->acc_ppk == 0)
                                                                <a href="{{ route('pengajuan-pbj.acc-ppk', [
                                                                    'pengajuan_pbj_uuid' => $item->uuid,
                                                                    'status' => 2,
                                                                ]) }}"
                                                                    class="btn  py-2  btn-danger">Tolak</a>
                                                                <a href="{{ route('pengajuan-pbj.acc-ppk', [
                                                                    'pengajuan_pbj_uuid' => $item->uuid,
                                                                    'status' => 1,
                                                                ]) }}"
                                                                    class="btn  py-2  btn-success">Setujui</a>
                                                            @elseif($item->acc_ppk == 2)
                                                                <a href="{{ route('pengajuan-pbj.acc-ppk', [
                                                                    'pengajuan_pbj_uuid' => $item->uuid,
                                                                    'status' => 1,
                                                                ]) }}"
                                                                    class="btn  py-2  btn-success">Setujui</a>
                                                            @else
                                                                @can('Pengajuan PBJ Disposisi')
                                                                    <a href="{{ route('pengajuan-pbj.disposisi.index', $item->uuid) }}"
                                                                        class="btn btn-sm py-2 btn-primary">Disposisi</a>
                                                                @endcan
                                                            @endif
                                                        @endrole
                                                    @endif
                                                    @role('Wakil Direktur II')
                                                        @if ($item->acc_wadir2 == 0)
                                                            <a href="{{ route('pengajuan-pbj.acc-wadir2', [
                                                                'pengajuan_pbj_uuid' => $item->uuid,
                                                                'status' => 2,
                                                            ]) }}"
                                                                class="btn  py-2  btn-danger">Tolak</a>
                                                            <a href="{{ route('pengajuan-pbj.acc-wadir2', [
                                                                'pengajuan_pbj_uuid' => $item->uuid,
                                                                'status' => 1,
                                                            ]) }}"
                                                                class="btn  py-2  btn-success">Setujui</a>
                                                        @elseif($item->acc_wadir2 == 2)
                                                            <a href="{{ route('pengajuan-pbj.acc-wadir2', [
                                                                'pengajuan_pbj_uuid' => $item->uuid,
                                                                'status' => 1,
                                                            ]) }}"
                                                                class="btn  py-2  btn-success">Setujui</a>
                                                        @else
                                                            @can('Pengajuan PBJ Disposisi')
                                                                <a href="{{ route('pengajuan-pbj.disposisi.index', $item->uuid) }}"
                                                                    class="btn btn-sm py-2 btn-primary">Disposisi</a>
                                                            @endcan
                                                        @endif
                                                    @endrole
                                                @endcan
                                                @can('Pengajuan PBJ Show')
                                                    <a href="{{ route('pengajuan-pbj.show', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-warning">Detail</a>
                                                @endcan
                                                @can('Pengajuan PBJ Edit')
                                                    <a href="{{ route('pengajuan-pbj.edit', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Pengajuan PBJ Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('pengajuan-pbj.destroy', $item->uuid) }}">Hapus</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endcanany
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
