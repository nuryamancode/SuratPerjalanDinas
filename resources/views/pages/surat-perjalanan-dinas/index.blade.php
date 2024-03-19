@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Surat</h4>
                        @can('Surat Perjalanan Dinas Create')
                            <a href="{{ route('surat-perjalanan-dinas.create') }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Surat Perjalanan Dinas</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th>Tipe</th>
                                    <th>Tujuan Disposisi</th>
                                    <th>Status</th>
                                    @canany(['Surat Edit', 'Surat Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->surat->nomor_surat }}</td>
                                        <td>{{ $item->surat->perihal }}</td>
                                        <td>{{ $item->tipe }}</td>
                                        <td>{{ $item->tujuan_disposisi->nama ?? '-' }}</td>
                                        <td>{{ $item->status }}</td>
                                        @canany(['Surat Edit', 'Surat Delete', 'Surat Show'])
                                            <td>
                                                @can('Surat Perjalanan Dinas Edit')
                                                    <a href="{{ route('surat-perjalanan-dinas.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                    <a href="{{ route('surat-perjalanan-dinas.disposisi-single', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-warning">Disposisi</a>
                                                @endcan
                                                @can('Surat Perjalanan Dinas Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('surat-perjalanan-dinas.destroy', $item->id) }}">Hapus</button>
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
