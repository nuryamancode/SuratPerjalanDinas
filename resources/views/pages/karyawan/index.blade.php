@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Karyawan</h4>
                        <a href="{{ route('karyawan.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                            Karyawan</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor HP</th>
                                    <th>Jabatan</th>
                                    <th>Golongan</th>
                                    <th>Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->nomor_hp }}</td>
                                        <td>{{ $item->jabatan->nama }}</td>
                                        <td>{{ $item->golongan->nama }}</td>
                                        <td>{{ $item->statusAkun() }} </td>
                                        <td>
                                            <a href="{{ route('karyawan.edit', $item->id) }}"
                                                class="btn btn-sm py-2 btn-info">Edit</a>
                                            <form action="javascript:void(0)" method="post" class="d-inline"
                                                id="formDelete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                    data-action="{{ route('karyawan.destroy', $item->id) }}">Hapus</button>
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
