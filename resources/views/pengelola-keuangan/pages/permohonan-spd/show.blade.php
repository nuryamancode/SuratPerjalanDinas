@extends('pengelola-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('pengelola-keuangan.permohonan-spd.index') }}" class="back">
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
                            <span>{{ $item->surat->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->nomor_agenda_1 }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat</span>
                            <span>{{ \Carbon\Carbon::parse($item->surat->created_at)->format('d M Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->surat->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pelaksana</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->surat->pelaksana as $pelaksana)
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
                                <a href="{{ $item->surat->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Surat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lihat Disposisi</span>
                            <span>
                                <a href="{{ route('pengelola-keuangan.permohonan-spd.print-ppk', $item->id) }}"
                                    target="_blank" class="btn btn-success btn-sm">Lihat
                                    Disposisi</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                @if ($item->spd_pelaksana_dinas)
                                    <a href="{{ route('pengelola-keuangan.buat-spd.show', $item->id) }}"
                                        class="btn btn-sm py-2 btn-info">Lihat SPD Pelaksana Dinas</a>
                                @else
                                    <a href="{{ route('pengelola-keuangan.buat-spd.create', $item->id) }}"
                                        class="btn btn-sm btn-success">Buat SPD Pelaksana Dinas</a>
                                @endif
                                @if ($item->surat->antar == 1)
                                    @if ($item->spd_supir)
                                        <a href="{{ route('pengelola-keuangan.buat-spd.show-supir', $item->id) }}"
                                            class="btn btn-sm py-2 btn-info">Lihat SPD Supir</a>
                                    @else
                                        <a href="{{ route('pengelola-keuangan.buat-spd.create-supir', $item->id) }}"
                                            class="btn btn-sm btn-success">Buat SPD Supir</a>
                                    @endif
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
                        @forelse ($item->surat->lampiran as $lampiran)
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
            @if ($item->surat->antar == 1)
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Keterangan Supir</h4>
                        <ul class="list-unstyled">
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Nomor Surat Jalan Dinas</span>
                                <span>{{ $item->surat->no_surat_jalan_dinas }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Tanggal Surat Jalan</span>
                                <span>{{ $item->surat->tanggal_surat_jalan }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Nama Supir</span>
                                <span>{{ $item->surat->supir->nama }}</span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Lampiran Surat Tugas</span>
                                <span>
                                    <a href="{{ $item->surat->getFileLampiranSuratTugas() }}" target="_blank"
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
