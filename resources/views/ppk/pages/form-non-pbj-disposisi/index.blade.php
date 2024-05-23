@extends('ppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('ppk.form-non-pbj.index') }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Form Non PBJ</h4>
                        @if ($pengajuan->acc_ppk == 0)
                            <a href="{{ route('ppk.pengajuan-form-non-pbj-disposisi.create', $pengajuan->id) }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No Surat</th>
                                    <th>No Agenda</th>
                                    <th>Asal Surat</th>
                                    <th>Tipe Disposisi</th>
                                    <th>Tanggal Surat</th>
                                    <th>Perihal</th>
                                    <th>Catatan Disposiisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->no_agenda }}</td>
                                        <td>{{ $item->form_non_pbj->karyawan->nama }}</td>
                                        <td>{{ $item->tipe_disposisi }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ $item->catatan_disposisi }}</td>
                                        <td>
                                            <a href="{{ route('ppk.pengajuan-form-non-pbj-disposisi.edit', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Edit</a>
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
