@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('ppk.permohonan-spd.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Disposisi Permohonan SPD</h4>
                        @if (!$permohonan->is_arsip)
                            @if ($permohonan->disposisi == null || $permohonan->disposisi->pembuat_karyawan_id_2 == null)
                                <a href="{{ route('ppk.permohonan-spd-disposisi.create', [
                                    'permohonan_spd_uuid' => $permohonan->id,
                                ]) }}"
                                    class="btn my-2 mb-3 btn-sm py-2 btn-primary">Buat Disposisi</a>
                            @else
                                {{ null }}
                            @endif
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
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
                                        <td>{{ $item->perihal_2 }}</td>
                                        <td>{{ $item->pembuat2->nama }}</td>
                                        <td>{{ $item->tujuan2->nama }}</td>
                                        <td>
                                            @if (!$permohonan->disposisi)
                                                @if ($item->pembuat_karyawan_id_2 == auth()->user()->karyawan->id)
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('ppk.permohonan-spd-disposisi.destroy', $item->id) }}">Hapus</button>
                                                    </form>
                                                @endif
                                            @else
                                                -
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
