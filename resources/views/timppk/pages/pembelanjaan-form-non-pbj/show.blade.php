@extends('timppk.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('bendahara-keuangan.permohonan-belanja.index') }}" class="back">
        <div class="d-flex align-items-center">
            <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
            <span>Kembali</span>
        </div>
    </a>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Permohonan Belanja Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>No Surat</span>
                            <span>
                                {{ $item->disposisi_form->no_surat }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat</span>
                            <span>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>
                                {{ $item->disposisi_form->perihal }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pelaksana Belanja</span>
                            <span>
                                {{ $item->uang_muka1->karyawan->nama }} - {{ $item->uang_muka1->karyawan->jabatan->nama }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Uang Muka</span>
                            <span>
                                {{ $item->uang_muka1->nominal ? 'Rp. ' . number_format($item->uang_muka1->nominal, 0, ',', '.') : '-' }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Formulir</span>
                            <span>
                                <a href="{{ $item->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Formulir</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status Pengajuan</span>
                            <span>
                                {{ $item->status }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                            </div>
                            <div>
                                @if ($item->spj == null || $item->spj->acc_ppk == 0)
                                    <a href="{{ route('timppk.form-non-pbj-spj.index', $item->id) }}"
                                        class="btn btn-sm py-2 btnTolak btn-primary">Buat SPJ</a>
                                @else
                                    <a href="{{ route('timppk.form-non-pbj-spj.show', $item->id) }}"
                                        class="btn btn-sm py-2 btnTolak btn-primary">Lihat SPJ</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
