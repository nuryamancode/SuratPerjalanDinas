@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('wakil-direktur-ii.laporan.spd') }}" class="back">
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
                            <span>Tanggal Surat</span>
                            <span>{{ \Carbon\Carbon::parse($item->surat->created_at)->format('d M Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->surat->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Mulai Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Sampai Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal_sampai)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Berangkat</span>
                            <span>{{ $item->surat->tempat_berangkat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Tujuan</span>
                            <span>{{ $item->surat->tempat_tujuan }}</span>
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
                            <span>Kebutuhan Anggaran Pelaksana</span>
                            <span>
                                @if ($item->uang_muka_pelaksana)
                                    Rp. {{ number_format($item->uang_muka_pelaksana->nominal) }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Kebutuhan Anggaran Supir</span>
                            <span>
                                @if ($item->uang_muka_supir)
                                    Rp. {{ number_format($item->uang_muka_supir->nominal) }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Realisasi</span>
                            <span>
                                @if ($item->spd_pelaksana || $item->spd_supir)
                                    <span class="badge badge-success">Sudah Dibuat</span>
                                @else
                                    <span class="badge badge-danger">Belum Dibuat</span>
                                @endif
                            </span>
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
