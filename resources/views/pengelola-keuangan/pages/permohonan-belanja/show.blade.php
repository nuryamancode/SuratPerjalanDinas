@extends('pengelola-keuangan.layouts.app')
@section('content')
    <style>
        .back:hover {
            text-decoration: none;
        }
    </style>
    <a href="{{ route('pengelola-keuangan.permohonan-form-non-pbj.index') }}" class="back">
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
                            <span>Formulir</span>
                            <span>
                                <a href="{{ $item->form_non_pbj->getFile() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat
                                    Formulir</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Pembuatan</span>
                            <span>
                                {{ \Carbon\Carbon::parse($item->form_non_pbj->created_at)->format('d F Y') }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status Pengajuan</span>
                            <span>
                                {{ $item->form_non_pbj->status }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                            </div>
                            <div>
                                <a href="{{ route('pengelola-keuangan.permohonan-form-non-pbj-disposisi.index', $item->id) }}"
                                    class="btn btn-sm py-2 btnTolak btn-primary">Lihat Disposisi</a>
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
