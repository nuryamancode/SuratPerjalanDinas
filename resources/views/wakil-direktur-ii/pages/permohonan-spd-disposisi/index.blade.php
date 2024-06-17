@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.permohonan-spd.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Permohonan SPD</h4>
                        @if ($permohonan->disposisi == null || $permohonan->disposisi->pembuat_karyawan_id_1 == null)
                            <a href="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.create', [
                                'permohonan_spd_uuid' => $permohonan->id,
                            ]) }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Nomor Agenda</th>
                                    <th>Asal Surat</th>
                                    <th>Pembuat</th>
                                    <th>Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->spd->surat->nomor_surat }}</td>
                                        <td>{{ $item->nomor_agenda }}</td>
                                        <td>{{ $item->spd->surat->asal_surat }}</td>
                                        <td>{{ $item->pembuat->nama }}</td>
                                        <td>{{ $item->tujuan->nama }}</td>
                                        <td>
                                            @if ($item->pembuat_karyawan_id == auth()->user()->karyawan->id)
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.destroy', $item->id) }}">Hapus</button>
                                                </form>
                                            @endif
                                            @if ($item->spd->acc_ppk == 2)
                                                <a href="{{ route('wakil-direktur-ii.permohonan-spd-disposisi.edit', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Kirim Ulang</a>
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
