@extends('bendahara-keuangan.layouts.app')
@section('content')
<style>
    .back:hover {
        text-decoration: none;
    }
</style>
<a href="{{ route('bendahara-keuangan.permohonan-belanja-disposisi.index', $item->id) }}" class="back">
    <div class="d-flex align-items-center">
        <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
        <span>Kembali</span>
    </div>
</a>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Permohonan Belanja Disposisi Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Formulir</span>
                            <span>
                                <a href="{{ $item->form_non_pbj->getFile() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Formulir</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal Surat</span>
                            <span>
                                {{ \Carbon\Carbon::parse($item->form_non_pbj->created_at)->format('d F Y') }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>
                                {{ $item->no_surat }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Agenda</span>
                            <span>
                                {{ $item->no_agenda }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Asal Surat</span>
                            <span>
                                {{ $item->karyawan->nama }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tipe Disposisi</span>
                            <span>
                                {{ $item->tipe_disposisi }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tipe Disposisi</span>
                            <span>
                                {{ $item->perihal }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Status Pengajuan</span>
                            <span>
                                {{ $item->form_non_pbj->status }}
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Catatan Disposisi</span>
                            <span>
                                {{ $item->catatan_disposisi }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
