@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Surat</h4>
                        <a href="{{ route('surat.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                            Surat</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
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
                                        <td>{{ $item->perihal }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($item->pelaksana as $pelaksana)
                                                    <li>{{ $pelaksana->karyawan->nama ?? '-' }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ route('surat.show', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            <a href="{{ route('surat.edit', $item->uuid) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('surat.destroy', $item->uuid) }}">Hapus</button>
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
