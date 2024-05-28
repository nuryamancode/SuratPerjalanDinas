@extends('kabag.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
            <style>
                .back:hover {
                    text-decoration: none;
                }
            </style>
            <a href="{{ route('kabag.pengajuan-pbj.index') }}" class="back">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-arrow-left-bold-circle  pr-2 pt-1 icon-large"></i>
                    <span>Kembali</span>
                </div>
            </a>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Form Non PBJ</h4>
                    <ul class="list-inline">
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Surat</span>
                            <span>{{ $item->nomor_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Nomor Agenda</span>
                            <span>{{ $item->nomor_agenda }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal</span>
                            <span>{{ $item->tanggal_surat }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->getFileDokumen() }}" target="_blank"
                                    class="btn btn-success btn-sm">Lihat Dokumen</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Lampiran</span>
                            <span>
                                <ol class="list-group">
                                    @foreach ($item->lampiranpbj as $lampiranpbj)
                                        <li>
                                            <a href="{{ $lampiranpbj->getFile() }}" target="_blank"
                                                class="btn btn-success btn-sm mt-2">Lihat Lampiran</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Pengusul</span>
                            <div>
                                <ol class="list-group">
                                    @foreach ($item->pengusul as $pengusul)
                                        <li>
                                            {{ $pengusul->karyawan->nama }}
                                        </li>
                                    @endforeach
                                </ol>
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
