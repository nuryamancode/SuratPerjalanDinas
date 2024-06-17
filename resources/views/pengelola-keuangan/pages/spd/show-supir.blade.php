@extends('pengelola-keuangan.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('pengelola-keuangan.permohonan-spd.show', $item->id) }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail SPD Supir</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Supir</span>
                            <span>{{ $item->surat->supir->nama }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->surat->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>File</span>
                            <span>
                                <a href="{{ $item->surat->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Surat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tingakat Biaya</span>
                            <span>{{ $item->spd_supir->tingkat_biaya }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Maksud Perjalanan Dinas</span>
                            <span>{{ $item->spd_supir->maksud_perjalanan_dinas }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Alat Angkut</span>
                            <span>{{ $item->spd_supir->alat_angkut }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Berangkat</span>
                            <span>{{ $item->spd_supir->tempat_berangkat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tempat Tujuan</span>
                            <span>{{ $item->spd_supir->tempat_tujuan }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lama Perjalanan</span>
                            <span>{{ $item->spd_supir->lama_perjalanan }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Berangkat</span>
                            <span>{{ $item->spd_supir->tanggal_berangkat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pembebanan Anggaran</span>
                            <span>{{ $item->spd_supir->pembebanan_anggaran }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Instansi</span>
                            <span>{{ $item->spd_supir->instansi }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Mata Anggaran Kegiatan</span>
                            <span>{{ $item->spd_supir->mata_anggaran_kegiatan }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Dikeluarkan Di</span>
                            <span>{{ $item->spd_supir->dikeluarkan_di }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Keterangan Lain Lain</span>
                            <span>{{ $item->spd_supir->keterangan_lain_lain ?? '-' }}</span>
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
