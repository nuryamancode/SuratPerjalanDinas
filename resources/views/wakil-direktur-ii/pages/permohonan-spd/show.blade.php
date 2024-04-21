@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
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
                            <span>{{ $item->surat->tanggal_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->surat->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Mulai Tanggal</span>
                            <span>{{ $item->surat->tanggal_mulai }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Sampai Tanggal</span>
                            <span>{{ $item->surat->tanggal_sampai }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Berangkat</span>
                            <span>{{ $item->surat->tempat_berangkat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Tujuan</span>
                            <span>{{ $item->surat->tempat_tujuan }}</span>
                        </li>
                        @if ($item->surat->antar == 1)
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
                        @endif
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
                                <a href="{{ $item->surat->getFile() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Surat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('wakil-direktur-ii.permohonan-spd.index') }}"
                                    class="btn btn-sm btn-warning">Kembali</a>
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
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
