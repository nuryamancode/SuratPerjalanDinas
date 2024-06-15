@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
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
                    <h4 class="card-title mb-5">Detail Surat</h4>
                    <ul class="list-inline">
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
                                <span>Disposisi Wakil Direktur II</span>
                                <span>
                                    <a href="{{ route('ppk.permohonan-spd.print-disposisi-wadir2', $item->id) }}"
                                        target="_blank" class="btn btn-info btn-sm">Print Surat</a>
                                </span>
                            </li>
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <div>
                                    @if ($item->acc_ppk == 0)
                                        <form action="javascript:void(0)" class="d-inline" id="formAcc">
                                            @csrf
                                            <button class="btn btnAcc btn-sm py-2 btn-success"
                                                data-action="{{ route('ppk.permohonan-spd-disposisi.index', $item->id) }}">Terima</button>
                                        </form>
                                        <a href="#" data-toggle="modal" data-target="#modalKeterangan"
                                            class="btn btn-sm py-2 btnTolak btn-danger">Tolak</a>
                                    @endif
                                    @if ($item->acc_ppk == 1 && $item->verifikasi_ppk == 1)
                                        <a href="{{ route('ppk.permohonan-spd-disposisi.index', $item->id) }}"
                                            class="btn btn-sm py-2 btn-warning">Lihat Disposisi</a>
                                    @endif
                                </div>
                            </li>
                        </ul>

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


    <div class="modal fade" id="modalKeterangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ppk.permohonan-spd.tolak', $item->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
