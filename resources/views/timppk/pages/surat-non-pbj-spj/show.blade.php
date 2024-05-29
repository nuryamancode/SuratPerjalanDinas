@extends('timppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('timppk.surat-non-pbj.index') }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="row">
        <div class="col-md-4 mb-3">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Pembayaran</span>
                            <span>{{ $suratNonPbj->untuk_pembayaran }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Uang Muka </span>
                            <span>Rp. {{ number_format($suratNonPbj->nominal) }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span class="font-weight-bold">Status </span>
                            <span>{!! $suratNonPbj->surat_non_pbj->spj->acc_ppk() !!}</span>
                        </li>
                        @if ($suratNonPbj->surat_non_pbj->spj->acc_ppk == 2)
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span class="font-weight-bold">Aksi </span>
                                <span>
                                    <form
                                        action="{{ route('timppk.surat-non-pbj-spj-detail.kirim.ulang', $suratNonPbj->surat_non_pbj->spj->id) }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        @method('put')
                                        <button class="btn btn-sm py-2 btn-success">Kirim Ulang</button>
                                    </form>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <h4 class="card-title ">Detail Biaya</h4>
                        @if ($suratNonPbj->surat_non_pbj->spj->acc_ppk != 1)
                            <a href="{{ route('timppk.surat-non-pbj-spj-detail.create', $suratNonPbj->surat_non_pbj->spj->id) }}"
                                class="btn btn-primary btn-sm">Tambah
                                Data</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Perincian Biaya</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>File Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suratNonPbj->surat_non_pbj->spj->details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->perincian_biaya }}</td>
                                        <td>Rp. {{ number_format($detail->nominal) }}</td>
                                        <td>{{ $detail->keterangan }}</td>
                                        <td>
                                            <a href="{{ $detail->downloadFile() }}" target="_blank"
                                                class="btn btn-success btn-sm">Lihat</a>
                                        </td>
                                        <td>
                                            @if ($suratNonPbj->surat_non_pbj->spj->acc_ppk != 1)
                                                <a href="{{ route('timppk.surat-non-pbj-spj-detail.edit', $detail->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('timppk.surat-non-pbj-spj-detail.destroy', $detail->id) }}">Hapus</button>
                                                </form>
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
<x-Admin.Datatable />
<x-Admin.Sweetalert />
