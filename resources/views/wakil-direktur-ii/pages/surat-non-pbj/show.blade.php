@extends('wakil-direktur-ii.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md">
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
                            <span>{{ $item->nomor_agenda ?? '-' }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Dokumen surat</span>
                            <span>
                                <a href="{{ $item->getFileDokumen() }}" target="_blank" class="btn btn-success btn-sm">Lihat
                                    Dokumen</a>
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
                        @if ($item->acc_wadir2 == '0')
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <div>
                                </div>
                                <div>
                                    <form action="javascript:void(0)" class="d-inline" id="formAcc">
                                        @csrf
                                        <button class="btn btnAcc btn-sm py-2 btn-success"
                                            data-action="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $item->id) }}">Terima</button>
                                    </form>
                                    <a href="#" data-toggle="modal" data-target="#modalKeterangan{{ $item->id }}"
                                        class="btn btn-sm py-2 btnTolak btn-danger">Tolak</a>
                                </div>
                            </li>
                        @endif
                        @if ($item->acc_wadir2 == '1')
                            <li class="list-item mb-4 d-flex justify-content-between">
                                <span>Aksi</span>
                                <div>
                                </div>
                                <div>
                                    <a href="{{ route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $item->id) }}"
                                        class="btn btn-sm py-2 btnTolak btn-primary">Lihat Disposisi</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
