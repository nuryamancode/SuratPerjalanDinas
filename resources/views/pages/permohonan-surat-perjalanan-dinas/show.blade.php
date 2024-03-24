@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Surat</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
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
                            <span>Diteruskan Kepada</span>
                            <span>
                                {{ $item->disposisi->tujuan_karyawan->nama ?? '-' }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('surat-perjalanan-dinas.index') }}"
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
