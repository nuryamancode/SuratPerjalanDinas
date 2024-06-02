@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Surat Tugas</h4>
                        <a href="{{ route('pengadministrasi-umum.surat.create') }}"
                            class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                            Surat Tugas</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Pelaksana</th>
                                    <th>Status Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($item->pelaksana as $pelaksana)
                                                    <li>{{ $pelaksana->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->status() }}</td>
                                        <td>
                                            <a href="{{ route('pengadministrasi-umum.surat.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            @if ($item->surat_perjalanan_dinas && $item->surat_perjalanan_dinas->disposisis)
                                            @else
                                                <a href="{{ route('pengadministrasi-umum.surat.edit', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('pengadministrasi-umum.surat.destroy', $item->id) }}">Hapus</button>
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
