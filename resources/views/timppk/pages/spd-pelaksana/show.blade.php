@extends('timppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('timppk.spd.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Surat</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->spd->surat->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->spd->nomor_agenda_1 }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat</span>
                            <span>{{ \Carbon\Carbon::parse($item->spd->surat->created_at)->format('d M Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->spd->surat->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pelaksana</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->spd->surat->pelaksana as $pelaksana)
                                        <li>
                                            {{ $pelaksana->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>File</span>
                            <span>
                                <a href="{{ $item->spd->surat->getFile() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Surat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lihat Disposisi</span>
                            <span>
                                <a href="{{ route('timppk.permohonan-spd.print-ppk', $item->spd->disposisi->id) }}"
                                    target="_blank" class="btn btn-success btn-sm">Lihat
                                    Disposisi</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                @if ($item->uang_muka)
                                    @if ($item->spd->surat->antar == 1)
                                        <a href="{{ route('timppk.spd.print', $item->spd->spd_supir->id) }}"
                                            target="_blank" class="btn btn-sm py-2 btn-info">Lihat SPD Supir</a>
                                    @endif
                                    <a href="{{ route('timppk.spd.print-pelaksana', $item->id) }}"
                                        target="_blank" class="btn btn-sm py-2 btn-info">Lihat SPD Pelaksana</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">List Lampiran</h4>
                    <ul class="list-unstyled">
                        @forelse ($item->spd->surat->lampiran as $lampiran)
                            <li class="mb-4 d-flex justify-content-between">
                                <p>Lampiran {{ $loop->iteration }}</p>
                                <a href="{{ $lampiran->getFile() }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                            </li>
                        @empty
                            <li class="text-center">
                                Lampiran Tidak Ada
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            @if ($item->spd->surat->antar == 1)
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Keterangan Supir</h4>
                        <ul class="list-unstyled">
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Nomor Surat Jalan Dinas</span>
                                <span>{{ $item->spd->surat->no_surat_jalan_dinas }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Tanggal Surat Jalan</span>
                                <span>{{ $item->spd->surat->tanggal_surat_jalan }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Nama Supir</span>
                                <span>{{ $item->spd->surat->supir->nama }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Lampiran Surat Tugas</span>
                                <span>
                                    <a href="{{ $item->spd->surat->getFileLampiranSuratTugas() }}" target="_blank"
                                        class="btn btn-success btn-sm">Lihat
                                        Surat</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
