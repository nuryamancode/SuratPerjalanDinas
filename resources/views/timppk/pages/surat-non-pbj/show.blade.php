@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->surat_non_pbj->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->surat_non_pbj->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->surat_non_pbj->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->karyawan->nama }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nilai Taksiran</span>
                            <span>{{ $item->nominal ? 'Rp. ' . number_format($item->nominal, 0, ',', '.') : 'Belum ada nilai taksiran' }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->surat_non_pbj->getFileDokumen() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Dokumen</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lampiran</span>
                            <span>
                                <ol class="list-group">
                                    @foreach ($item->surat_non_pbj->lampiransnpbj as $lampiransnpbj)
                                        <li>
                                            <a href="{{ $lampiransnpbj->getFile() }}" target="_blank"
                                                class="btn btn-success btn-sm mt-2">Lihat Lampiran</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </span>
                        </li>
                        @if ($item->surat_non_pbj->spj == null || $item->surat_non_pbj->spj->status_spj == null)
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <span>
                                    <a href="{{ route('timppk.surat-non-pbj-spj.index', $item->id) }}"
                                        class="btn btn-sm py-2 btn-info">Buat SPJ</a>
                                </span>
                            </li>
                        @else
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <span>
                                    <a href="{{ route('timppk.surat-non-pbj-spj.show', $item->id) }}"
                                        class="btn btn-sm py-2 btn-info">Lihat SPJ</a>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
