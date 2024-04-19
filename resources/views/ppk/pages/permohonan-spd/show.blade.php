@extends('ppk.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
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
                                    <a href="{{ route('ppk.permohonan-spd.index') }}"
                                        class="btn btn-sm btn-warning">Kembali</a>
                                    @if ($item->acc_ppk == 0)
                                        <form action="{{ route('ppk.permohonan-spd.acc-ppk', $item->uuid) }}"
                                            method="post" class="d-inline" id="formAcc">
                                            @csrf
                                            <textarea name="keterangan_ppk" id="keterangan_ppk" hidden cols="30" rows="10"></textarea>
                                            <button class="btn py-2  btn-sm btn-success" name="status"
                                                value="1">Terima</button>
                                            <button data-url="{{ route('ppk.permohonan-spd.acc-ppk', $item->uuid) }}"
                                                type="button" class="btn btnTolak py-2  btn-sm btn-danger" name="status"
                                                value="2">Tolak</button>
                                        </form>
                                    @elseif($item->acc_ppk == 1)
                                        <a href="{{ route('ppk.permohonan-spd-disposisi.index', [
                                            'permohonan_spd_uuid' => $item->uuid,
                                        ]) }}"
                                            class="btn btn-sm py-2 btn-info">Disposisi</a>
                                    @endif
                                    @if (count($item->disposisis->where('pembuat_karyawan_id', auth()->user()->karyawan->id)) > 0)
                                        @if (count($item->details) > 0)
                                            @if ($item->verifikasi_ppk == 0)
                                                <form
                                                    action="{{ route('ppk.permohonan-spd.verifikasi-ppk', $item->uuid) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    <button class="btn py-2  btn-sm btn-success" name="status">Set
                                                        Verifikasi</button>
                                                </form>
                                            @endif
                                        @endif
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
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
