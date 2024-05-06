@extends('wakil-direktur-i.layouts.app')
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
                            <span>{{ $item->tanggal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Perihal</span>
                            <span>{{ $item->perihal }}</span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Diteruskan Ke</span>
                            <span>{{ $item->diteruskan->nama }}</span>
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
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>File</span>
                            <span>
                                <a href="{{ $item->getFile() }}" class="btn btn-secondary btn-sm" target="_blank">Lihat</a>
                            </span>
                        </li>
                        <li class="list-item mb-4 d-flex justify-content-between">
                            <span>Aksi</span>
                            <div>
                                <a href="{{ route('wakil-direktur-i.surat-non-pbj-detail.index', [
                                    'surat_non_pbj_uuid' => $item->uuid,
                                ]) }}"
                                    class="btn btn-sm py-2 btn-info">Taksiran</a>
                                <a href="{{ route('wakil-direktur-i.surat-non-pbj.index') }}"
                                    class="btn btn-sm btn-warning">Kembali</a>
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
