@extends('pengadministrasi-umum.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('pengadministrasi-umum.surat.index') }}" class="back">
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
                            <span>{{ $item->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat</span>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->maksud_perjalanan_dinas }}</span>
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
                            <span>{{ $item->tempat_berangkat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Tujuan</span>
                            <span>{{ $item->tempat_tujuan }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pelaksana</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pelaksana as $pelaksana)
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
                                <a href="{{ $item->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Surat</a>
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
                        @forelse ($item->lampiran as $lampiran)
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
            @if ($item->antar == 1)
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title mb-5">Keterangan Supir</h4>
                    <ul class="list-unstyled">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat Jalan Dinas</span>
                            <span>{{ $item->no_surat_jalan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat Jalan</span>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal_surat_jalan)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nama Supir</span>
                            <span>{{ $item->supir->nama }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lampiran Surat Tugas</span>
                            <span>
                                <a href="{{ $item->getFileLampiranSuratTugas() }}" target="_blank"
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
